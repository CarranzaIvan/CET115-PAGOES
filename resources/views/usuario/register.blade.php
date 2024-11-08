@extends('layout.app')

@section('content')
<link href="{{asset('templates/xhtml/css/style.css')}}" rel="stylesheet">
<div class="authincation d-flex align-items-center justify-content-center" style="height: 97vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center pl-5">
                            <img src="{{ asset('images/pagomovil.png') }}" alt="Register Image" class="img-fluid mb-4">
                        </div>
                        <div class="col-md-7">
                            <div class="auth-form">
                                <h3 class="text-center mb-4">Registro de Usuario</h3>
                                <form method="POST" action="{{ route('usuario.register') }}" id="registerForm">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nombre">Nombre Completo</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre_completo" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="direccion">Dirección</label>
                                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="telefono">Teléfono</label>
                                                <input type="text" class="form-control" id="telefono" name="telefono" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="email" name="correo" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Contraseña</label>
                                                <input type="password" class="form-control" id="password" name="password" required minlength="8">
                                                <small class="form-text text-muted">La contraseña debe tener al menos 8 caracteres.</small>
                                                <small id="passwordError" class="text-danger" style="display: none;">Las contraseñas no coinciden.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirmar Contraseña</label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                                    </div>
                                </form>
                                <div class="new-account mt-3 text-center">
                                    <p>¿Ya tienes cuenta? <a class="text-primary" href="{{ route('login.form') }}">Iniciar sesión</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = $('#registerForm');
        const passwordInput = $('#password');
        const confirmPasswordInput = $('#password_confirmation');
        const passwordError = $('#passwordError');

        form.on('submit', function(e) {
            e.preventDefault(); // Previene el envío normal del formulario

            if (passwordInput.val() !== confirmPasswordInput.val()) {
                passwordError.show();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Las contraseñas no coinciden.'
                });
                return;
            } else {
                passwordError.hide();
            }

            $.ajax({
                url: "{{ route('usuario.register') }}",
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Registro exitoso!',
                        text: 'El usuario se ha registrado correctamente.',
                    }).then(() => {
                        window.location.href = "{{ route('login.form') }}";
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors.correo) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'El correo ya está en uso. Por favor, elige otro.',
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema con el registro. Inténtalo nuevamente.',
                        });
                    }
                }
            });
        });
    });
</script>
@endsection