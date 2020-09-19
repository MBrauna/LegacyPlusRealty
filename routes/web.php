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

            
        }); // Route::prefix('admin')->name('admin')->namespace('Admin')->group(function(){ ... }
    });