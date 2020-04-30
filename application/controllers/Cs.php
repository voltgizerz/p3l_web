<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cs extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

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

    public function transaksi_penjualan_produk(){
        $data['title'] = 'Transaksi Penjualan Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Penjualan_Produk_Model', 'menu');
        $data['dataPenjualanProduk'] = $this->menu->getDataPenjualanProdukAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('cs', 'cs', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('cs/transaksi_penjualan_produk', $data);
            $this->load->view('templates/footer');
        } else {
            $ci = get_instance();
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'kode_transaksi_penjualan_produk' => $this->menu->ambilKode(),
                'tanggal_penjualan_produk' => date("0000:00:0:00:00"),
                'tanggal_pembayaran_produk' => date("0000:00:0:00:00"),
                'diskon' => '0',
                'total_penjualan_produk' => '0',
                'status_penjualan' => 'Belum Selesai',
                'status_pembayaran' => 'Belum Lunas',
                'id_cs' => $ci->session->userdata('id_pegawai'),
                'id_kasir' => $ci->session->userdata('id_pegawai'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'total_harga' => '0',
            ];

            $this->db->insert('data_transaksi_penjualan_produk', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Transaksi Penjualan Berhasil Ditambahkan!
           </div>');
            redirect('cs/transaksi_penjualan_produk');
        }
    }

    public function updatePenjualanProduk($id){
        $data['title'] = 'Transaksi Penjualan Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Penjualan_Produk_Model', 'menu');
        $data['dataPenjualanProduk'] = $this->menu->getPenjualanProdukId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('status_penjualan', 'status_penjualan', 'required');
        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('cs/transaksi_penjualan_produk', $data);
            $this->load->view('templates/footer');
        } else {
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'status_penjualan' => $this->input->post('status_penjualan'),
                'tanggal_penjualan_produk' => date("Y-m-d H:i:s"),
                'updated_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_transaksi_penjualan_produk', $id)->update('data_transaksi_penjualan_produk', $data);
             $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Transaksi Pengadaan Sukses di Edit!
           </div>');
            redirect('cs/transaksi_penjualan_produk');
            }

        }
        
        public function hapusPenjualanProduk($id)
        {
            $this->load->model('Penjualan_Produk_Model');
            $this->Penjualan_Produk_Model->deletePenjualanProduk($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                  Sukses Hapus Transaksi Penjualan Produk!
                   </div>');
            redirect('cs/transaksi_penjualan_produk');
        }
    }