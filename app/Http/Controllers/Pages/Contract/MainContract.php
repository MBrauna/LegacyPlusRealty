<?php

    namespace App\Http\Controllers\Pages\Contract;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Auth;
    use Carbon\Carbon;
    
    use App\Models\Archive;
    use App\Models\Contract;
    use App\Models\ContractAddress;
    use App\Models\ContractPhone;
    use App\User;

    class MainContract extends Controller
    {
        public function list(Request $request) {
            try {
                $contracts      =   Contract::where('end_contract','>=',Carbon::now())
                                    ->where('id_user_seller',Auth::user()->id)
                                    ->get();

                foreach ($contracts as $key => $value) {
                    $contracts[$key]->allDesc                   =   (object)[];
                    $contracts[$key]->allDesc->start_contract   =   Carbon::parse($value->start_contract)->format('m/d/Y');
                    $contracts[$key]->allDesc->end_contract     =   Carbon::parse($value->end_contract)->format('m/d/Y');
                    $contracts[$key]->allDesc->payment_date     =   Carbon::parse($value->payment_date)->format('m/d/Y');
                    $contracts[$key]->allDesc->payment_exec     =   $value->payment_exec ? 'Paid' : 'Unpaid';
                    $contracts[$key]->allDesc->value            =   'US$ '.number_format($value->value, 2, '.', ',');
                    $contracts[$key]->allDesc->id_user_seller   =   User::find($value->id_user_seller);


                    switch ($value->type) {
                        case 1:
                            $contracts[$key]->allDesc->type =   'Sales';
                            break;
                        case 2:
                            $contracts[$key]->allDesc->type =   'Rental';
                            break;
                        default:
                            $contracts[$key]->allDesc->type =   'Error';
                            break;
                    } // switch ($value->type) { ... }
                } // foreach ($contracts as $key => $value) { ... }

                return view('pages.contract.list',[
                    'contracts' =>  $contracts,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }

        public function id(Request $request) {
            try {
                if(is_null($request->id_contract)) return redirect()->route('contract.list');

                $contract  =   Contract::find($request->id_contract);

                if(!Auth::user()->admin) {
                    return redirect()->route('contract.list');
                } // if(!Auth::user()->admin) { ... }

                if(is_null($contract)) return redirect()->route('contract.list');

                $contract->allDesc                  =   (object)[];
                $contract->allDesc->start_contract  =   Carbon::parse($contract->start_contract)->format('m/d/Y');
                $contract->allDesc->end_contract    =   Carbon::parse($contract->end_contract)->format('m/d/Y');
                $contract->allDesc->payment_date    =   Carbon::parse($contract->payment_date)->format('m/d/Y');
                $contract->allDesc->payment_exec    =   $contract->payment_exec ? 'Paid' : 'Unpaid';
                $contract->allDesc->value           =   'US$ '.number_format($contract->value, 2, '.', ',');
                $contract->allDesc->id_user_seller  =   User::find($contract->id_user_seller);

                switch ($contract->type) {
                    case 1:
                        $contract->allDesc->type =   'Sales';
                        break;
                    case 2:
                        $contract->allDesc->type =   'Rental';
                        break;
                    default:
                        $contract->allDesc->type =   'Error';
                        break;
                } // switch ($value->type) { ... }

                $address    =   ContractAddress::where('id_contract',$request->id_contract)->orderBy('id_contract_address','asc')->get();
                $phone      =   ContractPhone::where('id_contract',$request->id_contract)->orderBy('id_contract_phone','asc')->get();
                $archive    =   Archive::where('id_contract',$request->id_contract)->orderBy('name_file','asc')->get();

                foreach ($archive as $key => $value) {
                    $archive[$key]->allDesc =   (object)[];
                    $archive[$key]->allDesc->created_at         =   Carbon::parse($value->created_at)->format('m/d/Y');
                    $archive[$key]->allDesc->id_user_created    =   User::find($value->id_user_created);
                    $archive[$key]->allDesc->length             =   number_format($value->length,0,'.',',').' KB';
                } // foreach ($archive as $key => $value) { ... }

                return view('pages.contract.id',[
                    'contract'  =>  $contract,
                    'address'   =>  $address,
                    'phone'     =>  $phone,
                    'archive'   =>  $archive,
                ]);

            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        }
    } // class MainContract extends Controller { ... }
