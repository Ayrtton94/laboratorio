@extends('tenant.layouts.app')

@push('styles')

@endpush
@php
	$permisos = collect(session('permisos'));
	$roles = collect(session('roles'));
	$intersect = false;
	if($roles->contains('slug','administrador')|| $roles->contains('slug','administrador-tienda')) $intersect = true;
	else $intersect= $permisos->pluck('slug')->intersect('tenant.documents.edit_price')->count() > 0  ;
	if($roles->contains('slug','administrador')|| $roles->contains('slug','administrador-tienda')){
		$admin = true;
	}else{
		$admin = false;
	}
	// dd(auth()->user()->id);
	$isAdmin = $intersect;
@endphp
@section('content')

    <tenant-orders-invoice
		:almacen="{{ session('almacen') ?? 1}}"
		:sucursal="{{ session('sucursal') ?? 1}}"
		isadmin="{{ $isAdmin ?? false}}"
		admin="{{ $admin ?? false}}"
		{{-- :userauth="{{ auth()->user()->id }}" --}}
        :impredirecta="{{ session('IMPRESION_DIRECTA') }}"
		:checkalmacenprecio="{{ session('PRECIOS_POR_ALMACEN')}}"
		:molitalia="{{ session('PERMISOS_MOLITALIA') ?? 0}}"
		:muestraprecios="{{ session('MUESTRA_PRECIOS_ORDEN_VENTA') ?? 0}}"
		:validarprecios="{{ session('VALIDAR_PRECIOS') ?? 0}}"
		:venta_multialmacen="{{ session('VENTA_MULTIALMACEN') ?? 0}}"
		:muestrapreciocompra="{{ session('MUESTRA_PRECIOS_COMPRA') ?? 0}}"
        :inventory_configuration="{{ session('inventory_configuration') }}"
        :formato_ordenventa="{{ session('FORMATO_ORDEN_VENTA') ?? 0}}"
		></tenant-orders-invoice>

@endsection

@push('scripts')

@endpush
