<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Urgencias
 *
 * @author felipe de jesus
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Urgencias extends Config{
    public function __construct() {
        parent::__construct();
        $this->VerificarSession();
    }
    public function Areas() {
        $this->load->view('pisos/Camas/GestionCamas');
    }
}
