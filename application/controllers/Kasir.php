<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        require_once "vendor/autoload.php";
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

        //CEK APAKAH PRODUK TERSEDIA

        $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk,data_produk.stok_produk,data_produk.nama_produk,data_produk.id_produk,data_produk.stok_minimal_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
        $this->db->where('data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk', $kode);
        $this->db->from('data_detail_penjualan_produk');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);

        if ($this->input->post('status_pembayaran') == 'Lunas') {
            $count = 0;
            $minus = 0;
            for ($i = 0; $i < count($arrTemp); $i++) {
                if ($arrTemp[$i]['stok_produk'] - $arrTemp[$i]['jumlah_produk'] < 0) {
                    $count = $i;
                    $minus = -1;
                    break;
                }
                break;
            }
            if ($minus == 0) {
                $this->form_validation->set_rules('status_pembayaran', 'status_pembayaran', 'required');
                //PENGURANGAN PRODUK DAN UPPDATE STOK PRODUK
                for ($i = 0; $i < count($arrTemp); $i++) {
                    $stokUpdate = $arrTemp[$i]['stok_produk'] - $arrTemp[$i]['jumlah_produk'];
                    $this->db->where('id_produk', $arrTemp[$i]['id_produk'])->update('data_produk', ['stok_produk' => $stokUpdate]);
                    //HEMAT KUOTA SMS BOS LIMIT SMS HANYA 20 KALI
                    //if ($stokUpdate < $arrTemp[$i]['stok_minimal_produk']) {
                    //$basic  = new \Nexmo\Client\Credentials\Basic('66df917e', 'Jm3QidLR8uuwF5uh');
                    //$client = new \Nexmo\Client($basic);
                    //$message = $client->message()->send([
                    //'to' => '6285155099184',
                    //'from' => 'KOUVEE PETSHOP',
                    //'text' => 'Halo dari Kouvee PetShop, Produk ['.$arrTemp[$i]['nama_produk'].'] Mulai Menipis Tersisa : '.$stokUpdate.' Stok '
                    //]);                            
                    //}
                }
            } else {
                // PRODUK SUDAH DIEMBAT ORANG LAIN
                $this->form_validation->set_rules('cek', 'cek', 'required|less_than[' . $minus . ' ]', [
                    'less_than' => 'OOPS... Stok Produk ' . $arrTemp[$count]['nama_produk'] . ' Tersedia sekarang Hanya : ' . $arrTemp[$count]['stok_produk']
                ]);
                $this->form_validation->set_rules('status_pembayaran', 'status_pembayaran', 'required');
            }
        }
        $this->form_validation->set_rules('status_pembayaran', 'status_pembayaran', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kasir/transaksi_pembayaran_produk', $data);
            $this->load->view('templates/footer');
        } else {
            if ($totalHarga = $subtotal - $this->input->post('diskon') < 0) {
                $totalHarga =0;
            } else {
                $totalHarga = $subtotal - $this->input->post('diskon');
            }
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

    public function detail_pembayaran_produk($id)
    {
        $data['title'] = 'Transaksi Pembayaran Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Penjualan_Produk_Model', 'menu');
        $data['dataDetailPenjualanProduk'] = $this->menu->getDataDetailPenjualanProdukAdmin($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_produk'] = $this->menu->select_produk();
        $kode = $this->db->get_where('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id])->row()->kode_transaksi_penjualan_produk;
        $data['kode_penjualan'] = $kode;
        $data['id_penjualan'] = $id;
        if ($this->input->post('pilih_produk') != null) {
            $cekStok = $this->db->get_where('data_produk', ['id_produk' => $this->input->post('pilih_produk')])->row()->stok_produk;
            if ($cekStok < $this->input->post('jumlah_produk')) {

                $this->form_validation->set_rules('jumlah_produk', 'jumlah_produk', 'required|less_than[' . $cekStok . ']', [
                    'less_than' => 'Stok Produk Tersedia Hanya : ' . $cekStok
                ]);
            } else {
                $this->form_validation->set_rules('jumlah_produk', 'jumlah_produk', 'required');
                $this->form_validation->set_rules('pilih_produk', 'pilih_produk', 'required');
            }
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kasir/detail_pembayaran_produk', $data);
            $this->load->view('templates/footer');
        }
    }

    public function updateDetailPembayaranProduk($id)
    {
        $kode = $this->db->get_where('data_detail_penjualan_produk', ['id_detail_penjualan_produk' => $id])->row()->kode_transaksi_penjualan_produk_fk;
        $idtrx = $this->db->get_where('data_transaksi_penjualan_produk', ['kode_transaksi_penjualan_produk' => $kode])->row()->id_transaksi_penjualan_produk;
        $data['title'] = 'Transaksi Pembayaran Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Penjualan_Produk_Model', 'menu');
        $data['dataDetailPenjualanProduk'] = $this->menu->getDetailPenjualanProdukId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_produk'] = $this->menu->select_produk();
        $data['kode_penjualan'] = $kode;
        $data['id_penjualan'] = $id;

        $cekStok = $this->db->get_where('data_produk', ['id_produk' => $this->input->post('pilih_produk')])->row()->stok_produk;
        if ($cekStok < $this->input->post('jumlah_produk')) {
            $this->form_validation->set_rules('jumlah_produk', 'jumlah_produk', 'required|less_than[' . $cekStok . ']', [
                'less_than' => 'Stok Produk Tersedia Hanya : ' . $cekStok
            ]);
        } else {
            $this->form_validation->set_rules('pilih_produk', 'pilih_produk', 'required');
            $this->form_validation->set_rules('jumlah_produk', 'jumlah_produk', 'required');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('cs/detail_penjualan_produk', $data);
            $this->load->view('templates/footer');
        } else {
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'kode_transaksi_penjualan_produk_fk' => $kode,
                'id_produk_penjualan_fk' => $this->input->post('pilih_produk'),
                'jumlah_produk' => $this->input->post('jumlah_produk'),
            ];

            if ($this->db->where('id_detail_penjualan_produk', $id)->update('data_detail_penjualan_produk', $data)) {
                //CARI NILAI TOTAL HARGA UPDATE
                $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk,data_produk.stok_minimal_produk');
                $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
                $this->db->where('data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk', $kode);
                $this->db->from('data_detail_penjualan_produk');
                $query = $this->db->get();
                $arrTemp = json_decode(json_encode($query->result()), true);

                // NILAI TAMPUNG TOTAL HARGA PENJUALAN YANG BARU
                $temp = 0;
                for ($i = 0; $i < count($arrTemp); $i++) {
                    $temp = $temp + $arrTemp[$i]['jumlah_produk'] * $arrTemp[$i]['harga_produk'];
                }
                //UPDATE NILAI TOTAL PENGADAAN
                $this->db->where('kode_transaksi_penjualan_produk', $kode)->update('data_transaksi_penjualan_produk', ['total_penjualan_produk' => $temp, 'updated_date' => date("Y-m-d H:i:s")]);

                //CARI NILAI SUBTOTAL PRODUK DETAIL HARGA UPDATE
                $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk');
                $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
                $this->db->where('data_detail_penjualan_produk.id_detail_penjualan_produk', $id);
                $this->db->from('data_detail_penjualan_produk');
                $query = $this->db->get();
                $arrTemp = json_decode(json_encode($query->result()), true);

                // NILAI TAMPUNG SUB TOTAL  DETAIL PENJUALAN HARGA YANG BARU
                $temp = $arrTemp[0]['jumlah_produk'] * $arrTemp[0]['harga_produk'];
                //UPDATE NILAI TOTAL PENGADAAN
                $this->db->where('id_detail_penjualan_produk', $id)->update('data_detail_penjualan_produk', ['subtotal' => $temp]);

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Pembayaran Berhasil Diedit!
           </div>');
                redirect('kasir/detail_pembayaran_produk/' . $idtrx);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Pembayaran Berhasil Diedit!
           </div>');
            redirect('kasir/detail_pembayaran_produk/' . $idtrx);
        }
    }

    public function hapusDetailPembayaranProduk($id)
    {
        $kode = $this->db->get_where('data_detail_penjualan_produk', ['id_detail_penjualan_produk' => $id])->row()->kode_transaksi_penjualan_produk_fk;
        $idtrx = $this->db->get_where('data_transaksi_penjualan_produk', ['kode_transaksi_penjualan_produk' => $kode])->row()->id_transaksi_penjualan_produk;
        $this->load->model('Penjualan_Produk_Model');
        $this->Penjualan_Produk_Model->deleteDetailPenjualanProduk($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                  Sukses Hapus Produk Transaksi Pembayaran!
                   </div>');
        redirect('kasir/detail_pembayaran_produk/' . $idtrx);
    }

    public function hapusPembayaranProduk($id)
    {
        $this->load->model('Penjualan_Produk_Model');
        $this->Penjualan_Produk_Model->deletePenjualanProduk($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                  Sukses Hapus Transaksi Pembayaran Produk!
                   </div>');
        redirect('kasir/transaksi_pembayaran_produk');
    }

    public function transaksi_pembayaran_layanan()
    {
        $data['title'] = 'Transaksi Pembayaran Layanan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pembayaran_Layanan_Model', 'menu');
        $data['dataPenjualanLayanan'] = $this->menu->getDataPembayaranLayananAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_hewan'] = $this->menu->select_hewan();

        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kasir/transaksi_pembayaran_layanan', $data);
        $this->load->view('templates/footer');
    }

    public function updatePembayaranLayanan($id)
    {
        $kode = $this->db->get_where('data_transaksi_penjualan_jasa_layanan', ['id_transaksi_penjualan_jasa_layanan' => $id])->row()->kode_transaksi_penjualan_jasa_layanan;
        $cekLayanan = $this->db->get_where('data_detail_penjualan_jasa_layanan', ['kode_transaksi_penjualan_jasa_layanan_fk' => $kode])->num_rows();
        $subtotal = $this->db->get_where('data_transaksi_penjualan_jasa_layanan', ['id_transaksi_penjualan_jasa_layanan' => $id])->row()->total_penjualan_jasa_layanan;

        $data['title'] = 'Transaksi Pembayaran Layanan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Penjualan_Layanan_Model', 'menu');
        $data['dataPenjualanLayanan'] = $this->menu->getPenjualanLayananId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_hewan'] = $this->menu->select_hewan();

        $this->form_validation->set_rules('status_pembayaran', 'status_pembayaran', 'required');
        $this->form_validation->set_rules('pilih_hewan', 'pilih_hewan', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kasir/transaksi_pembayaran_layanan', $data);
            $this->load->view('templates/footer');
        } else {
            if ($totalHarga = $subtotal - $this->input->post('diskon') < 0) {
                $totalHarga =0;
            } else {
                $totalHarga = $subtotal - $this->input->post('diskon');
            }

            $ci = get_instance();
            date_default_timezone_set("Asia/Bangkok");
            if ($this->input->post('status_pembayaran') == 'Lunas') {
                $data = [
                    'id_hewan' => $this->input->post('pilih_hewan'),
                    'status_pembayaran' => $this->input->post('status_pembayaran'),
                    'tanggal_pembayaran_jasa_layanan' => date("Y-m-d H:i:s"),
                    'updated_date' => date("Y-m-d H:i:s"),
                    'id_kasir' => $ci->session->userdata('id_pegawai'),
                    'diskon' => $this->input->post('diskon'),
                    'total_harga' => $totalHarga,
                ];
                $this->db->where('id_transaksi_penjualan_jasa_layanan', $id)->update('data_transaksi_penjualan_jasa_layanan', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Transaksi Pembayaran Jasa Layanan Telah Selesai Diproses!
               </div>');
            } else {
                $data = [
                    'id_hewan' => $this->input->post('pilih_hewan'),
                    'status_pembayaran' => $this->input->post('status_pembayaran'),
                    'updated_date' => date("Y-m-d H:i:s"),
                    'id_kasir' => $ci->session->userdata('id_pegawai'),
                    'diskon' => $this->input->post('diskon'),
                    'total_harga' => $totalHarga,
                ];
                $this->db->where('id_transaksi_penjualan_jasa_layanan', $id)->update('data_transaksi_penjualan_jasa_layanan', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Transaksi Pembayaran Layanan Sukses di Edit!
               </div>');
            }
            redirect('kasir/transaksi_pembayaran_layanan');
        }
    }

    public function hapusPembayaranLayanan($id)
    {
        $this->load->model('Penjualan_Layanan_Model');
        $this->Penjualan_Layanan_Model->deletePenjualanLayanan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                  Sukses Hapus Transaksi Pembayaran Jasa Layanan!
                   </div>');
        redirect('kasir/transaksi_pembayaran_layanan');
    }

    public function updateDetailPembayaranLayanan($id)
    {
        $kode = $this->db->get_where('data_detail_penjualan_jasa_layanan', ['id_detail_penjualan_jasa_layanan' => $id])->row()->kode_transaksi_penjualan_jasa_layanan_fk;
        $idtrx = $this->db->get_where('data_transaksi_penjualan_jasa_layanan', ['kode_transaksi_penjualan_jasa_layanan' => $kode])->row()->id_transaksi_penjualan_jasa_layanan;
        $data['title'] = 'Transaksi Pembayaran Layanan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Penjualan_Layanan_Model', 'menu');
        $data['dataDetailPenjualanLayanan'] = $this->menu->getDetailPenjualanLayananId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_layanan'] = $this->menu->select_layanan();
        $data['kode_penjualan'] = $kode;
        $data['id_penjualan'] = $id;

        $this->form_validation->set_rules('pilih_layanan', 'pilih_layanan', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kasir/detail_pembayaran_layanan', $data);
            $this->load->view('templates/footer');
        } else {
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'kode_transaksi_penjualan_jasa_layanan_fk' => $kode,
                'id_jasa_layanan_fk' => $this->input->post('pilih_layanan'),
                'jumlah_jasa_layanan' => '1',
            ];

            if ($this->db->where('id_detail_penjualan_jasa_layanan', $id)->update('data_detail_penjualan_jasa_layanan', $data)) {
                //CARI NILAI TOTAL HARGA UPDATE
                $this->db->select('data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk,data_detail_penjualan_jasa_layanan.jumlah_jasa_layanan,data_jasa_layanan.harga_jasa_layanan');
                $this->db->join('data_jasa_layanan', 'data_jasa_layanan.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
                $this->db->where('data_detail_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan_fk', $kode);
                $this->db->from('data_detail_penjualan_jasa_layanan');
                $query = $this->db->get();
                $arrTemp = json_decode(json_encode($query->result()), true);

                // NILAI TAMPUNG TOTAL HARGA PENJUALAN YANG BARU
                $temp = 0;
                for ($i = 0; $i < count($arrTemp); $i++) {
                    $temp = $temp + $arrTemp[$i]['jumlah_jasa_layanan'] * $arrTemp[$i]['harga_jasa_layanan'];
                }
                //UPDATE NILAI TOTAL PENGADAAN
                $this->db->where('kode_transaksi_penjualan_jasa_layanan', $kode)->update('data_transaksi_penjualan_jasa_layanan', ['total_penjualan_jasa_layanan' => $temp, 'updated_date' => date("Y-m-d H:i:s")]);

                //CARI NILAI SUBTOTAL PRODUK DETAIL HARGA UPDATE
                $this->db->select('data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk,data_detail_penjualan_jasa_layanan.jumlah_jasa_layanan,data_jasa_layanan.harga_jasa_layanan');
                $this->db->join('data_jasa_layanan', 'data_jasa_layanan.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
                $this->db->where('data_detail_penjualan_jasa_layanan.id_detail_penjualan_jasa_layanan', $id);
                $this->db->from('data_detail_penjualan_jasa_layanan');

                $query = $this->db->get();
                $arrTemp = json_decode(json_encode($query->result()), true);

                // NILAI TAMPUNG SUB TOTAL  DETAIL PENJUALAN HARGA YANG BARU
                $temp = $arrTemp[0]['jumlah_jasa_layanan'] * $arrTemp[0]['harga_jasa_layanan'];
                //UPDATE NILAI TOTAL PENGADAAN
                $this->db->where('id_detail_penjualan_jasa_layanan', $id)->update('data_detail_penjualan_jasa_layanan', ['subtotal' => $temp]);

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Jasa Layanan Penjualan Berhasil Diedit!
           </div>');
                redirect('kasir/detail_pembayaran_layanan/' . $idtrx);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Jasa Layanan Pembayaran Berhasil Diedit!
           </div>');
            redirect('kasir/detail_pembayaran_layanan/' . $idtrx);
        }
    }

    public function detail_pembayaran_layanan($id)
    {
        $data['title'] = 'Transaksi Pembayaran Layanan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Penjualan_Layanan_Model', 'menu');
        $data['dataDetailPenjualanLayanan'] = $this->menu->getDataDetailPenjualanLayananAdmin($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_layanan'] = $this->menu->select_layanan();
        $kode = $this->db->get_where('data_transaksi_penjualan_jasa_layanan', ['id_transaksi_penjualan_jasa_layanan' => $id])->row()->kode_transaksi_penjualan_jasa_layanan;
        $data['kode_penjualan'] = $kode;
        $data['id_penjualan'] = $id;


        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kasir/detail_pembayaran_layanan', $data);
        $this->load->view('templates/footer');
    }

    public function hapusDetailPembayaranLayanan($id)
    {
        $kode = $this->db->get_where('data_detail_penjualan_jasa_layanan', ['id_detail_penjualan_jasa_layanan' => $id])->row()->kode_transaksi_penjualan_jasa_layanan_fk;
        $idtrx = $this->db->get_where('data_transaksi_penjualan_jasa_layanan', ['kode_transaksi_penjualan_jasa_layanan' => $kode])->row()->id_transaksi_penjualan_jasa_layanan;
        $this->load->model('Penjualan_Layanan_Model');
        $this->Penjualan_Layanan_Model->deleteDetailPenjualanLayanan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                  Sukses Hapus Jasa  Layanan Transaksi Pembayaran!
                   </div>');
        redirect('kasir/detail_pembayaran_layanan/' . $idtrx);
    }
}
