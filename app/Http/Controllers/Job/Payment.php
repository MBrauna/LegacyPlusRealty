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
    
    
                foreach($listContracts as $key => $value) {
                    // Limpa os dados do contrato que foram gerados.
                    PaymentModel::where('id_contract',$value->id_contract)->delete();
                    
                    // Coleta o valor para o vendedor
                    $user   =   User::find($value->id_user_seller);
                    
                    // Comissão de árvore para segundo comissionamento
                    if(is_null($user->id_user_recommend)) {
                        $userSec    =   null;
                    } // if(is_null($user->id_user_recommend)) { ... }
                    else {
                        $userSec    =   User::find($user->id_user_recommend);
                    } // else { ... }
                    // Comissão de árvore para terceiro comissionamento
                    if(is_null($userSec) || is_null($userSec->id_user_recommend)) {
                        $userFinal  =   null;
                    } // if(is_null($userSec) || is_null($userSec->id_user_recommend)) { ... }
                    else {
                        $userFinal  =   User::find($userSec->id_user_recommend);
                    } // else { ... }
    
    
                    // Coleta o valor do contrato
                    $valueLegacy=   (($value->value/100)*10);
    
                    if(is_null($user->percent) || $user->percent == 0) {
                        $valueMain  =   0;
                    } // if(is_null($user->percent) || $user->percent == 0) { ... }
                    else {
                        $percent    =   UserCompensation::where('id_user',$user->id)
                                        ->where('type',$value->type)
                                        ->first();
                        $valueMain  =   round(((($value->value - $valueLegacy)/100)*$percent->percentual),2);
                    } // else { ... }
    
                    if(isset($user->id) && !is_null($user) && $valueMain > 0) {
                        $payment    =   new PaymentModel;
    
                        $payment->id_contract   =   $value->id_contract;
                        $payment->id_user       =   $user->id;
                        $payment->value         =   $value->value;
                        $payment->comission     =   $valueMain;
                        $payment->percent       =   $user->percent ?? 0;
                        $payment->payment_date  =   Carbon::now();
    
                        $payment->save();
    
                    } // if(!is_null($user) || !is_null($user->id)) { ... }
    
                    if(is_null($userSec) || is_null($userSec->percent) || $userSec->percent == 0) {
                        $valueSec   =   0;
                    } // if(is_null($user->percent) || $user->percent == 0) { ... }
                    else {
                        $valueSec   =   round((($valueLegacy/100)*$userSec->percent),2);
                    } // else { ... }
    
    
                    if(isset($userSec) && !is_null($userSec) && $valueSec > 0) {
                        $payment    =   new PaymentModel;
    
                        $payment->id_contract   =   $value->id_contract;
                        $payment->id_user       =   $userSec->id;
                        $payment->value         =   $valueLegacy;
                        $payment->comission     =   $valueSec;
                        $payment->percent       =   $userSec->percent ?? 0;
                        $payment->payment_date  =   Carbon::now();
    
                        $payment->save();
                    } // if(isset($userSec) && !is_null($userSec) && $valueSec > 0) { ... }
                    $valueLegacy=   $valueLegacy - $valueSec;
    
    
                    if($valueLegacy <= 0) {
                        $valueLegacy = 0;
                    } // if($valueLegacy <= 0) { ... }
                    
                    if(is_null($userFinal) || is_null($userFinal->percent) || $userFinal->percent == 0 || $valueLegacy <= 0) {
                        $valueFinal   =   0;
                    } // if(is_null($user->percent) || $user->percent == 0) { ... }
                    else {
                        $valueFinal =   round((($valueLegacy/100)*$userFinal->percent),2);
                    } // else { ... }
    
                    if(isset($userFinal) && !is_null($userFinal) && $valueFinal > 0) {
                        $payment    =   new PaymentModel;
    
                        $payment->id_contract   =   $value->id_contract;
                        $payment->id_user       =   $userFinal->id;
                        $payment->value         =   $valueLegacy;
                        $payment->comission     =   $valueFinal;
                        $payment->percent       =   $userFinal->percent ?? 0;
                        $payment->payment_date  =   Carbon::now();
    
                        $payment->save();
                    } // if(isset($userFinal) && !is_null($userFinal) && $valueFinal > 0) { ... }
                    $valueLegacy=   $valueLegacy - $valueFinal;
    
                    Contract::where('id_contract',$value->id_contract)->update([
                        'payment_exec'  =>  true,
                        'payment_date'  =>  Carbon::now(),
                    ]);
                } // foreach($listContracts as $key => $value) { ... }
            }
            catch(Exception $error) {
                return 1;
            }
        }
    }
