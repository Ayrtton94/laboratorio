<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LaboratorioOrderDetail extends Model
{
//	protected $with = ['affectation_igv_type', 'system_isc_type', 'price_type'];
    public $timestamps = false;
	protected $table = 'laboratorio_order_details';

    protected $fillable = [
        'laboratorio_order_id',
		'matriz_id',
		'muestra_id',
		'prueba_id',
		'especie_id',
		'subespecie_id',
		'presentacion_id',
		'quantity',
		'observacion',
		'date_of_muestra',
		'date_of_recepcion',
		'date_of_resultado',
		'temperatura',
		'unit_value',
		'unit_price',
		'total_igv',
		'total_value',
		'total',
		'age_select',
		'lote',
		'datef',
		'attributes'
    ];

	public function muestra()
	{
		return $this->belongsTo(Muestra::class, 'muestra_id');
	}

	public function ensayo()
	{
		return $this->belongsTo(Prueba::class, 'prueba_id');
	}

	public function laboratorio()
	{
		return $this->belongsTo(Laboratorio::class, 'prueba_id');
	}
}
