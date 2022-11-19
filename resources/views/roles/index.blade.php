@extends('layouts.app')

@section('content')

<roles :permissionsall="{{$permissionsall}}"/>

@endsection