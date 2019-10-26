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
class Actividades extends REST_Controller {

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
            $this->db->select('*')->from('tb_actividades')->
            where('actividadid', $buscar);
            $query = $this->db->get();
            $msg = 'Resultado de busqueda';
        } else {
            // Mostrar todos
            $this->db->select('*')->from('tb_actividades');
            $query = $this->db->get();
            $msg = 'Datos de todas las actividades';
        }
        // Respuesta
        $this->response(
            self::respuesta_datos($error, $msg, 'actividades', $query->result_array())
        );

    }

    public function crear_put() {
        // Parametros
        $error = false;
        $msg = '';
        $datos['titulo'] = $this->put('titulo');
        $datos['descr'] = $this->put('descr');
        $datos['cantidad'] = $this->put('cantidad');
        // Verificar los parametros
        if (self::no_vacios($datos)) {
            // Hay datos
            $this->db->insert('tb_actividades', $datos);
            $msg = 'Se insertó la actividad';
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
        $actividadid = $this->post('actividadid');
        $datos['titulo'] = $this->post('titulo');
        $datos['descr'] = $this->post('descr');
        $datos['cantidad'] = $this->post('cantidad');
        // Verificar los parametros
        if (self::no_vacio($actividadid) && self::no_vacios($datos)) {
            // Hay datos
            $this->db->where('actividadid', $actividadid);
            $this->db->update('tb_actividades', $datos);
            $msg = 'Se editó la actividad ' . $actividadid;
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
        $actividadid = $this->post('actividadid');
        // Verificar los parametros
        if (self::no_vacio($actividadid)) {
            // Hay datos
            $this->db->where('actividadid', $actividadid);
            $this->db->delete('tb_actividades'); 
            $msg = 'Se eliminó la actividad ' . $actividadid;
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