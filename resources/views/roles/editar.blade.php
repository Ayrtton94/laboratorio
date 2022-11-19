@extends('layouts.app')

@section('content')

<roles-editar :role="{{$role}}" :permissionsall="{{$permissionsall}}"/>

@endsection

