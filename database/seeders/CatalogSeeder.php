<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Serie;
use App\Models\Matriz;
use App\Models\Metodo;
use App\Models\Person;
use App\Models\Company;
use App\Models\Especie;
use App\Models\Muestra;
use App\Models\TipoOrden;
use App\Models\SubEspecie;
use App\Models\Laboratorio;
use App\Models\presentacion;
use App\Models\Establishment;
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
		Company::create([
			'identity_document_type_id' => '6',
            'number' => '20136268041',
            'name' => 'Laboratorio Veterinario del Sur',
            'trade_name' => 'Laboratorio Veterinario del Sur',
			'address' => 'Av. Alfonso Ugarte 500-A Zona Industrial, Arequipa',
			'telephone' => '054-213677',
			'phone' => '978404610'
		]);

		Person::create([
            'name' => 'CLIENTES VARIOS',
            'identity_document_id'=> 1,
            'number'=>'00000000',
            'type' =>'customers',
            'country_id'=> 'PE'
        ]);
		
		Establishment::create([
			'description' => 'Oficina Principal',
			'country_id' => 'PE',
			'department_id' => '20',
            'province_id' => '2001',
            'district_id' => '200101',
			'address' => '',
			'email' => 'almacenprincipal@gmail.com',
			'telephone' => '-',
			'code' => '0000',
			'created_at' => now(),
			'updated_at' => now()
		]);

		Serie::insert([
            ['establishment_id' => 1,'number'=>1, 'document_type_id' => '01', 'serie' => 'F001', 'estado' => 1],
            ['establishment_id' => 1,'number'=>1, 'document_type_id' => '02', 'serie' => 'C001', 'estado' => 1],
            ['establishment_id' => 1,'number'=>1, 'document_type_id' => '03', 'serie' => 'B001', 'estado' => 1],
            ['establishment_id' => 1,'number'=>1, 'document_type_id' => '07', 'serie' => 'FC01', 'estado' => 1],
            ['establishment_id' => 1,'number'=>1, 'document_type_id' => '07', 'serie' => 'BC01', 'estado' => 1],
            ['establishment_id' => 1,'number'=>1, 'document_type_id' => '08', 'serie' => 'FD01', 'estado' => 1],
            ['establishment_id' => 1,'number'=>1, 'document_type_id' => '08', 'serie' => 'BD01', 'estado' => 1],
			['establishment_id' => 1,'number'=>1, 'document_type_id' => '09', 'serie' => 'T001', 'estado' => 0],
            ['establishment_id' => 1,'number'=>1, 'document_type_id' => '20', 'serie' => 'R001', 'estado' => 0],
            ['establishment_id' => 1,'number'=>1, 'document_type_id' => '100', 'serie' => 'NV01', 'estado' => 0],
            ['establishment_id' => 1,'number'=>1, 'document_type_id' => '101', 'serie' => 'TR01', 'estado' => 0],
			['establishment_id' => 1,'number'=>1, 'document_type_id' => '103', 'serie' => 'AJ01', 'estado' => 0],
			['establishment_id' => 1,'number'=>1, 'document_type_id' => '104', 'serie' => 'OL01', 'estado' => 1],
        ]);
		
		Area::insert([
			['name' => 'Administración', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Administración', 'created_at' => now(), 'updated_at' => now()],
		]);

		TipoOrden::insert([
			['name' => 'Servicio', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Capacitación', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Otros', 'created_at' => now(), 'updated_at' => now()],
		]);

        Matriz::insert([
            ['description' => 'Cuerpos, tejidos y fluidos biologicos animales', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Leche y productos lacteos', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Carnes y productos carnicos', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Cereales y productos a base de cereales, granos, legumbres y leguminosas', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Productos de pamadería, galletería y pastelería', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Huevos y productos a base de huevo', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Azúcares, jarabes y miel', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Alimentos preparados listos para consumir', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Condimentos, especias, salsas y sales', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Alimento de consumo animal', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Ambientes y Superficies', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Servicios especiales', 'created_at' => now(), 'updated_at' => now()],
        ]);

		Laboratorio::insert([
			['name' => 'Bacteriología', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Citología', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Control de calidad', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Fisicoquímico', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Hematología', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Inmunología', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Parasitología', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Patología', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'N/A', 'created_at' => now(), 'updated_at' => now()],
		]);

		Metodo::insert([
			['name' => 'Absorbancia', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Acidificación de leche', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Coloracion HE', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Coloracion Wrigth', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Cultivo aerobico', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Cultivo en agar', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Cultivos en anaerobiosis y microanaerobiosis', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Elisa', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Flotación', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Hisopado y coloración', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'ISO 4831:2006', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'ISO 4833-1:2013', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'LVS-LIM-01 versión 02.(Basado en Guía Brucella abortus Antibody test kit /Bovine Milk) (validado) - 2020', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Mac Master modificado', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'MacMaster modificado y  tamizado', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Método clínico', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Metodo de Kirby - Bauer', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Metodo de necropsia por especie', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Metodo directo: Secado en estufa', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Microbiológico', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'NTP-ISO 6579-1:2019', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Observación directa', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Observación directa y microscopica', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Observación directa, microscopica y tinción', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Raspado de mucosa y flotación', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Recuento en placa', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Recuentos en Camara de Newbauer', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Sedimentación', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Seroaglutinación en placa', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'SM 9215 B', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Ultrasonido con Lactoscan', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Titulación', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'N/A', 'created_at' => now(), 'updated_at' => now()],
		]);

        Muestra::insert([
            ['matriz_id'=> 1,'description' => 'Cuerpo Vivo', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 1,'description' => 'Raspado de Piel', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 1,'description' => 'Cuerpo Muerto', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 1,'description' => 'Organos', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 1,'description' => 'Leche fresca de bovino', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 1,'description' => 'suero de leche', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 1,'description' => 'sangre', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 1,'description' => 'heces', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 1,'description' => 'orina', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 1,'description' => 'secrecion(nasal,ocular,otica, vaginal, etc)', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 1,'description' => 'otros', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 1,'description' => 'Preparacion de solucion salina fenolada 100ml', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 2,'description' => 'Leche cruda fresca', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 2,'description' => 'Leche pasteurizada', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 2,'description' => 'Leche UHT', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 2,'description' => 'Queso, yogurt', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 2,'description' => 'otros', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 3,'description' => 'Bovino, porcino, pollo y otros', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 3,'description' => 'Carnes secas(charqui, chalona, cecina)', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 3,'description' => 'otros', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 4,'description' => 'Harina de trigo, harina de maiz, arroz, soy y otros', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 5,'description' => 'Pan, galleta, pan dulce, pastel, keke, quequitos y otros ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 6,'description' => 'huevos y otros', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 7,'description' => 'miel, jarabe, mermelada y otros', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 8,'description' => 'Frescos, pre-cocidos, conservas y envasados', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 9,'description' => 'Hierbas aromáticas, condimiento, especies,  ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 9,'description' => 'Harina de pescado, harina de soya, concentrados, desechos de la industria alimetaria ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 10,'description' => 'Superficies vivas ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 10,'description' => 'Superficies muertas ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 10,'description' => 'PREPARACION DE MICOLAB X100G(para el tratamiento de hongos en piel de cuyes y bovinos) ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE LEVELAB(para el tratamiento de mastitis causada por hongos y levaduras )', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE AGUA DESTILADA ESTERIL/LITRO', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE AGUA DESTILADA/LITRO ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE AUTOVACUNAS 1 DOSIS', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE MEDIOS DE CULTIVO ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 11,'description' => 'PREPARACION DE CEPAS ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 11,'description' => 'EVALUACION DE ACTIVIDAD ANTIMICROBIANA', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 11,'description' => 'VENTA DE CEPAS ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 11,'description' => 'VENTA DE CEPAS ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 11,'description' => 'VENTA DE CEPAS ', 'created_at' => now(), 'updated_at' => now()],
            ['matriz_id'=> 11,'description' => 'VENTA DE CEPAS ', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Especie::insert([
            ['description' => 'Aves', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Caninos y Felino', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Caprinos y Ovino', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Bovino', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Porcino', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Cuy', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Animales Silvestres y Otros', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Camelidos Sudamericanos', 'created_at' => now(), 'updated_at' => now()],
        ]);

        SubEspecie::insert([
            ['especie_id'=> 1,'description' => 'Gallina', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 1,'description' => 'Pato', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 1,'description' => 'Pavo', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 1,'description' => 'Ganso', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 1,'description' => 'Pollo', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 1,'description' => 'Codorniz', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 2,'description' => 'Perro', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 2,'description' => 'Gato', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 3,'description' => 'Cabra', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 3,'description' => 'Obeja', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 4,'description' => 'Bovino', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 5,'description' => 'Porcino', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 6,'description' => 'Cuy', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 7,'description' => 'Animales Silvestres y Otros', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 8,'description' => 'Alpaca', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 8,'description' => 'Llama', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 8,'description' => 'Vicuña', 'created_at' => now(), 'updated_at' => now()],
            ['especie_id'=> 8,'description' => 'Huanaco', 'created_at' => now(), 'updated_at' => now()],
        ]);

        presentacion::insert([
            ['description' => 'Tubo vaccutainer'],
            ['description' => 'Frasco de Plástico'],
            ['description' => 'Frasco de Vidrio'],
            ['description' => 'Viales'],
            ['description' => 'Jeringa'],
            ['description' => 'Bolsa de primer uso'],
        ]);
    }
}