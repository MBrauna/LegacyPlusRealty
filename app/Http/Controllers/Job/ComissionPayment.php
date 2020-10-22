<?php

namespace App\Http\Controllers\Job;


use Carbon\Carbon;

use App\Models\Contract;
use App\Models\SplitParameter;
use App\Models\Payment;
use App\Models\PaymentAdditional;
use App\Models\UserCompensation;
use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComissionPayment extends Controller
{
    public function paymentJob($content){
        try {
            $listContracts  =   Contract::where('payment_exec',false)->get();
            $comissionlevel =   SplitParameter::where('param_name','COMISSION_LEVEL')->first();

            /*Contract::where('payment_exec',false)
                                ->whereNull('payment_date')
                                ->get();*/

            foreach ($listContracts as $key => $value) {
                if($value->id_transaction_type == 1) {
                    $directSplit    =   SplitParameter::where('param_name','BROKER_SALLE')->first();
                }
                else {
                    $directSplit    =   SplitParameter::where('param_name','BROKER_RENT')->first();
                }
                // Limpa os dados do contrato que foram gerados.
                Payment::where('id_contract',$value->id_contract)->delete();
                PaymentAdditional::where('id_contract',$value->id_contract)->delete();
                // Coleta o valor para o vendedor do contrato
                $user       =   User::find($value->id_user_seller);

                # Retira o valor da comissão que iremos trabalhar
                $totalValue =   round((($value->value/100)*($directSplit->value ?? 0)),2);
                $totalBroker=   $totalValue;
                $broker     =   $totalValue;

                $this->message($content, "[LOG] - {$totalValue} === {$totalBroker} === {$broker}");

                $iteracao   =   0;

                if($totalValue > 0) {
                    // -- ## COMISSÃO AO VENDEDOR
                    if(isset($user) && isset($user->id) && !is_null($user->id)) {
                        $userComission          =   UserCompensation::where('id_user',$user->id)
                                                    ->whereRaw('? between min_value and max_value',[$value->value])
                                                    ->where('id_transaction_type',$value->id_transaction_type)
                                                    ->first();
                        if(isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) {
                            $valueFirst                 =   round((($totalValue/100)*$userComission->percentual),2);

                            $payment                    =   new Payment;
                            $payment->id_contract       =   $value->id_contract;
                            $payment->id_user           =   $user->id;
                            $payment->value_total       =   $totalValue;
                            $payment->value_split       =   $valueFirst;
                            $payment->percentual        =   $userComission->percentual;
                            $payment->processing_date   =   Carbon::now();
                            $payment->save();

                            $broker                 =   round(($broker - $valueFirst),2);
                            $totalBroker            =   $broker;


                            # comissao por venda
                            while ($iteracao < (intval($comissionlevel->value ?? 0))) {
                                $iteracao += 1;
                                if($broker <= 0){
                                    break;
                                }


                                if(isset($user) && isset($user->id) && !is_null($user->id) && !is_null($user->id_user_recommend)) {
                                    $user                   =   User::find($user->id_user_recommend);
                                    if(isset($user) && isset($user->percent) && !is_null($user->percent) && $user->percent > 0) {
                                        $valueFirst             =   round((($totalBroker/100)*$user->percent),2);

                                        if(round(($broker - $valueFirst),2) > 0) {
                                            $payment                    =   new Payment;
                                            $payment->id_contract       =   $value->id_contract;
                                            $payment->id_user           =   $user->id;
                                            $payment->value_total       =   $totalBroker;
                                            $payment->value_split       =   $valueFirst;
                                            $payment->percentual        =   $user->percent;
                                            $payment->processing_date   =   Carbon::now();
                                            $payment->save();
                
                                            $broker                 =   round(($broker - $valueFirst),2);
                                        }
                                        else {
                                            break;
                                        }
                                    } // if(isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) { ... }
                                } // if(isset($user) && isset($user->id) && !is_null($user->id) && !is_null($user->id_user_recommend)) { ... }
                            } // while ($iteracao < 3 && $broker > 0) { ... }

                            // Comissão para Legacy
                            $payment                    =   new Payment;
                            $payment->id_contract       =   $value->id_contract;
                            $payment->id_user           =   null;
                            $payment->value_total       =   $totalBroker;
                            $payment->value_split       =   $broker;
                            $payment->percentual        =   3;
                            $payment->processing_date   =   Carbon::now();
                            $payment->save();

                            Contract::where('id_contract',$value->id_contract)
                            ->update([
                                'payment_exec'      =>  false,
                            ]);

                        } // if(isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) { ... }
                    } // if(isset($user) && isset($user->id) && !is_null($user->id)) { ... }
                } // if($totalValue > 0) { ... }

                $this->message($content, "[INFO] - Executando contrato {$value->id_contract}");
            } // foreach ($listContracts as $key => $value) { ... }

            return 0;
        }
        catch(Exception $error) {
            $this->message($content, "[ERRO] - {$error}");
            return 1;
        }
    }

    private function message($content, $text) {
        if(isset($content) && !is_null($content)) {
            $content->info("[INFO] - {$text}");
        } // if(isset($content) && !is_null($content)) { ... }
    } // private function message($content) { ... }
}
