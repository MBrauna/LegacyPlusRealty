<?php

    namespace App\Http\Controllers\Pages\Archive;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use DB;
    use Auth;
    
    use App\Models\Archive;

    class MainArchive extends Controller
    {
        public function index(Request $request) {

            $archive        =   Archive::where('id_user',Auth::user()->id)->get();
            $contentGroup   =   [];

            foreach (user_group(Auth::user()->id) as $group) {
                $tmpContent             =   $group;
                $tmpContent['archive']  =   Archive::where('id_group',$group->id_users_group)->get();

                array_push($contentGroup,(object)$tmpContent);
            } // foreach (user_group(Auth::user()-id) as $group) { ... }

            return view('pages.archive.list',[
                // Lista de arquivos atribuidos ao usuário
                'archives'  =>  $archive,
                'groups'    =>  $contentGroup,
            ]);
        }
    }
