@extends('layout.app')

@section('title', 'Mis Citas')

@section('content')
<div class="container mt-5">
    <center><h1 class="mb-4">Mis Citas</h1></center>
    

    <!-- Descripción o introducción a la página -->
    <div class="alert alert-info">
        Aquí podrás ver todas las citas que has registrado en nuestro sistema. Puedes revisar los detalles de cada cita y su estado.
    </div>

    @if($citas->isEmpty())
        <div class="alert alert-warning">
            No tienes citas registradas.
        </div>
    @else
        <div class="table-responsive">
            <table class="table-info table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $cita)
                        <tr>
                            <td>{{ $cita->servicio->nomServicio }}</td>
                            <td>{{ \Carbon\Carbon::parse($cita->fecha_cita)->format('d/m/Y') }}</td>
                            <td>{{ $cita->hora_cita }}</td>
                            <td>
                                <span class="badge {{ $cita->estado === 'pendiente' ? 'bg-warning' : 'bg-success' }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="verDetalles('{{ $cita->id_cita }}')">
                                    Ver Detalles
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Script para mostrar detalles de la cita -->
<script>
    function verDetalles(citaId) {
        $.ajax({
            url: '/citas/detalle',
            type: 'GET',
            data: { id: citaId },
            success: function(response) {
                if (response.error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: response.error
                    });
                } else {
                    Swal.fire({
                        title: 'Detalles de la Cita',
                        html: `
                            <div style="text-align: center;">
                                <b>Servicio:</b> ${response.servicio}<br>
                                <b>Fecha:</b> ${response.fecha}<br>
                                <b>Hora:</b> ${response.hora}<br>
                                <b>Estado:</b> ${response.estado}<br>
                            </div>
                        `,
                        icon: 'info'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar los detalles de la cita.'
                });
            }
        });
    }
</script>
@endsection
