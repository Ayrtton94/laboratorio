@extends('tenant.layouts.app')

@section('content')
    @can('tenant.orders.index')
	<tenant-orders-index
        :formato_ordenventa="{{ session('FORMATO_ORDEN_VENTA') ?? 0}}"
        :impredirecta="{{ session('IMPRESION_DIRECTA') }}"
        :orden_list="{{ session('FORMATO_LISTADO_ORDEN') ?? 0}}"></tenant-orders-index>
    @endcan

@endsection

@push('scripts')

@endpush
