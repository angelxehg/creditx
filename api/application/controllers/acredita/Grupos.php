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
class Grupos extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database('utzac_acr');
        $this->load->helper(array('form', 'url'));
    }
    public function grupo_get() {
        // Parametros
        $error = false;
        $msg = '';
        $grupoid = $this->get('grupoid');
        // Verificar los parametros
        if (Common::not_empty($grupoid)) {
            $this->db->
                select('*')->
                from('acr_grupos')->
                where('grupoid', $grupoid);
            $msg = 'Datos del grupo ' . $grupoid;
        } else {
            $this->db->
                select('*')->
                from('acr_grupos');
            $msg = 'Datos de todos los grupos';
        }
        // Obtener datos
        $query = $this->db->get();
        // Respuesta
        $this->response(
            Common::data_response($error, $msg, 'grupos', $query->result_array())
        );
    }
    public function grupo_put() {
        // Parametros
        $error = false;
        $msg = '';
        $data['carrera'] = $this->put('carrera');
        $data['grupo'] = $this->put('grupo');
        $data['generacion'] = $this->put('generacion');
        $data['grupoid'] = $data['generacion'] . "_" . $data['carrera'] . "_" . $data['grupo'];
        // Verificar los parametros
        if (Common::not_empty_values($data)) {
            $this->db->insert('acr_grupos', $data);
            $msg = 'Se insertó el grupo ' . $data['grupoid'];
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
    public function grupo_post() {
        // Parametros
        $error = false;
        $msg = '';
        $grupoid = $this->post('grupoid');
        $data['carrera'] = $this->post('carrera');
        $data['grupo'] = $this->post('grupo');
        $data['generacion'] = $this->post('generacion');
        // Verificar los parametros
        if (Common::not_empty_values($data) && Common::not_empty($grupoid)) {
            $this->db->where('grupoid', $grupoid);
            $this->db->update('acr_grupos', $data);
            $msg = 'Se actualizó el grupo ' . $grupoid;
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
    public function grupo_delete() {
        // Parametros
        $error = false;
        $msg = '';
        $grupoid = $this->delete('grupoid');
        // Verificar los parametros
        if (Common::not_empty($grupoid)) {
            $this->db->where('grupoid', $grupoid);
            $this->db->delete('acr_grupos'); 
            $msg = 'Se borró el grupo ' . $grupoid;
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
    public function borrar_post() {
        // Parametros
        $error = false;
        $msg = '';
        $grupoid = $this->post('grupoid');
        // Verificar los parametros
        if (Common::not_empty($grupoid)) {
            $this->db->where('grupoid', $grupoid);
            $this->db->delete('acr_grupos'); 
            $msg = 'Se borró el grupo ' . $grupoid;
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