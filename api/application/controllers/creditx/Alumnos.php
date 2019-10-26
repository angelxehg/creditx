<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Alumnos extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database('creditx');
        $this->load->helper(array('form', 'url'));
    }

    // Operaciones de Datos
    public function listar_get() {
        // Parametros
        $error = false;
        $msg = '';
        $buscar = $this->get('buscar');
        // Verificar los parametros
        if (self::no_vacio($buscar)) {
            // Busqueda filtrada
            $this->db->select('*')->from('vw_alumnos')->
            where('matricula', $buscar);
            $query = $this->db->get();
            $msg = 'Resultado de busqueda';
        } else {
            // Mostrar todos
            $this->db->select('*')->from('vw_alumnos');
            $query = $this->db->get();
            $msg = 'Datos de todos los alumnos';
        }
        // Respuesta
        $this->response(
            self::respuesta_datos($error, $msg, 'alumnos', $query->result_array())
        );

    }

    public function crear_put() {
        // Parametros
        $error = false;
        $msg = '';
        $datos['matricula'] = $this->put('matricula');
        $datos['nombre'] = $this->put('nombre');
        $datos['apellidop'] = $this->put('apellidop');
        $datos['apellidom'] = $this->put('apellidom');
        $datos['grupoid'] = $this->put('grupoid');
        $datos['genero'] = $this->put('genero');
        $datos['fechan'] = $this->put('fechan');
        // Verificar los parametros
        if (self::no_vacios($datos)) {
            // Hay datos
            $this->db->insert('tb_alumnos', $datos);
            $msg = 'Se insertó el alumno';
        } else {
            // Faltan parametros
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            self::respuesta_basica($error, $msg)
        );

    }

    public function editar_post() {
        // Parametros
        $error = false;
        $msg = '';
        $matricula = $this->post('matricula');
        $datos['nombre'] = $this->post('nombre');
        $datos['apellidop'] = $this->post('apellidop');
        $datos['apellidom'] = $this->post('apellidom');
        $datos['grupoid'] = $this->post('grupoid');
        $datos['genero'] = $this->post('genero');
        $datos['fechan'] = $this->post('fechan');
        // Verificar los parametros
        if (self::no_vacio($matricula) && self::no_vacios($datos)) {
            // Hay datos
            $this->db->where('matricula', $matricula);
            $this->db->update('tb_alumnos', $datos);
            $msg = 'Se editó el alumno ' . $matricula;
        } else {
            // Faltan parametros
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            self::respuesta_basica($error, $msg)
        );

    }

    public function eliminar_post() {
        // Parametros
        $error = false;
        $msg = '';
        $matricula = $this->post('matricula');
        // Verificar los parametros
        if (self::no_vacio($matricula)) {
            // Hay datos
            $this->db->where('matricula', $matricula);
            $this->db->delete('tb_alumnos'); 
            $msg = 'Se eliminó el alumno ' . $matricula;
        } else {
            // Faltan parametros
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            self::respuesta_basica($error, $msg)
        );

    }

    // Operaciones Comunes
    public static function no_vacio($parametro) {
        return (null !== $parametro && $parametro != '');
    }

    public static function no_vacios($parametros) {
        foreach ($parametros as $parametro) {
            if (!self::no_vacio($parametro)) {
                return false;
            }
        }
        return true;
    }

    public static function respuesta_basica($error, $msg) {
        $response = array (
            'error' => $error,
            'msg' => $msg
        );
        return $response;
    }

    public static function respuesta_datos($error, $msg, $head, $data) {
        $response = array (
            'error' => $error,
            'msg' => $msg,
            $head => $data
        );
        return $response;
    }
}