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
class Creditos extends REST_Controller {

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
            $this->db->select('*')->from('vw_creditos')->
            where('matricula', $buscar);
            $query = $this->db->get();
            $msg = 'Resultado de busqueda';
        } else {
            // Mostrar todos
            $this->db->select('*')->from('vw_creditos');
            $query = $this->db->get();
            $msg = 'Datos de todos los registros';
        }
        // Respuesta
        $this->response(
            self::respuesta_datos($error, $msg, 'creditos', $query->result_array())
        );

    }

    public function crear_put() {
        // Parametros
        $error = false;
        $msg = '';
        $datos['actividadid'] = $this->put('actividadid');
        $datos['matricula'] = $this->put('matricula');
        $datos['cantidad'] = $this->put('cantidad');
        // Verificar los parametros
        if (self::no_vacios($datos)) {
            // Hay datos
            $this->db->insert('tb_creditos', $datos);
            $msg = 'Se insertó el registro';
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
        $creditoid = $this->post('creditoid');
        $datos['actividadid'] = $this->post('actividadid');
        $datos['matricula'] = $this->post('matricula');
        $datos['cantidad'] = $this->post('cantidad');
        // Verificar los parametros
        if (self::no_vacio($creditoid) && self::no_vacios($datos)) {
            // Hay datos
            $this->db->where('creditoid', $creditoid);
            $this->db->update('tb_creditos', $datos);
            $msg = 'Se editó el registro ' . $creditoid;
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
        $creditoid = $this->post('creditoid');
        // Verificar los parametros
        if (self::no_vacio($creditoid)) {
            // Hay datos
            $this->db->where('creditoid', $creditoid);
            $this->db->delete('tb_creditos'); 
            $msg = 'Se eliminó el registro ' . $creditoid;
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