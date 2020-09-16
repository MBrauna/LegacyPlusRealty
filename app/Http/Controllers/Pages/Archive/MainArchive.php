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

            $archive    =   Archive::get();

            return view('pages.archive.list',[
                // Lista de arquivos atribuidos ao usuário
                'archives'  =>  $archive,
            ]);
        }
    }
