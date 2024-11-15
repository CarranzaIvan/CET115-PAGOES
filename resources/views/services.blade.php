@extends('layout.app')
@section('title', 'Servicios')
@section('content')

<div class="container text-center">
    <!--ENCABEZADO DE SERVICIOS-->
    <h1 class="font-weight-bold colorEstandarTexto">Nuestros servicios</h1>
    <h5 class="text-black font-weight-light">Selecciona uno de nuestros servicios para iniciar y realiza tus pagos o transferencias de manera segura</h5>

    <br>
    <br>

    <div class="row ">
        <div class="col-md-4">
            <div class="card" style="border-radius: 1rem; height: 420px;">
                <div class="card-body">
                    <h5 class="card-title">Pagos</h5>
                    <img src="{{ asset('images/pago.png') }}" class="card-img-top" alt="Pagos">
                    <p class="card-text">Realiza pagos de servicios básicos como luz, agua, teléfono, etc.</p>
                </div>
                <div class="card-footer text-right">
                    <a href="#" class="btn btn-primary col-md-3" data-bs-toggle="modal" data-bs-target="#modalPagarServicio" style="background-color: #0c387a;">Ir</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="border-radius: 1rem; height: 420px;">
                <div class="card-body">
                    <h5 class="card-title
                    ">Transferencias</h5>
                    <img src="{{ asset('images/tranferencia.avif') }}" class="card-img-top" alt="Transferencias">
                    <p class="card-text">Realiza transferencias a cualquier banco de manera segura y rápida.</p>
                </div>
                <div class="card-footer text-right">
                    <a href="#" class="btn btn-primary col-md-3">Ir</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="border-radius: 1rem; height: 420px;">
                <div class="card-body">
                    <h5 class="card-title">Cargar saldo</h5>
                    <img src="{{ asset('images/cargar_saldo.png') }}" class="card-img-top" alt="Cargar saldo" style="width: 80%; height: auto;">
                    <p class="card-text">Recarga saldo a tu billetera PagoMovilES de manera rápida y segura.</p>
                </div>
                <div class="card-footer text-right">
                    <a href="#" class="btn btn-primary col-md-3 " data-bs-toggle="modal" data-bs-target="#modalCargarSaldo" style="background-color: #0c387a;">Ir</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para pagar un servicio -->
<div class="modal fade" id="modalPagarServicio" tabindex="-1" aria-labelledby="modalPagarServicioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPagarServicioLabel">Pagar Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="monto">Monto a pagar</label>
                    <input type="number" class="form-control" id="montoServices" name="montoServices" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="servicio">Servicio</label>
                    <select class="form-select" id="servicio" name="servicio" required>
                        <option value="" disabled selected>Selecciona un servicio</option>
                        <option value="luz">Luz</option>
                        <option value="agua">Agua</option>
                        <option value="teléfono">Teléfono</option>
                        <option value="internet">Internet</option>
                    </select>
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="saldo-tab" data-bs-toggle="tab" href="#saldo" role="tab" aria-controls="saldo" aria-selected="true"><i class="fas fa-wallet"></i> Tu saldo</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tarjeta-tab" data-bs-toggle="tab" href="#tarjeta" role="tab" aria-controls="tarjeta" aria-selected="false"><i class="fas fa-credit-card"></i> Tarjeta</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="bitcoin-tab" data-bs-toggle="tab" href="#bitcoin" role="tab" aria-controls="bitcoin" aria-selected="false"><i class="fab fa-bitcoin"></i> Bitcoin</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="saldo" role="tabpanel" aria-labelledby="saldo-tab">
                        <div class="alert alert-info mt-3" role="alert">
                            <i class="fas fa-info-circle"></i> Tu saldo actual es de: ${{ Auth::user()->wallet->saldo }}
                        </div>
                        <div id="mostrarMessage" class="alert alert-info mt-3" style="display: none;" role="alert">
                            <i class="fas fa-info-circle"></i> <span id="message"></span>
                        </div>
                        <div id="error-saldo" role="alert" class="text-danger mt-2"></div>

                        <!-- campo para solicitar codigo otp -->
                        <div id="mostrarOtp" style="display: none;">
                            <label for="codigo_otp">Código OTP</label>
                            <input type="text" name="codigo_otp" id="codigo_otp" class="form-control text-center"
                                pattern="\d{6}" maxlength="6" required autofocus
                                inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                title="El código OTP debe ser un número de 6 dígitos">

                            <div class="form-group mt-3 text-center">
                                <button type="button" id="paySaldo" class="btn btn-primary">Pagar ahora</button>
                            </div>
                        </div>
                        <div class="form-group mt-3 text-center">
                            <button type="button" id="solicitar_otp" class="btn btn-primary col-md-4">Solicitar pago</button>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="tarjeta" role="tabpanel" aria-labelledby="tarjeta-tab">
                        <form id="paymentStripeServices">
                            <div class="form-group mt-4">
                                <label for="numeroTarjeta">Número de Tarjeta</label>
                                <div id="numeroTarjetaServices" class="form-control"></div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fechaExpiracion">Fecha de Expiración</label>
                                    <div id="fechaExpiracionServices" class="form-control"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cvv">CVV</label>
                                    <div id="cvvServices" class="form-control"></div>
                                </div>
                            </div>
                            <div id="card-errorsServices" role="alert" class="text-danger mt-2"></div>
                            <div class="form-group text-center">
                                <button type="submit" id="paytarjetaServices" class="btn btn-primary">Pagar ahora</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="bitcoin" role="tabpanel" aria-labelledby="bitcoin-tab">
                        <div id="bitcoin-errorServices" role="alert" class="text-danger mt-2"></div>
                        <div class="form-group text-center mt-4">
                            <button type="button" id="payBitcoinServices" class="btn btn-primary">Generar Pago</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal para cargar saldo -->
<div class="modal fade" id="modalCargarSaldo" tabindex="-1" aria-labelledby="modalCargarSaldoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCargarSaldoLabel">Recargar Saldo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="monto">Monto a recargar</label>
                    <input type="number" class="form-control" id="monto" name="monto" required>
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tarjeta-tab" data-bs-toggle="tab" href="#tarjeta" role="tab" aria-controls="tarjeta" aria-selected="true"><i class="fas fa-credit-card"></i> Tarjeta</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="bitcoin-tab" data-bs-toggle="tab" href="#bitcoin" role="tab" aria-controls="bitcoin" aria-selected="false"><i class="fab fa-bitcoin"></i> Bitcoin</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tarjeta" role="tabpanel" aria-labelledby="tarjeta-tab">
                        <form id="paymentStripe">
                            <div class="form-group mt-3">
                                <label for="numeroTarjeta">Número de Tarjeta</label>
                                <div id="numeroTarjeta" class="form-control"></div>
                            </div>
                            <div class="row">
                                <div class="form-group mt-3 col-md-6">
                                    <label for="fechaExpiracion">Fecha de Expiración</label>
                                    <div id="fechaExpiracion" class="form-control"></div>
                                </div>
                                <div class="form-group mt-3 col-md-6">
                                    <label for="cvv">CVV</label>
                                    <div id="cvv" class="form-control"></div>
                                </div>
                            </div>
                            <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                            <div class="form-group mt-3 text-center">
                                <button type="submit" id="paytarjeta" class="btn btn-primary">Procesar</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="bitcoin" role="tabpanel" aria-labelledby="bitcoin-tab">
                        <div id="bitcoin-error" role="alert" class="text-danger mt-2"></div>
                        <div class="form-group mt-3 text-center">
                            <button type="button" id="payBitcoin" class="btn btn-primary">Generar Pago</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#solicitar_otp').on('click', function() {
        const monto = document.getElementById('montoServices').value;
        const servicio = document.getElementById('servicio').value;
        if (monto === '') {
            const displayError = document.getElementById('error-saldo');
            displayError.textContent = 'El monto es requerido';
            return;
        }

        if (servicio === '') {
            const displayError = document.getElementById('error-saldo');
            displayError.textContent = 'El servicio es requerido';
            return;
        }

        if (parseFloat(monto) > parseFloat('{{ Auth::user()->wallet->saldo }}')) {
            const displayError = document.getElementById('error-saldo');
            displayError.textContent = 'No tienes suficiente saldo en tu billetera';
            return;
        }
        const displayError = document.getElementById('error-saldo');
        displayError.textContent = '';
        $.ajax({
            url: "{{ route('payment.otp') }}",
            type: 'POST',
            data: {
                id_usuario: '{{ Auth::user()->id_usuario }}',
                _token: '{{ csrf_token() }}' // Asegúrate de incluir el token CSRF
            },
            success: function(response) {
                if (response.success) {
                    document.getElementById('message').textContent = 'Se ha enviado un código OTP a tu correo electrónico';
                    document.getElementById('mostrarMessage').style.display = 'block';
                    document.getElementById('mostrarOtp').style.display = 'block';
                    document.getElementById('solicitar_otp').style.display = 'none';
                } else {
                    alert('Error: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $('#paySaldo').on('click', function() {
        const monto = document.getElementById('montoServices').value;
        const servicio = document.getElementById('servicio').value;
        const codigo_otp = document.getElementById('codigo_otp').value;
        if (codigo_otp === '' || codigo_otp.length < 6) {
            const displayError = document.getElementById('error-saldo');
            displayError.textContent = 'El código OTP es requerido';
            return;
        }
        if (monto === '') {
            const displayError = document.getElementById('error-saldo');
            displayError.textContent = 'El monto es requerido';
            return;
        }

        if (servicio === '') {
            const displayError = document.getElementById('error-saldo');
            displayError.textContent = 'El servicio es requerido';
            return;
        }

        if (parseFloat(monto) > parseFloat('{{ Auth::user()->wallet->saldo }}')) {
            const displayError = document.getElementById('error-saldo');
            displayError.textContent = 'No tienes suficiente saldo en tu billetera';
            return;
        }
        const displayError = document.getElementById('error-saldo');
        displayError.textContent = '';

        $.ajax({
            url: "{{ route('payment.otp-verify') }}",
            type: 'POST',
            data: {
                id_usuario: '{{ Auth::user()->id_usuario }}',
                codigo_otp: codigo_otp,
                _token: '{{ csrf_token() }}' // Asegúrate de incluir el token CSRF
            },
            success: function(response) {
                if (response.success) {
                    $.ajax({
                        url: "{{ route('payment.wallet') }}",
                        type: 'POST',
                        data: {
                            id_usuario: '{{ Auth::user()->id_usuario }}',
                            monto: monto,
                            servicio: servicio,
                            _token: '{{ csrf_token() }}' // Asegúrate de incluir el token CSRF
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.href = "{{ route('verServicios') }}";
                            } else {
                                alert('Error: ' + response.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Error: ' + error);
                        }
                    });
                } else {
                    const displayError = document.getElementById('error-saldo');
                    displayError.textContent = response.error;
                    return;
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
</script>

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
    cardNumber.mount('#numeroTarjeta');

    const cardExpiry = elements.create('cardExpiry', {
        style: style,
        placeholder: 'MM/AA',
        showIcon: true
    });
    cardExpiry.mount('#fechaExpiracion');

    const cardCvc = elements.create('cardCvc', {
        style: style,
        placeholder: 'CVC',
        showIcon: true
    });
    cardCvc.mount('#cvv');

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

        if (document.getElementById('monto').value == '') {
            const displayError = document.getElementById('card-errors');
            displayError.textContent = 'El monto es requerido';
            return;
        } else {
            const displayError = document.getElementById('card-errors');
            displayError.textContent = '';
            const submitButton = document.getElementById('paytarjeta');
            submitButton.disabled = true;
            submitButton.textContent = 'Procesando ...';

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod('card', cardNumber, {
                billing_details: {
                    name: '{{ Auth::user()->nombre_completo }}',
                }
            });

            if (error) {
                const displayError = document.getElementById('card-errors');
                displayError.textContent = error.message;
                submitButton.disabled = false;
                submitButton.textContent = 'Procesar';
            } else {
                const response = await fetch('/stripe-payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        payment_method_id: paymentMethod.id,
                        total_a_pagar: document.getElementById('monto').value,
                        user_id: '{{ Auth::user()->id_usuario }}'
                    })
                });

                const result = await response.json();
                if (result.error) {
                    const displayError = document.getElementById('card-errors');
                    displayError.textContent = result.error;
                    submitButton.disabled = false;
                    submitButton.textContent = 'Procesar';
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
                        window.location.href = "{{ route('verServicios') }}";
                    }
                } else {
                    window.location.href = "{{ route('verServicios') }}";
                }
            }
        }


    });

    //Para servicios

    const elementsServices = stripe.elements();
    const cardNumberServices = elementsServices.create('cardNumber', {
        style: style,
        placeholder: 'Número de tarjeta',
        showIcon: true
    });
    cardNumberServices.mount('#numeroTarjetaServices');

    const cardExpiryServices = elementsServices.create('cardExpiry', {
        style: style,
        placeholder: 'MM/AA',
        showIcon: true
    });
    cardExpiryServices.mount('#fechaExpiracionServices');

    const cardCvcServices = elementsServices.create('cardCvc', {
        style: style,
        placeholder: 'CVC',
        showIcon: true
    });
    cardCvcServices.mount('#cvvServices');

    cardNumberServices.on('change', ({
        error
    }) => {
        const displayError = document.getElementById('card-errorsServices');
        if (error) {
            displayError.textContent = error.message;
        } else {
            displayError.textContent = '';
        }
    });

    const formServices = document.getElementById('paymentStripeServices');
    formServices.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (document.getElementById('montoServices').value == '') {
            const displayError = document.getElementById('card-errorsServices');
            displayError.textContent = 'El monto es requerido';
            return;
        } else {
            if (document.getElementById('servicio').value == '') {
                const displayError = document.getElementById('card-errorsServices');
                displayError.textContent = 'El servicio es requerido';
                return;
            }
            const displayError = document.getElementById('card-errorsServices');
            displayError.textContent = '';
            const submitButton = document.getElementById('paytarjetaServices');
            submitButton.disabled = true;
            submitButton.textContent = 'Procesando ...';

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod('card', cardNumberServices, {
                billing_details: {
                    name: '{{ Auth::user()->nombre_completo }}',
                }
            });

            if (error) {
                const displayError = document.getElementById('card-errorsServices');
                displayError.textContent = error.message;
                submitButton.disabled = false;
                submitButton.textContent = 'Procesar';
            } else {
                const response = await fetch('/stripe-paymentServices', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        payment_method_id: paymentMethod.id,
                        total_a_pagar: document.getElementById('montoServices').value,
                        user_id: '{{ Auth::user()->id_usuario }}',
                        servicio: document.getElementById('servicio').value
                    })
                });

                const result = await response.json();
                if (result.error) {
                    const displayError = document.getElementById('card-errorsServices');
                    displayError.textContent = result.error;
                    submitButton.disabled = false;
                    submitButton.textContent = 'Procesar';
                } else if (result.requires_action) {
                    const {
                        error: confirmError
                    } = await stripe.confirmCardPayment(result.payment_intent_client_secret);
                    if (confirmError) {
                        const displayError = document.getElementById('card-errorsServices');
                        displayError.textContent = confirmError.message;
                        submitButton.disabled = false;
                        submitButton.textContent = 'Pagar ahora';
                    } else {
                        window.location.href = "{{ route('verServicios') }}";
                    }
                } else {
                    window.location.href = "{{ route('verServicios') }}";
                }
            }
        }
    });
</script>


<script>
    //Pagar con bitcoin usando OpenNode
    $('#payBitcoin').on('click', function() {
        const monto = document.getElementById('monto').value;
        if (monto === '') {
            const displayError = document.getElementById('bitcoin-error');
            displayError.textContent = 'El monto es requerido';
            return;
        }

        const options = {
            method: 'POST',
            headers: {
                accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: '73123932-1bf0-415e-b03a-b01a39b62cf9' // Asegúrate de que esta es una clave API válida
            },
            body: JSON.stringify({
                notify_receiver: true,
                amount: monto,
                currency: 'USD',
                description: 'Recargar saldo',
                customer_name: '{{ Auth::user()->nombre_completo }}',
                customer_email: '{{ Auth::user()->correo }}',
                order_id: '{{ Auth::user()->id_usuario }}' + Date.now(),
                ttl: 10
            })
        };

        fetch('https://api.opennode.com/v1/charges', options)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.data) {
                    const width = 700;
                    const height = screen.height * 0.9;
                    const left = (screen.width / 2) - (width / 2);
                    const top = (screen.height / 2) - (height / 2);

                    const paymentWindow = window.open(data.data.hosted_checkout_url, '_blank', `width=${width},height=${height},top=${top},left=${left}`);
                    checkPaymentStatus(data.data.id, paymentWindow, monto);
                } else {
                    const displayError = document.getElementById('bitcoin-error');
                    displayError.textContent = data.message;
                }
            })
            .catch(error => {
                const displayError = document.getElementById('bitcoin-error');
                displayError.textContent = 'Ocurrió un error al procesar el pago';
            });
    });

    //Pagar con bitcoin usando OpenNode para servicios
    $('#payBitcoinServices').on('click', function() {
        const monto = document.getElementById('montoServices').value;
        const service = document.getElementById('servicio').value;
        if (monto === '') {
            const displayError = document.getElementById('bitcoin-errorServices');
            displayError.textContent = 'El monto es requerido';
            return;
        }

        if (service === '') {
            const displayError = document.getElementById('bitcoin-errorServices');
            displayError.textContent = 'El servicio es requerido';
            return;
        }

        const options = {
            method: 'POST',
            headers: {
                accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: '73123932-1bf0-415e-b03a-b01a39b62cf9' // Asegúrate de que esta es una clave API válida
            },
            body: JSON.stringify({
                notify_receiver: true,
                amount: monto,
                currency: 'USD',
                description: 'Pago de ' + service,
                customer_name: '{{ Auth::user()->nombre_completo }}',
                customer_email: '{{ Auth::user()->correo }}',
                order_id: '{{ Auth::user()->id_usuario }}' + Date.now(),
                ttl: 10
            })
        };

        fetch('https://api.opennode.com/v1/charges', options)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.data) {
                    const width = 700;
                    const height = screen.height * 0.9;
                    const left = (screen.width / 2) - (width / 2);
                    const top = (screen.height / 2) - (height / 2);

                    const paymentWindow = window.open(data.data.hosted_checkout_url, '_blank', `width=${width},height=${height},top=${top},left=${left}`);
                    servicePaymentStatus(data.data.id, paymentWindow, monto, service);
                } else {
                    const displayError = document.getElementById('bitcoin-errorServices');
                    displayError.textContent = data.message;
                }
            })
            .catch(error => {
                const displayError = document.getElementById('bitcoin-errorServices');
                displayError.textContent = 'Ocurrió un error al procesar el pago';
            });

    });

    //fuccion para verificar el estado del pago de los servicios

    function servicePaymentStatus(charge_id, paymentWindow, monto, service) {
        const options = {
            method: 'GET',
            headers: {
                accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: '73123932-1bf0-415e-b03a-b01a39b62cf9' // Asegúrate de que esta es una clave API válida
            }
        };

        fetch('https://api.opennode.com/v1/charge/' + charge_id, options)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.data.status === 'paid') {
                    paymentWindow.close();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Pago exitoso!',
                        text: 'El pago de ' + service + ' se ha realizado con éxito',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = "{{ route('verServicios') }}";
                    });
                } else {
                    //si la ventana de pago se cierra, detener la verificación
                    if (paymentWindow.closed) {
                        window.location.href = "{{ route('verServicios') }}";
                        return;
                    }
                    // Verificar el estado del pago cada 5 segundos
                    setTimeout(() => {
                        servicePaymentStatus(charge_id, paymentWindow, monto, service);
                    }, 5000);
                }
            })
            .catch(error => {
                console.log(error);
            });
    }


    //funcion para verificar el estado del pago
    function checkPaymentStatus(charge_id, paymentWindow, monto) {
        const options = {
            method: 'GET',
            headers: {
                accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: '73123932-1bf0-415e-b03a-b01a39b62cf9' // Asegúrate de que esta es una clave API válida
            }
        };

        fetch('https://api.opennode.com/v1/charge/' + charge_id, options)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.data.status === 'paid') {
                    paymentWindow.close();
                    $.ajax({
                        url: "{{ route('payment.opennode') }}",
                        type: 'POST',
                        data: {
                            id_usuario: '{{ Auth::user()->id_usuario }}',
                            monto: monto,
                            _token: '{{ csrf_token() }}' // Asegúrate de incluir el token CSRF
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.href = "{{ route('verServicios') }}";
                            } else {
                                alert('Error: ' + response.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Error: ' + error);
                        }
                    });


                } else {
                    //si la ventana de pago se cierra, detener la verificación
                    if (paymentWindow.closed) {
                        window.location.href = "{{ route('verServicios') }}";
                        return;
                    }
                    // Verificar el estado del pago cada 5 segundos
                    setTimeout(() => {
                        checkPaymentStatus(charge_id, paymentWindow, monto);
                    }, 5000);
                }
            })
            .catch(error => {
                console.log(error);
            });
    }
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    });
</script>
@endif

@endsection