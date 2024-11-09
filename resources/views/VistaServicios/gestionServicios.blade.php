@extends('layout.app')

@section('title', 'Servicios || Gestión')

@section('custom_css')
    <link rel="stylesheet" href="{{ asset('css/styleServicio.css') }}">
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


    <div class="container text-center">
        <!-- Encabezado de Servicios -->
        <h1 class="font-weight-bold colorEstandarTexto mb-4">Gestión de Servicios de Carwash</h1>
        <h5 class="text-black font-weight-light mb-4">Actualiza, verifica y descarta los servicios vigentes en Shine & Go.
            <br>
            Crea nuevos servicios e innova con tus ideas para los clientes.
        </h5>

        <!-- Botón para Nuevo Servicio -->
        <div class="d-flex justify-content-end mb-4">
            <button class="btn btn-agregar" data-bs-toggle="modal" data-bs-target="#nuevoServicioModal">
                <i class="bi bi-plus"></i> Nuevo Servicio
            </button>
        </div>

        <!-- Listado de Servicios -->
        <div class="row">
            @foreach ($servicios as $servicio)
                <x-servicio-card-gestion 
                    titulo="{{ $servicio->nomServicio }}" 
                    precio="{{ $servicio->precio }}"
                    descripcion="{{ $servicio->descripcion }}" 
                    id_servicio="{{ $servicio->id }}" 
                    imagen="{{ $servicio->imagen ?? 'images/default.png' }}" />
            @endforeach
        </div>
        
    </div>

    <!-- Modal para Agregar Nuevo Servicio -->
    <div class="modal fade" id="nuevoServicioModal" tabindex="-1" aria-labelledby="nuevoServicioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoServicioModalLabel">Crear Nuevo Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="nuevoServicioForm" action="/servicios/gestion/guardar" method="POST"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="nomServicio" class="form-label">Nombre del Servicio</label>
                            <input type="text" class="form-control" id="nomServicio" name="nomServicio"
                                placeholder="Ingrese el nombre del servicio..." required>
                            <div class="invalid-feedback">
                                El nombre del servicio es obligatorio.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio del Servicio</label>
                            <input type="number" class="form-control" id="precio" name="precio"
                                placeholder="Ingrese el precio del servicio..." step="0.01" min="0" required>
                            <div class="invalid-feedback">
                                El precio del servicio es obligatorio y debe ser un valor positivo a dos decimales.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese la descripción del servicio..."
                                required></textarea>
                            <div class="invalid-feedback">
                                La descripción del servicio es obligatoria.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="imagen">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Crear Servicio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Servicio -->
    <div class="modal fade" id="editarServicioModal" tabindex="-1" aria-labelledby="editarServicioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarServicioModalLabel">Editar Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarServicioForm" action="" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editarTitulo" class="form-label">Nombre del Servicio</label>
                            <input type="text" class="form-control" id="editarTitulo" name="nomServicio" required>
                            <div class="invalid-feedback">
                                El nombre del servicio es obligatorio.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editarPrecio" class="form-label">Precio del Servicio</label>
                            <input type="number" class="form-control" id="editarPrecio" name="precio" step="0.01"
                                min="0" required>
                            <div class="invalid-feedback">
                                El precio del servicio es obligatorio y debe ser un valor positivo a dos decimales.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editarDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editarDescripcion" name="descripcion" required></textarea>
                            <div class="invalid-feedback">
                                La descripción del servicio es obligatoria.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="imagen">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro que deseas eliminar este servicio? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('custom_js')
    <script src="{{ asset('js/servicio.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
