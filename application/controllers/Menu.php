<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function index() {
        $data['title']  = 'Menu';
        $data['main_view'] = 'view_menu';

        $this->load->view('layout', $data);
    }
}