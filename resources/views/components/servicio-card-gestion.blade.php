<div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm d-flex flex-column"> <!-- Agregamos d-flex y flex-column -->
        <div class="card-body text-start d-flex flex-grow-1 flex-column"> <!-- Flex para el contenido -->
            <h5 class="card-title font-weight-bold servicio-titulo" id="titulo-{{ $idServicio }}">{{ $titulo }}</h5>
            <h6 class="servicio-precio text-secondary" id="precio-{{ $idServicio }}"> $ {{ $precio }}</h6>
            <div class="text-center">
                <img src="{{ asset($imagen ? 'storage/' . $imagen : 'images/default.png') }}" 
                     class="img-fluid mb-3 img-servicio" 
                     alt="{{ $titulo }}" 
                     onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';"
                     style="width: 100%; height: 200px; object-fit: cover;">
            </div>
            <p class="font-weight-normal servicio-descripcion flex-grow-1" id="descripcion-{{ $idServicio }}">{{ $descripcion }}</p>
            <!-- Botones al final -->
            <div class="d-flex flex-row">
                <button class="btn btnEditarServicio" data-id="{{ $idServicio }}">
                    <i class="bi bi-pencil-square"></i> Editar
                </button>
                <form action="/servicios/gestion/{{ $idServicio }}/eliminar" method="POST" class="ms-2">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-danger" type="submit">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
