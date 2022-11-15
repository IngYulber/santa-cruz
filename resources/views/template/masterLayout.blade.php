<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Santa cruz</title>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="icon" type="image/x-icon"
        href="{{mix('images/favicon.png')}}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>

<body id="page-top" class="sidebar-toggled">
    <div id="app">
        <div id="wrapper">
            {{-- @include('template.sidebar') --}}
            <sidebar-component></sidebar-component>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">

                    <navbar-component></navbar-component>
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>

                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Santa cruz 2022</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Desea cerrar sesión?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccionar "Cerar sesión" si realmente quiere terminar con su sesión.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="{{ url('logout') }}">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>
    @include('template.scripts')
</body>

</html>
