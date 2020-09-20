<?php

    namespace App\Http\Controllers\Pages\Archive;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use DB;
    use Auth;
    
    use App\Models\Archive;
    use App\Models\Group;
    use App\Models\GroupUser;

    class MainArchive extends Controller
    {
        public function index(Request $request) {

            $archive        =   Archive::where('id_user',Auth::user()->id)->orderBy('name_file','asc')->get();
            $contentGroup   =   GroupUser::where('id_user',Auth::user()->id)->select('id_group')->distinct();
            $groups         =   Group::whereIn('id_group',$contentGroup)->get();
            $groupReturn    =   [];

            foreach($groups as $group) {
                $tmpContent             =   $group;
                $tmpContent->archive    =   Archive::where('id_group',$group->id_users_group)->orderBy('name_file','asc')->get();

                array_push($groupReturn,(object)$tmpContent);
            } // foreach (user_group(Auth::user()-id) as $group) { ... }

            return view('pages.archive.list',[
                // Lista de arquivos atribuidos ao usuário
                'archives'  =>  $archive,
                'groups'    =>  $groupReturn,
            ]);
        }
    }
