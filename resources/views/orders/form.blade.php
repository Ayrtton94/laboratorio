@extends('layouts.app')

@push('styles')

@endpush

@section('content')

    <orders-invoice/>

{{--    :almacen="{{ session('almacen') ?? 1}}"--}}
{{--    :sucursal="{{ session('sucursal') ?? 1}}"--}}
{{--    isadmin="{{ $isAdmin ?? false}}"--}}
{{--    admin="{{ $admin ?? false}}"--}}

@endsection

@push('scripts')

@endpush
