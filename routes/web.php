<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SpecialtiesController;
use App\Http\Controllers\PresentacionController;

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



	// PRESENTACION
	Route::controller(PresentacionController::class)->prefix('presentaciones')->group(function(){
		Route::get('restore//{id}', 'restore');
		Route::get('', 'index')->name('presentaciones');
		Route::get('/records', 'records');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});

	// ESPECIE
	Route::controller(EspecieController::class)->prefix('especies')->group(function(){
		Route::get('restore//{id}', 'restore');
		Route::get('', 'index')->name('especies');
		Route::get('/records', 'records');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});

	// SUB-ESPECIE
	Route::controller(SubEspecieController::class)->prefix('subespecies')->group(function(){
		Route::get('restore//{id}', 'restore');
		Route::get('', 'index')->name('subespecies');
		Route::get('/records', 'records');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});

	// MATRIZ
	Route::controller(MatrizController::class)->prefix('matrices')->group(function(){
		Route::get('restore//{id}', 'restore');
		Route::get('', 'index')->name('matrices');
		Route::get('/records', 'records');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});

	// MATRIZ-MUESTRA
	Route::controller(MuestraController::class)->prefix('muestras')->group(function(){
		Route::get('restore//{id}', 'restore');
		Route::get('', 'index')->name('muestras');
		Route::get('/records', 'records');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});

	// LABORATORIOS
	Route::controller(LaboratorioController::class)->prefix('laboratorios')->group(function(){
		Route::get('restore//{id}', 'restore');
		Route::get('', 'index')->name('laboratorios');
		Route::get('/records', 'records');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});

	// METODOS
	Route::controller(MetodoController::class)->prefix('metodos')->group(function(){
		Route::get('restore//{id}', 'restore');
		Route::get('', 'index')->name('metodos');
		Route::get('/records', 'records');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});

	// PRUEBA
	Route::controller(PruebaController::class)->prefix('pruebas')->group(function(){
		Route::get('restore//{id}', 'restore');
		Route::get('', 'index')->name('pruebas');
		Route::get('/records', 'records');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});
