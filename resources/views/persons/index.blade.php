@extends('layouts.app')

@section('content')

<persons :type="{{ json_encode($type) }}"/>

@endsection