<?php

    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Auth;
    use App\User;
    use Carbon\Carbon;
    use App\Models\Contract;

    class MainContract extends Controller
    {
        public function list(Request $request) {
            $contract   =   Contract::where('contract_date','>=',Carbon::now()->subMonths(1))->orderBy('contract_date','asc')->get();

            foreach ($contract as $key => $value) {
                $contract[$key]->user   =   User::find($value->id_user_seller);
            } // foreach ($contract as $key => $value) { ... }

            $users      =   User::orderBy('name','asc')->get();

            return view('pages.admin.contract',[
                'contracts' =>  $contract,
                'users'     =>  $users,
            ]);
        } // public function list(Request $request) { ... }

        public function add(Request $request) {
            try {
                $type           =   intval($request->input('type',1));
                $contractDate   =   $request->input('contractDate');
                $paymentDate    =   $request->input('paymentDate');
                $address        =   $request->input('address');
                $description    =   $request->input('description');
                $value          =   str_replace('.',',',$request->input('value',0));
                $seller         =   $request->input('idUserSeller');

                if(is_null($type) || is_null($contractDate) || is_null($paymentDate) || is_null($address) || is_null($value) || is_null($seller)) {
                    return redirect()->route('admin.contract.list');
                } // if(is_null($type) || is_null($contractDate) || is_null($paymentDate) || is_null($address) || is_null($value) || is_null($seller)) { ... }

                $contract                   =   new Contract;
                $contract->type             =   $type;
                $contract->contract_date    =   Carbon::parse($contractDate);
                $contract->payment_date     =   Carbon::parse($paymentDate);
                $contract->payment          =   false;
                $contract->value            =   doubleval($value);
                $contract->id_user_seller   =   intval($seller);
                $contract->id_housing       =   null;
                $contract->address          =   $address;
                $contract->description      =   $description;

                $contract->save();

                return redirect()->route('admin.contract.list');
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function add(Request $request) { ... }
    }
