<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_Layanan_model extends CI_Model
{
    public function getDataBeliMobil()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataPenjualanLayananAdmin()
    {
        $this->db->select('data_transaksi_penjualan_jasa_layanan.id_transaksi_penjualan_jasa_layanan,
            data_transaksi_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan,
            data_transaksi_penjualan_jasa_layanan.id_hewan,
            data_transaksi_penjualan_jasa_layanan.tanggal_penjualan_jasa_layanan,
            data_transaksi_penjualan_jasa_layanan.tanggal_pembayaran_jasa_layanan,status_layanan,
            data_transaksi_penjualan_jasa_layanan.status_penjualan,
            data_transaksi_penjualan_jasa_layanan.status_pembayaran,
            data_transaksi_penjualan_jasa_layanan.diskon,total_penjualan_jasa_layanan,
            data_transaksi_penjualan_jasa_layanan.id_cs,
            data_transaksi_penjualan_jasa_layanan.id_kasir,
            data_transaksi_penjualan_jasa_layanan.total_harga,
            data_transaksi_penjualan_jasa_layanan.created_date,
            data_transaksi_penjualan_jasa_layanan.updated_date,
            data_hewan.nama_hewan,
            data_pegawai.nama_pegawai AS nama_cs,
            a.nama_pegawai AS nama_kasir ');
        $this->db->join('data_hewan', 'data_hewan.id_hewan = data_transaksi_penjualan_jasa_layanan.id_hewan');
        $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = data_transaksi_penjualan_jasa_layanan.id_cs');
        $this->db->join('data_pegawai a', 'a.id_pegawai = data_transaksi_penjualan_jasa_layanan.id_kasir');
        $this->db->from('data_transaksi_penjualan_jasa_layanan');
        $this->db->order_by("data_transaksi_penjualan_jasa_layanan.id_transaksi_penjualan_jasa_layanan desc");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getDataDetailPenjualanLayananAdmin($id)
    {
        $data = $this->db->get_where('data_transaksi_penjualan_jasa_layanan', ['id_transaksi_penjualan_jasa_layanan' => $id])->row()->kode_transaksi_penjualan_jasa_layanan;
        $this->db->select('data_detail_penjualan_jasa_layanan.id_detail_penjualan_jasa_layanan,
        data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk,
        data_detail_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan_fk,
        data_detail_penjualan_jasa_layanan.jumlah_jasa_layanan,
        data_detail_penjualan_jasa_layanan.subtotal,
        data_jasa_layanan.nama_jasa_layanan,
        a.id_jenis_hewan AS id_jenis_hewan,
        b.id_ukuran_hewan AS id_ukuran_hewan,
        data_jenis_hewan.nama_jenis_hewan,
        data_ukuran_hewan.ukuran_hewan');
        $this->db->join('data_jasa_layanan', 'data_jasa_layanan.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
        $this->db->join('data_jasa_layanan a', 'a.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
        $this->db->join('data_jasa_layanan b', 'b.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = b.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = a.id_jenis_hewan');
        $this->db->where('kode_transaksi_penjualan_jasa_layanan_fk', $data);
        $this->db->from('data_detail_penjualan_jasa_layanan');
        $this->db->order_by("data_detail_penjualan_jasa_layanan.id_detail_penjualan_jasa_layanan desc");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function deletePenjualanLayanan($id)
    {
        $data = $this->db->get_where('data_transaksi_penjualan_jasa_layanan', ['id_transaksi_penjualan_jasa_layanan' => $id])->row()->kode_transaksi_penjualan_jasa_layanan;
        $this->db->delete('data_detail_penjualan_jasa_layanan', ['kode_transaksi_penjualan_jasa_layanan_fk' => $data]);
        $this->db->delete('data_transaksi_penjualan_jasa_layanan', ['id_transaksi_penjualan_jasa_layanan' => $id]);
    }

    public function getPenjualanLayananId($id)
    {
        $this->db->select('data_transaksi_penjualan_jasa_layanan.id_transaksi_penjualan_jasa_layanan,
        data_transaksi_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan,
        data_transaksi_penjualan_jasa_layanan.id_hewan,
        data_transaksi_penjualan_jasa_layanan.tanggal_penjualan_jasa_layanan,
        data_transaksi_penjualan_jasa_layanan.tanggal_pembayaran_jasa_layanan,status_layanan,
        data_transaksi_penjualan_jasa_layanan.status_penjualan,
        data_transaksi_penjualan_jasa_layanan.status_pembayaran,
        data_transaksi_penjualan_jasa_layanan.diskon,total_penjualan_jasa_layanan,
        data_transaksi_penjualan_jasa_layanan.id_cs,
        data_transaksi_penjualan_jasa_layanan.id_kasir,
        data_transaksi_penjualan_jasa_layanan.total_harga,
        data_transaksi_penjualan_jasa_layanan.created_date,
        data_transaksi_penjualan_jasa_layanan.updated_date,
        data_hewan.nama_hewan,
        data_pegawai.nama_pegawai AS nama_cs,
        a.nama_pegawai AS nama_kasir ');
        $this->db->join('data_hewan', 'data_hewan.id_hewan = data_transaksi_penjualan_jasa_layanan.id_hewan');
        $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = data_transaksi_penjualan_jasa_layanan.id_cs');
        $this->db->join('data_pegawai a', 'a.id_pegawai = data_transaksi_penjualan_jasa_layanan.id_kasir');
        $this->db->where('id_transaksi_penjualan_jasa_layanan', $id);
        $this->db->from('data_transaksi_penjualan_jasa_layanan');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getDetailPenjualanLayananId($id)
    {
        $data = $this->db->get_where('data_transaksi_penjualan_jasa_layanan', ['id_transaksi_penjualan_jasa_layanan' => $id])->row()->kode_transaksi_penjualan_jasa_layanan;
        $this->db->select('data_detail_penjualan_jasa_layanan.id_detail_penjualan_jasa_layanan,
        data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk,
        data_detail_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan_fk,
        data_detail_penjualan_jasa_layanan.jumlah_jasa_layanan,
        data_detail_penjualan_jasa_layanan.subtotal,
        data_jasa_layanan.nama_jasa_layanan,
        a.id_jenis_hewan AS id_jenis_hewan,
        b.id_ukuran_hewan AS id_ukuran_hewan,
        data_jenis_hewan.nama_jenis_hewan,
        data_ukuran_hewan.ukuran_hewan');
        $this->db->join('data_jasa_layanan', 'data_jasa_layanan.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
        $this->db->join('data_jasa_layanan a', 'a.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
        $this->db->join('data_jasa_layanan b', 'b.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = b.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = a.id_jenis_hewan');
        $this->db->where('id_detail_penjualan_jasa_layanan', $id);
        $this->db->from('data_detail_penjualan_jasa_layanan');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cariPenjualanLayanan($berdasarkan, $yangdicari)
    {
        $this->db->select('data_transaksi_penjualan_jasa_layanan.id_transaksi_penjualan_jasa_layanan,
        data_transaksi_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan,
        data_transaksi_penjualan_jasa_layanan.id_hewan,
        data_transaksi_penjualan_jasa_layanan.tanggal_penjualan_jasa_layanan,
        data_transaksi_penjualan_jasa_layanan.tanggal_pembayaran_jasa_layanan,status_layanan,
        data_transaksi_penjualan_jasa_layanan.status_penjualan,
        data_transaksi_penjualan_jasa_layanan.status_pembayaran,
        data_transaksi_penjualan_jasa_layanan.diskon,total_penjualan_jasa_layanan,
        data_transaksi_penjualan_jasa_layanan.id_cs,
        data_transaksi_penjualan_jasa_layanan.id_kasir,
        data_transaksi_penjualan_jasa_layanan.total_harga,
        data_transaksi_penjualan_jasa_layanan.created_date,
        data_transaksi_penjualan_jasa_layanan.updated_date,
        data_hewan.nama_hewan,
        data_pegawai.nama_pegawai AS nama_cs,
        a.nama_pegawai AS nama_kasir ');
        $this->db->join('data_hewan', 'data_hewan.id_hewan = data_transaksi_penjualan_jasa_layanan.id_hewan');
        $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = data_transaksi_penjualan_jasa_layanan.id_cs');
        $this->db->join('data_pegawai a', 'a.id_pegawai = data_transaksi_penjualan_jasa_layanan.id_kasir');
        $this->db->from('data_transaksi_penjualan_jasa_layanan');

        switch ($berdasarkan) {
            case "":
                $this->db->like('kode_transaksi_penjualan_jasa_layanan', $yangdicari);
                $this->db->or_like('data_pegawai.nama_pegawai', $yangdicari);
                $this->db->or_like('data_transaksi_penjualan_jasa_layanan.status_penjualan', $yangdicari);
                $this->db->or_like('data_transaksi_penjualan_jasa_layanan.status_penjualan', $yangdicari);
                $this->db->or_like('data_hewan.nama_hewan', $yangdicari);
                break;

            case "kode_penjualan":
                $this->db->like('data_transaksi_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan', $yangdicari);
                break;

            case "nama_cs":
                $this->db->like('data_pegawai.nama_pegawai', $yangdicari);
                break;

            case "nama_hewan":
                $this->db->like('data_hewan.nama_hewan', $yangdicari);
                break;
            default:
                $this->db->like($berdasarkan, $yangdicari);
        }
        return $this->db->get();
    }

    public function ambilKode()
    {
        date_default_timezone_set("Asia/Bangkok");
        $query = "SHOW TABLE STATUS LIKE 'data_transaksi_penjualan_jasa_layanan'";
        $result = $this->db->query($query)->result();
        $hari = date('d');
        $bln = date('m');
        $thn = date('y');
        if ($result[0]->Auto_increment > 9) {
            return ("LY-" . $hari . $bln . $thn . "-" . $result[0]->Auto_increment);
        } else {
            return ("LY-" . $hari . $bln . $thn . "-0" . $result[0]->Auto_increment);
        }
    }

    public function totalBayarPengadaan($kode)
    {
        $this->db->select('data_detail_pengadaan.id_produk_fk,data_detail_pengadaan.jumlah_pengadaan,data_produk.harga_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
        $this->db->where('data_detail_pengadaan.kode_pengadaan_fk', $kode);
        $this->db->from('data_detail_pengadaan');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);
        $temp = 0;
        for ($i = 0; $i < count($arrTemp); $i++) {
            $temp = $temp + $arrTemp[$i]['jumlah_pengadaan'] * $arrTemp[$i]['harga_produk'];
        }
        return $temp;
    }

    public function select_hewan()
    {
        $this->db->select('data_hewan.id_hewan,data_hewan.nama_hewan, data_hewan.id_jenis_hewan, data_hewan.id_ukuran_hewan, data_hewan.id_customer, data_hewan.tanggal_lahir_hewan, data_hewan.created_date, data_hewan.updated_date, data_hewan.deleted_date,data_jenis_hewan.nama_jenis_hewan, data_ukuran_hewan.ukuran_hewan,data_customer.nama_customer');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_hewan.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_hewan.id_jenis_hewan');
        $this->db->join('data_customer', 'data_customer.id_customer = data_hewan.id_customer');
        $this->db->where('data_hewan.deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_hewan');
        $this->db->order_by("data_hewan.nama_hewan asc");
        $query = $this->db->get();
        return $query;
    }

    public function select_layanan()
    {
        $this->db->select('data_jasa_layanan.id_jasa_layanan,data_jasa_layanan.nama_jasa_layanan,data_jasa_layanan.harga_jasa_layanan,data_jasa_layanan.id_jenis_hewan,data_jasa_layanan.id_ukuran_hewan,data_jasa_layanan.created_date,data_jasa_layanan.updated_date,data_jasa_layanan.deleted_date,data_ukuran_hewan.ukuran_hewan,data_jenis_hewan.nama_jenis_hewan');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_jasa_layanan.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_jasa_layanan.id_jenis_hewan');
        $this->db->where('data_jasa_layanan.deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_jasa_layanan');
        $this->db->order_by("data_jasa_layanan.nama_jasa_layanan asc");
        $query = $this->db->get();
        return $query;
    }

    public function cariPengadaan($berdasarkan, $yangdicari)
    {
        $this->db->select('data_pengadaan.id_pengadaan,data_pengadaan.kode_pengadaan,data_pengadaan.id_supplier,data_supplier.nama_supplier,data_pengadaan.status as status_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.total AS total_pengadaan,data_pengadaan.created_date,data_pengadaan.updated_date');
        $this->db->join('data_supplier', 'data_supplier.id_supplier = data_pengadaan.id_supplier');
        $this->db->from('data_pengadaan');

        switch ($berdasarkan) {
            case "":
                $this->db->like('kode_pengadaan', $yangdicari);
                $this->db->or_like('nama_supplier', $yangdicari);
                $this->db->or_like('status', $yangdicari);

                break;

            case "kode_pengadaan":
                $this->db->where('kode_pengadaan', $yangdicari);

            default:
                $this->db->like($berdasarkan, $yangdicari);
        }
        return $this->db->get();
    }

    public function deleteDetailPenjualanLayanan($id)
    {

        $kode = $this->db->get_where('data_detail_penjualan_jasa_layanan', ['id_detail_penjualan_jasa_layanan' => $id])->row()->kode_transaksi_penjualan_jasa_layanan_fk;
        $this->db->delete('data_detail_penjualan_jasa_layanan', ['id_detail_penjualan_jasa_layanan' => $id]);

        $this->db->delete('data_detail_penjualan_jasa_layanan', ['id_detail_penjualan_jasa_layanan' => $id]);
        $rowdelete = $this->db->affected_rows();

        //CARI NILAI TOTAL HARGA UPDATE
        $this->db->select('data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk,data_detail_penjualan_jasa_layanan.jumlah_jasa_layanan,data_jasa_layanan.harga_jasa_layanan');
        $this->db->join('data_jasa_layanan', 'data_jasa_layanan.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
        $this->db->where('data_detail_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan_fk', $kode);
        $this->db->from('data_detail_penjualan_jasa_layanan');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);

        $this->db->where('kode_transaksi_penjualan_jasa_layanan', $kode)->update('data_transaksi_penjualan_jasa_layanan', ['updated_date' => date("Y-m-d H:i:s")]);

        // NILAI TAMPUNG TOTAL HARGA YANG BARU
        $temp = 0;
        for ($i = 0; $i < count($arrTemp); $i++) {
            $temp = $temp + $arrTemp[$i]['jumlah_jasa_layanan'] * $arrTemp[$i]['harga_jasa_layanan'];
        }
        //UPDATE NILAI TOTAL PENJUALAN JASA LAYANAN
        $this->db->where('kode_transaksi_penjualan_jasa_layanan', $kode)->update('data_transaksi_penjualan_jasa_layanan', ['total_penjualan_jasa_layanan' => $temp]);

    }
}