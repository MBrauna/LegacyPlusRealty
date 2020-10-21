<?php

    namespace App\Http\Controllers\Pages;

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
                $idUsuario  =   null;
                $idGroup    =   null;
                $idContract =   null;

                switch($legacyType) {
                    case 1:
                        $idUsuario  =   Auth::user()->id;
                        $idGroup    =   null;
                        $idContract =   null;

                        break;

                    case 2:
                        $idUsuario  =   null;
                        $idGroup    =   $request->input('idGroup');
                        $idContract =   null;

                        if(is_null($idGroup)) {
                            return response()->json([
                                'error' =>  [
                                    'code'  =>  'LEGACY002',
                                    'message'   =>  'Importação falhou!'
                                ]
                            ],500);
                        }
                        break;

                    case 3:
                        $idUsuario  =   null;
                        $idGroup    =   null;
                        $idContract =   $request->input('idContract');

                        if(is_null($idContract)) {
                            return response()->json([
                                'error' =>  [
                                    'code'  =>  'LEGACY002',
                                    'message'   =>  'Importação falhou!'
                                ]
                            ],500);
                        }

                        break;

                    case 4:
                        $idUsuario  =   $request->input('idUser');
                        $idGroup    =   null;
                        $idContract =   null;

                        if(is_null($idUsuario)) {
                            return response()->json([
                                'error' =>  [
                                    'code'  =>  'LEGACY002',
                                    'message'   =>  'Importação falhou!'
                                ]
                            ],500);
                        }
                        break;

                    default:
                        return response()->json([
                            'error' =>  [
                                'code'  =>  'LEGACY002',
                                'message'   =>  'Importação falhou!'
                            ]
                        ],500);
                        break;
                }

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
                        $archive->id_user           =   $idUsuario;
                        $archive->id_group          =   $idGroup;
                        $archive->id_contract       =   $idContract;
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
