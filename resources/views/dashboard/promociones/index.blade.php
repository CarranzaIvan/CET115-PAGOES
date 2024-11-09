@extends('dashboard.layout.app_dashboard')

@section('title', 'Promociones')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background-color: #0D5C75;">
                <h4 class="card-title text-white">Listado de promociones</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('crear_promocion') }}" class="btn mb-3 text-white" style="background-color: #0D5C75;">
                    <i class="fa fa-plus"></i> Agregar Promoción </a>
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descuento</th>
                                <th>Descripción</th>
                                <th>Nombre del servicio</th>
                                <th>Fecha Expiración</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promociones as $promocion)
                            <tr>
                                <td class="text-center">{{ $promocion->nombrePromocion }}</td>
                                <td class="text-center">{{ $promocion->descuento }}%</td>
                                <td class="text-center">{{ $promocion->descripcion }}</td>
                                <td class="text-center">{{ $promocion->servicio->nomServicio }}</td>
                                <td class="text-center">{{ $promocion->fecha_expiracion }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('promociones.show', $promocion->id) }}" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('promociones.edit', $promocion->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger shadow btn-xs sharp" data-toggle="modal" data-target="#deleteModal" data-action="{{ route('promociones.destroy', $promocion->id) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Modal de Confirmación de Eliminación -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar esta promoción?
                                </div>
                                <div class="modal-footer">
                                    <form id="deleteForm" method="POST" action="">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            $('#deleteModal').on('show.bs.modal', function(event) {
                                var button = $(event.relatedTarget);
                                var action = button.data('action');
                                var modal = $(this);
                                modal.find('#deleteForm').attr('action', action);
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        </script>
        @endif
    </div>
</div>
@endsection