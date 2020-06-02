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
        $data['title'] = 'Kouvee Pet Shop - Status Layanan';
        $this->load->model('Pembayaran_Layanan_Model', 'menu');
        $data['dataPenjualanLayanan'] = $this->menu->getDataPembayaranLayananCustomer();
        $this->load->view('templates/auth_header', $data);
        $this->load->view('customer/status');
        $this->load->view('templates/auth_footer');
    }

    public function cari()
    {
        $data['title'] = 'Kouvee Pet Shop - Status Layanan';
        $this->load->model('Pembayaran_Layanan_Model', 'menu');
        $data['data_hewan'] = $this->menu->select_hewan();
        //UNTUK SERACHING DATA
        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");
        $data['dataPenjualanLayanan'] = $this->menu->cariPenjualanLayananCustomer($data['cariberdasarkan'], $data['yangdicari'])->result_array();
        $data["jumlah"] = count($data["dataPenjualanLayanan"]);

        if (!isset($_POST['cari'])) {
            $this->form_validation->set_rules('cs', 'cs', 'required|trim');
        }
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('customer/status', $data);
            $this->load->view('templates/auth_footer');
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Cache-Control: no cache");
        }
    }
}
