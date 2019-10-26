<!DOCTYPE html>
<html lang="es" ng-app="Creditx">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="/creditx/assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Creditx | Grupos</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Angular.JS -->
    <script src="/creditx/assets/angular/angular.min.js"></script>
    <script src="/creditx/app/creditx.js"></script>
    <!-- Bootstrap core CSS     -->
    <link href="/creditx/assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Animation library for notifications   -->
    <link href="/creditx/assets/css/animate.min.css" rel="stylesheet" />
    <!--  Light Bootstrap Table core CSS    -->
    <link href="/creditx/assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet" />
    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="/creditx/assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
</head>

<?php
    include_once '../servicio/session.php';
    // Inicio de sesión
    $session = $_SESSION['status'];
    // Verificar
    if ($session) {
        // Hay sesión
    } else {
        print("<h2>Inicie sesión</h2>");
        print("
            <form action='/creditx/servicio/login.php' method='POST' style='max-width: 200px;'>
                <div class='form-group'>
                    <input name='user' type='text' class='form-control' placeholder='Usuario'>
                </div>
                <div class='form-group'>
                    <input name='pass' type='password' class='form-control' placeholder='Contraseña'>
                </div>
                <button type='submit' class='btn btn-primary'>Entrar</button>
            </form>
        ");
        exit;
    }
?>

<body ng-controller="Grupos as C" ng-init="C.Listar(); C.mensaje = 'Listo!';">
    <!-- Modals -->
    <div id="form_nuevo" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar grupo</h5>
                </div>
                <div class="modal-body">
                    <form ng-submit="C.Crear()">
                        <div class="form-group">
                            <label for="in_turno">Turno</label>
                            <select ng-model="C.nuevo_turno" class="form-control" id="in_turno">
                                <option value="Matutino">Matutino</option>
                                <option value="Vespertino">Vespertino</option>
                                <option value="Despresurizado">Despresurizado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="in_generacion">Generación</label>
                            <select ng-model="C.nuevo_generacion" class="form-control" id="in_generacion">
                                <option ng-repeat="elemento in generaciones_lista" value="{{ elemento['id'] }}">{{
                                    elemento['titulo']
                                    }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="in_carrera">Carrera</label>
                            <select ng-model="C.nuevo_carrera" class="form-control" id="in_carrera">
                                <option ng-repeat="elemento in carreras_lista" value="{{ elemento['id'] }}">{{
                                    elemento['titulo']
                                    }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="in_grupo">Grupo</label>
                            <input ng-model="C.nuevo_grupo" type="text" class="form-control" id="in_grupo"
                                aria-describedby="emailHelp" placeholder="Ejemplo: A, B, C">
                        </div>
                        <div class="form-group">
                            <label for="in_especialidad">Especialidad</label>
                            <input ng-model="C.nuevo_especialidad" type="text" class="form-control" id="in_especialidad"
                                aria-describedby="emailHelp" placeholder="Sistemas, Multimedia, etc">
                        </div>
                        <div class="form-group">
                            <label>{{ C.mensaje }}</label>
                        </div>
                        <div class="btn-group" role="group">
                            <a type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancelar</a>
                            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="form_editar" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar grupo</h5>
                </div>
                <div class="modal-body">
                    <form ng-submit="C.Editar()">
                        <div class="form-group">
                            <label for="in_turno">Turno</label>
                            <select ng-model="C.editar_turno" class="form-control" id="in_turno">
                                <option value="Matutino">Matutino</option>
                                <option value="Vespertino">Vespertino</option>
                                <option value="Despresurizado">Despresurizado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="in_generacion">Generación</label>
                            <select ng-model="C.editar_generacion" class="form-control" id="in_generacion">
                                <option ng-repeat="elemento in generaciones_lista" value="{{ elemento['id'] }}">{{
                                    elemento['titulo']
                                    }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="in_carrera">Carrera</label>
                            <select ng-model="C.editar_carrera" class="form-control" id="in_carrera">
                                <option ng-repeat="elemento in carreras_lista" value="{{ elemento['id'] }}">{{
                                    elemento['titulo']
                                    }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="in_grupo">Grupo</label>
                            <input ng-model="C.editar_grupo" type="text" class="form-control" id="in_grupo"
                                aria-describedby="emailHelp" placeholder="Ejemplo: A, B, C">
                        </div>
                        <div class="form-group">
                            <label for="in_especialidad">Especialidad</label>
                            <input ng-model="C.editar_especialidad" type="text" class="form-control" id="in_especialidad"
                                aria-describedby="emailHelp" placeholder="Sistemas, Multimedia, etc">
                        </div>
                        <div class="form-group">
                            <label>{{ C.mensaje }}</label>
                        </div>
                        <div class="btn-group" role="group">
                            <a type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancelar</a>
                            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <!-- Panel de navegación -->
        <div class="sidebar" data-color="green" data-image="/creditx/assets/img/sidebar-5.jpg">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="/creditx/" class="simple-text">
                        Creditx
                    </a>
                </div>
                <ul class="nav">
                    <li>
                        <a href="/creditx/carreras">
                            <i class="pe-7s-info"></i>
                            <p>Carreras</p>
                        </a>
                    </li>
                    <li>
                        <a href="/creditx/generaciones">
                            <i class="pe-7s-info"></i>
                            <p>Generaciones</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="/creditx/grupos">
                            <i class="pe-7s-users"></i>
                            <p>Grupos</p>
                        </a>
                    </li>
                    <li>
                        <a href="/creditx/alumnos">
                            <i class="pe-7s-user"></i>
                            <p>Alumnos</p>
                        </a>
                    </li>
                    <li>
                        <a href="/creditx/actividades">
                            <i class="pe-7s-note2"></i>
                            <p>Actividades</p>
                        </a>
                    </li>
                    <li>
                        <a href="/creditx/creditos">
                            <i class="pe-7s-server"></i>
                            <p>Creditos</p>
                        </a>
                    </li>
                    <li>
                        <a href="/creditx/tarjetas">
                            <i class="pe-7s-credit"></i>
                            <p>Tarjetas</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Contenido -->
        <div class="main-panel">
            <!-- Barra de Título -->
            <nav class="navbar navbar-default navbar-fixed">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand">Grupos</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="/creditx/servicio/logout.php">
                                    <p>Cerrar sesión</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Contenido-->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Lista de Grupos</h4>
                                    <p class="category">Estado: {{ C.estado }}</p>
                                    <p class="category">Ultimo: {{ C.mensaje }}</p>
                                    <div class="btn-group" role="group">
                                        <a type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#form_nuevo">Nuevo</a>
                                        <a type="button" ng-click="C.Listar()" class="btn btn-sm btn-primary">Recargar</a>
                                    </div>
                                </div>
                                <div class="content table-responsive table-full-width">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>Grupo</th>
                                            <th>Turno</th>
                                            <th>Generación</th>
                                            <th>Carrera</th>
                                            <th>Grado</th>
                                            <th>Especialidad</th>
                                            <th>Acciones</th>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="grupo in grupos">
                                                <td>{{ grupo['gruponom'] }}</td>
                                                <td>{{ grupo['turno'] }}</td>
                                                <td>{{ grupo['generacion'] }}</td>
                                                <td>{{ grupo['carrera'] }}</td>
                                                <td>{{ grupo['grupo'] }}</td>
                                                <td>{{ grupo['especialidad'] }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a ng-click="C.Seleccionar(grupo['grupoid'])" type="button"
                                                            class="btn btn-sm btn-warning" data-toggle="modal"
                                                            data-target="#form_editar">Editar</a>
                                                        <a ng-click="C.Eliminar(grupo['grupoid'])" type="button" class="btn btn-sm btn-danger">Eliminar</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!--   Core JS Files   -->
<script src="/creditx/assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="/creditx/assets/js/bootstrap.min.js" type="text/javascript"></script>
<!--  Charts Plugin -->
<script src="/creditx/assets/js/chartist.min.js"></script>
<!--  Notifications Plugin    -->
 <script src="/creditx/assets/js/bootstrap-notify.js"></script>
<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="/creditx/assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
<script src="/creditx/assets/js/demo.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // demo.initChartist();
    });
</script>

</html>