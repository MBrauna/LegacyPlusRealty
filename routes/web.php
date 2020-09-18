<?php

    use Illuminate\Support\Facades\Route;

    Auth::routes([
        //'register' => false,
    ]);

    // Rotas protegidas pelo Sanctum
    Route::middleware(['auth'])->namespace('Pages')->group(function(){
        // [home] - Rota para tela principal
        Route::any('/',function(){ return redirect()->route('dashboard.home'); })->name('home');
        
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




        Route::middleware('admin')->prefix('admin')->name('admin.')->namespace('Admin')->group(function(){
            // [admin.home]
            Route::any('/',function(){ return redirect()->route('admin.users.list'); })->name('home');

            // [admin.users]
            Route::name('users.')->prefix('users')->group(function(){
                // [admin.users.home]
                Route::any('/',function(){ return redirect()->route('admin.users.list'); })->name('home');

                // [admin.users.list]
                Route::any('/list','MainUsers@list')->name('list');
                // [admin.users.group]
                Route::any('/group','MainGroup@userGroups')->name('group');

                // [admin.users.save]
                Route::post('/save','MainUsers@save')->name('save');
                // [admin.users.update]
                Route::post('/update','MainUsers@update')->name('update');
                // [admin.users.addGroup]
                Route::post('/addGroup','MainGroup@addGroupUser')->name('addGroup');
                // [admin.users.removeGroup]
                Route::post('/removeGroup','MainGroup@removeGroupUser')->name('removeGroup');
            }); // Route::name('users')->group(function(){ ... }

            // [admin.groups]
            Route::name('groups.')->prefix('groups')->group(function(){
                // [admin.users.home]
                Route::any('/',function(){ return redirect()->route('admin.groups.list'); })->name('home');

                // [admin.groups.list]
                Route::any('/list','MainGroup@list')->name('list');
                // [admin.groups.user]
                Route::any('/user','MainGroup@groupUsers')->name('user');

                // [admin.groups.save]
                Route::post('/save','MainGroup@save')->name('save');
                // [admin.groups.update]
                Route::post('/update','MainGroup@update')->name('update');
            }); // Route::name('groups.')->prefix('groups')-group(function(){ ... }

            // [admin.tree]
            Route::name('tree.')->prefix('tree')->group(function(){
                // [admin.tree.home]
                Route::any('/',function(){ return redirect()->route('admin.tree.list'); })->name('home');

                // [admin.tree.list]
                Route::any('/list','MainTree@list')->name('list');
                // [admin.tree.add]
                Route::any('/add','MainTree@add')->name('add');
                // [admin.tree.remove]
                Route::any('/remove','MainTree@remove')->name('remove');
            }); // Route::name('groups.')->prefix('groups')-group(function(){ ... });

            // [admin.archive]
            Route::name('archive.')->prefix('archive')->group(function(){
                // [admin.archive.home]
                Route::any('/',function(){ return redirect()->route('admin.archive.list'); })->name('home');

                // [admin.archive.list]
                Route::any('/list','MainArchive@list')->name('list');
            }); // Route::name('archive.')->prefix('archive')->group(function(){ ... }

            // [admin.link]
            Route::name('link.')->prefix('link')->group(function(){
                // [admin.link.home]
                Route::any('/',function(){ return redirect()->route('admin.link.list'); })->name('home');

                // [admin.link.list]
                Route::any('/list','MainLinks@list')->name('list');
                // [admin.link.add]
                Route::any('/add','MainLinks@add')->name('add');
                // [admin.link.remove]
                Route::any('/remove','MainLinks@remove')->name('remove');
            }); // Route::name('link.')->prefix('link')->group(function(){ ... }
        }); // Route::prefix('admin')->name('admin')->namespace('Admin')->group(function(){ ... }
    });