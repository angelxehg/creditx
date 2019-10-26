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
class Carreras extends REST_Controller {

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
            $this->db->select('*')->from('tb_carreras')->
            where('carrera', $buscar);
            $query = $this->db->get();
            $msg = 'Resultado de busqueda';
        } else {
            // Mostrar todos
            $this->db->select('*')->from('tb_carreras');
            $query = $this->db->get();
            $msg = 'Datos de todas las carreras';
        }
        // Respuesta
        $this->response(
            self::respuesta_datos($error, $msg, 'carreras', $query->result_array())
        );

    }

    public function crear_put() {
        // Parametros
        $error = false;
        $msg = '';
        $datos['carrera'] = $this->put('carrera');
        $datos['descr'] = $this->put('descr');
        // Verificar los parametros
        if (self::no_vacios($datos)) {
            // Hay datos
            $this->db->insert('tb_carreras', $datos);
            $msg = 'Se insertó la carrera ' . $datos['carrera'];
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
        $carrera = $this->post('carrera');
        $datos['descr'] = $this->post('descr');
        // Verificar los parametros
        if (self::no_vacio($carrera) && self::no_vacios($datos)) {
            // Hay datos
            $this->db->where('carrera', $carrera);
            $this->db->update('tb_carreras', $datos);
            $msg = 'Se editó la carrera ' . $carrera;
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
        $carrera = $this->post('carrera');
        // Verificar los parametros
        if (self::no_vacio($carrera)) {
            // Hay datos
            $this->db->where('carrera', $carrera);
            $this->db->delete('tb_carreras'); 
            $msg = 'Se eliminó la carrera ' . $carrera;
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