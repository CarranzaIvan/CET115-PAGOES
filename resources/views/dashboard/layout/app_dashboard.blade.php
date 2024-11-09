@if(Auth::check() && Auth::user()->id_rol === 1)
<!-- Mostrar contenido del dashboard -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title')</title>
    <!-- Datatable -->
    <link href="{{asset('templates/xhtml/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="{{asset('templates/xhtml/vendor/jqvmap/css/jqvmap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('templates/xhtml/vendor/chartist/css/chartist.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{asset('templates/xhtml/css/style.css')}}" rel="stylesheet">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{route('dashboard')}}" class="brand-logo">
                <img class="logo-abbr" src="{{asset('images/logo.png')}}" alt="">
                <img class="logo-compact" src="{{asset('images/shine.png')}}" alt="">
                <img class="brand-title" src="{{asset('images/shinev1.png')}}" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->


        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                Dashboard
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <div class="header-info">
                                        <!-- Mostramos el nombre del usuario autenticado -->
                                        <span>{{ Auth::user()->nombre_completo }}</span>
                                        <small>{{ Auth::user()->id_rol === 1 ? 'ADMIN' : 'USER' }}</small>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('logout') }}" class="dropdown-item ai-icon"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span class="ml-2">Cerrar Sesión</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-381-networking"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                        </ul>
                    </li>

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-381-calendar"></i>

                            <span class="nav-text">Citas</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('dashboard.citas.index')}}">Listado de citas</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-381-gift"></i>
                            <span class="nav-text">Promociones</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('promociones')}}">Listado de promociones</a></li>
                        </ul>
                    </li>

                    <ul style="color: red;" aria-expanded="false">
                        <li>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-btn">
                                <i class="bi bi-box-arrow-right"></i> <!-- Ícono de Bootstrap Icons -->
                                Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </ul>


                <div class="copyright">
                    <p><strong>Shine&Go</strong> © 2024 Todos los derechos Reservados</p>
                </div>
            </div>
        </div>

        <style>
            .logout-btn {
                display: flex;
                align-items: center;
                padding: 10px;
                color: #dc3545;
                /* Color rojo para destacar */
                font-weight: bold;
                transition: background-color 0.3s, color 0.3s;
                border-radius: 5px;
                /* Bordes redondeados */
            }

            .logout-btn i {
                margin-right: 8px;
                /* Espacio entre el ícono y el texto */
                font-size: 1.2rem;
            }

            .logout-btn:hover {
                background-color: #f8d7da;
                /* Fondo rojo claro al pasar el mouse */
                color: #721c24;
                /* Cambiar el color del texto al pasar el mouse */
            }
        </style>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <div">
                    @yield('content')
            </div>

        </div>
    </div>
    <!--**********************************
            Content body end
        ***********************************-->

    <!--**********************************
            Footer start
        ***********************************-->
    <div class="footer">
        <div class="copyright">
            <p><strong>Shine&Go</strong> © 2024 Todos los Derechos Reservados</p>
        </div>
    </div>
    <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('templates/xhtml/vendor/global/global.min.js')}}"></script>
    <script src="{{asset('templates/xhtml/js/custom.min.js')}}"></script>
    <script src="{{asset('templates/xhtml/js/deznav-init.js')}}"></script>
    <!-- Apex Chart -->
    <script src="{{asset('templates/xhtml/vendor/apexchart/apexchart.js')}}"></script>

    <!-- Datatable -->
    <script src="{{asset('templates/xhtml/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <!--aqui se edita cada datatable-->
    <script src="{{asset('templates/xhtml/js/plugins-init/datatables.init.js')}}"></script>


    <!-- Dashboard 1 -->
    <script src="{{asset('templates/xhtml/js/dashboard/dashboard-1.js')}}"></script>
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
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


</body>

</html>
@else
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Acceso Denegado',
            text: 'No tienes permiso para acceder a esta sección.',
            confirmButtonText: 'Aceptar'
        }).then(function() {
            window.location.replace("{{ route('inicio') }}");
        });
    });
</script>
@endif