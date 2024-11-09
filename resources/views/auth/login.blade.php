@extends('layout.app')

@section('content')

<div class="d-flex align-items-center justify-content-center" style="min-height: 85vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="authincation-content p-5 shadow-lg rounded bg-white">
                    <!-- Logo en la parte superior centrado -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/pagomovil.png') }}" alt="Login Image" class="img-fluid" style="width: 100px; height: auto;">
                    </div>
                    
                    <h4 class="text-center mb-4 font-weight-bold" style="color: #0056b3;">Iniciar sesión</h4>
                    
                    <!-- Formulario de Inicio de Sesión -->
                    <form action="{{ route('usuario.login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" style="color: #555;">Correo</label>
                            <input type="email" name="correo" class="form-control" placeholder="Correo" required style="border-radius: 8px; border: 1px solid #ced4da;">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label class="font-weight-bold" style="color: #555;">Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="Contraseña" required style="border-radius: 8px; border: 1px solid #ced4da;">
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-block" style="border-radius: 8px; background-color: #0056b3; border: none;">Iniciar Sesión</button>
                        </div>
                    </form>
                    
                    <div class="new-account mt-4 text-center">
                        <p class="mb-1">¿No tienes cuenta? <a class="text-primary font-weight-bold" href="{{ route('usuario.register.form') }}" style="text-decoration: none;">Regístrate</a></p>
                        <p>¿Olvidaste tu contraseña? <a class="text-primary font-weight-bold" href="{{ route('password.request') }}" style="text-decoration: none;">Recupérala aquí</a></p>
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

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "{{ session('error') }}",
        showConfirmButton: true
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
