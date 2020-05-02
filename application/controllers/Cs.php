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

    public function transaksi_penjualan_produk()
    {
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

    public function updatePenjualanProduk($id)
    {
        $kode = $this->db->get_where('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id])->row()->kode_transaksi_penjualan_produk;
        $cekProduk = $this->db->get_where('data_detail_penjualan_produk', ['kode_transaksi_penjualan_produk_fk' => $kode])->num_rows();
        $data['title'] = 'Transaksi Penjualan Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Penjualan_Produk_Model', 'menu');
        $data['dataPenjualanProduk'] = $this->menu->getPenjualanProdukId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        if ($this->input->post('status_penjualan') == 'Sudah Selesai') {
            if ($cekProduk == 0) {
                $this->form_validation->set_rules('status_penjualan', 'status_penjualan', 'required|equal[Belum Selesai]', [
                    'equal' => 'Gagal Ubah Status Penjualan, Produk Penjualan masih Kosong!']);
            } else {
                $this->form_validation->set_rules('status_penjualan', 'status_penjualan', 'required');
            }
        } else {
            $this->form_validation->set_rules('status_penjualan', 'status_penjualan', 'required');
        }

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

    public function detail_penjualan_produk($id)
    {
        $data['title'] = 'Transaksi Penjualan Produk';
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
                    'less_than' => 'Stok Produk Tersedia Hanya : ' . $cekStok]);
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
            $this->load->view('cs/detail_penjualan_produk', $data);
            $this->load->view('templates/footer');
        } else {
            // $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'kode_transaksi_penjualan_produk_fk' => $kode,
                'id_produk_penjualan_fk' => $this->input->post('pilih_produk'),
                'jumlah_produk' => $this->input->post('jumlah_produk'),
                'subtotal' => '0',
            ];

            $this->db->insert('data_detail_penjualan_produk', $data);
            $rowcreate = $this->db->affected_rows();
            //CARI NILAI SUBTOTAL PRODUK DETAIL HARGA UPDATE
            $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk');
            $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
            $this->db->where('data_detail_penjualan_produk.subtotal', '0');
            $this->db->from('data_detail_penjualan_produk');
            $query = $this->db->get();
            $arrTemp = json_decode(json_encode($query->result()), true);

            // NILAI TAMPUNG SUB TOTAL  DETAIL PENJUALAN HARGA YANG BARU
            $temp = $arrTemp[0]['jumlah_produk'] * $arrTemp[0]['harga_produk'];
            //UPDATE NILAI TOTAL PENGADAAN
            $this->db->where('subtotal', '0')->update('data_detail_penjualan_produk', ['subtotal' => $temp]);

            //CARI NILAI TOTAL HARGA UPDATE
            $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk');
            $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
            $this->db->where('data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk', $data['kode_transaksi_penjualan_produk_fk']);
            $this->db->from('data_detail_penjualan_produk');
            $query = $this->db->get();
            $arrTemp = json_decode(json_encode($query->result()), true);

            // NILAI TAMPUNG TOTAL HARGA PENJUALAN YANG BARU
            $temp = 0;
            for ($i = 0; $i < count($arrTemp); $i++) {
                $temp = $temp + $arrTemp[$i]['jumlah_produk'] * $arrTemp[$i]['harga_produk'];
            }
            //UPDATE NILAI TOTAL PENGADAAN
            $this->db->where('kode_transaksi_penjualan_produk', $data['kode_transaksi_penjualan_produk_fk'])->update('data_transaksi_penjualan_produk', ['total_penjualan_produk' => $temp]);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Penjualan Berhasil Ditambahkan!
           </div>');
            redirect('cs/detail_penjualan_produk/' . $id);
        }
    }

    public function hapusDetailPenjualanProduk($id)
    {
        $kode = $this->db->get_where('data_detail_penjualan_produk', ['id_detail_penjualan_produk' => $id])->row()->kode_transaksi_penjualan_produk_fk;
        $idtrx = $this->db->get_where('data_transaksi_penjualan_produk', ['kode_transaksi_penjualan_produk' => $kode])->row()->id_transaksi_penjualan_produk;
        $this->load->model('Penjualan_Produk_Model');
        $this->Penjualan_Produk_Model->deleteDetailPenjualanProduk($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                  Sukses Hapus Produk Transaksi Penjualan!
                   </div>');
        redirect('cs/detail_penjualan_produk/' . $idtrx);

    }

    public function updateDetailPenjualanProduk($id)
    {
        $kode = $this->db->get_where('data_detail_penjualan_produk', ['id_detail_penjualan_produk' => $id])->row()->kode_transaksi_penjualan_produk_fk;
        $idtrx = $this->db->get_where('data_transaksi_penjualan_produk', ['kode_transaksi_penjualan_produk' => $kode])->row()->id_transaksi_penjualan_produk;
        $data['title'] = 'Transaksi Penjualan Produk';
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
                'less_than' => 'Stok Produk Tersedia Hanya : ' . $cekStok]);
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
                $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk');
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
            Produk Penjualan Berhasil Diedit!
           </div>');
                redirect('cs/detail_penjualan_produk/' . $idtrx);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Penjualan Berhasil Diedit!
           </div>');
            redirect('cs/detail_penjualan_produk/' . $idtrx);

        }

    }

    public function cariPenjualanProduk()
    {
        $data['title'] = 'Transaksi Penjualan Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Penjualan_Produk_Model', 'menu');
        $data['menu'] = $this->db->get('user_menu')->result_array();

        //UNTUK SERACHING DATA
        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");
        $data['dataPenjualanProduk'] = $this->menu->cariPenjualanProduk($data['cariberdasarkan'], $data['yangdicari'])->result_array();
        $data["jumlah"] = count($data["dataPenjualanProduk"]);

        if (!isset($_POST['cari'])) {
            $this->form_validation->set_rules('cs', 'cs', 'required|trim');
        }
        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('cs/cariPenjualanProduk', $data);
            $this->load->view('templates/footer');
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Cache-Control: no cache");
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
}