@extends('layout.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 85vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="authincation-content p-5 shadow-lg rounded bg-white">
                    <!-- Logo en la parte superior centrado -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/pagomovil.png') }}" alt="Logo PagoMovil" class="img-fluid" style="width: 100px; height: auto;">
                    </div>
                    
                    <h4 class="text-center mb-4 font-weight-bold" style="color: #333;">Restablecer Contraseña</h4>
                    
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="form-group mb-3">
                            <label for="correo" class="font-weight-bold" style="color: #555;">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" placeholder="Ingresa tu correo electrónico" required style="border-radius: 8px; border: 1px solid #ced4da;">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="contraseña" class="font-weight-bold" style="color: #555;">Nueva Contraseña</label>
                            <input type="password" minlength="8" name="contraseña" class="form-control" placeholder="Nueva contraseña" required style="border-radius: 8px; border: 1px solid #ced4da;">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="contraseña_confirmation" class="font-weight-bold" style="color: #555;">Confirmar Contraseña</label>
                            <input type="password" minlength="8" name="contraseña_confirmation" class="form-control" placeholder="Confirma tu nueva contraseña" required style="border-radius: 8px; border: 1px solid #ced4da;">
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-block" style="border-radius: 8px; background-color: #0056b3; border: none;">Restablecer Contraseña</button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <a class="text-primary font-weight-bold" href="{{ route('login.form') }}" style="text-decoration: none;">Regresar al inicio de sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('status'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Contraseña restablecida!',
        text: "{{ session('status') }}",
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ $errors->first() }}",
            showConfirmButton: true,
        });
    });
</script>
@endif

@endsection
