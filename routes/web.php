<?php

    use Illuminate\Support\Facades\Route;

    Auth::routes([
        'register' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
    ]);

    // Rotas protegidas pelo Sanctum
    Route::middleware(['auth'])->namespace('Pages')->group(function(){
        // [home] - Rota para tela principal
        Route::any('/',function(){ return redirect()->route('dashboard.home'); })->name('home');
        // [profile]
        Route::any('/profile','Profile\Profile@profile')->name('profile');
        
        // Dados para dashboard - MainDashboard
        Route::prefix('dashboard')->name('dashboard.')->namespace('Dashboard')->group(function(){
            // [dashboard.home]
            Route::any('/','MainDashboard@index')->name('home');
        }); // Route::prefix('dashboard')->name('dashboard.')->group(function(){ ... });


        Route::prefix('quickAccess')->name('quickAccess.')->namespace('QuickAccess')->group(function(){
            // [quickAcess.list]
            Route::any('/','MainQuickAccess@index')->name('list');
        }); // Route::prefix('quickAccess')->name('quickAccess.')->namespace('QuickAccess')->group(function(){ ... });


        Route::prefix('archive')->name('archive.')->namespace('Archive')->group(function(){
            // [archive.list]
            Route::any('/','MainArchive@index')->name('list');
            // [archive.import]
            Route::any('/import','ImportFile@index')->name('import');
        }); // Route::prefix('archive')->name('archive.')->namespace('Archive')->group(function(){ ... });

        Route::prefix('contract')->name('contract.')->namespace('Contract')->group(function(){
            // [contract.list]
            Route::any('/','MainContract@list')->name('list');
            // [contract.id]
            Route::any('/{id_contract}','MainContract@id')->name('id');
        });




        Route::middleware('admin')->prefix('admin')->name('admin.')->namespace('Admin')->group(function(){
            // [admin.home]
            Route::any('/',function(){ return redirect()->route('admin.users.list'); })->name('home');

            // [admin.contract]
            Route::namespace('Contract')->prefix('contract')->name('contract.')->group(function(){
                // [admin.contract.list]
                Route::any('/','MainContract@list')->name('list');
                // [admin.contract.create]
                Route::any('/create','MainContract@createPage')->name('create');
                // [admin.contract.idList]
                Route::any('/id',function(){ return redirect()->route('admin.contract.list'); })->name('idList');
                // [admin.contract.id]
                Route::any('/id/{id_contract}','MainContract@id')->name('id');
                // [admin.contract.add]
                Route::post('/add','MainContract@add')->name('add');
            }); // Route::namespace('Contract')->prefix('contract')->name('contract.')->group(function(){ ... });

            // [admin.financial]
            Route::namespace('Financial')->prefix('financial')->name('financial.')->group(function(){
                // [admin.financial.home]
                Route::any('/',function(){ return redirect()->route('admin.financial.list'); });

                // [admin.financial.list]
                Route::any('/list','MainFinancial@list')->name('list');
                // [admin.financial.additional]
                Route::post('/additional','MainFinancial@additional')->name('additional');
                // [admin.financial.confirm]
                Route::post('/confirm','MainFinancial@confirm')->name('confirm');
            }); // Route::namespace('Financial')->prefix('financial')->name('financial.')->group(function(){ ... });

            // [admin.utilities]
            Route::namespace('Utilities')->prefix('utilities')->name('utilities.')->group(function(){
                // [admin.financial.home]
                Route::any('/',function(){ return redirect()->route('dashboard.home'); })->name('home');

                // [admin.utilities.file]
                Route::any('/file','MainArchive@list')->name('file');

                // [admin.utilities.link]
                Route::any('/link','MainLink@list')->name('link');
                // [admin.utilities.linkAdd]
                Route::post('/linkAdd','MainLink@add')->name('linkAdd');
                // [admin.utilities.linkRemove]
                Route::post('/linkRemove','MainLink@remove')->name('linkRemove');
            }); // Route::namespace('Utilities')->prefix('utilities')->name('utilities.')->group(function(){ ... }

            // [admin.group]
            Route::namespace('Group')->name('group.')->prefix('group')->group(function(){
                // [admin.group.home]
                Route::any('/',function(){ return redirect()->route('dashboard.home'); })->name('home');

                // [admin.group.list]
                Route::any('/list','MainGroup@list')->name('list');
                // [admin.group.save]
                Route::post('/save','MainGroup@save')->name('save');
                // [admin.group.update]
                Route::post('/update','MainGroup@update')->name('update');
                // [admin.group.user]
                Route::any('/user','MainGroup@groupUsers')->name('user');
                // [admin.group.addGroup]
                Route::post('/addGroup','MainGroup@addGroupUser')->name('addGroup');
                // [admin.group.removeGroup]
                Route::post('/removeGroup','MainGroup@removeGroupUser')->name('removeGroup');
                // [admin.group.archive]
                Route::any('/archive','MainGroup@archive')->name('archive');
            }); // Route::namespace('Group')->name('group.')->prefix('group')->group(function(){ ... });

            Route::namespace('User')->name('user.')->prefix('user')->group(function(){
                // [admin.user.home]
                Route::any('/',function(){ return redirect()->route('dashboard.home'); })->name('home');

                // [admin.user.list]
                Route::any('/list','MainUser@list')->name('list');
                // [admin.user.pageAdd]
                Route::any('/add','MainUser@pageAdd')->name('pageAdd');
                // [admin.user.pageEdit]
                Route::any('/edit','MainUser@pageEdit')->name('pageEdit');
                // [admin.user.save]
                Route::any('/save','MainUser@save')->name('save');
                // [admin.user.update]
                Route::any('/update','MainUser@update')->name('update');
            });
        }); // Route::prefix('admin')->name('admin')->namespace('Admin')->group(function(){ ... }
    });