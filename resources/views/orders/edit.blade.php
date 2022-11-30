@extends('tenant.layouts.app')

@push('styles')

@endpush

@php
	$permisos = collect(session('permisos'));
	$roles = collect(session('roles'));
	$intersect = false;
	if($roles->contains('slug','administrador')|| $roles->contains('slug','administrador-tienda')) $intersect = true;
	else $intersect= $permisos->pluck('slug')->intersect('tenant.documents.edit_price')->count() > 0  ;

	$isAdmin = $intersect;
@endphp


@section('content')
    @can('tenant.orders.update')
    <tenant-orders-edit :order_id="{{ json_encode($order_id) }}"
		:almacen="{{ session('almacen') ?? 1}}"
		:sucursal="{{ session('sucursal') ?? 1}}"
		isadmin="{{ $isAdmin ?? false}}"
        :molitalia="{{ session('PERMISOS_MOLITALIA') ?? 0}}"
		:checkalmacenprecio="{{ session('PRECIOS_POR_ALMACEN')}}"
        :formato_ordenventa="{{ session('FORMATO_ORDEN_VENTA') ?? 0}}"
	></tenant-orders-edit>
    @endcan

@endsection

@push('scripts')

@endpush
