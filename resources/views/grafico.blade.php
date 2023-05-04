@extends('home')
@section('content')
<div class="card">
  <h4 class="card-header">Gráfico de indicadores</h4>
  <div class="card-body">
    <form action="{{ route('grafico') }}" method="get">
        Desde: <input type="date" name="desde" value="{{ old('desde') }}">
        Hasta: <input type="date" name="hasta" value="{{ old('hasta') }}">
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
    <canvas id="grafico"></canvas>
  </div>
</div>
@endsection


@section('scripts')
<script>
    var indicadores = {!! json_encode($indicadores) !!};
    var fechas = indicadores.map(indicador => indicador.fechaIndicador);
    var valores = indicadores.map(indicador => indicador.valorIndicador);
    var ctx = document.getElementById('grafico').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [{
                label: 'Valor del Indicador',
                data: valores,
                borderColor: 'skyblue',
                fill: false
            }]
        }
    });
</script>
@endsection