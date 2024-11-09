@extends('dashboard.layout.app_dashboard')

@section('title', 'Crear Promocion')
@section('content')
<style>
    .autocomplete-list {
        position: absolute;
        z-index: 1000;
        background-color: white;
        border: 1px solid #ccc;
        width: 92%;
        max-height: 200px;
        overflow-y: auto;
    }
</style>
<div class="card">
    <div class="card-header" style="background-color: #0D5C75;">
        <h4 class="card-title text-white">Crear promoción</h4>
    </div>
    <div class="card-body">
        <form id="promocion-form" action="{{ route('promociones.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="nombre"><strong>Nombre de la Promoción</strong></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="descuento"><strong>Descuento (%)</strong></label>
                        <input type="number" class="form-control" id="descuento" name="descuento" required min="5" max="50">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descripcion"><strong>Descripción</strong></label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="servicio"><strong>Nombre del Servicio</strong></label>
                        <input type="text" class="form-control" id="servicio" required autocomplete="off">
                        <input type="hidden" id="servicio_id" name="servicio_id">
                        <ul id="servicio-list" class="list-group autocomplete-list"></ul>
                        <div id="error_serv_id" style="display: none;">
                            <i class="bi bi-info-circle text-danger"></i>
                            <span id="serv_id_novalidate" class="text-danger">Por favor, seleccione un servicio válido de la lista.</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fecha_expiracion"><strong>Fecha de Expiración</strong></label>
                        <input type="date" class="form-control" id="fecha_expiracion" name="fecha_expiracion" required min="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <br>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn text-white mb-3 w-25" style="background-color: #0D5C75;">Crear</button>
                <a href="{{ route('promociones') }}" class="btn btn-secondary mb-3 w-25 ml-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const servicioInput = document.getElementById('servicio');
        const servicioList = document.getElementById('servicio-list');
        const servicioIdInput = document.getElementById('servicio_id');
        const form = document.getElementById('promocion-form');
        const errorServId = document.getElementById('error_serv_id');

        let selectedFromList = false;

        servicioInput.addEventListener('input', function() {
            const query = this.value;
            selectedFromList = false;

            if (query.length >= 2) {
                fetch(`{{ route('servicios.search') }}?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        servicioList.innerHTML = '';
                        data.forEach(servicio => {
                            const li = document.createElement('li');
                            li.classList.add('list-group-item');
                            li.textContent = servicio.nomServicio;
                            li.dataset.id = servicio.id;
                            servicioList.appendChild(li);
                            if(servicioInput.value === servicio.nomServicio) {
                                servicioIdInput.value = servicio.id;
                                selectedFromList = true;
                                servicioList.innerHTML = '';
                            }else {
                                servicioIdInput.value = '';
                            }
                        });
                    });
            } else {
                servicioList.innerHTML = '';
            }
        });

        servicioList.addEventListener('click', function(e) {
            if (e.target.tagName === 'LI') {
                servicioInput.value = e.target.textContent;
                servicioIdInput.value = e.target.dataset.id;
                servicioList.innerHTML = '';
                selectedFromList = true;
            }
        });

        form.addEventListener('submit', function(event) {
            const servicioValue = servicioInput.value;
            const servicioIdValue = servicioIdInput.value;

            if (!selectedFromList || servicioValue.trim() === '' || servicioIdValue === '') {
                event.preventDefault();
                errorServId.style.display = 'block';
            } else {
                errorServId.style.display = 'none';
            }
        });
    });
</script>

@endsection