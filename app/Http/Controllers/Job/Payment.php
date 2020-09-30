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

                    // -- ## RETIRADA DE PERCENTUAL PARA BROKER
                    $percBroker             =   round((($value->value/100)*10),2);
                    $valor                  =   round(($value->value - $percBroker),2);
                    $valueBroker            =   $valor;

                    // -- ## PRIMEIRO NÍVEL DE COMISSÃO
                    if(isset($user) && isset($user->id) && !is_null($user->id)) {
                        $userComission          =   UserCompensation::where('id_user',$user->id)
                                                    ->whereRaw('? between min_value and max_value',[$value->value])
                                                    ->first();
                        if(isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) {
                            $valueFirst             =   round((($valor/100)*$userComission->percentual),2);

                            $payment                =   new PaymentModel;
                            $payment->id_contract   =   $value->id_contract;
                            $payment->id_user       =   $user->id;
                            $payment->value         =   $valor;
                            $payment->comission     =   $valueFirst;
                            $payment->percent       =   $userComission->percentual;
                            $payment->payment_date  =   Carbon::now();
                            $payment->save();
                        } // if(isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) { ... }
                    } // if(isset($user) && isset($user->id) && !is_null($user->id)) { ... }

                    if(isset($user) && isset($user->id) && !is_null($user->id) && !is_null($user->id_user_recommend)) {
                        // -- ## SEGUNDO NÍVEL DE COMISSÃO
                        $user                   =   User::find($user->id_user_recommend);
                        $userComission          =   UserCompensation::where('id_user',$user->id)
                                                    ->whereRaw('? between min_value and max_value',[$valueBroker])
                                                    ->first();

                        if(isset($user) && isset($user->id) && is_null($user->id) && isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) {
                            $valueFirst             =   round((($valueBroker/100)*$userComission->percentual),2);

                            $payment                =   new PaymentModel;
                            $payment->id_contract   =   $value->id_contract;
                            $payment->id_user       =   $user->id;
                            $payment->value         =   $valueBroker;
                            $payment->comission     =   $valueFirst;
                            $payment->percent       =   $userComission->percentual;
                            $payment->payment_date  =   Carbon::now();
                            $payment->save();

                            $valueBroker            =   round($valueBroker - $valueFirst,2);
                        } // if(isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) { ... }

                        // -- ## TERCEIRO NÍVEL DE COMISSÃO
                        if(isset($user) && isset($user->id) && !is_null($user->id) && !is_null($user->id_user_recommend)) {
                            $user                   =   User::find($user->id_user_recommend);
                            $userComission          =   UserCompensation::where('id_user',$user->id)
                                                        ->whereRaw('? between min_value and max_value',[$valueBroker])
                                                        ->first();

                            if(isset($user) && isset($user->id) && is_null($user->id) && isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) {
                                $valueFirst             =   round((($valueBroker/100)*$userComission->percentual),2);

                                $payment                =   new PaymentModel;
                                $payment->id_contract   =   $value->id_contract;
                                $payment->id_user       =   $user->id;
                                $payment->value         =   $valueBroker;
                                $payment->comission     =   $valueFirst;
                                $payment->percent       =   $userComission->percentual;
                                $payment->payment_date  =   Carbon::now();
                                $payment->save();

                                $valueBroker            =   round($valueBroker - $valueFirst,2);
                            } // if(isset($userComission) && isset($userComission->percentual) && !is_null($userComission->percentual)) { ... }
                        } // if(isset($user) && isset($user->id) && !is_null($user->id) && !is_null($user->id_user_recommend)) { ... }
                    } // if(isset($user) && isset($user->id) && !is_null($user->id)) { ... }
                } // foreach ($listContracts as $key => $value) { ... }
            }
            catch(Exception $error) {
                return 1;
            }
        }
    }
