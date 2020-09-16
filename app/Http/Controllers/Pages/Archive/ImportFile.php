<?php

    namespace App\Http\Controllers\Pages\Archive;

    use Illuminate\Support\Facades\Storage;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use DB;
    use Auth;
    use Carbon\Carbon;
    use App\Models\Archive;

    class ImportFile extends Controller
    {
        public function index(Request $request) {
            try {
                $file       =   $request->file('file');
                $legacyType =   intval($request->input('legacy_type',1));

                Archive::where('id_archive','>=',1)->delete();

                if($request->hasFile('file')) {
                    $repository =   'public';

                    try {
                        switch ($legacyType) {
                            case 1:
                                $repository =   'user';
                                break;
                            case 2:
                                $repository =   'group';
                                break;
                            case 3:
                                $repository =   'contract';
                                break;
                            default:
                                $repository =   'public';
                                break;
                        } // switch ($legacyType) { ... }

                        $nameServer                 =   'LegacyPlus'.uniqid().'-'.Carbon::now()->timestamp.'.'.$file->getClientOriginalExtension();
    
                        $archive                    =   new Archive;
                        $archive->id_user           =   $legacyType == 1 ? Auth::user()->id : null;
                        $archive->id_group          =   $legacyType == 2 ? intval($request->id_group) : null;
                        $archive->id_contract       =   $legacyType == 3 ? intval($request->id_contract) : null;
                        $archive->id_user_created   =   Auth::user()->id;
                        $archive->local             =   true;
                        $archive->repository        =   $repository;
                        $archive->name_server       =   $nameServer;
                        $archive->name_file         =   $file->getClientOriginalName();
                        $archive->extension         =   $file->getClientOriginalExtension();
                        $archive->mime              =   $file->getMimeType();
                        $archive->length            =   $file->getSize();

                        $archive->save();
    
                        $request->file('file')->storeAs($repository, $nameServer);

                    } // try { ... }
                    catch(Exception $erro) {
                        DB::rollback();
                        return response()->json([
                            'error' =>  [
                                'code'  =>  'LEGACY002',
                                'message'   =>  'Importação falhou!'
                            ]
                        ],500);
                    } // catch(Exception $erro) { ... }
                } // if($request->hasFile('arquivoBPMS') && count($arquivos) > 0) { ... }
                
                
                return response()->json([
                    'success'   =>  true,
                ],200);


            } // try { ... }
            catch(Exception $error) {
                return response()->json([
                    'error' =>  [
                        'code'  =>  'LEGACY001',
                        'message'   =>  'Importação falhou!'
                    ]
                ],500);
            } // catch(Exception $error) { ... }
        } // public function index(Request $request) { ... }
    }
