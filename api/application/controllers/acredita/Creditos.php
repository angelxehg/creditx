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
class Creditos extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database('utzac_acr');
        $this->load->helper(array('form', 'url'));
    }
    public function credito_get() {
        // Parametros
        $error = false;
        $msg = '';
        $creditoid = $this->get('creditoid');
        // Verificar los parametros
        if (Common::not_empty($creditoid)) {
            $this->db->
                select('*')->
                from('acr_view_creditos')->
                where('creditoid', $creditoid);
            $msg = 'Datos del registro ' . $creditoid;
        } else {
            $this->db->
                select('*')->
                from('acr_view_creditos');
            $msg = 'Datos de todos los registros ';
        }
        // Obtener datos
        $query = $this->db->get();
        // Respuesta
        $this->response(
            Common::data_response($error, $msg, 'registros', $query->result_array())
        );
    }
    public function credito_put() {
        // Parametros
        $error = false;
        $msg = '';
        $data['actividadid'] = $this->put('actividadid');
        $data['matricula'] = $this->put('matricula');
        $data['cantidad'] = $this->put('cantidad');
        // Verificar los parametros
        if (Common::not_empty_values($data)) {
            $this->db->insert('acr_creditos', $data);
            $msg = 'Se insertó el registro para el alumno ' . $data['matricula'];
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
    public function credito_post() {
        // Parametros
        $error = false;
        $msg = '';
        $creditoid = $this->post('creditoid');
        $data['actividadid'] = $this->post('actividadid');
        $data['matricula'] = $this->post('matricula');
        $data['cantidad'] = $this->post('cantidad');
        // Verificar los parametros
        if (Common::not_empty_values($data) && Common::not_empty($creditoid)) {
            $this->db->where('creditoid', $creditoid);
            $this->db->update('acr_creditos', $data);
            $msg = 'Se actualizó el registro ' . $creditoid;
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
    public function credito_delete() {
        // Parametros
        $error = false;
        $msg = '';
        $creditoid = $this->delete('creditoid');
        // Verificar los parametros
        if (Common::not_empty($creditoid)) {
            $this->db->where('creditoid', $creditoid);
            $this->db->delete('acr_creditos');
            $msg = 'Se borró el registro ' . $creditoid;
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