<?php
class Laporan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
    }

    function index()
    {
        $cnt = 1;
        $pdf = new FPDF('l', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string
        $pdf->Cell(270, 7, 'LAPORAN PEMBELIAN MOBIL RICHZ AUTO', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(270, 7, 'LIST BUY CARS 2019/2020', 0, 1, 'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'NO', 1, 0, 'C');
        $pdf->Cell(50, 6, 'FULL NAME', 1, 0, 'C');
        $pdf->Cell(30, 6, 'MERK', 1, 0, 'C');
        $pdf->Cell(40, 6, 'TYPE', 1, 0, 'C');
        $pdf->Cell(40, 6, 'PRICE DEAL', 1, 0, 'C');
        $pdf->Cell(60, 6, 'CONTACT MESSAGE', 1, 0, 'C');
        $pdf->Cell(40, 6, 'EMAIL BUYER', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $buku = $this->db->get('buy_cars')->result();
        foreach ($buku as $row) {
            $pdf->Cell(10, 6, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(50, 6, $row->name, 1, 0);
            $pdf->Cell(30, 6, $row->merk, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->type, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->harga, 1, 0, 'C');
            $pdf->Cell(60, 6, $row->nomorhp, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->email_pembeli, 1, 1, 'C');
            $cnt++;
        }
        $pdf->Output('D', 'LaporanPembelianMobil.pdf');
    }


    function userAdmin()
    {
        $cnt = 1;
        $pdf = new FPDF('l', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string
        $pdf->Cell(270, 7, 'LAPORAN MOBIL RICHZ AUTO', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(270, 7, 'LIST MEMBERS RICHZ AUTO 2019/2020', 0, 1, 'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(10, 6, 'NO', 1, 0, 'C');
        $pdf->Cell(70, 6, 'FULL NAME', 1, 0, 'C');
        $pdf->Cell(45, 6, 'EMAIL', 1, 0, 'C');
        $pdf->Cell(40, 6, 'STATUS', 1, 0, 'C');
        $pdf->Cell(60, 6, 'ROLE', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $buku = $this->db->get('user')->result();
        foreach ($buku as $row) {
            $pdf->Cell(10, 6, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(70, 6, $row->name, 1, 0, 'C');
            $pdf->Cell(45, 6, $row->email, 1, 0, 'C');
            if ($row->is_active == 1) {
                $pdf->Cell(40, 6, 'ACTIVE', 1, 0, 'C');
            } else {
                $pdf->Cell(40, 6, 'NOT VERIFIED', 1, 0, 'C');
            }

            if ($row->role_id == 1) {
                $pdf->Cell(60, 6, 'ADMIN', 1, 1, 'C');
            } else {
                $pdf->Cell(60, 6, 'MEMBER', 1, 1, 'C');
            }

            $cnt++;
        }
        $pdf->Output('D', 'LaporanSemuaMember.pdf');
    }

    function laporanSparepartAdmin()
    {
        $cnt = 1;
        $pdf = new FPDF('l', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string
        $pdf->Cell(270, 7, 'LAPORAN PENJUALANA SPAREPART RICHZ AUTO', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(270, 7, 'LIST SELL SPAREPART 2019/2020', 0, 1, 'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'NO', 1, 0, 'C');
        $pdf->Cell(70, 6, 'FULL NAME', 1, 0, 'C');
        $pdf->Cell(60, 6, 'SPAREPART', 1, 0, 'C');
        $pdf->Cell(40, 6, 'PRICE', 1, 0, 'C');
        $pdf->Cell(40, 6, 'CONDITION', 1, 0, 'C');
        $pdf->Cell(60, 6, 'EMAIL BUYER', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $buku = $this->db->get('buy_sparepart')->result();
        foreach ($buku as $row) {
            $pdf->Cell(10, 6, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(70, 6, $row->name, 1, 0);
            $pdf->Cell(60, 6, $row->name_sparepart, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->harga, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->kondisi, 1, 0, 'C');
            $pdf->Cell(60, 6, $row->email_pembeli, 1, 1, 'C');
            $cnt++;
        }
        $pdf->Output('D', 'LaporanPenjualanSparepart.pdf');
    }

    function laporanJualMobilAdmin()
    {
        $cnt = 1;
        $pdf = new FPDF('l', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string
        $pdf->Cell(270, 7, 'LAPORAN PENJUALANA MOBIL RICHZ AUTO', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(270, 7, 'LIST SELL MOBIL 2019/2020', 0, 1, 'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'NO', 1, 0, 'C');
        $pdf->Cell(70, 6, 'FULL NAME', 1, 0, 'C');
        $pdf->Cell(60, 6, 'TYPE', 1, 0, 'C');
        $pdf->Cell(40, 6, 'COLOR', 1, 0, 'C');
        $pdf->Cell(40, 6, 'PRICE', 1, 0, 'C');
        $pdf->Cell(40, 6, 'FUEL', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $buku = $this->db->get('sell_cars')->result();
        foreach ($buku as $row) {
            $pdf->Cell(10, 6, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(70, 6, $row->name, 1, 0);
            $pdf->Cell(60, 6, $row->merk, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->warna, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->harga, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->bahan_bakar, 1, 1, 'C');
            $cnt++;
        }
        $pdf->Output('D', 'LaporanPenjualanMobil.pdf');
    }


    //LAPORANNNNNNNNNNNNNNNNNNNNNNNNNNNN USER

    function laporanBeliMobil()
    {
        $cnt = 1;
        $pdf = new FPDF('l', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string
        $pdf->Cell(270, 7, 'LAPORAN PEMBELIAN MOBIL ANDA DI RICHZ AUTO', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(270, 7, 'LIST BUY CARS 2019/2020', 0, 1, 'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'NO', 1, 0, 'C');
        $pdf->Cell(50, 6, 'FULL NAME', 1, 0, 'C');
        $pdf->Cell(30, 6, 'MERK', 1, 0, 'C');
        $pdf->Cell(40, 6, 'TYPE', 1, 0, 'C');
        $pdf->Cell(40, 6, 'PRICE DEAL', 1, 0, 'C');
        $pdf->Cell(60, 6, 'CONTACT MESSAGE', 1, 0, 'C');
        $pdf->Cell(40, 6, 'EMAIL BUYER', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        $buku = $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result();
        foreach ($buku as $row) {
            $pdf->Cell(10, 6, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(50, 6, $row->name, 1, 0);
            $pdf->Cell(30, 6, $row->merk, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->type, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->harga, 1, 0, 'C');
            $pdf->Cell(60, 6, $row->nomorhp, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->email_pembeli, 1, 1, 'C');
            $cnt++;
        }
        $pdf->Output('D', 'LaporanPembelianMobil.pdf');
    }


    function laporanSparepart()
    {
        $cnt = 1;
        $pdf = new FPDF('l', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string
        $pdf->Cell(270, 7, 'LAPORAN PENJUALAN SPAREPART ANDA DI RICHZ AUTO', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(270, 7, 'LIST SELL SPAREPART 2019/2020', 0, 1, 'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'NO', 1, 0, 'C');
        $pdf->Cell(70, 6, 'FULL NAME', 1, 0, 'C');
        $pdf->Cell(60, 6, 'SPAREPART', 1, 0, 'C');
        $pdf->Cell(40, 6, 'PRICE', 1, 0, 'C');
        $pdf->Cell(40, 6, 'CONDITION', 1, 0, 'C');
        $pdf->Cell(60, 6, 'EMAIL BUYER', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        $buku = $this->db->get_where('buy_sparepart', ['email_Pembeli' => $tampilDataPembeli])->result();
        foreach ($buku as $row) {
            $pdf->Cell(10, 6, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(70, 6, $row->name, 1, 0);
            $pdf->Cell(60, 6, $row->name_sparepart, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->harga, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->kondisi, 1, 0, 'C');
            $pdf->Cell(60, 6, $row->email_pembeli, 1, 1, 'C');
            $cnt++;
        }
        $pdf->Output('D', 'LaporanPenjualanSparepart.pdf');
    }

    function laporanJualMobil()
    {
        $cnt = 1;
        $pdf = new FPDF('l', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string
        $pdf->Cell(270, 7, 'LAPORAN PENJUALANA MOBIL ANDA DI RICHZ AUTO', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(270, 7, 'LIST SELL MOBIL 2019/2020', 0, 1, 'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'NO', 1, 0, 'C');
        $pdf->Cell(70, 6, 'FULL NAME', 1, 0, 'C');
        $pdf->Cell(60, 6, 'TYPE', 1, 0, 'C');
        $pdf->Cell(40, 6, 'COLOR', 1, 0, 'C');
        $pdf->Cell(40, 6, 'PRICE', 1, 0, 'C');
        $pdf->Cell(40, 6, 'FUEL', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        $buku = $this->db->get_where('sell_cars', ['email_Pembeli' => $tampilDataPembeli])->result();
        foreach ($buku as $row) {
            $pdf->Cell(10, 6, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(70, 6, $row->name, 1, 0);
            $pdf->Cell(60, 6, $row->merk, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->warna, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->harga, 1, 0, 'C');
            $pdf->Cell(40, 6, $row->bahan_bakar, 1, 1, 'C');
            $cnt++;
        }
        $pdf->Output('D', 'LaporanPenjualanMobil.pdf');
    }
}
