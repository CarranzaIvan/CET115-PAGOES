@extends('layout.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 85vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="authincation-content p-5 shadow-lg rounded bg-white text-center">
                    <h4 class="mb-4 font-weight-bold">Verificar Código OTP</h4>

                    <form action="{{ route('verify-otp') }}" method="POST" onsubmit="return validateOTP()">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="otp">Ingresa el código OTP</label>
                            <input type="text" name="otp" id="otp" class="form-control text-center" 
                                   pattern="\d{6}" maxlength="6" required autofocus
                                   inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   title="El código OTP debe ser un número de 6 dígitos">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Verificar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script de SweetAlert para mostrar errores -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ $errors->first() }}",
            timer: 2000,
            showConfirmButton: false,
        });
    });
</script>
@endif

<!-- Validación de JavaScript para el campo OTP -->
<script>
    function validateOTP() {
        const otpInput = document.getElementById('otp').value;
        if (!/^\d{6}$/.test(otpInput)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El código OTP debe ser un número de exactamente 6 dígitos.',
                timer: 2000,
                showConfirmButton: false,
            });
            return false; // Evita el envío del formulario si la validación falla
        }
        return true;
    }
</script>
@endsection
