<?php

namespace Database\Seeders;

use App\Models\Especie;
use App\Models\Matriz;
use App\Models\Muestra;
use App\Models\presentacion;
use App\Models\SubEspecie;
use Illuminate\Database\Seeder;


class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Matriz::query()->create([
            ['description' => 'Cuerpos, tejidos y fluidos biologicos animales', 'created_at' => now()],
            ['description' => 'Leche y productos lacteos', 'created_at' => now()],
            ['description' => 'Carnes y productos carnicos', 'created_at' => now()],
            ['description' => 'Cereales y productos a base de cereales, granos, legumbres y leguminosas', 'created_at' => now()],
            ['description' => 'Productos de pamadería, galletería y pastelería', 'created_at' => now()],
            ['description' => 'Huevos y productos a base de huevo', 'created_at' => now()],
            ['description' => 'Azúcares, jarabes y miel', 'created_at' => now()],
            ['description' => 'Alimentos preparados listos para consumir', 'created_at' => now()],
            ['description' => 'Condimentos, especias, salsas y sales', 'created_at' => now()],
            ['description' => 'Alimento de consumo animal', 'created_at' => now()],
            ['description' => 'Ambientes y Superficies', 'created_at' => now()],
            ['description' => 'Servicios especiales', 'created_at' => now()]
        ]);

        Muestra::query()->create([
            ['matriz_id'=> 1,'description' => 'Cuerpo Vivo', 'created_at' => now()],
            ['matriz_id'=> 1,'description' => 'Raspado de Piel', 'created_at' => now()],
            ['matriz_id'=> 1,'description' => 'Cuerpo Muerto', 'created_at' => now()],
            ['matriz_id'=> 1,'description' => 'Organos', 'created_at' => now()],
            ['matriz_id'=> 1,'description' => 'Leche fresca de bovino', 'created_at' => now()],
            ['matriz_id'=> 1,'description' => 'suero de leche', 'created_at' => now()],
            ['matriz_id'=> 1,'description' => 'sangre', 'created_at' => now()],
            ['matriz_id'=> 1,'description' => 'heces', 'created_at' => now()],
            ['matriz_id'=> 1,'description' => 'orina', 'created_at' => now()],
            ['matriz_id'=> 1,'description' => 'secrecion(nasal,ocular,otica, vaginal, etc)', 'created_at' => now()],
            ['matriz_id'=> 1,'description' => 'otros', 'created_at' => now()],
            ['matriz_id'=> 1,'description' => 'Preparacion de solucion salina fenolada 100ml', 'created_at' => now()],
            ['matriz_id'=> 2,'description' => 'Leche cruda fresca', 'created_at' => now()],
            ['matriz_id'=> 2,'description' => 'Leche pasteurizada', 'created_at' => now()],
            ['matriz_id'=> 2,'description' => 'Leche UHT', 'created_at' => now()],
            ['matriz_id'=> 2,'description' => 'Queso, yogurt', 'created_at' => now()],
            ['matriz_id'=> 2,'description' => 'otros', 'created_at' => now()],
            ['matriz_id'=> 3,'description' => 'Bovino, porcino, pollo y otros', 'created_at' => now()],
            ['matriz_id'=> 3,'description' => 'Carnes secas(charqui, chalona, cecina)', 'created_at' => now()],
            ['matriz_id'=> 3,'description' => 'otros', 'created_at' => now()],
            ['matriz_id'=> 4,'description' => 'Harina de trigo, harina de maiz, arroz, soy y otros', 'created_at' => now()],
            ['matriz_id'=> 5,'description' => 'Pan, galleta, pan dulce, pastel, keke, quequitos y otros ', 'created_at' => now()],
            ['matriz_id'=> 6,'description' => 'huevos y otros', 'created_at' => now()],
            ['matriz_id'=> 7,'description' => 'miel, jarabe, mermelada y otros', 'created_at' => now()],
            ['matriz_id'=> 8,'description' => 'Frescos, pre-cocidos, conservas y envasados', 'created_at' => now()],
            ['matriz_id'=> 9,'description' => 'Hierbas aromáticas, condimiento, especies,  ', 'created_at' => now()],
            ['matriz_id'=> 9,'description' => 'Harina de pescado, harina de soya, concentrados, desechos de la industria alimetaria ', 'created_at' => now()],
            ['matriz_id'=> 10,'description' => 'Superficies vivas ', 'created_at' => now()],
            ['matriz_id'=> 10,'description' => 'Superficies muertas ', 'created_at' => now()],
            ['matriz_id'=> 10,'description' => 'PREPARACION DE MICOLAB X100G(para el tratamiento de hongos en piel de cuyes y bovinos) ', 'created_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE LEVELAB(para el tratamiento de mastitis causada por hongos y levaduras )', 'created_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE AGUA DESTILADA ESTERIL/LITRO', 'created_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE AGUA DESTILADA/LITRO ', 'created_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE AUTOVACUNAS 1 DOSIS', 'created_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE MEDIOS DE CULTIVO ', 'created_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE CEPAS ', 'created_at' => now()],
            ['matriz_id'=> 11,'description' => 'EVALUACION DE ACTIVIDAD ANTIMICROBIANA', 'created_at' => now()],
            ['matriz_id'=> 11,'description' => 'VENTA DE CEPAS ', 'created_at' => now()],
            ['matriz_id'=> 11,'description' => 'VENTA DE CEPAS ', 'created_at' => now()],
            ['matriz_id'=> 11,'description' => 'VENTA DE CEPAS ', 'created_at' => now()],
            ['matriz_id'=> 11,'description' => 'VENTA DE CEPAS ', 'created_at' => now()]
        ]);

        Especie::query()->create([
            ['description' => 'Aves', 'created_at' => now()],
            ['description' => 'Caninos y Felino', 'created_at' => now()],
            ['description' => 'Caprinos y Ovino', 'created_at' => now()],
            ['description' => 'Bovino', 'created_at' => now()],
            ['description' => 'Porcino', 'created_at' => now()],
            ['description' => 'Cuy', 'created_at' => now()],
            ['description' => 'Animales Silvestres y Otros', 'created_at' => now()],
            ['description' => 'Camelidos Sudamericanos', 'created_at' => now()]
        ]);

        SubEspecie::query()->create([
            ['especie_id'=> 1,'description' => 'Gallina', 'created_at' => now()],
            ['especie_id'=> 1,'description' => 'Pato', 'created_at' => now()],
            ['especie_id'=> 1,'description' => 'Pavo', 'created_at' => now()],
            ['especie_id'=> 1,'description' => 'Ganso', 'created_at' => now()],
            ['especie_id'=> 1,'description' => 'Pollo', 'created_at' => now()],
            ['especie_id'=> 1,'description' => 'Codorniz', 'created_at' => now()],
            ['especie_id'=> 2,'description' => 'Perro', 'created_at' => now()],
            ['especie_id'=> 2,'description' => 'Gato', 'created_at' => now()],
            ['especie_id'=> 3,'description' => 'Cabra', 'created_at' => now()],
            ['especie_id'=> 3,'description' => 'Obeja', 'created_at' => now()],
            ['especie_id'=> 4,'description' => 'Bovino', 'created_at' => now()],
            ['especie_id'=> 5,'description' => 'Porcino', 'created_at' => now()],
            ['especie_id'=> 6,'description' => 'Cuy', 'created_at' => now()],
            ['especie_id'=> 7,'description' => 'Animales Silvestres y Otros', 'created_at' => now()],
            ['especie_id'=> 8,'description' => 'Alpaca', 'created_at' => now()],
            ['especie_id'=> 8,'description' => 'Llama', 'created_at' => now()],
            ['especie_id'=> 8,'description' => 'Vicuña', 'created_at' => now()]
            ['especie_id'=> 8,'description' => 'Huanaco', 'created_at' => now()]
        ]);

        presentacion::query()->create([
            ['description' => 'Tubo vaccutainer', 'created_at' => now()],
            ['description' => 'Frasco de Plástico', 'created_at' => now()],
            ['description' => 'Frasco de Vidrio', 'created_at' => now()],
            ['description' => 'Viales', 'created_at' => now()],
            ['description' => 'Jeringa', 'created_at' => now()],
            ['description' => 'Bolsa de primer uso', 'created_at' => now()]
        ]);
    }
}
