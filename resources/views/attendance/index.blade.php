@extends('layouts.app')

@section('content')

<attendance csrf="{{csrf_token()}}"/>

@endsection