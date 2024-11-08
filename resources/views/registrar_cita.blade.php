@extends('layout.app')

@section('title', 'Registrar Cita')

@section('content')

<style>
    /* Estilo general para el contenedor del calendario */
    #calendar-container {
        background-color: #fdfdfd;
        /* Fondo más claro */
        border-radius: 20px;
        /* Bordes más suaves */
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
        /* Sombra suave */
        padding: 40px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 40px;
    }

    /* Efecto de elevación al pasar el ratón */
    #calendar-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.18);
    }

    /* Estilo del calendario */
    #calendar {
        max-width: 100%;
        margin: 0 auto;
        border-radius: 20px;
        overflow: hidden;
        background-color: #f9fafb;
        /* Fondo más claro */
    }

    /* Estilos para los días de la semana (encabezados) */
    .fc-day-header {
        background: linear-gradient(135deg, #ffcc80 0%, #ffa726 100%);
        /* Gradiente dorado */
        color: #2c2c2c;
        /* Texto oscuro */
        font-weight: bold;
        padding: 15px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 14px;
        border-bottom: 2px solid #e0e0e0;
        transition: background-color 0.3s ease;
    }

    /* Estilos para los días del calendario */
    .fc-day {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        transition: background-color 0.3s ease, transform 0.3s ease;
        cursor: pointer;
    }

    /* Efecto de cambio de color y elevación al pasar el ratón */
    .fc-day:hover {
        background-color: #fff3e0;
        /* Suave tono crema */
        transform: scale(1.02);
        z-index: 10;
    }

    /* Estilos para eventos */
    .fc-event {
        border-radius: 10px;
        padding: 10px;
        font-weight: bold;
        color: white;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    /* Animación sutil para eventos */
    .fc-event:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    /* Colores degradados para eventos */
    .fc-event-success {
        background: linear-gradient(135deg, #66bb6a 0%, #43a047 100%);
        /* Degradado verde */
    }

    .fc-event-warning {
        background: linear-gradient(135deg, #ffca28 0%, #f57f17 100%);
        /* Degradado dorado */
    }

    .fc-event-danger {
        background: linear-gradient(135deg, #ef5350 0%, #d32f2f 100%);
        /* Degradado rojo */
    }

    /* Estilos para el día de hoy */
    .fc-today {
        background-color: #ffecb3;
        /* Fondo dorado suave para el día actual */
        border: 2px solid #ffb74d;
        /* Borde dorado */
        font-weight: bold;
    }

    /* Animación para los días actuales */
    .fc-today-highlight {
        animation: pulse 1.5s infinite;
    }

    /* Animación de pulso para el día actual */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 183, 77, 0.4);
        }

        70% {
            box-shadow: 0 0 0 15px rgba(255, 183, 77, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(255, 183, 77, 0);
        }
    }

    /* Ajustes responsivos */
    @media (max-width: 768px) {
        #calendar-container {
            padding: 20px;
        }

        .fc-day-header {
            padding: 10px;
            font-size: 12px;
        }

        .fc-event {
            padding: 8px;
            font-size: 12px;
        }
    }
</style>

<!--CALENDARIO-->
<section style="background-color: #f5f5f5;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <br>
                <h1 class="text-center">Reserva una Cita</h1>
                <br>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div id='calendar-container'>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</section>
<!--FIN CALENDARIO-->


<!-- Vertically centered modal HORARIOS-->
<div class="modal fade" id="modal-reservas" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div style="background-color:#0d6efd ;" class="modal-header">
                <h1 style="color: white;" class="modal-title fs-5" id="staticBackdropLabel"><b>Reserva tu cita para el dia <span id="dia_de_la_semana"></span></b></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md 6">
                        <center>
                            Turnos de la mañana
                        </center>
                        <br>
                        <div class="d-grid gap-1">
                            <button type="button" id="btn_h1" class="btn btn-success">08:00 - 09:00</button>
                            <button type="button" id="btn_h2" class="btn btn-success">09:00 - 10:00</button>
                            <button type="button" id="btn_h3" class="btn btn-success">10:00 - 11:00</button>
                            <button type="button" id="btn_h4" class="btn btn-success">11:00 - 12:00</button>
                            <br>
                        </div>
                    </div>

                    <div class="col-md 6">
                        <center>
                            Turnos de la tarde
                        </center>
                        <br>
                        <div class="d-grid gap-1">
                            <button type="button" id="btn_h5" class="btn btn-success">13:00 - 14:00</button>
                            <button type="button" id="btn_h6" class="btn btn-success">14:00 - 15:00</button>
                            <button type="button" id="btn_h7" class="btn btn-success">15:00 - 16:00</button>
                            <button type="button" id="btn_h8" class="btn btn-success">16:00 - 17:00</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal FORMULARIO -->
<div class="modal fade" id="modal-formulario" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div style="background-color:#0d6efd ;" class="modal-header">
                <h1 style="color: white;" class="modal-title fs-5" id="staticBackdropLabel"><b><span id="dia_de_la_semana"></span></b></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="reservationForm" method="post">
                        @csrf <!-- Este token es obligatorio para las solicitudes POST en Laravel -->
                        <div class="row">
                            <div class="col-md 6">
                                <div class="mb-3">
                                    <label><b>Usuario</b></label>
                                    @if(Auth::check())
                                    <input type="text" name="usuario" class="form-control" value="{{ Auth::user()->nombre_completo }}" readonly>
                                    <input type="hidden" name="id_usuario" value="{{ Auth::user()->id_usuario }}">
                                    @else
                                    <input type="text" class="form-control" value="Usuario no autenticado" readonly>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for=""><b>Tipo de Servicio</b></label>
                                    <select name="id_servicio" class="form-select" required>
                                        <option value="" selected>Selecciona un servicio</option>
                                        @foreach($servicios as $servicio)
                                        <option value="{{ $servicio->id }}">{{ $servicio->nomServicio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label><b>Fecha de reserva</b></label>
                                    <input type="text" id="fecha_cita" name="fecha_cita" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for=""><b>Hora de reserva</b></label>
                                    <input type="text" id="hora_cita" name="hora_cita" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" id="regresar" class="btn btn-secondary">Regresar</button>
                            <button id="reservarCita" type="submit" class="btn btn-primary">Reservar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Crear un modal para pagar la cita -->
<div class="modal fade" id="modal-pago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div style="background-color:#0d6efd ;" class="modal-header">
                <h1 style="color: white;" class="modal-title fs-5" id="staticBackdropLabel"><b>Detalles del servicio adquirido<span id="dia_de_la_semana"></span></b></h1>
            </div>
            <div class="modal-body p-5">
                <div class="row">
                    <div class="card">
                        <input type="hidden" id="cita_id" name="cita_id" value="">
                        <div class="row">
                            <div class="col-md-8" style="text-align: right;">
                                <label class="form-control-plaintext" for="nom_servicio">Servicio</label>
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                <p class="form-control-plaintext" id="nom_servicio"></p>
                                <input type="hidden" id="name_service" value="">
                                <input type="hidden" id="description_service" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8" style="text-align: right;">
                                <label class="form-control-plaintext" for="sub_servicios">Subtotal</label>
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                <p class="form-control-plaintext" id="servicio_tt"></p>
                                <input id="subtotal_servicio" type="hidden" name="subtotal_servicio" value="0">
                            </div>
                        </div>

                        <!-- Subtotal de Servicios (Solo Texto) -->
                        <div class="row" id="posee_descuento" style="display: none">
                            <div class="col-md-8" style="text-align: right;">
                                <label for="descuento">Descuento</label>
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                <p class="form-control-plaintext" id="descuentoLbl"></p>
                                <input id="descuento" type="hidden" name="descuento" value="0">
                            </div>
                        </div>
                        <!-- Total a Pagar (Solo Texto) -->
                        <div class="row">
                            <div class="col-md-8" style="text-align: right;">
                                <label for="total_a_pagar">Total a Pagar</label>
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                <p class="form-control-plaintext text-success" id="pago">$20</p>
                                <input type="hidden" id="total_a_pagar_hidden" name="total_a_pagar" value="20">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <!-- Card para métodos de pago -->
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="paymentMethods" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tarjeta-tab" data-toggle="tab" href="#tarjeta" role="tab" aria-controls="tarjeta" aria-selected="true"><i class="bi bi-credit-card"></i> Tarjeta</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false"><i class="bi bi-paypal"></i> PayPal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="bitcoin-tab" data-toggle="tab" href="#bitcoin" role="tab" aria-controls="bitcoin" aria-selected="false"><i class="fa-brands fa-bitcoin"></i> Criptomonedas</a>
                                </li>
                                <!-- Otros métodos omitidos para simplicidad -->
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="paymentMethodsContent">
                                <div class="tab-pane fade show active" id="tarjeta" role="tabpanel" aria-labelledby="tarjeta-tab">
                                    <form id="paymentStripe">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="card-holder-name">Nombre del titular</label>
                                                    <input type="text" class="form-control" id="card-holder-name" name="card_name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="card-expiry">Fecha de Expiración</label>
                                                    <div id="card-expiry" class="form-control"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="card-number">Número de la Tarjeta</label>
                                                    <div id="card-number" class="form-control"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="card-cvc">CVC</label>
                                                    <div id="card-cvc" class="form-control"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                                        <button type="submit" id="stripePago" class="btn btn-primary mt-2">Pagar ahora</button>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
                                    <form id="paypalPayment">
                                        <div class="text-center">
                                            <p>Para completar el pago con PayPal, haga clic en el botón de abajo:</p>
                                            <div id="paypal-button-container"></div>
                                        </div>
                                    </form>
                                </div>


                                <div class="tab-pane fade" id="bitcoin" role="tabpanel" aria-labelledby="bitcoin-tab">
                                    <div class="text-center">
                                        <p>Para completar haz clic en el botón de abajo:</p>
                                        <!-- logica para pago con criptomonedas -->
                                        <div id="criptoPay"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-danger" id="confim_delete">
                    Cancelar Cita
                </button>
            </div>
        </div>
    </div>

    <!-- Modal for canceling a cita -->
    <div class="modal fade" id="modal-cancelar-cita" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Cancelar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas cancelar esta cita?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close_delete">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmar-cancelacion">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para guardar datos de la cita con ajax -->
    <script>
        $(document).ready(function() {
            $('#reservationForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('citas.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            var modal = new bootstrap.Modal(document.getElementById('modal-pago'), {
                                backdrop: 'static',
                                keyboard: false
                            });
                            modal.show();
                            // Fetch and display the service details
                            var detalleUrl = "{{ url('/citas/detalle-pago') }}/" + response.cita_id;
                            $.ajax({
                                url: detalleUrl,
                                method: 'GET',
                                success: function(data) {
                                    $('#cita_id').val(response.cita_id);
                                    $('#nom_servicio').text(data.servicio);
                                    $('#name_service').val(data.servicio);
                                    $('#description_service').val(data.descripcion);
                                    $('#servicio_tt').text('$' + data.precio);
                                    $('#subtotal_servicio').val(data.precio);
                                    if (data.descuento > 0) {
                                        $('#posee_descuento').show();
                                        $('#descuentoLbl').text('- $' + (data.precio * (data.descuento / 100)).toFixed(2));
                                        $('#descuento').val((data.precio * (data.descuento / 100)).toFixed(2));
                                    } else {
                                        $('#posee_descuento').hide();
                                    }
                                    $('#pago').text('$' + ((data.precio - (data.precio * (data.descuento / 100))).toFixed(2)));
                                    $('#total_a_pagar_hidden').val((data.precio - (data.precio * (data.descuento / 100))).toFixed(2));
                                },
                                error: function(xhr) {
                                    console.error("Error en la solicitud AJAX:", xhr);
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Error en la solicitud AJAX:", xhr);
                    }
                });
            });
        });
    </script>
    <!-- inicializar stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('pk_test_51QBjVvP7vtejcYNuzawAM4ZJuQT7RcTQ9ft9ugJnrhUllyrAwNvxgLyfIP8G2VX80PecZQCqVURLyTL218e2Mf7p007D9dEHl7');
        const elements = stripe.elements();
        const style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                },
                iconColor: '#666EE8'
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        const cardNumber = elements.create('cardNumber', {
            style: style,
            placeholder: 'Número de tarjeta',
            showIcon: true
        });
        cardNumber.mount('#card-number');

        const cardExpiry = elements.create('cardExpiry', {
            style: style,
            placeholder: 'MM/AA',
            showIcon: true
        });
        cardExpiry.mount('#card-expiry');

        const cardCvc = elements.create('cardCvc', {
            style: style,
            placeholder: 'CVC',
            showIcon: true
        });
        cardCvc.mount('#card-cvc');

        cardNumber.on('change', ({
            error
        }) => {
            const displayError = document.getElementById('card-errors');
            if (error) {
                displayError.textContent = error.message;
            } else {
                displayError.textContent = '';
            }
        });
        //pago con tarjeta usando stripe
        const form = document.getElementById('paymentStripe');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const submitButton = document.getElementById('stripePago');
            submitButton.disabled = true;
            submitButton.textContent = 'Procesando ...';

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod('card', cardNumber, {
                billing_details: {
                    name: document.getElementById('card-holder-name').value
                }
            });

            if (error) {
                const displayError = document.getElementById('card-errors');
                displayError.textContent = error.message;
                submitButton.disabled = false;
                submitButton.textContent = 'Pagar ahora';
            } else {
                const response = await fetch('/stripe-payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        payment_method_id: paymentMethod.id,
                        total_a_pagar: document.getElementById('total_a_pagar_hidden').value,
                        cita_id: document.getElementById('cita_id').value
                    })
                });

                const result = await response.json();
                if (result.error) {
                    const displayError = document.getElementById('card-errors');
                    displayError.textContent = result.error;
                    submitButton.disabled = false;
                    submitButton.textContent = 'Pagar ahora';
                } else if (result.requires_action) {
                    const {
                        error: confirmError
                    } = await stripe.confirmCardPayment(result.payment_intent_client_secret);
                    if (confirmError) {
                        const displayError = document.getElementById('card-errors');
                        displayError.textContent = confirmError.message;
                        submitButton.disabled = false;
                        submitButton.textContent = 'Pagar ahora';
                    } else {
                        window.location.href = "{{ route('registrar_cita') }}";
                    }
                } else {
                    window.location.href = "{{ route('registrar_cita') }}";
                }
            }
        });
    </script>
    <!-- Script para pago con PayPal -->
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: document.getElementById('total_a_pagar_hidden').value
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Llamar al método payPalPayment en el servidor
                    $.ajax({
                        url: '{{ route("payment.paypal") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            cita_id: document.getElementById('cita_id').value
                        },
                        success: function(response) {
                            if (response.success) {
                                // Mostrar mensaje de éxito
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Pago completado!',
                                    text: 'Gracias por su compra.',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = "{{ route('registrar_cita') }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.error,
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un problema al procesar el pago.',
                            });
                        }
                    });
                });
            }
        }).render('#paypal-button-container');
    </script>
    <!-- Script para pago con criptomonedas usando coinbase -->
    <script>
        $('#bitcoin-tab').on('click', function() {
            pagarCrypto();
        });

        function pagarCrypto() {
            const apiKey = "{{ env('COINBASE_API') }}";
            const chargeData = {
                name: document.getElementById('name_service').value,
                description: document.getElementById('description_service').value,
                pricing_type: 'fixed_price',
                local_price: {
                    amount: document.getElementById('total_a_pagar_hidden').value,
                    currency: 'USD'
                }
            };
            fetch('https://api.commerce.coinbase.com/charges/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CC-Api-Key': apiKey
                    },
                    body: JSON.stringify(chargeData)
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.data && data.data.hosted_url) {
                        $('#criptoPay').html(`<a href="${data.data.hosted_url}" class="btn btn-primary" target="_blank">Pagar con criptomonedas</a>`);

                        // Polling to check the payment status
                        const chargeId = data.data.id;
                        const interval = setInterval(() => {
                            fetch(`https://api.commerce.coinbase.com/charges/${chargeId}`, {
                                    method: 'GET',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CC-Api-Key': apiKey
                                    }
                                })
                                .then(response => response.json())
                                .then(chargeData => {
                                    if (chargeData.data.timeline[0].status === 'COMPLETED') {
                                        clearInterval(interval);

                                        // Call the callback route after successful payment
                                        $.ajax({
                                            url: '{{ route("payment.crypto.callback") }}',
                                            method: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                cita_id: document.getElementById('cita_id').value,
                                                charge_id: chargeId
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    // Mostrar mensaje de éxito
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: '¡Pago completado!',
                                                        text: 'Gracias por su compra.',
                                                        timer: 2000,
                                                        showConfirmButton: false
                                                    }).then(() => {
                                                        window.location.href = "{{ route('registrar_cita') }}";
                                                    });
                                                } else {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error',
                                                        text: response.error,
                                                    });
                                                }
                                            },
                                            error: function(xhr) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: 'Hubo un problema al procesar el pago.',
                                                });
                                            }
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        }, 5000); // Poll every 5 seconds
                    } else {
                        $('#criptoPay').html('<p>Hubo un problema al procesar el pago.</p>');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    $('#criptoPay').html('<p>Hubo un problema al procesar el pago.</p>');
                });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#confirmar-cancelacion').click(function() {
                var citaId = document.getElementById('cita_id').value;

                $.ajax({
                    url: '/citas/eliminar',
                    type: 'DELETE',
                    data: {
                        id: citaId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: '¡Eliminada!',
                                text: 'La cita ha sido cancelada.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                'No se pudo cancelar la cita.',
                                'error'
                            );
                        }
                    },
                });
            });

            $('#close_delete').click(function() {
                $('#modal-cancelar-cita').modal('hide');
            });
            $('#confim_delete').click(function() {
                $('#modal-cancelar-cita').modal('show');
            });
        });
    </script>



    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    <!--SCRIPT PARA CALENDARIO-->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>


    <script>
        var a; // Variable para almacenar la fecha seleccionada

        document.addEventListener('DOMContentLoaded', function() {
            // Configuración de la zona horaria de El Salvador
            var isAuthenticated = "{{ Auth::check() ? 'true' : 'false' }}";
            var options = {
                timeZone: 'America/El_Salvador',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            };
            var today = new Date();

            var dateElSalvador = new Intl.DateTimeFormat('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                timeZone: 'America/El_Salvador'
            }).format(today);

            var currentHourElSalvador = parseInt(new Intl.DateTimeFormat('es-SV', {
                hour: '2-digit',
                timeZone: 'America/El_Salvador',
                hour12: false
            }).format(today));

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                editable: true,
                selectable: true,
                allDaySlot: false,
                validRange: {
                    start: dateElSalvador
                },
                events: '/citas', // URL a la ruta en Laravel
                dateClick: function(info) {

                    // Verificar si el usuario está autenticado
                    if (isAuthenticated !== 'true') {
                        Swal.fire({
                            icon: "warning",
                            title: "Oops...",
                            text: "Debes iniciar sesión para reservar una cita",
                            footer: `<a href="{{ route('login.form') }}">¿Ya tienes una cuenta? Inicia Sesión</a>`,
                        });
                        return; // Salir de la función si el usuario no está autenticado
                    }

                    a = info.dateStr;
                    var selectedDate = new Date(a);
                    var selectedDateFormatted = selectedDate.toISOString().split('T')[0];
                    var dayOfWeek = selectedDate.getUTCDay();

                    var dia = selectedDate.getDate() + 1;
                    var mes = selectedDate.toLocaleString('es-SV', {
                        month: 'long'
                    });
                    var anio = selectedDate.getFullYear();
                    var diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                    var finalDate = `${diasSemana[dayOfWeek]} ${dia} de ${mes} del ${anio}`;

                    $('#dia_de_la_semana').text(finalDate);

                    if (dayOfWeek === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lo sentimos',
                            text: 'No se pueden reservar citas los domingos.',
                            confirmButtonText: 'Entendido'
                        });
                        return;
                    }

                    $.ajax({
                        url: '/citas/horas-ocupadas',
                        type: 'GET',
                        data: {
                            fecha: a
                        },
                        success: function(response) {
                            var horasOcupadas = response;

                            $('button[id^="btn_h"]').removeClass('btn-danger').addClass('btn-success').prop('disabled', false);

                            if (selectedDateFormatted === dateElSalvador) {
                                $('button[id^="btn_h"]').each(function() {
                                    var horaBoton = $(this).text().trim();
                                    var horaNumero = parseInt(horaBoton.split(':')[0]);

                                    if (horaNumero < currentHourElSalvador) {
                                        $(this).removeClass('btn-success').addClass('btn-secondary').prop('disabled', true);
                                    } else {
                                        $(this).removeClass('btn-secondary').addClass('btn-success').prop('disabled', false);
                                    }
                                });
                            } else {
                                $('button[id^="btn_h"]').removeClass('btn-secondary').addClass('btn-success').prop('disabled', false);
                            }

                            horasOcupadas.forEach(function(hora) {
                                switch (hora) {
                                    case '08:00 - 09:00':
                                        $('#btn_h1').removeClass('btn-success').addClass('btn-danger').prop('disabled', true);
                                        break;
                                    case '09:00 - 10:00':
                                        $('#btn_h2').removeClass('btn-success').addClass('btn-danger').prop('disabled', true);
                                        break;
                                    case '10:00 - 11:00':
                                        $('#btn_h3').removeClass('btn-success').addClass('btn-danger').prop('disabled', true);
                                        break;
                                    case '11:00 - 12:00':
                                        $('#btn_h4').removeClass('btn-success').addClass('btn-danger').prop('disabled', true);
                                        break;
                                    case '13:00 - 14:00':
                                        $('#btn_h5').removeClass('btn-success').addClass('btn-danger').prop('disabled', true);
                                        break;
                                    case '14:00 - 15:00':
                                        $('#btn_h6').removeClass('btn-success').addClass('btn-danger').prop('disabled', true);
                                        break;
                                    case '15:00 - 16:00':
                                        $('#btn_h7').removeClass('btn-success').addClass('btn-danger').prop('disabled', true);
                                        break;
                                    case '16:00 - 17:00':
                                        $('#btn_h8').removeClass('btn-success').addClass('btn-danger').prop('disabled', true);
                                        break;
                                }
                            });

                            // Mostrar el modal utilizando Bootstrap 5
                            var modal = new bootstrap.Modal(document.getElementById('modal-reservas'));
                            modal.show();
                        }
                    });
                },

                eventClick: function(info) {
                    var eventObj = info.event; // Obtenemos el objeto del evento

                    if (eventObj.id) { // Verificamos si el evento tiene un ID
                        $.ajax({
                            url: '/citas/detalle',
                            type: 'GET',
                            data: {
                                id: eventObj.id // Pasando el ID del evento
                            },
                            success: function(response) {
                                console.log('Respuesta del servidor:', response);
                                if (response.error) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: response.error
                                    });
                                } else {



                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Detalles de la Cita',
                                        html: `
                                            <div style="text-align: center; font-size: 16px; line-height: 1.6;">
                                            <b>Usuario:</b> ${response.usuario}<br>
                                                <b>Servicio:</b> ${response.servicio}<br>
                                                <b>Fecha:</b> ${response.fecha}<br>
                                                <b>Hora:</b> ${response.hora}<br>
                                            </div>
                                            <div style="margin-top: 20px; text-align: center;">
                                                
                                                <button id="deleteCita" class="btn btn-danger">Cancelar Cita</button>
                                            </div>
                                        `,
                                        showConfirmButton: false,
                                        width: 500,
                                        padding: '2em',
                                        background: '#fff',
                                        customClass: {
                                            popup: 'custom-swal-popup'
                                        },
                                        backdrop: `
                                        rgba(0,0,123,0.2)
                                        url("{{asset('images/nyan-cat-nyan.gif')}}")
                                        left top
                                        no-repeat
                                    `
                                    });

                                    document.getElementById('deleteCita').addEventListener('click', function() {
                                        var currentDateTime = new Date();
                                        var citaDateTime = new Date(response.fecha + ' ' + response.hora.split(' - ')[0]);

                                        // Calcular la diferencia en horas entre la fecha y hora actual y la fecha y hora de la cita
                                        var diffInHours = (citaDateTime - currentDateTime) / (1000 * 60 * 60);

                                        if (diffInHours < 24) {
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Oops...',
                                                text: 'No puedes cancelar la cita con menos de 24 horas de anticipación.'
                                            });
                                            return;
                                        } else {
                                            // Lógica para eliminar la cita...
                                            Swal.fire({
                                                title: '¿Estás seguro?',
                                                text: "¡No podrás revertir esto!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Sí, cancelar cita',
                                                cancelButtonText: 'No, mantener cita'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        url: '/citas/eliminar',
                                                        type: 'DELETE',
                                                        data: {
                                                            id: eventObj.id,
                                                            _token: '{{ csrf_token() }}'
                                                        },
                                                        success: function(response) {
                                                            if (response.success) {
                                                                Swal.fire({
                                                                    position: "top-center",
                                                                    icon: "success",
                                                                    title: "Cancelada ",
                                                                    text: '¡La cita ha sido cancelada!',
                                                                    showConfirmButton: false,   
                                                                    timer: 2000
                                                                }).then(() => {
                                                                    location.reload();
                                                                });
                                                            } else {
                                                                Swal.fire(
                                                                    'Error',
                                                                    'No se pudo cancelar la cita.',
                                                                    'error'
                                                                );
                                                            }
                                                        },
                                                        error: function(jqXHR, textStatus, errorThrown) {
                                                            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                                                            Swal.fire('Error', 'Error al cancelar la cita.', 'error');
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                                if (jqXHR.status === 403) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Acceso Denegado',
                                        text: 'No tienes permiso para ver los detalles de esta cita.'
                                    });
                                } else {
                                    Swal.fire('Error', 'Error al cargar los detalles de la cita.', 'error');
                                }
                            }
                        });
                    } else {
                        console.error('El evento no tiene un ID asignado.');
                        Swal.fire('Error', 'No se puede identificar la cita.', 'error');
                    }
                }
            });
            calendar.render();
        });
    </script>

    <script>
        // Función para validar y mostrar el modal de formulario
        function validarYMostrarFormulario(horaSeleccionada) {
            var currentDateTime = new Date(); // Hora actual
            var citaDateTime = new Date(a + ' ' + horaSeleccionada.split(' - ')[0] + ':00'); // Fecha y hora de la cita

            // Calcular la diferencia en horas entre la fecha y hora actual y la fecha y hora de la cita
            var diffInHours = (citaDateTime - currentDateTime) / (1000 * 60 * 60);

            if (diffInHours < 24) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Las citas deben reservarse con al menos 24 horas de anticipación.'
                });
                return;
            } else {
                $('#modal-reservas').modal('hide');
                $('#modal-formulario').modal('show');
                $('#fecha_cita').val(a); //para input
                $('#hora_cita').val(horaSeleccionada); //para input
            }
        }

        // Eventos para cada botón de horario con la validación integrada
        $('#btn_h1').click(function() {
            validarYMostrarFormulario('08:00 - 09:00');
        });
        $('#btn_h2').click(function() {
            validarYMostrarFormulario('09:00 - 10:00');
        });
        $('#btn_h3').click(function() {
            validarYMostrarFormulario('10:00 - 11:00');
        });
        $('#btn_h4').click(function() {
            validarYMostrarFormulario('11:00 - 12:00');
        });
        $('#btn_h5').click(function() {
            validarYMostrarFormulario('13:00 - 14:00');
        });
        $('#btn_h6').click(function() {
            validarYMostrarFormulario('14:00 - 15:00');
        });
        $('#btn_h7').click(function() {
            validarYMostrarFormulario('15:00 - 16:00');
        });
        $('#btn_h8').click(function() {
            validarYMostrarFormulario('16:00 - 17:00');
        });

        $('#regresar').click(function() {
            $('#modal-reservas').modal('show');
            $('#modal-formulario').modal('hide');
        });
    </script>

    @endsection