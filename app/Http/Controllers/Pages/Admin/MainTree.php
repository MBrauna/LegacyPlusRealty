<?php

    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\Models\TreeComission;
    use App\User;

    class MainTree extends Controller
    {
        private function childData($idData) {
            $return =   TreeComission::where('id_tree_comission_prev',$idData)->get();

            foreach ($return as $key => $value) {
                $return[$key]->child    =   TreeComission::where('id_tree_comission_prev',$value->id_tree_comission)->get();
                $return[$key]->user     =   User::find($value->id_user);

                if(count($return[$key]->child) > 0) {
                    foreach ($return[$key]->child as $keyChild => $valueChild) {
                        $return[$key]->child[$keyChild]->child  =   $this->childData($valueChild->id_tree_comission);
                        $return[$key]->child[$keyChild]->user   =   User::find($valueChild->id_user);
                    } // foreach ($return[$key]->child as $keyChild => $valueChild) { ... }
                } // if(count($return[$key]->child) > 0) { ... }
                else {
                    $return[$key]->child    =   [];
                }
            } // foreach ($return as $key => $value) { ... }

            return $return;
        } // private function childData($idData) { ... }

        public function list(Request $request) {
            try {
                // Peguei os nós principais de cada um
                $treeData   =   TreeComission::whereNull('id_tree_comission_prev')->get();
                $treeList   =   TreeComission::all();
                $mainTree   =   [];

                foreach ($treeData as $key => $data) {
                    $treeData[$key]->child  =   $this->childData($data->id_tree_comission);
                    $treeData[$key]->user   =   User::find($data->id_user);
                } // foreach ($treeData as $key => $data) { ... }

                foreach($treeList  as $key => $data) {
                    $treeList[$key]->user   =   User::find($data->id_user);
                } // foreach($treeList  as $key => $data) { ... }

                $users      =   User::all();

                return view('pages.admin.tree',[
                    'tree'      =>  $treeData,
                    'treeList'  =>  $treeList,
                    'user'      =>  $users,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return response()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }

        public function add(Request $request) {
            try {
                $idPrevNode =   $request->input('idPrevNode');
                $idUser     =   $request->input('idUser');
                $percent    =   str_replace('.',',',$request->input('percentual',0));

                if(is_null($idUser) || is_null($percent)) return redirect()->route('admin.tree.list');

                $tree                           =   new TreeComission;
                $tree->id_tree_comission_prev   =   is_null($idPrevNode) ? null : intval($idPrevNode);
                $tree->id_user                  =   intval($idUser);
                $tree->percent                  =   doubleval($percent);
                $tree->save();

                return redirect()->route('admin.tree.list');
            } // try { ... }
            catch(Exception $error){
                return response()->route('dashboard.home');
            } // catch(Exception $error){ ... }
        } // public function add(Request $request) { ... }

        public function remove(Request $request) {
            try {
                $idData     =   $request->input('idTreeNode');
                if(is_null($idData)) return redirect()->route('admin.tree.list');

                TreeComission::where('id_tree_comission',$idData)->with('childs')->delete();

                return redirect()->route('admin.tree.list');
            } // try { ... }
            catch(Exception $error) {
                return response()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function remove(Request $request) { ... }
    } // class MainTree extends Controller { ... }
