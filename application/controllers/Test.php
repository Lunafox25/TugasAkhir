<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function ditolak() {
        $data['title'] = 'Akses Ditolak';
        $data['main_view'] = 'ditolak';
        $this->load->view('layout', $data);
    }
}
