@extends('layouts.app')

@section('content')

<usuarios-search :roles="{{$roles}}" :specialties="{{$specialties}}"/>

@endsection
