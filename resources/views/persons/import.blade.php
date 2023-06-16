@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card">
                <div class="card-header">Importar Proveedor</div>
                <div class="card-body">
                    <div class="container">
                        <br>
                        <div class="row">
                            <div class="cold-md-4"></div>
                            <div class="cold-md-6">
                                <div class="row">
                                    <form action="{{ url('import/proveedor') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="cold-md-6">
                                            <input class="form-control" type="file" name="documento" required>
                                        </div>
                                        <div class="cold-md-6">
                                            <button class="form-control" class="btn btn-primary" type="submit">importar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection