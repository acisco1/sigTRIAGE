<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JefeQuirofanos
 *
 * @author felipe de jesus
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Jefequirofanos extends Config{
    
    public function index() {
        $this->load->view('JefeQuirofanos');
    }
}
