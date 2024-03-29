<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MatrizController;
use App\Http\Controllers\MetodoController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EspecieController;
use App\Http\Controllers\MuestraController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ImprimierController;
use App\Http\Controllers\TipoOrdenController;
use App\Http\Controllers\ApiServiceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SubEspecieController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\ImportSupplierController;
use App\Http\Controllers\CustomerBrucelaController;
use App\Http\Controllers\LaboratorioOrderController;
use App\Http\Controllers\ProgramaBrucellaController;
use App\Http\Controllers\LaboratorioBrucellaController;


Route::get('/', function () {
	return view('auth.login');
});

Auth::routes();

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    // USUARIOS
    Route::controller(UsuarioController::class)->middleware(['middleware' => 'auth'])->group( function () {
        Route::get('/usuarios', 'index')->name('usuarios');
        Route::post('/usuarios', 'store');
        Route::get('/usuarios/records', 'records')->name('records');
        Route::delete('/usuarios/{id}', 'destroy');
        Route::get('/usuarios/restore/{id}', 'restore');
        Route::get('/usuarios/edit/{id}', 'edit');
        Route::put('/usuarios/update', 'update');
    });

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

    //AREA
    Route::controller(AreaController::class)->prefix('areas')->group(function(){
        Route::get('', 'index')->name('areas');
        Route::post('', 'store');
        Route::get('/records', 'records');
		Route::get('restore/{id}', 'restore');
        Route::delete('/{id}', 'destroy');
    });

    //PERMISOS
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::get('/permissions/records', [PermissionController::class, 'records'])->name('records');

	// PRESENTACION
	Route::controller(PresentacionController::class)->prefix('presentaciones')->group(function(){
		Route::get('restore/{id}', 'restore');
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
		Route::get('restore/{id}', 'restore');
		Route::get('', 'index')->name('especies.index');
		Route::get('/records', 'records');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});

	// SUB-ESPECIE
	Route::controller(SubEspecieController::class)->prefix('subespecie')->group(function(){
		Route::get('restore/{id}', 'restore');
		Route::get('', 'index')->name('subespecie.index');
		Route::get('/records', 'records');
		Route::get('/tables', 'tables');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});

	// MATRIZ
	Route::controller(MatrizController::class)->prefix('matrices')->group(function(){
		Route::get('restore/{id}', 'restore');
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
		Route::get('restore/{id}', 'restore');
		Route::get('', 'index')->name('muestras');
		Route::get('/records', 'records');
		Route::get('/tables', 'tables');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});

	// LABORATORIOS
	Route::controller(LaboratorioController::class)->prefix('laboratorios')->group(function(){
		Route::get('restore/{id}', 'restore');
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
		Route::get('restore/{id}', 'restore');
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
		Route::get('restore/{id}', 'restore');
		Route::get('', 'index')->name('pruebas');
		Route::get('/records', 'records');
		Route::get('/tables', 'tables');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});
	// TIPO DE ORDENES
	Route::controller(TipoOrdenController::class)->prefix('tipodeorden')->group(function(){
		Route::get('', 'index')->name('tipodeorden.index');
		Route::post('', 'store');
		Route::get('/records', 'records');
		Route::delete('/{id}', 'destroy');
		Route::get('restore/{id}', 'restore');
	});
	// PERSONAS
	Route::post('/search/persons/{type}', [PersonController::class, 'search']);
	Route::controller(PersonController::class)->prefix('persons')->group(function(){
		Route::get('restore/{id}', 'restore');
		Route::get('columns', 'columns');
		Route::get('tables', 'tables');
		Route::get('table/{table}', 'table');
		Route::get('{type}',  'index')->name('persons.index');
		Route::get('{type}/records', 'records');
        Route::get('record/{id}', 'record');
		Route::post('', 'store');
		Route::delete('{id}', 'destroy');
	});

	//CLIENTE, CLIENTE BRUCELA
	Route::controller(CustomerBrucelaController::class)->prefix('customers')->group(function(){
        Route::get('{type}', 'index')->name('customer.index');
        Route::get('restore/{id}', 'restore');
		Route::get('columns', 'columns');
		Route::get('tables', 'tables');
		Route::get('table/{table}', 'table');
		Route::get('{type}/records', 'records');
        Route::get('record/{id}', 'record');
		Route::post('', 'store');
		Route::delete('{id}', 'destroy');
    });

	//REGISTRO DE EMPRESAS
	Route::controller(CompanyController::class)->prefix('company')->group(function(){
        Route::get('', 'index')->name('company');
        Route::get('restore/{id}', 'restore');
		Route::get('columns', 'columns');
		Route::get('tables', 'tables');
		Route::get('table/{table}', 'table');
		Route::get('{type}/records', 'records');
        Route::get('record/{id}', 'record');
		Route::post('', 'store');
		Route::delete('{id}', 'destroy');
		Route::get('/records', 'records');
    });


	// PROGRAMA BRUCELLAS
	Route::controller(ProgramaBrucellaController::class)->prefix('programabrucellas')->group(function(){
		Route::get('restore/{id}', 'restore');
		Route::get('', 'index')->name('programabrucellas');
		Route::get('/records', 'records');
		Route::get('/tables', 'tables');
		Route::get('/columns', 'columns');
		Route::get('/record/{id}', 'record');
		Route::post('', 'store');
        Route::post('/import', 'import');
		Route::get('/todos', 'todos');
		Route::delete('/{id}', 'destroy');
	});

	Route::get('importar', [ImprimierController::class,'index'])->name('importar.index');
	Route::post('import/programabrucellas', [ImprimierController::class, 'ImportProductEcxel']);


	// LABORATORIO ORDERS
	Route::controller(LaboratorioOrderController::class)->prefix('orders')->group(function(){
		Route::get('', 'index')->name('orders.index');
		Route::get('columns', 'columns');
		Route::get('/records', 'records');
		Route::get('/totals', 'totals');
		Route::get('/crear', 'create')->name('orders.create');
		Route::get('/editar/{order}', 'edit');
		Route::get('tables', 'tables');
		Route::get('/record/{order}', 'record');
		Route::get('/tables3/{order}', 'tables3');
		Route::post('', 'store');
		Route::post('/update/{order}', 'update');
		Route::get('/send/{order}', 'send');
		Route::post('/email', 'email');
		Route::get('/table/{table}', 'table');
		Route::get('/evaluacion/{recordId}', 'evaluacionData');
		Route::post('/status_paid/{id}', 'updatePayment');
		Route::post('/status_order/{id}', 'updateSorder');
		Route::post('/resultado_order/{id}', 'updateResultado');
		
		Route::get('/prueva_order/{id}', 'pruebalav');
		Route::get('/list_prueba/{id}', 'lisprmimu');
		Route::get('/detalle/{id}', 'detalle');
		Route::get('/dato_detalle/{id}', 'dato_detalle');

		Route::get('/items', 'items');
		Route::delete('/{order}', 'destroy');
		Route::get('/imprimir/{order}/{format}', 'imprimir');
	});

	Route::get('orders/eva/{id}', [LaboratorioOrderController::class, 'evaData']);

	// ASISTENCIAS
	Route::controller(AttendanceController::class)->prefix('attendance')->group(function(){
		Route::get('',  'index')->name('attendance.index');
		Route::post('import', 'import');
		Route::get('/records', 'records');
		Route::put('/update', 'update');
		Route::get('records/pdf', 'pdf');
		Route::get('records/excel', 'excel');
	});

	Route::controller(ApiServiceController::class)->prefix('apiservices')->group(function(){
		Route::get('{type}/{number}', 'ApiServices');
	});

	//HORARIOS
    Route::controller(ScheduleController::class)->prefix('schedule')->group(function(){
        Route::get('', 'index')->name('schedule');
        Route::post('', 'store');
        Route::get('/records', 'records');
		Route::get('restore/{id}', 'restore');
        Route::delete('/{id}', 'destroy');
    });

	//IMPORTAR PROVEEDOR
	Route::get('importar_proveedor', [ImportSupplierController::class,'index'])->name('importar_proveedor.index');
	Route::post('import/proveedor', [ImportSupplierController::class, 'ImportProovedorEcxel']);

	// LAVORATORIO BRUCELLAS
	Route::controller(LaboratorioBrucellaController::class)->prefix('laboratoriobrucellas')->group(function(){
		Route::get('', 'index')->name('laboratoriobrucellas.index');
		Route::get('/crear', 'create')->name('laboratoriobrucellas.create');
		Route::get('tables', 'tables');
		Route::get('/table/{table}', 'table');
		Route::get('/records', 'records');
		Route::post('', 'store');
		Route::post('/importar', 'importar');
		Route::delete('/{id}', 'destroy');
		Route::get('restore/{id}', 'restore');
	});
	
	

	