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
class Alumnos extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database('utzac_acr');
        $this->load->helper(array('form', 'url'));
    }
    public function alumno_get() {
        // Parametros
        $error = false;
        $msg = '';
        $matricula = $this->get('matricula');
        // Verificar los parametros
        if (Common::not_empty($matricula)) {
            $this->db->
                select('*')->
                from('acr_alumnos')->
                where('matricula', $matricula);
            $msg = 'Datos del alumno ' . $matricula;
        } else {
            $this->db->
                select('*')->
                from('acr_alumnos');
                $msg = 'Datos de todos los alumnos';
        }
        // Obtener datos
        $query = $this->db->get();
        // Respuesta
        $this->response(
            Common::data_response($error, $msg, 'alumnos', $query->result_array())
        );
    }
    public function alumno_put() {
        // Parametros
        $error = false;
        $msg = '';
        $data['matricula'] = $this->put('matricula');
        $data['nombre'] = $this->put('nombre');
        $data['apellidop'] = $this->put('apellidop');
        $data['apellidom'] = $this->put('apellidom');
        $data['grupoid'] = $this->put('grupoid');
        $data['genero'] = $this->put('genero');
        $data['fechan'] = $this->put('fechan');
        // Verificar los parametros
        if (Common::not_empty_values($data)) {
            $this->db->insert('acr_alumnos', $data);
            $msg = 'Se insertó el alumno ' . $data['matricula'];
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
    public function alumno_post() {
        // Parametros
        $error = false;
        $msg = '';
        $matricula = $this->post('matricula');
        $data['nombre'] = $this->post('nombre');
        $data['apellidop'] = $this->post('apellidop');
        $data['apellidom'] = $this->post('apellidom');
        $data['grupoid'] = $this->post('grupoid');
        $data['genero'] = $this->post('genero');
        $data['fechan'] = $this->post('fechan');
        // Verificar los parametros
        if (Common::not_empty_values($data) && Common::not_empty($matricula)) {
            $this->db->where('matricula', $matricula);
            $this->db->update('acr_alumnos', $data);
            $msg = 'Se actualizó el alumno ' . $matricula;
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
    public function alumno_delete() {
        // Parametros
        $error = false;
        $msg = '';
        $matricula = $this->delete('matricula');
        if (Common::not_empty($matricula)) {
            $this->db->where('matricula', $matricula);
            $this->db->delete('acr_alumnos'); 
            $msg = 'Se borró el alumno ' . $matricula;
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