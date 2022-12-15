@extends('layouts.app')

@push('styles')

@endpush




@section('content')

    <orders-edit
        :order_id="{{ json_encode($order_id) }}"></orders-edit>

@endsection

@push('scripts')

@endpush
