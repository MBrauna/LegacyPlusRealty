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
        public function paymentJob($content){
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

                    $this->message($content, "Teste - {$totalValue} -----> {$broker} ----> {$realtor} -----> {$valueBroker}");
                } // foreach ($listContracts as $key => $value) { ... }

                return 0;
            }
            catch(Exception $error) {
                return 1;
            }
        }

        private function message($content, $text) {
            if(isset($content) && !is_null($content)) {
                $content->info("[INFO] - {$text}");
            } // if(isset($content) && !is_null($content)) { ... }
        } // private function message($content) { ... }
    }
