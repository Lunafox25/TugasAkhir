<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AksesHook {
    public function cek_akses() {
        $CI =& get_instance();
        if (isset($CI->akses_tolak) && $CI->akses_tolak) {
            $data['title'] = 'Akses Ditolak';
            echo $CI->load->view('ditolak', $data, TRUE);
            exit; // Stop further execution
        }
    }
}
