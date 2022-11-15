<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio de sesión</title>
    <link rel="icon" type="image/x-icon" href="{{mix('images/favicon.png')}}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
</head>

<body class="bg-gradient-light">
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center pt-5">

                <div class="col-xl-6 col-lg-8 col-md-8">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Santa cruz de huachipa S.A.C</h1>
                                        </div>
                                        <form class="user" method="POST" action="{{url('login')}}">
                                            @csrf
                                            @if (isset($errors) && count($errors) > 0)
                                                <div class="alert alert-danger">
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{$error}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id="exampleInputEmail" name="dni" aria-describedby="emailHelp"
                                                    placeholder="DNI">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                    id="exampleInputPassword" name="password" placeholder="Contraseña">
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Recordar contraseña</label>
                                                </div>
                                            </div>
                                            <input type="submit" class="btn btn-primary btn-user btn-block" value="Iniciar sesión"/>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="">¿Has olvidado la contraseña?</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
</body>
</html>
