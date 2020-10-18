<?php

    namespace App\Http\Controllers\Job;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Carbon\Carbon;

    use App\Models\Contract;
    use App\Models\Payment as PaymentModel;
    use App\Models\UserCompensation;
    use App\User;

    class Payment extends Controller
    {
        public function paymentJob(){
            try {
                $listContracts  =   Contract::where('payment_exec',false)
                                    ->whereNull('payment_date')
                                    ->get();
                
                foreach ($listContracts as $key => $value) {
                    // Limpa os dados do contrato que foram gerados.
                    PaymentModel::where('id_contract',$value->id_contract)->delete();
                    // Coleta o valor para o vendedor do contrato
                    $user       =   User::find($value->id_user_seller);


                    # Retira o valor da comissão que iremos trabalhar
                    $totalValue =   round((($value->value/100)*6),2);
                    $broker     =   round((($value->value/100)*10),2);
                    $realtor    =   round(($totalValue - $broker),2);
                    $valueBroker=   $broker;

                    // -- ## PRIMEIRO NÍVEL DE COMISSÃO
                    if(isset($user) && isset($user->id) && !is_null($user->id)) {
                        $userComission          =   UserCompensation::where('id_user',$user->id)
                                                    ->whereRaw('? between min_value and max_value',[$value->value])
                                                    ->where('type',$value->type)
                                                    ->first();

                        if(isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) {
                            $valueFirst             =   round((($realtor/100)*$userComission->percentual),2);

                            $payment                =   new PaymentModel;
                            $payment->id_contract   =   $value->id_contract;
                            $payment->id_user       =   $user->id;
                            $payment->value         =   $totalValue;
                            $payment->comission     =   $valueFirst;
                            $payment->percent       =   $userComission->percentual;
                            $payment->payment_date  =   Carbon::now();
                            $payment->save();
                        } // if(isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) { ... }
                    } // if(isset($user) && isset($user->id) && !is_null($user->id)) { ... }

                    # Indicação para nível 1
                    if(isset($user) && isset($user->id) && !is_null($user->id) && !is_null($user->id_user_recommend)) {
                        $user                   =   User::find($user->id_user_recommend);
                        if(isset($user) && isset($user->percent) && !is_null($user->percent) && $user->percent > 0) {
                            $valueFirst             =   round((($broker/100)*$user->percent),2);

                            if(round(($valueBroker - $valueFirst),2) > 0) {
                                $payment                =   new PaymentModel;
                                $payment->id_contract   =   $value->id_contract;
                                $payment->id_user       =   $user->id;
                                $payment->value         =   $broker;
                                $payment->comission     =   $valueFirst;
                                $payment->percent       =   $user->percent;
                                $payment->payment_date  =   Carbon::now();
                                $payment->save();

                                $valueBroker            =   round(($valueBroker - $valueFirst),2);
                            }
                        } // if(isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) { ... }
                    } // if(isset($user) && isset($user->id) && !is_null($user->id) && !is_null($user->id_user_recommend)) { ... }


                    if($valueBroker > 0) {
                        // Comissão para Legacy
                        $payment                =   new PaymentModel;
                        $payment->id_contract   =   $value->id_contract;
                        $payment->id_user       =   null;
                        $payment->value         =   $broker;
                        $payment->comission     =   $valueBroker;
                        $payment->percent       =   3;
                        $payment->payment_date  =   Carbon::now();
                        $payment->save();
                    } // if($valueBroker > 0) { ... }
                    

                    Contract::where('id_contract',$value->id_contract)
                    ->update([
                        'payment_exec'  =>  true,
                        'payment_date'  =>  Carbon::now(),
                    ]);
                } // foreach ($listContracts as $key => $value) { ... }

                return 0;
            }
            catch(Exception $error) {
                return 1;
            }
        }
    }
