@extends('home')
@section('content')
<div class="card">
  <h4 class="card-header">Indicadores importados</h4>
  <div class="card-body">
    <a class="btn btn-primary" href="javascript:void(0)" id="createNewIndicador"> Crear Nuevo Indicador</a>
    <table class="table table-bordered data-table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Nombre</th>
          <th>Código</th>
          <th>Unidad de Medida</th>
          <th>Valor</th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="formularioIndicador" name="formularioIndicador" class="form-horizontal">
                   <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="nombreIndicador" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nombreIndicador" name="nombreIndicador" placeholder="Ingrese Nombre" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="codigoIndicador" class="col-sm-2 control-label">Código</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="codigoIndicador" name="codigoIndicador" placeholder="Ingrese Código" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="unidadMedidaIndicador" class="col-sm-6 control-label">Unidad de Medida</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="unidadMedidaIndicador" name="unidadMedidaIndicador" placeholder="Ingrese Unidad de Medida" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="valorIndicador" class="col-sm-2 control-label">Valor</label>
                        <div class="col-sm-12">
                            <input type="number" step="any" class="form-control" id="valorIndicador" name="valorIndicador" placeholder="Ingrese Valor" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fechaIndicador" class="col-sm-2 control-label">Fecha</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="fechaIndicador" name="fechaIndicador" placeholder="Ingrese Fecha" value="" maxlength="50" required>
                        </div>
                    </div>
                    
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')
@parent

<script type="text/javascript">
  $(function(){

    /* Header Token */
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    /* Datatable */
    var table = $(".data-table").DataTable({
      processing: true,
      serverSide: true,
      ajax:"{{route('crud.index')}}",
        columns:[
          {data:'DT_RowIndex', name: 'DT_RowIndex'},
          {data:'nombreIndicador', name: 'nombreIndicador'},
          {data:'codigoIndicador', name: 'codigoIndicador'},
          {data:'unidadMedidaIndicador', name: 'unidadMedidaIndicador'},
          {data:'valorIndicador', name: 'valorIndicador'},
          {data:'fechaIndicador', name: 'fechaIndicador'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
    /* Click crear indicador  */
    $('#createNewIndicador').click(function () {
        $('#saveBtn').val("create-indicador");
        $('#id').val('');
        $('#formularioIndicador').trigger("reset");
        $('#modalHeading').html("Crear Nuevo Indicador");
        $('#ajaxModel').modal('show');
    });

    //* Crear indicador */
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Guardar');
        $.ajax({
          data: $('#formularioIndicador').serialize(),
          url: "{{ route('crud.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
              $('#formularioIndicador').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Guardar');
          }
      });
    });

    /* Eliminar indicador */
    $('body').on('click', '.deleteIndicador', function () {
        var id = $(this).data("id");
        if(confirm("¿Seguro que quiere eliminar el indicador?")){
            $.ajax({
            type: "DELETE",
            url: "{{ route('crud.store') }}"+'/'+id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
            });
            alert("Indicador eliminado correctamente");
        }else{
            alert("No se ha eliminado el indicador");
        }
    });
      
    /* Click Editar indicador */
    $('body').on('click', '.editIndicador', function () {
      var id = $(this).data('id');
      $.get("{{ route('crud.index') }}" +'/' + id +'/edit', function (data) {
          $('#modalHeading').html("Editar Indicador");
          $('#saveBtn').val("edit-indicador");
          $('#ajaxModel').modal('show');
          $('#id').val(data.id);
          $('#nombreIndicador').val(data.nombreIndicador);
          $('#codigoIndicador').val(data.codigoIndicador);
          $('#unidadMedidaIndicador').val(data.unidadMedidaIndicador);
          $('#valorIndicador').val(data.valorIndicador);
          $('#fechaIndicador').val(data.fechaIndicador);
      })
    });
  });
</script>
@stop