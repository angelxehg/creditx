<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require 'Common.php';

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
        $this->load->database('utzac_acr');
        $this->load->helper(array('form', 'url'));
    }
    public function actividad_get() {
        // Parametros
        $error = false;
        $msg = '';
        $actividadid = $this->get('actividadid');
        // Verificar los parametros
        if (Common::not_empty($actividadid)) {
            $this->db->
                select('*')->
                from('acr_actividades')->
                where('actividadid', $actividadid);
            $msg = 'Datos de la actividad ' . $actividadid;
        } else {
            $this->db->
                select('*')->
                from('acr_actividades');
            $msg = 'Datos de todas las actividades';
        }
        // Obtener datos
        $query = $this->db->get();
        // Respuesta
        $this->response(
            Common::data_response($error, $msg, 'actividades', $query->result_array())
        );
    }
    public function actividad_put() {
        // Parametros
        $error = false;
        $msg = '';
        $data['titulo'] = $this->put('titulo');
        $data['descr'] = $this->put('descr');
        $data['cantidad'] = $this->put('cantidad');
        // Verificar los parametros
        if (Common::not_empty($data['titulo'])) {
            $this->db->insert('acr_actividades', $data);
            $msg = 'Se insertó la actividad ' . $data['titulo'];
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
    public function actividad_post() {
        // Parametros
        $error = false;
        $msg = '';
        $actividadid = $this->post('actividadid');
        $data['titulo'] = $this->post('titulo');
        $data['descr'] = $this->post('descr');
        $data['cantidad'] = $this->post('cantidad');
        if (Common::not_empty_values($data) && Common::not_empty($actividadid)) {
            $this->db->where('actividadid', $actividadid);
            $this->db->update('acr_actividades', $data);
            $msg = 'Se actualizó la actividad ' . $data['titulo'];
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
    public function actividad_delete() {
        // Parametros
        $error = false;
        $msg = '';
        $actividadid = $this->delete('actividadid');
        if (Common::not_empty($actividadid)) {
            $this->db->where('actividadid', $actividadid);
            $this->db->delete('acr_actividades');
            $msg = 'Se borró la actividad ID ' . $actividadid;
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
}