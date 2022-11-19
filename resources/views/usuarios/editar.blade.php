@extends('layouts.app')

@section('content')
	{{-- @can('crear-user') --}}
		<usuarios-editar :usuarios="{{$usuarios}}"/>
	{{-- @endcan --}}
@endsection