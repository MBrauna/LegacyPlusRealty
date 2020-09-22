<?php

    namespace App\Http\Controllers\Pages\Admin\Contract;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Carbon\Carbon;
    use Validator;

    use App\Models\Contract;
    use App\Models\ContractAddress;
    use App\Models\ContractPhone;
    use App\Models\Archive;
    use App\User;

    class MainContract extends Controller {
        public function list(Request $request) {
            try {
                $contracts      =   Contract::where('start_contract','>=',Carbon::now()->subYears(1))->get();

                foreach ($contracts as $key => $value) {
                    $contracts[$key]->allDesc                   =   (object)[];
                    $contracts[$key]->allDesc->start_contract   =   Carbon::parse($value->start_contract)->format('m/d/Y');
                    $contracts[$key]->allDesc->end_contract     =   Carbon::parse($value->end_contract)->format('m/d/Y');
                    $contracts[$key]->allDesc->payment_date     =   Carbon::parse($value->payment_date)->format('m/d/Y');
                    $contracts[$key]->allDesc->payment_exec     =   $value->payment_exec ? 'Paid' : 'Unpaid';
                    $contracts[$key]->allDesc->value            =   'US$ '.number_format($value->value, 2, ',', ' ');
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

                return view('pages.admin.contract.contractList',[
                    'contracts' =>  $contracts,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }

        public function createPage(Request $request) {
            try {
                $users  =   User::orderBy('name','asc')->get();
                $minDate=   Carbon::now()->format('Y-m-d');

                foreach ($users as $key => $value) {
                    $users[$key]->allDesc                       =   (object)[];
                    $users[$key]->allDesc->percent              =   number_format($value->percent,2,',',' ').'%';
                    $users[$key]->allDesc->id_user_recommend    =   (is_null($value->id_user_recommend) ? null : User::find($value->id_user_recommend));
                } // foreach ($users as $key => $value) { ... }

                $types  =   [
                    (object)[
                        'code'  =>  1,
                        'name'  =>  'Sale',
                    ],
                    (object)[
                        'code'  =>  2,
                        'name'  =>  'Rental',
                    ],
                ];

                return view('pages.admin.contract.create',[
                    'users'     =>  $users,
                    'types'     =>  $types,
                    'minDate'   =>  $minDate,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function createPage(Request $request) { ... }

        public function add(Request $request) {
            try {
                $validator = Validator::make($request->all(), [
                    'type'              =>  'required|integer',
                    'id_user_seller'    =>  'required|integer',
                    'start_contract'    =>  'required|date',
                    'end_contract'      =>  'required|date',
                    'value'             =>  'required|regex:/^\d+(\.\d{1,2})?$/',
                    'description'       =>  'required|string',
                ]);
        
                if ($validator->fails()) {
                    return back();
                } // if ($validator->fails()) { ... }

                $contract                   =   new Contract;
                $contract->type             =   $request->type;
                $contract->start_contract   =   Carbon::parse($request->start_contract);
                $contract->end_contract     =   Carbon::parse($request->end_contract);
                $contract->payment_date     =   null;
                $contract->payment_exec     =   false;
                $contract->value            =   $request->value;
                $contract->id_user_seller   =   $request->id_user_seller;
                $contract->description      =   $request->description;
                $contract->save();


                if(isset($request->address) && count($request->address) > 0) {
                    foreach ($request->address as $key => $value) {
                        $contractAddress                =   new ContractAddress;
                        $contractAddress->id_contract   =   $contract->id_contract;
                        $contractAddress->address       =   $request->address[$key];
                        $contractAddress->city          =   $request->city[$key];
                        $contractAddress->state         =   $request->state[$key];
                        $contractAddress->country       =   $request->country[$key];
                        $contractAddress->postal_code   =   $request->postal_code[$key];
                        $contractAddress->save();
                    } // foreach ($request->address as $key => $value) { ... }
                } // if(isset($request->address) && count($request->address) > 0) { .. }

                if(isset($request->ddi) && count($request->ddi) > 0) {
                    foreach ($request->ddi as $key => $value) {
                        $contractPhone              =   new ContractPhone;
                        $contractPhone->id_contract =   $contract->id_contract;
                        $contractPhone->ddi         =   $request->ddi[$key];
                        $contractPhone->ddd         =   $request->ddd[$key];
                        $contractPhone->phone       =   $request->phone[$key];
                        $contractPhone->save();
                    } // foreach ($request->ddi as $key => $value) { ... }
                } // if(isset($request->ddi) && count($request->ddi) > 0) { ... }

                return redirect()->route('admin.contract.id',[
                    'id_contract'   =>  $contract->id_contract,
                ]);

            } // try { ... }
            catch(Exception $error) {
                return back();
            } // catch(Exception $error) { ... }
        } // public function createPage(Request $request) { ... }

        public function id(Request $request) {
            try {
                if(is_null($request->id_contract)) return redirect()->route('admin.contract.list');

                $contract  =   Contract::find($request->id_contract);

                if(is_null($contract)) return redirect()->route('admin.contract.list');

                $contract->allDesc                  =   (object)[];
                $contract->allDesc->start_contract  =   Carbon::parse($contract->start_contract)->format('m/d/Y');
                $contract->allDesc->end_contract    =   Carbon::parse($contract->end_contract)->format('m/d/Y');
                $contract->allDesc->payment_date    =   Carbon::parse($contract->payment_date)->format('m/d/Y');
                $contract->allDesc->payment_exec    =   $contract->payment_exec ? 'Paid' : 'Unpaid';
                $contract->allDesc->value           =   'US$ '.number_format($contract->value, 2, ',', ' ');
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
                    $archive[$key]->allDesc->length             =   number_format($value->length,0,',',' ').' KB';
                } // foreach ($archive as $key => $value) { ... }

                return view('pages.admin.contract.id',[
                    'contract'  =>  $contract,
                    'address'   =>  $address,
                    'phone'     =>  $phone,
                    'archive'   =>  $archive,
                ]);

            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('admin.contract.list');
            } // catch(Exception $error) { ... }
        } // public function id(Request $request) { ... }
    } // class MainContract extends Controller { ... }