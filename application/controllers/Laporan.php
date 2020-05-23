<?php
class Laporan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
        date_default_timezone_set("Asia/Bangkok");
    }

    function index($id)
    {
        $kode = $this->db->get_where('data_pengadaan', ['id_pengadaan' => $id])->row()->kode_pengadaan;
        $tanggal = $this->db->get_where('data_pengadaan', ['id_pengadaan' => $id])->row()->created_date;
        $id_supplier = $this->db->get_where('data_pengadaan', ['id_pengadaan' => $id])->row()->id_supplier;
        $namaSupplier = $this->db->get_where('data_supplier', ['id_supplier' => $id_supplier])->row()->nama_supplier;
        $alamatSupplier = $this->db->get_where('data_supplier', ['id_supplier' => $id_supplier])->row()->alamat_supplier;
        $telp = $this->db->get_where('data_supplier', ['id_supplier' => $id_supplier])->row()->nomor_telepon_supplier;
       
        $new_date = date('d F Y',strtotime($tanggal));
        $cnt = 1;
        $pdf = new FPDF('P','mm',array(210,210));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        //HEADER LAPORAN
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Rect(5, 5, 200, 200, 'D');
        $pdf->Image('D:\XAMPP\htdocs\p3l_web\assets\img\headerlaporan.png',7,10,195,0,'PNG');

        //TEXT
        $pdf->Cell(10, 60, '', 0, 1);
        $pdf->Cell(190, 7, 'SURAT PEMESANAN', 99, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);
        // KODE PENGADDAN
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(300, 0, 'No : '.$kode, 99, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);
        //TANGGAL PENGADAAN
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(300, 0, 'Tanggal : '.$new_date, 99, 1, 'C');
        $pdf->Cell(1,1, '', 0, 1);
        //TANGGAL PENGADAAN
        $pdf->SetLeftMargin(28);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(100, 0, 'Kepada Yth : ', 99, 1, 'L');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 0, $namaSupplier, 99, 1, 'L');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 0, $alamatSupplier, 99, 1, 'L');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 0, $telp, 99, 1, 'L');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        // mencetak string
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 0, 'Mohon untuk disediakan produk-produk berikut ini : ', 99, 5, 'L');
        $pdf->Cell(10, 5, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 5, 'No', 1, 0, 'C');
        $pdf->Cell(65, 5, 'Nama Produk', 1, 0, 'C');
        $pdf->Cell(35, 5, 'Satuan', 1, 0, 'C');
        $pdf->Cell(40, 5, 'Jumlah', 1, 1, 'C');
        $pdf->SetFillColor(193,229,252);
        
        $this->db->select('data_detail_pengadaan.id_detail_pengadaan,data_detail_pengadaan.id_produk_fk,data_produk.nama_produk,data_produk.gambar_produk,data_detail_pengadaan.kode_pengadaan_fk,data_detail_pengadaan.satuan_pengadaan,data_detail_pengadaan.jumlah_pengadaan,data_detail_pengadaan.tanggal_pengadaan');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
        $this->db->from('data_detail_pengadaan');
        $this->db->order_by("data_detail_pengadaan.id_detail_pengadaan desc");
        $this->db->where('kode_pengadaan_fk', $kode);
        $query = $this->db->get();
        $produk = $query->result();
        foreach ($produk as $row) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 5, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(65, 5, $row->nama_produk, 1, 0);
            $pdf->Cell(35, 5, $row->satuan_pengadaan, 1, 0, 'C');
            $pdf->Cell(40, 5, $row->jumlah_pengadaan, 1, 1, 'C');
            $cnt++;
        }
        $pdf->Cell(10, 20, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(279, 0, 'Dicetak Tanggal '.date('d F Y'), 99, 1, 'C');
        $pdf->Output("I","Struk - ".$kode.".pdf");
    }

    function strukLunasProduk($id)
    {
        $kode = $this->db->get_where('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id])->row()->kode_transaksi_penjualan_produk;
        $subtotal = $this->db->get_where('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id])->row()->total_penjualan_produk;
        $diskon = $this->db->get_where('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id])->row()->diskon;
        $total = $this->db->get_where('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id])->row()->total_harga;
        $cnt = 1;
        $pdf = new FPDF('P','mm',array(210,210));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        //HEADER LAPORAN
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Rect(5, 5, 200, 200, 'D');
        $pdf->Image('D:\XAMPP\htdocs\p3l_web\assets\img\headerlaporan.png',7,10,195,0,'PNG');

        //TEXT
        $pdf->Cell(10, 60, '', 0, 1);
        $pdf->Cell(190, 7, 'NOTA LUNAS', 99, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);
        // KODE PENGADDAN
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(300, 0, date('d F Y H:i'), 99, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);
        //TANGGAL PENGADAAN
        $pdf->SetLeftMargin(28);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(100, 0, $kode, 99, 1, 'L');
        $pdf->Cell(10, 10, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 0,'Member : ', 99, 1, 'L');
        $pdf->Cell(150, 0,'CS    : Felix Fernando Wijaya ', 99, 1, 'R');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 0,'Telepon : ', 99, 1, 'L');
        $pdf->Cell(135, 0,'Kasir : Bang wawan ', 99, 1, 'R');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Image('D:\XAMPP\htdocs\p3l_web\assets\img\garis.png',23,110,160,0,'PNG');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(154, 1, 'Produk', 4, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Image('D:\XAMPP\htdocs\p3l_web\assets\img\garis.png',23,125,160,0,'PNG');
        // mencetak string
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->SetLeftMargin(18);
        $pdf->Cell(10, 5, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 5, 'No', 1, 0, 'C');
        $pdf->Cell(65, 5, 'Nama Produk', 1, 0, 'C');
        $pdf->Cell(35, 5, 'Harga', 1, 0, 'C');
        $pdf->Cell(20, 5, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(40, 5, 'Subtotal Per Item', 1, 1, 'C');
        
        $this->db->select('data_detail_penjualan_produk.id_detail_penjualan_produk,data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk,data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_detail_penjualan_produk.subtotal,data_produk.nama_produk,data_produk.gambar_produk,data_produk.harga_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
        $this->db->from('data_detail_penjualan_produk');
        $this->db->order_by("data_detail_penjualan_produk.id_detail_penjualan_produk desc");
        $this->db->where('data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk', $kode);
        $query = $this->db->get();
        $produk = $query->result();
        foreach ($produk as $row) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 5, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(65, 5,$row->nama_produk, 1, 0);
            $pdf->Cell(35, 5,'Rp.   '.$row->harga_produk.',-', 1, 0);
            $pdf->Cell(20, 5, $row->jumlah_produk, 1, 0, 'C');
            $pdf->Cell(40, 5,'Rp.   '.$row->harga_produk*$row->jumlah_produk.',-', 1, 1);
            $cnt++;
        }
        $pdf->SetLeftMargin(134);
        $pdf->Cell(10, 5, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(154, 0, 'Subtotal Rp.   '.$subtotal.',-', 99, 1, 'L');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(154, 0, 'Diskon   Rp.   '.$diskon.',-', 99, 1, 'L');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(154, 0, 'TOTAL  Rp.   '.$total.',-', 99, 1, 'L');
        $pdf->Output("I","[LUNAS] Struk - ".$kode.".pdf");
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