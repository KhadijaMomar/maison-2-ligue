<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\connexionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CollaborateurController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AuthUtilisateur;
// Authentification (unique page pour admin et collaborateur)
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'handleLogin');
    Route::get('/utilisateur/dashboard', 'dashboard');
    Route::post('/logout','logout')->name('logout');
    
});

//Route::get('/', [connexionController::class, 'index']); 

Route::get('/connexion', function () {
    return view('login', [
        'titre' => 'Connexion',
        'date' => new DateTime(),
    ]);
});