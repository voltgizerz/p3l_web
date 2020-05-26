<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function status()
    {
        $data['title'] = 'Kouvee Pet Shop - HomePage';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('customer/status');
        $this->load->view('templates/auth_footer');
    }
}
