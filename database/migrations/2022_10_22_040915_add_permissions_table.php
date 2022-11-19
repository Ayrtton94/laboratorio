<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->insert([
			['id' => 1, 'name' => 'ver-user', 'guard_name' => 'web', 'description' => 'Ver Usuarios', 'created_at' => DB::raw('NOW()'), 'updated_at' => DB::raw('NOW()')],
			['id' => 2, 'name' => 'crear-user', 'guard_name' => 'web', 'description' => 'Crear Usuario', 'created_at' => DB::raw('NOW()'), 'updated_at' => DB::raw('NOW()')],
			['id' => 3, 'name' => 'editar-user', 'guard_name' => 'web', 'description' => 'Editar Usuario', 'created_at' => DB::raw('NOW()'), 'updated_at' => DB::raw('NOW()')],
			['id' => 4, 'name' => 'eliminar-user', 'guard_name' => 'web', 'description' => 'Eliminar Usuario', 'created_at' => DB::raw('NOW()'), 'updated_at' => DB::raw('NOW()')],
			['id' => 5, 'name' => 'ver-rol', 'guard_name' => 'web', 'description' => 'Ver Roles', 'created_at' => DB::raw('NOW()'), 'updated_at' => DB::raw('NOW()')],
			['id' => 6, 'name' => 'crear-rol', 'guard_name' => 'web', 'description' => 'Crear Rol', 'created_at' => DB::raw('NOW()'), 'updated_at' => DB::raw('NOW()')],
			['id' => 7, 'name' => 'editar-rol', 'guard_name' => 'web', 'description' => 'Editar Rol', 'created_at' => DB::raw('NOW()'), 'updated_at' => DB::raw('NOW()')],
			['id' => 8, 'name' => 'eliminar-rol', 'guard_name' => 'web', 'description' => 'Eliminar Rol', 'created_at' => DB::raw('NOW()'), 'updated_at' => DB::raw('NOW()')]
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('articles');
    }
}
