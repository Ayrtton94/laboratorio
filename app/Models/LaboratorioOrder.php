<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class LaboratorioOrder extends Model
{

	protected $with = ['user', 'items'];

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'laboratorio_orders';
    protected $fillable = [
        'user_id',
        'establishment_id',
        'establishment',
        'state_type_id',
        'group_id',
        'document_type_id',
        'series',
        'number',
        'date_of_issue',
        'time_of_issue',

        'customer_id',
        'customer',
        'currency_type_id',
        'tporden_id',
        'responsable_id',
        'documento_referencia',

        'total_value',
        'total_igv',
        'total',

        'legends',
        'filename',
		'type_document_fact',
		'tipo'

    ];

    // protected $casts = [
    //     'date_of_issue' => 'date',
    // ];

    public function getEstablishmentAttribute($value)
    {
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setEstablishmentAttribute($value)
    {
        $this->attributes['establishment'] = (is_null($value))?null:json_encode($value);
    }

    public function getCustomerAttribute($value)
    {
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setCustomerAttribute($value)
    {
        $this->attributes['customer'] = (is_null($value))?null:json_encode($value);
    }

    public function getLegendsAttribute($value)
    {
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setLegendsAttribute($value)
    {
        $this->attributes['legends'] = (is_null($value))?null:json_encode($value);
    }

    public function getAdditionalInformationAttribute($value)
    {
        $arr = explode('|', $value);
        return $arr;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function person()
	{
        return $this->belongsTo(Person::class, 'customer_id');
    }

    public function staff()
	{
        return $this->belongsTo(Person::class, 'responsable_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function currency_type()
    {
        return $this->belongsTo(CurrencyType::class, 'currency_type_id');
    }

    public function items()
    {
        return $this->hasMany(LaboratorioOrderDetail::class);
    }

    public function getNumberFullAttribute()
    {
        return $this->series.'-'.$this->number;
    }

    public function getNumberToLetterAttribute()
    {
        $legends = $this->legends;
        $legend = collect($legends)->where('code', '1000')->first();
        return $legend->value;
    }

    public function getDownloadExternalPdfAttribute()
    {
        return route('download.external_id', ['model' => 'document', 'type' => 'pdf', 'external_id' => $this->external_id]);
    }

    public static function getItems($order_id)
    {
        $query = DB::table('order_items as qui')
          ->select('ite.*')
          ->join('items as ite', 'ite.id', '=', 'qui.item_id')
          ->where('qui.order_id', $order_id)
          ->get();

        $items = $query->transform(function($row) {
            $full_description = ($row->internal_id)?$row->internal_id.' - '.$row->description:$row->description;
            $currency_type_symbol = "EN";
            return [
                'id' => $row->id,
                'full_description' => $full_description,
                'description' => $row->description,
                'currency_type_id' => $row->currency_type_id,
                'currency_type_symbol' => $currency_type_symbol,
                'sale_unit_price' => $row->sale_unit_price,
                'purchase_unit_price' => $row->purchase_unit_price,
                'unit_type_id' => $row->unit_type_id,
                'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id
            ];
        });

        return $items;
    }
}
