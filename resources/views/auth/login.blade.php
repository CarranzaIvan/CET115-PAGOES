@extends('layout.app')

@section('content')
<link href="{{asset('templates/xhtml/css/style.css')}}" rel="stylesheet">
<div class="authincation d-flex align-items-center justify-content-center" style="height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center pl-5">
                            <img src="{{ asset('images/pagomovil.png') }}" alt="Login Image" class="img-fluid mb-4">
                        </div>
                        <div class="col-md-7">
                            <div class="auth-form">
                                <h3 class="text-center mb-4">Iniciar sesión</h3>
                                <form action="{{ route('usuario.login') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Correo</strong></label>
                                        <input type="email" name="correo" class="form-control" placeholder="correo" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Contraseña</strong></label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                                    </div>
                                </form>
                                <div class="new-account mt-3 text-center">
                                    <p>No tienes cuenta? <a class="text-primary" href="{{ route('usuario.register.form') }}">Registrate</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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