@extends('layout.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 90vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-8">
                <div class="authincation-content p-5 shadow-lg rounded bg-white">
                    <!-- Logo en la parte superior centrado -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/pagomovil.png') }}" alt="Register Image" class="img-fluid" style="width: 120px; height: auto;">
                    </div>

                    <h4 class="text-center mb-4 font-weight-bold" style="color: #0056b3;">Registro de Usuario</h4>

                    <!-- Formulario de Registro -->
                    <form method="POST" action="{{ route('usuario.register') }}" id="registerForm">
                        @csrf

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <div class="form-group mb-3">
                                    <label for="nombre" class="font-weight-bold" style="color: #555;">Nombre Completo</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre_completo" required style="border-radius: 8px; border: 1px solid #ced4da;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="telefono" class="font-weight-bold" style="color: #555;">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required style="border-radius: 8px; border: 1px solid #ced4da;">
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="direccion" class="font-weight-bold" style="color: #555;">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required style="border-radius: 8px; border: 1px solid #ced4da;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group mb-3">
                                    <label for="email" class="font-weight-bold" style="color: #555;">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="correo" required style="border-radius: 8px; border: 1px solid #ced4da;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="password" class="font-weight-bold" style="color: #555;">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required minlength="8" style="border-radius: 8px; border: 1px solid #ced4da;">
                                    <small class="form-text text-muted">Debe tener al menos 8 caracteres.</small>
                                    <small id="passwordError" class="text-danger" style="display: none;">Las contraseñas no coinciden.</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="password_confirmation" class="font-weight-bold" style="color: #555;">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" minlength="8" id="password_confirmation" name="password_confirmation" required style="border-radius: 8px; border: 1px solid #ced4da;">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-block" style="border-radius: 8px; background-color: #0056b3; border: none;">Registrarse</button>
                        </div>
                    </form>

                    <div class="new-account mt-4 text-center">
                        <p>¿Ya tienes cuenta? <a class="text-primary font-weight-bold" href="{{ route('login.form') }}" style="text-decoration: none;">Iniciar sesión</a></p>
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
            e.preventDefault();

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