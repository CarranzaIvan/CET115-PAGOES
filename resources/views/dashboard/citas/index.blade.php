@extends('dashboard.layout.app_dashboard')

@section('title', 'Citas')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background-color: #0D5C75;">
                <h4 class="card-title text-white">Listado de Citas</h4>
            </div>
            <div class="card-body">
                <!--<a href="{{ route('crear_promocion') }}" class="btn mb-3 text-white" style="background-color: #0D5C75;">
                    <i class="fa fa-plus"></i> Agregar Cita</a>-->
                <div class="table-responsive">
                    <table id="example" class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Nombre del Servicio</th>
                                <th class="text-center">Fecha de Cita</th>
                                <th class="text-center">Hora de Cita</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($citas as $cita)
                            <tr>
                                <td class="text-center">{{ $cita->id_usuario }}</td>
                                <td class="text-center">{{ $cita->servicio->nomServicio ?? 'Servicio no disponible' }}</td>
                                <td class="text-center">{{ $cita->fecha_cita }}</td>
                                <td class="text-center">{{ $cita->hora_cita }}</td>
                                <td class="text-center">{{ $cita->estado }}</td>
                                <td class="text-center">
                                    <center>
                                        <a href="{{ route('dashboard.citas.show', $cita->id_cita) }}" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
                                        <button class="btn btn-danger shadow btn-xs sharp" data-toggle="modal" data-target="#deleteModal" data-action="{{ route('dashboard.citas.destroy', $cita->id_cita) }}"><i class="fa fa-trash"></i></button>
                                    </center>
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
                                    ¿Estás seguro de que deseas eliminar esta cita?
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
                            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

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
        <!-- SweetAlert para mensajes de éxito -->
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