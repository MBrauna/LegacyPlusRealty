<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Models\Contract;
use App\Models\UsersGroup;
use App\Models\UsersGroupUser;
use App\Models\TreeComission;
use App\Models\Payment as PaymentModel;

class payment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:comission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executa o módulo de pagamento de comissões';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $listContracts  =   Contract::where('payment_date','<=',Carbon::now()->subDays(1))
                            ->where('payment',false)
                            ->get();

        foreach ($listContracts as $key => $value) {
            try {
                $this->info("Executando {{ $value->id_contract}}");

                // Coleta o grupo com maior percentual do usuário
                $tmpGroup   =   UsersGroupUser::where('id_user',$value->id_user_seller)->get();
                $tmpTree    =   TreeComission::where('id_user',$value->id_user_seller)->get();
                $group      =   null;
                $tree       =   null;

                foreach ($tmpGroup as $keyGroup => $valueGroup) {
                    if(is_null($group)) {
                        $group  =   $valueGroup;
                    } // if(is_null($group)) { ... }
                    else {
                        if($group->percent < $valueGroup->percent) {
                            $group  =   $valueGroup;
                        } // if($group->percent < $valueGroup->percent) { ... }
                    } // else { ... }
                } // foreach ($tmpGroup as $keyGroup => $valueGroup) { ... }

                foreach ($tmpTree as $keyTree => $valueTree) {
                    if(is_null($tree)) {
                        $tree  =   $valueTree;
                    } // if(is_null($group)) { ... }
                    else {
                        if($tree->percent < $valueTree->percent) {
                            $tree  =   $valueTree;
                        } // if($group->percent < $valueGroup->percent) { ... }
                    } // else { ... }
                } // foreach ($tmpGroup as $keyGroup => $valueGroup) { ... }

                // first value - Comission to user
                if(is_null($group)) {
                    $first  =   0;
                }
                else {
                    $group  =   UsersGroup::find($group->id_users_group);
                    $first  =   round((($value->value/100)*$group->percent),2);
                }

                if(is_null($tree) || $first ==  0) {
                    $firstAdditional    =   0;
                } // if(is_null($tree) || $first ==  0) { ... }
                else {
                    $firstAdditional    =   round((($value->value/100)*$tree->percent),2);
                }

                $payment    =   new PaymentModel;

                $payment->id_contract       =   $value->id_contract;
                $payment->id_user           =   $value->id_user_seller;
                $payment->value             =   $value->value;
                $payment->value_aditional   =   $firstAdditional;
                $payment->comission         =   $first;
                $payment->percent_group     =   $group->percent ?? 0;
                $payment->percent_tree      =   $tree->percent ?? 0;
                $payment->payment_date      =   Carbon::now();

                $payment->save();


                Contract::where('id_contract',$value->id_contract)->update([
                    'payment'   =>  true,
                ]);
            }
            catch(Exception $error) {
                $this->info("Error {{ $error }}");
            }

        } // foreach ($listContracts as $key => $value) { ... }

        return 0;
    }
}
