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
class Tarjetas extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database('utzac_acr');
        $this->load->helper(array('form', 'url'));
    }
    public function tarjeta_get() {
        // Parametros
        $error = false;
        $msg = '';
        $rfid = $this->get('rfid');
        // Verificar los parametros
        if (Common::not_empty($rfid)) {
            $query = $this->db->query("SELECT * FROM acr_tarjetas WHERE rfid = '" . $rfid . "' AND estado = 1");
            $msg = 'Datos de la tarjeta ' . $rfid;
        } else {
            $this->db->
                select('*')->
                from('acr_tarjetas')->
                where('estado', 1);
            // Obtener datos
            $query = $this->db->get();
            $msg = 'Datos de todas las tarjetas';
        }
        // Respuesta
        $this->response(
            Common::data_response($error, $msg, 'tarjetas', $query->result_array())
        );
    }
    public function tarjeta_valida_get() {
        // Parametros
        $error = false;
        $msg = '';
        $rfid = $this->get('rfid');
        // Query
        $query = $this->db->query("SELECT * FROM acr_tarjetas WHERE rfid = '" . $rfid . "' AND estado = 1");
        if ($query->result_array()) {
            $respuesta = array ('valida' => true);
        } else {
            $respuesta = array ('valida' => false);
        }
        // Respuesta
        $this->response($respuesta);
    }
    public function tarjeta_put() {
        // Parametros
        $error = false;
        $msg = '';
        $data['rfid'] = $this->put('rfid');
        $data['matricula'] = $this->put('matricula');
        // Verificar los parametros
        if (Common::not_empty_values($data)) {
            $this->db->insert('acr_tarjetas', $data);
            $msg = 'Se añadió la tarjeta ' . $data['rfid'];
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
    public function tarjeta_post() {
        // Parametros
        $error = false;
        $msg = '';
        $rfid = $this->post('rfid');
        $data['matricula'] = $this->post('matricula');
        // Verificar los parametros
        if (Common::not_empty_values($data) && Common::not_empty($rfid)) {
            $this->db->where('rfid', $rfid);
            $this->db->update('acr_tarjetas', $data);
            $msg = 'Se actualizó la tajerta ' . $rfid;
        } else {
            $error = true;
            $msg = 'Faltan parametros';
        }
        // Respuesta
        $this->response(
            Common::basic_response($error, $msg)
        );
    }
    public function tarjeta_delete() {
        // Parametros
        $error = false;
        $msg = '';
        $rfid = $this->delete('rfid');
        // Verificar los parametros
        if (Common::not_empty($rfid)) {
            $this->db->where('rfid', $rfid);
            $this->db->update('acr_tarjetas', ['estado' => 0]); 
            $msg = 'Se desactivo la tarjeta ' . $rfid;
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