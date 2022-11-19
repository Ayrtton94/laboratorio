<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SpecialtiesController;

Route::get('/', function () {
	return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// USUARIOS
// Route::middleware('auth:web')->group(function () {
Route::controller(UsuarioController::class)->middleware(['middleware' => 'auth'])->group( function () {
	Route::get('/usuarios', 'index')->name('usuarios');
	Route::post('/usuarios', 'store');
	Route::get('/usuarios/searchuser', 'searchuser')->name('searchuser');
	Route::post('/usuarios/search', 'search');
	Route::get('/usuarios/create', 'create')->name('usuarioscreate');
	Route::get('/usuarios/records', 'records')->name('records');
	Route::delete('/usuarios/eliminar/{id}', 'destroy');
	Route::get('/usuarios/edit/{id}', 'edit');
	Route::put('/usuarios/update', 'update');
});

//ESPECIALIDADES
Route::get('/specialties/specialtiesrecords', [SpecialtiesController::class, 'records'])->name('records');
//ROLES
Route::get('/roles', [RoleController::class, 'index'])->name('roles');
Route::get('/roles/create', [RoleController::class, 'create'])->name('rolescreate');
Route::post('/roles', [RoleController::class, 'store']);
Route::get('/roles/records', [RoleController::class, 'records'])->name('records');
Route::get('/roles/getpermission', [RoleController::class, 'getPermission']);
Route::delete('/roles/eliminar/{id}', [RoleController::class, 'destroy']);
Route::get('/roles/editroles/{id}', [RoleController::class, 'editroles']);
Route::put('/roles/update', [RoleController::class, 'update']);
Route::get('/roles/hasroles/{id}', [RoleController::class, 'querypermisos']);

//PERMISOS
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
Route::get('/permissions/records', [PermissionController::class, 'records'])->name('records');


// PACIENTES
Route::controller(PatientController::class)->prefix('patients')->group(function(){
    Route::get('', 'index')->name('patients');
    Route::get('/create', 'create')->name('patients-create');
    Route::get('/records', 'records')->name('patients-records');
    Route::post('', 'store');
    Route::post('/search', 'search');
    Route::get('/means', 'means');
});
