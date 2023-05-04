@extends('home')
@section('content')
<div class="card">
  <h4 class="card-header">Cargar base de datos</h4>
  <div class="card-body">
    <p class="card-text">Con el botón que se encuentra en la parte inferior será posible realizar la primera 
      carga de la base de datos con los datos extraidos mediante la api de indicadores.</p>
    <a href="/cargardatos" class="btn btn-primary">Cargar Datos</a>
    <h1></h1>
    @if(!empty($successMsg))
      <div class="alert alert-success">Los datos han sido cargados exitosamente!</div>
    @endif
  </div>
</div>
@endsection