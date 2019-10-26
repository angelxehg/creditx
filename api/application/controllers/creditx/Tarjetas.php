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
class Tarjetas extends REST_Controller {

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
            $this->db->select('*')->from('vw_tarjetas')->
            where('rfid', $buscar);
            $query = $this->db->get();
            $msg = 'Resultado de busqueda';
        } else {
            // Mostrar todos
            $this->db->select('*')->from('vw_tarjetas');
            $query = $this->db->get();
            $msg = 'Datos de todas las tarjetas';
        }
        // Respuesta
        $this->response(
            self::respuesta_datos($error, $msg, 'tarjetas', $query->result_array())
        );

    }

    public function crear_put() {
        // Parametros
        $error = false;
        $msg = '';
        $datos['rfid'] = $this->put('rfid');
        $datos['matricula'] = $this->put('matricula');
        // Verificar los parametros
        if (self::no_vacios($datos)) {
            // Hay datos
            $this->db->insert('tb_tarjetas', $datos);
            $msg = 'Se insertó la tarjeta';
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
        $rfid = $this->post('rfid');
        $datos['matricula'] = $this->post('matricula');
        $datos['estado'] = $this->post('estado');
        // Verificar los parametros
        if (self::no_vacio($rfid) && self::no_vacios($datos)) {
            // Hay datos
            $this->db->where('rfid', $rfid);
            $this->db->update('tb_tarjetas', $datos);
            $msg = 'Se editó la tarjeta ' . $rfid;
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

    public function desactivar_post() {
        // Parametros
        $error = false;
        $msg = '';
        $rfid = $this->post('rfid');
        // Verificar los parametros
        if (self::no_vacio($rfid)) {
            // Hay datos
            $this->db->where('rfid', $rfid);
            $this->db->update('tb_tarjetas', ['estado' => 0]); 
            $msg = 'Se desactivó la tarjeta ' . $rfid;
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
    public function validar_get() {
        // Parametros
        $error = false;
        $msg = '';
        $rfid = $this->get('rfid');
        // Query
        $query = $this->db->query("SELECT * FROM tb_tarjetas WHERE rfid = '" . $rfid . "' AND estado = 1");
        if ($query->result_array()) {
            $respuesta = array ('valida' => true);
        } else {
            $respuesta = array ('valida' => false);
        }
        // Respuesta
        $this->response($respuesta);
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