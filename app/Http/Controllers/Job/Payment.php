<?php

    namespace App\Http\Controllers\Job;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Carbon\Carbon;

    use App\Models\Contract;
    use App\Models\Parameters;
    use App\Models\Payment as PaymentModel;
    use App\Models\UserCompensation;
    use App\User;

    class Payment extends Controller
    {
        public function paymentJob($content){
            try {
                $listContracts  =   Contract::get();
                $directSplit    =   Parameters::where('parameter_name','DIRECT_COMISSION')->first();
                $comissionlevel =   Parameters::where('parameter_name','COMISSION_LEVEL')->first();

                /*Contract::where('payment_exec',false)
                                    ->whereNull('payment_date')
                                    ->get();*/

                foreach ($listContracts as $key => $value) {
                    // Limpa os dados do contrato que foram gerados.
                    PaymentModel::where('id_contract',$value->id_contract)->delete();
                    // Coleta o valor para o vendedor do contrato
                    $user       =   User::find($value->id_user_seller);

                    # Retira o valor da comissão que iremos trabalhar
                    $totalValue =   round((($value->value/100)*($directSplit->value ?? 0)),2);
                    $totalBroker=   $totalValue;
                    $broker     =   $totalValue;

                    $iteracao   =   0;

                    if($totalValue > 0) {
                        // -- ## COMISSÃO AO VENDEDOR
                        if(isset($user) && isset($user->id) && !is_null($user->id)) {
                            $userComission          =   UserCompensation::where('id_user',$user->id)
                                                        ->whereRaw('? between min_value and max_value',[$value->value])
                                                        ->where('type',$value->type)
                                                        ->first();
                            if(isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) {
                                $valueFirst             =   round((($totalValue/100)*$userComission->percentual),2);

                                $payment                =   new PaymentModel;
                                $payment->id_contract   =   $value->id_contract;
                                $payment->id_user       =   $user->id;
                                $payment->value         =   $totalValue;
                                $payment->comission     =   $valueFirst;
                                $payment->percent       =   $userComission->percentual;
                                $payment->payment_date  =   Carbon::now();
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
                                                $payment                =   new PaymentModel;
                                                $payment->id_contract   =   $value->id_contract;
                                                $payment->id_user       =   $user->id;
                                                $payment->value         =   $totalBroker;
                                                $payment->comission     =   $valueFirst;
                                                $payment->percent       =   $user->percent;
                                                $payment->payment_date  =   Carbon::now();
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
                                $payment                =   new PaymentModel;
                                $payment->id_contract   =   $value->id_contract;
                                $payment->id_user       =   null;
                                $payment->value         =   $totalBroker;
                                $payment->comission     =   $broker;
                                $payment->percent       =   3;
                                $payment->payment_date  =   Carbon::now();
                                $payment->save();

                                Contract::where('id_contract',$value->id_contract)
                                ->update([
                                    'payment_exec'  =>  true,
                                    'payment_date'  =>  Carbon::now(),
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
