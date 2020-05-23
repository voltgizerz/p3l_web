<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard Kasir';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kasir/index', $data);
        $this->load->view('templates/footer');
    }

    public function transaksi_pembayaran_produk()
    {
        $data['title'] = 'Transaksi Pembayaran Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pembayaran_Produk_Model', 'menu');
        $data['dataPembayaranProduk'] = $this->menu->getDataPembayaranProdukAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kasir/transaksi_pembayaran_produk', $data);
        $this->load->view('templates/footer');
    }

    public function updatePembayaranProduk($id)
    {
        $kode = $this->db->get_where('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id])->row()->kode_transaksi_penjualan_produk;
        $cekProduk = $this->db->get_where('data_detail_penjualan_produk', ['kode_transaksi_penjualan_produk_fk' => $kode])->num_rows();
        $subtotal = $this->db->get_where('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id])->row()->total_penjualan_produk;
        $data['title'] = 'Transaksi Pembayaran Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pembayaran_Produk_Model', 'menu');
        $data['dataPembayaranProduk'] = $this->menu->getPembayaranProdukId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('status_pembayaran', 'status_pembayaran', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kasir/transaksi_pembayaran_produk', $data);
            $this->load->view('templates/footer');
        } else {
            $totalHarga = $subtotal - $this->input->post('diskon');
            $ci = get_instance();
            date_default_timezone_set("Asia/Bangkok");
            if ($this->input->post('status_pembayaran') == 'Lunas') {
                $data = [
                    'status_pembayaran' => $this->input->post('status_pembayaran'),
                    'tanggal_pembayaran_produk' => date("Y-m-d H:i:s"),
                    'updated_date' => date("Y-m-d H:i:s"),
                    'id_kasir' => $ci->session->userdata('id_pegawai'),
                    'diskon' => $this->input->post('diskon'),
                    'total_harga' => $totalHarga,
                ];
                $this->db->where('id_transaksi_penjualan_produk', $id)->update('data_transaksi_penjualan_produk', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Transaksi Pembayaran Produk Telah Selesai Diproses!
               </div>');
            } else {
                $data = [
                    'status_pembayaran' => $this->input->post('status_pembayaran'),
                    'updated_date' => date("Y-m-d H:i:s"),
                    'id_kasir' => $ci->session->userdata('id_pegawai'),
                    'diskon' => $this->input->post('diskon'),
                    'total_harga' => $totalHarga,
                ];
                $this->db->where('id_transaksi_penjualan_produk', $id)->update('data_transaksi_penjualan_produk', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Transaksi Pembayaran Produk Sukses di Edit!
               </div>');
            }
            
            redirect('kasir/transaksi_pembayaran_produk');
        }
    }

    public function cariPembayaranProduk()
    {
        $data['title'] = 'Transaksi Pembayaran Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pembayaran_Produk_Model', 'menu');
        $data['menu'] = $this->db->get('user_menu')->result_array();

        //UNTUK SERACHING DATA
        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");
        $data['dataPembayaranProduk'] = $this->menu->cariPembayaranProduk($data['cariberdasarkan'], $data['yangdicari'])->result_array();
        $data["jumlah"] = count($data["dataPembayaranProduk"]);

        if (!isset($_POST['cari'])) {
            $this->form_validation->set_rules('cs', 'cs', 'required|trim');
        }
        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kasir/cariPembayaranProduk', $data);
            $this->load->view('templates/footer');
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Cache-Control: no cache");
        } 
    }

}