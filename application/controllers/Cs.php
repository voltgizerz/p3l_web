<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cs extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
      
    }

    public function index()
    {
        $data['title'] = 'Dashboard CS';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cs/index', $data);
        $this->load->view('templates/footer');
    }

   
}