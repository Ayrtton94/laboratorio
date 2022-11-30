<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\UnidadEquivalente;
use App\Models\Tenant\Catalogs\PriceType;
use App\Models\Tenant\Catalogs\SystemIscType;
use App\Models\Tenant\Catalogs\AffectationIgvType;

class LaboratorioOrderDetail extends Model
{
	protected $with = ['affectation_igv_type', 'system_isc_type', 'price_type'];
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
		'attributes'
    ];

    public function getAttributesAttribute($value)
    {
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setAttributesAttribute($value)
    {
        $this->attributes['attributes'] = (is_null($value))?null:json_encode($value);
    }

    public function getChargesAttribute($value)
    {
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setChargesAttribute($value)
    {
        $this->attributes['charges'] = (is_null($value))?null:json_encode($value);
    }

    public function getDiscountsAttribute($value)
    {
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setDiscountsAttribute($value)
    {
        $this->attributes['discounts'] = (is_null($value))?null:json_encode($value);
    }

    public function affectation_igv_type()
    {
        return $this->belongsTo(AffectationIgvType::class, 'affectation_igv_type_id');
    }

    public function system_isc_type()
    {
        return $this->belongsTo(SystemIscType::class, 'system_isc_type_id');
    }

    public function price_type()
    {
        return $this->belongsTo(PriceType::class, 'price_type_id');
	}

	public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
	}
	
	public function equivalencia()
    {
        return $this->belongsTo(UnidadEquivalente::class, 'equivalencia_id');
    }
}
