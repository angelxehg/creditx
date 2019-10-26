// Iniciar la aplicación
var ngapp = angular.module('Creditx', []);
var api_ip = 'localhost';
// Funciones simples
Mensaje = function (msg) {
    console.log(msg);
}
// Controlador para carreras y generaciones
ngapp.controller('Carreras', function ($scope, $http) {
    // Declarar el controlador como C, de controlador
    var C = this;
    // Estado del controlador
    C.MostrarEstado = function (msg) {
        C.estado = msg;
    }
    // Mensaje
    C.MostrarMensaje = function (msg) {
        C.mensaje = msg;
    }
    // Lista todos los elementos y los guarda en scope
    C.Listar = function () {
        // Cambiar estado
        C.MostrarEstado("Cargando datos...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/carreras/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            $scope.carreras = response.data.carreras;
            C.MostrarEstado(response.data.msg);
        }, function error(response) {
            // Error
            C.MostrarEstado("No se pudo actualizar");
        });
    };
    // Actualizar selección al hacer click en editar
    C.Seleccionar = function (id) {
        // Cambiar selección
        C.seleccionado = id;
        C.Limpiar();
        // Buscar datos
        $scope.carreras.forEach(elemento => {
            if (elemento['carrera'] == C.seleccionado) {
                C.editar_descr = elemento['descr'];
            }
        });
    }
    // Crear nuevo
    C.Crear = function () {
        // Cambiar estado
        C.MostrarMensaje("Creando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/carreras/crear';
        // Hacer solicitud
        $http({
            method: 'PUT',
            url: thisurl,
            data: {
                "carrera": C.nuevo_carrera,
                "descr": C.nuevo_descr
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_nuevo').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo crear");
        });
    };
    // Actualizar
    C.Editar = function () {
        // Cambiar estado
        C.MostrarMensaje("Actualizando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/carreras/editar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: {
                "carrera": C.seleccionado,
                "descr": C.editar_descr
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_editar').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo actualizar");
        });
    };
    // Eliminar
    C.Eliminar = function (carrera) {
        // Cambiar estado
        C.MostrarMensaje("Eliminando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/carreras/eliminar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: { "carrera": carrera }
        }).then(function success(response) {
            // Correcto
            C.Listar();
            C.MostrarMensaje(response.data.msg);
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo eliminar");
        });
    };
    // Limpiar
    C.Limpiar = function () {
        // Limpiar form
        C.nuevo_carrera = "";
        C.nuevo_descr = "";
        //
        C.editar_descr = "";
    }
});
// Controlador para generaciones
ngapp.controller('Generaciones', function ($scope, $http) {
    // Declarar el controlador como C, de controlador
    var C = this;
    // Estado del controlador
    C.MostrarEstado = function (msg) {
        C.estado = msg;
    }
    // Mensaje
    C.MostrarMensaje = function (msg) {
        C.mensaje = msg;
    }
    // Lista todos los elementos y los guarda en scope
    C.Listar = function () {
        // Cambiar estado
        C.MostrarEstado("Cargando datos...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/generaciones/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            $scope.generaciones = response.data.generaciones;
            C.MostrarEstado(response.data.msg);
        }, function error(response) {
            // Error
            C.MostrarEstado("No se pudo actualizar");
        });
    };
    // Actualizar selección al hacer click en editar
    C.Seleccionar = function (id) {
        // Cambiar selección
        C.seleccionado = id;
        C.Limpiar();
        // Buscar datos
        $scope.generaciones.forEach(elemento => {
            if (elemento['generacion'] == C.seleccionado) {
                C.editar_grado = elemento['grado'];
            }
        });
    }
    // Crear nuevo
    C.Crear = function () {
        // Cambiar estado
        C.MostrarMensaje("Creando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/generaciones/crear';
        // Hacer solicitud
        $http({
            method: 'PUT',
            url: thisurl,
            data: {
                "generacion": C.nuevo_generacion,
                "grado": C.nuevo_grado
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_nuevo').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo crear");
        });
    };
    // Actualizar
    C.Editar = function () {
        // Cambiar estado
        C.MostrarMensaje("Actualizando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/generaciones/editar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: {
                "generacion": C.seleccionado,
                "grado": C.editar_grado
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_editar').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo actualizar");
        });
    };
    // Eliminar
    C.Eliminar = function (generacion) {
        // Cambiar estado
        C.MostrarMensaje("Eliminando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/generaciones/eliminar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: { "generacion": generacion }
        }).then(function success(response) {
            // Correcto
            C.Listar();
            C.MostrarMensaje(response.data.msg);
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo eliminar");
        });
    };
    // Limpiar
    C.Limpiar = function () {
        // Limpiar form
        C.nuevo_generacion = "";
        C.nuevo_grado = "";
        //
        C.editar_grado = "";
    }
});
// Controlador para grupos
ngapp.controller('Grupos', function ($scope, $http) {
    // Declarar el controlador como C, de controlador
    var C = this;
    // Estado del controlador
    C.MostrarEstado = function (msg) {
        C.estado = msg;
    }
    // Mensaje
    C.MostrarMensaje = function (msg) {
        C.mensaje = msg;
    }
    // Lista todos los elementos y los guarda en scope
    C.Listar = function () {
        // Cambiar estado
        C.MostrarEstado("Cargando datos...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/grupos/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            $scope.grupos = response.data.grupos;
            C.MostrarEstado(response.data.msg);
            C.ListarGeneraciones();
            C.ListarCarreras();
        }, function error(response) {
            // Error
            C.MostrarEstado("No se pudo actualizar");
        });
    };
    // Listas Adicionales
    C.ListarGeneraciones = function () {
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/generaciones/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            var lista = Array();
            response.data.generaciones.forEach(generacion => {
                lista.push(
                    {
                        'id': generacion['generacion'],
                        'titulo': generacion['generacion'] + ": (" + generacion['grado'] + "°)",
                        'datos': generacion
                    }
                );
            });
            $scope.generaciones_lista = lista;
        }, function error(response) {
            // Error
        });
    };
    C.ListarCarreras = function () {
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/carreras/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            var lista = Array();
            response.data.carreras.forEach(carrera => {
                lista.push(
                    {
                        'id': carrera['carrera'],
                        'titulo': carrera['carrera'] + ": " + carrera["descr"],
                        'datos': carrera
                    }
                );
            });
            $scope.carreras_lista = lista;
        }, function error(response) {
            // Error
        });
    };
    // Actualizar selección al hacer click en editar
    C.Seleccionar = function (id) {
        // Cambiar selección
        C.seleccionado = id;
        C.Limpiar();
        // Buscar datos
        $scope.grupos.forEach(elemento => {
            if (elemento['grupoid'] == C.seleccionado) {
                C.editar_turno = elemento['turno'];
                C.editar_generacion = elemento['generacion'];
                C.editar_carrera = elemento['carrera'];
                C.editar_grupo = elemento['grupo'];
                C.editar_especialidad = elemento['especialidad'];
            }
        });
    }
    // Crear nuevo
    C.Crear = function () {
        // Cambiar estado
        C.MostrarMensaje("Creando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/grupos/crear';
        // Hacer solicitud
        $http({
            method: 'PUT',
            url: thisurl,
            data: {
                "turno": C.nuevo_turno,
                "generacion": C.nuevo_generacion,
                "carrera": C.nuevo_carrera,
                "grupo": C.nuevo_grupo,
                "especialidad": C.nuevo_especialidad
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_nuevo').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo crear");
        });
    };
    // Actualizar
    C.Editar = function () {
        // Cambiar estado
        C.MostrarMensaje("Actualizando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/grupos/editar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: {
                "grupoid": C.seleccionado,
                "turno": C.editar_turno,
                "generacion": C.editar_generacion,
                "carrera": C.editar_carrera,
                "grupo": C.editar_grupo,
                "especialidad": C.editar_especialidad
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_editar').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo actualizar");
        });
    };
    // Eliminar
    C.Eliminar = function (grupo) {
        // Cambiar estado
        C.MostrarMensaje("Eliminando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/grupos/eliminar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: { "grupoid": grupo }
        }).then(function success(response) {
            // Correcto
            C.Listar();
            C.MostrarMensaje(response.data.msg);
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo eliminar");
        });
    };
    // Limpiar
    C.Limpiar = function () {
        // Limpiar form
        C.nuevo_generacion = "";
        C.nuevo_carrera = "";
        C.nuevo_grupo = "";
        C.nuevo_especialidad = "";
        //
        C.editar_generacion = "";
        C.editar_carrera = "";
        C.editar_grupo = "";
        C.editar_especialidad = "";
    }
});
// Controlador para alumnos
ngapp.controller('Alumnos', function ($scope, $http) {
    // Declarar el controlador como C, de controlador
    var C = this;
    // Estado del controlador
    C.MostrarEstado = function (msg) {
        C.estado = msg;
    }
    // Mensaje
    C.MostrarMensaje = function (msg) {
        C.mensaje = msg;
    }
    // Lista todos los elementos y los guarda en scope
    C.Listar = function () {
        // Cambiar estado
        C.MostrarEstado("Cargando datos...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/alumnos/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            $scope.alumnos = response.data.alumnos;
            C.MostrarEstado(response.data.msg);
            C.ListarGrupos();
            C.ListarActividades();
        }, function error(response) {
            // Error
            C.MostrarEstado("No se pudo actualizar");
        });
    };
    // Listas Adicionales
    C.ListarGrupos = function () {
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/grupos/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            var lista = Array();
            response.data.grupos.forEach(grupo => {
                lista.push(
                    {
                        'id': grupo['grupoid'],
                        'titulo': grupo['gruponom'],
                        'datos': grupo
                    }
                );
            });
            $scope.grupos_lista = lista;
        }, function error(response) {
            // Error
        });
    };
    C.ListarActividades = function () {
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/actividades/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            var lista = Array();
            response.data.actividades.forEach(actividad => {
                lista.push(
                    {
                        'id': actividad['actividadid'],
                        'titulo': actividad['titulo'],
                        'datos': actividad
                    }
                );
            });
            $scope.actividades_lista = lista;
        }, function error(response) {
            // Error
        });
    };
    C.AgregarCreditos = function () {
        // Cambiar estado
        C.MostrarMensaje("Creando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/creditos/crear';
        // Hacer solicitud
        $http({
            method: 'PUT',
            url: thisurl,
            data: {
                "actividadid": C.nuevo_actividadid,
                "matricula": C.seleccionado,
                "cantidad": C.nuevo_cantidad
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_creditos').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo crear");
        });
    };
    // Actualizar selección al hacer click en editar
    C.Seleccionar = function (id) {
        // Cambiar selección
        C.seleccionado = id;
        C.Limpiar();
        // Buscar datos
        $scope.alumnos.forEach(elemento => {
            if (elemento['matricula'] == C.seleccionado) {
                C.editar_matricula = elemento['matricula'];
                C.editar_nombre = elemento['nombre'];
                C.editar_apellidop = elemento['apellidop'];
                C.editar_apellidom = elemento['apellidom'];
                C.editar_grupoid = elemento['grupoid'];
                C.editar_genero = elemento['genero'];
                C.editar_fechan = elemento['fechan'];
            }
        });
    }
    // Crear nuevo
    C.Crear = function () {
        // Cambiar estado
        C.MostrarMensaje("Creando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/alumnos/crear';
        // Hacer solicitud
        $http({
            method: 'PUT',
            url: thisurl,
            data: {
                "matricula": C.nuevo_matricula,
                "nombre": C.nuevo_nombre,
                "apellidop": C.nuevo_apellidop,
                "apellidom": C.nuevo_apellidom,
                "grupoid": C.nuevo_grupoid,
                "genero": C.nuevo_genero,
                "fechan": C.nuevo_fechan
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_nuevo').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo crear");
        });
    };
    // Actualizar
    C.Editar = function () {
        // Cambiar estado
        C.MostrarMensaje("Actualizando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/alumnos/editar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: {
                "matricula": C.seleccionado,
                "nombre": C.editar_nombre,
                "apellidop": C.editar_apellidop,
                "apellidom": C.editar_apellidom,
                "grupoid": C.editar_grupoid,
                "genero": C.editar_genero,
                "fechan": C.editar_fechan
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_editar').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo actualizar");
        });
    };
    // Eliminar
    C.Eliminar = function (matricula) {
        // Cambiar estado
        C.MostrarMensaje("Eliminando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/alumnos/eliminar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: { "matricula": matricula }
        }).then(function success(response) {
            // Correcto
            C.Listar();
            C.MostrarMensaje(response.data.msg);
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo eliminar");
        });
    };
    // Limpiar
    C.Limpiar = function () {
        // Limpiar form
        C.nuevo_matricula = "";
        C.nuevo_nombre = "";
        C.nuevo_apellidop = "";
        C.nuevo_apellidom = "";
        C.nuevo_grupoid = "";
        C.nuevo_genero = "";
        C.nuevo_fechan = "";
        //
        C.editar_matricula = "";
        C.editar_nombre = "";
        C.editar_apellidop = "";
        C.editar_apellidom = "";
        C.editar_grupoid = "";
        C.editar_genero = "";
        C.editar_fechan = "";
    }
});
// Controlador para actividades
ngapp.controller('Actividades', function ($scope, $http) {
    // Declarar el controlador como C, de controlador
    var C = this;
    // Estado del controlador
    C.MostrarEstado = function (msg) {
        C.estado = msg;
    }
    // Mensaje
    C.MostrarMensaje = function (msg) {
        C.mensaje = msg;
    }
    // Lista todos los elementos y los guarda en scope
    C.Listar = function () {
        // Cambiar estado
        C.MostrarEstado("Cargando datos...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/actividades/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            $scope.actividades = response.data.actividades;
            C.MostrarEstado(response.data.msg);
        }, function error(response) {
            // Error
            C.MostrarEstado("No se pudo actualizar");
        });
    };
    // Actualizar selección al hacer click en editar
    C.Seleccionar = function (id) {
        // Cambiar selección
        C.seleccionado = id;
        C.Limpiar();
        // Buscar datos
        $scope.actividades.forEach(elemento => {
            if (elemento['actividadid'] == C.seleccionado) {
                C.editar_titulo = elemento['titulo'];
                C.editar_descr = elemento['descr'];
                C.editar_cantidad = elemento['cantidad'];
            }
        });
    }
    // Crear nuevo
    C.Crear = function () {
        // Cambiar estado
        C.MostrarMensaje("Creando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/actividades/crear';
        // Hacer solicitud
        $http({
            method: 'PUT',
            url: thisurl,
            data: {
                "titulo": C.nuevo_titulo,
                "descr": C.nuevo_descr,
                "cantidad": C.nuevo_cantidad
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_nuevo').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo crear");
        });
    };
    // Actualizar
    C.Editar = function () {
        // Cambiar estado
        C.MostrarMensaje("Actualizando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/actividades/editar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: {
                "actividadid": C.seleccionado,
                "titulo": C.editar_titulo,
                "descr": C.editar_descr,
                "cantidad": C.editar_cantidad
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_editar').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo actualizar");
        });
    };
    // Eliminar
    C.Eliminar = function (actividad) {
        // Cambiar estado
        C.MostrarMensaje("Eliminando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/actividades/eliminar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: { "actividadid": actividad }
        }).then(function success(response) {
            // Correcto
            C.Listar();
            C.MostrarMensaje(response.data.msg);
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo eliminar");
        });
    };
    // Limpiar
    C.Limpiar = function () {
        // Limpiar form
        C.nuevo_titulo = "";
        C.nuevo_descr = "";
        C.nuevo_cantidad = "";
        //
        C.editar_titulo = "";
        C.editar_descr = "";
        C.editar_cantidad = "";
    }
});
// Controlador para creditos
ngapp.controller('Creditos', function ($scope, $http) {
    // Declarar el controlador como C, de controlador
    var C = this;
    // Estado del controlador
    C.MostrarEstado = function (msg) {
        C.estado = msg;
    }
    // Mensaje
    C.MostrarMensaje = function (msg) {
        C.mensaje = msg;
    }
    // Lista todos los elementos y los guarda en scope
    C.Listar = function () {
        // Cambiar estado
        C.MostrarEstado("Cargando datos...");
        C.filtrar_matricula = "";
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/creditos/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            $scope.creditos = response.data.creditos;
            C.MostrarEstado(response.data.msg);
            C.ListarActividades();
            C.ListarAlumnos();
        }, function error(response) {
            // Error
            C.MostrarEstado("No se pudo actualizar");
        });
    };
    C.Filtrar = function () {
        // Cambiar estado
        C.MostrarEstado("Filtrando datos...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/creditos/listar?buscar=' + C.filtrar_matricula;
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            $scope.creditos = response.data.creditos;
            C.MostrarEstado(response.data.msg);
            C.ListarActividades();
            C.ListarAlumnos();
        }, function error(response) {
            // Error
            C.MostrarEstado("No se pudo actualizar");
        });
    };
    // Listas Adicionales
    C.ListarActividades = function () {
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/actividades/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            var lista = Array();
            response.data.actividades.forEach(actividad => {
                lista.push(
                    {
                        'id': actividad['actividadid'],
                        'titulo': actividad['titulo'],
                        'datos': actividad
                    }
                );
            });
            $scope.actividades_lista = lista;
        }, function error(response) {
            // Error
        });
    };
    C.ListarAlumnos = function () {
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/alumnos/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            var lista = Array();
            response.data.alumnos.forEach(alumno => {
                lista.push(
                    {
                        'id': alumno['matricula'],
                        'nombre': alumno['nombrecom'],
                        'grupo': alumno['gruponom']
                    }
                );
            });
            $scope.alumnos_lista = lista;
        }, function error(response) {
            // Error
        });
    };
    C.VerificarMatricula = function (matricula) {
        // Encontrado
        C.alumno_encontrado = "Buscando...";
        // Buscar la matricula
        $scope.alumnos_lista.forEach(alumno => {
            if (alumno['id'] == matricula) {
                C.alumno_encontrado = alumno['nombre'] + " de " + alumno['grupo'];
            }
        });
        // Si no se encontró
        if (C.alumno_encontrado == "Buscando...") {
            C.alumno_encontrado = "No se encontró alumno con la matrícula " + matricula;
        }
    }
    // Actualizar selección al hacer click en editar
    C.Seleccionar = function (id) {
        // Cambiar selección
        C.seleccionado = id;
        C.Limpiar();
        // Buscar datos
        $scope.creditos.forEach(elemento => {
            if (elemento['creditoid'] == C.seleccionado) {
                C.editar_actividadid = elemento['actividadid'];
                C.editar_matricula = elemento['matricula'];
                C.editar_cantidad = elemento['cantidad'];
            }
        });
    }
    // Crear nuevo
    C.Crear = function () {
        // Cambiar estado
        C.MostrarMensaje("Creando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/creditos/crear';
        // Hacer solicitud
        $http({
            method: 'PUT',
            url: thisurl,
            data: {
                "actividadid": C.nuevo_actividadid,
                "matricula": C.nuevo_matricula,
                "cantidad": C.nuevo_cantidad
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_nuevo').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo crear");
        });
    };
    // Actualizar
    C.Editar = function () {
        // Cambiar estado
        C.MostrarMensaje("Actualizando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/creditos/editar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: {
                "creditoid": C.seleccionado,
                "actividadid": C.editar_actividadid,
                "matricula": C.editar_matricula,
                "cantidad": C.editar_cantidad
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_editar').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo actualizar");
        });
    };
    // Eliminar
    C.Eliminar = function (creditoid) {
        // Cambiar estado
        C.MostrarMensaje("Eliminando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/creditos/eliminar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: { "creditoid": creditoid }
        }).then(function success(response) {
            // Correcto
            C.Listar();
            C.MostrarMensaje(response.data.msg);
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo eliminar");
        });
    };
    // Limpiar
    C.Limpiar = function () {
        // Limpiar form
        C.nuevo_actividadid = "";
        C.nuevo_matricula = "";
        C.nuevo_cantidad = "";
        //
        C.editar_actividadid = "";
        C.editar_matricula = "";
        C.editar_cantidad = "";
        //
        C.alumno_encontrado = "";
    }
});
// Controlador para tarjetas
ngapp.controller('Tarjetas', function ($scope, $http) {
    // Declarar el controlador como C, de controlador
    var C = this;
    // Estado del controlador
    C.MostrarEstado = function (msg) {
        C.estado = msg;
    }
    // Mensaje
    C.MostrarMensaje = function (msg) {
        C.mensaje = msg;
    }
    // Lista todos los elementos y los guarda en scope
    C.Listar = function () {
        // Cambiar estado
        C.MostrarEstado("Cargando datos...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/tarjetas/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            $scope.tarjetas = response.data.tarjetas;
            C.MostrarEstado(response.data.msg);
            C.ListarAlumnos();
        }, function error(response) {
            // Error
            C.MostrarEstado("No se pudo actualizar");
        });
    };
    // Listas Adicionales
    C.ListarAlumnos = function () {
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/alumnos/listar';
        // Hacer solicitud
        $http({
            method: 'GET',
            url: thisurl
        }).then(function success(response) {
            // Correcto
            var lista = Array();
            response.data.alumnos.forEach(alumno => {
                lista.push(
                    {
                        'id': alumno['matricula'],
                        'nombre': alumno['nombrecom'],
                        'grupo': alumno['gruponom']
                    }
                );
            });
            $scope.alumnos_lista = lista;
        }, function error(response) {
            // Error
        });
    };
    C.VerificarMatricula = function (matricula) {
        // Encontrado
        C.alumno_encontrado = "Buscando...";
        // Buscar la matricula
        $scope.alumnos_lista.forEach(alumno => {
            if (alumno['id'] == matricula) {
                C.alumno_encontrado = alumno['nombre'] + " de " + alumno['grupo'];
            }
        });
        // Si no se encontró
        if (C.alumno_encontrado == "Buscando...") {
            C.alumno_encontrado = "No se encontró alumno con la matrícula " + matricula;
        }
    }
    // Actualizar selección al hacer click en editar
    C.Seleccionar = function (id) {
        // Cambiar selección
        C.seleccionado = id;
        C.Limpiar();
        // Buscar datos
        $scope.tarjetas.forEach(elemento => {
            if (elemento['rfid'] == C.seleccionado) {
                C.editar_matricula = elemento['matricula'];
                C.editar_estado = elemento['estado'];
            }
        });
    }
    // Crear nuevo
    C.Crear = function () {
        // Cambiar estado
        C.MostrarMensaje("Creando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/tarjetas/crear';
        // Hacer solicitud
        $http({
            method: 'PUT',
            url: thisurl,
            data: {
                "rfid": C.nuevo_rfid,
                "matricula": C.nuevo_matricula,
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_nuevo').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo crear");
        });
    };
    // Actualizar
    C.Editar = function () {
        // Cambiar estado
        C.MostrarMensaje("Actualizando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/tarjetas/editar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: {
                "rfid": C.seleccionado,
                "matricula": C.editar_matricula,
                "estado": C.editar_estado
            }
        }).then(function success(response) {
            // Evaluar respuesta de servidor
            if (response.data.error) {
                // Error
                C.MostrarMensaje(response.data.msg);
            } else {
                // Correcto
                C.Listar();
                C.MostrarMensaje(response.data.msg);
                $('#form_editar').modal('hide');
                C.Limpiar();
            }
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo actualizar");
        });
    };
    // Desactivar
    C.Desactivar = function (tarjeta) {
        // Cambiar estado
        C.MostrarMensaje("Desactivando...");
        // Formular URL
        var thisurl = 'http://' + api_ip + '/creditx/api/index.php/creditx/tarjetas/desactivar';
        // Hacer solicitud
        $http({
            method: 'POST',
            url: thisurl,
            data: { "rfid": tarjeta }
        }).then(function success(response) {
            // Correcto
            C.Listar();
            C.MostrarMensaje(response.data.msg);
        }, function error(response) {
            // Error
            C.MostrarMensaje("No se pudo desactivar");
        });
    };
    // Limpiar
    C.Limpiar = function () {
        // Limpiar form
        C.nuevo_rfid = "";
        C.nuevo_matricula = "";
        //
        C.editar_matricula = "";
        C.editar_estado = "";
        //
        C.alumno_encontrado = "";
    }
});