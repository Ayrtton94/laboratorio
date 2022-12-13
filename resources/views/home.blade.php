@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}

<dashboard :user_auth="{{ $user_auth }}"/>

{{-- </div> --}}
@endsection
