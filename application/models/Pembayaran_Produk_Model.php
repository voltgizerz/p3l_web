<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran_Produk_model extends CI_Model
{

    public function get_count()
    {
        $this->db->select('data_transaksi_penjualan_produk.id_transaksi_penjualan_produk,data_transaksi_penjualan_produk.kode_transaksi_penjualan_produk
        ,data_transaksi_penjualan_produk.tanggal_penjualan_produk,
        data_transaksi_penjualan_produk.tanggal_pembayaran_produk,data_transaksi_penjualan_produk.diskon,
        data_transaksi_penjualan_produk.total_penjualan_produk,data_transaksi_penjualan_produk.total_harga,data_transaksi_penjualan_produk.status_penjualan,data_transaksi_penjualan_produk.status_pembayaran,data_transaksi_penjualan_produk.id_cs,
        data_transaksi_penjualan_produk.id_kasir,data_transaksi_penjualan_produk.created_date,data_transaksi_penjualan_produk.updated_date,
        data_pegawai.nama_pegawai AS nama_cs, a.nama_pegawai AS nama_kasir');
        $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = data_transaksi_penjualan_produk.id_cs');
        $this->db->join('data_pegawai a', 'a.id_pegawai = data_transaksi_penjualan_produk.id_kasir');
        $this->db->from('data_transaksi_penjualan_produk');
        $this->db->where('data_transaksi_penjualan_produk.status_penjualan', 'Sudah Selesai');
        $this->db->order_by("data_transaksi_penjualan_produk.id_transaksi_penjualan_produk desc");
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDataPembayaranProdukAdmin($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->select('data_transaksi_penjualan_produk.id_transaksi_penjualan_produk,data_transaksi_penjualan_produk.kode_transaksi_penjualan_produk
        ,data_transaksi_penjualan_produk.tanggal_penjualan_produk,
        data_transaksi_penjualan_produk.tanggal_pembayaran_produk,data_transaksi_penjualan_produk.diskon,
        data_transaksi_penjualan_produk.total_penjualan_produk,data_transaksi_penjualan_produk.total_harga,data_transaksi_penjualan_produk.status_penjualan,data_transaksi_penjualan_produk.status_pembayaran,data_transaksi_penjualan_produk.id_cs,
        data_transaksi_penjualan_produk.id_kasir,data_transaksi_penjualan_produk.created_date,data_transaksi_penjualan_produk.updated_date,
        data_pegawai.nama_pegawai AS nama_cs, a.nama_pegawai AS nama_kasir');
        $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = data_transaksi_penjualan_produk.id_cs');
        $this->db->join('data_pegawai a', 'a.id_pegawai = data_transaksi_penjualan_produk.id_kasir');
        $this->db->from('data_transaksi_penjualan_produk');
        $this->db->where('data_transaksi_penjualan_produk.status_penjualan', 'Sudah Selesai');
        $this->db->order_by("data_transaksi_penjualan_produk.id_transaksi_penjualan_produk desc");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getDataDetailPenjualanProdukAdmin($id)
    {
        $data = $this->db->get_where('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id])->row()->kode_transaksi_penjualan_produk;

        $this->db->select('data_detail_penjualan_produk.id_detail_penjualan_produk,data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk,data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_detail_penjualan_produk.subtotal,data_produk.nama_produk,data_produk.gambar_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
        $this->db->where('kode_transaksi_penjualan_produk_fk', $data);
        $this->db->from('data_detail_penjualan_produk');
        $this->db->order_by("data_detail_penjualan_produk.id_detail_penjualan_produk desc");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function deletePenjualanProduk($id)
    {
        $data = $this->db->get_where('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id])->row()->kode_transaksi_penjualan_produk;
        $this->db->delete('data_detail_penjualan_produk', ['kode_transaksi_penjualan_produk_fk' => $data]);
        $this->db->delete('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id]);
    }

    public function getPembayaranProdukId($id)
    {
        $this->db->select('data_transaksi_penjualan_produk.id_transaksi_penjualan_produk,data_transaksi_penjualan_produk.kode_transaksi_penjualan_produk
        ,data_transaksi_penjualan_produk.tanggal_penjualan_produk,
        data_transaksi_penjualan_produk.tanggal_pembayaran_produk,data_transaksi_penjualan_produk.diskon,
        data_transaksi_penjualan_produk.total_penjualan_produk,data_transaksi_penjualan_produk.total_harga,data_transaksi_penjualan_produk.status_penjualan,data_transaksi_penjualan_produk.status_pembayaran,data_transaksi_penjualan_produk.id_cs,
        data_transaksi_penjualan_produk.id_kasir,data_transaksi_penjualan_produk.created_date,data_transaksi_penjualan_produk.updated_date,
        data_pegawai.nama_pegawai AS nama_cs, a.nama_pegawai AS nama_kasir');
        $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = data_transaksi_penjualan_produk.id_cs');
        $this->db->join('data_pegawai a', 'a.id_pegawai = data_transaksi_penjualan_produk.id_kasir');
        $this->db->where('id_transaksi_penjualan_produk', $id);
        $this->db->from('data_transaksi_penjualan_produk');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getDetailPenjualanProdukId($id)
    {
        $this->db->select('data_detail_penjualan_produk.id_detail_penjualan_produk,data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk,data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_detail_penjualan_produk.subtotal,data_produk.nama_produk,data_produk.gambar_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
        $this->db->from('data_detail_penjualan_produk');
        $this->db->where('id_detail_penjualan_produk', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cariPembayaranProduk($berdasarkan, $yangdicari)
    {
        $this->db->select('data_transaksi_penjualan_produk.id_transaksi_penjualan_produk,data_transaksi_penjualan_produk.kode_transaksi_penjualan_produk
        ,data_transaksi_penjualan_produk.tanggal_penjualan_produk,
        data_transaksi_penjualan_produk.tanggal_pembayaran_produk,data_transaksi_penjualan_produk.diskon,
        data_transaksi_penjualan_produk.total_penjualan_produk,data_transaksi_penjualan_produk.total_harga,data_transaksi_penjualan_produk.status_penjualan,data_transaksi_penjualan_produk.status_pembayaran,data_transaksi_penjualan_produk.id_cs,
        data_transaksi_penjualan_produk.id_kasir,data_transaksi_penjualan_produk.created_date,data_transaksi_penjualan_produk.updated_date,
        data_pegawai.nama_pegawai AS nama_cs, a.nama_pegawai AS nama_kasir');
        $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = data_transaksi_penjualan_produk.id_cs');
        $this->db->join('data_pegawai a', 'a.id_pegawai = data_transaksi_penjualan_produk.id_kasir');
        $this->db->from('data_transaksi_penjualan_produk');
        $this->db->where('data_transaksi_penjualan_produk.status_penjualan', 'Sudah Selesai');
        switch ($berdasarkan) {
            case "":
                $this->db->like('data_transaksi_penjualan_produk.kode_transaksi_penjualan_produk', $yangdicari);
                $this->db->or_like('a.nama_pegawai', $yangdicari);
                $this->db->where('data_transaksi_penjualan_produk.status_penjualan', 'Sudah Selesai');

                $this->db->order_by("data_transaksi_penjualan_produk.id_transaksi_penjualan_produk desc");
                break;

            case "kode_penjualan":
                $this->db->like('data_transaksi_penjualan_produk.kode_transaksi_penjualan_produk', $yangdicari);
                $this->db->where('data_transaksi_penjualan_produk.status_penjualan', 'Sudah Selesai');
                $this->db->order_by("data_transaksi_penjualan_produk.id_transaksi_penjualan_produk desc");
                break;

            case "nama_kasir":
                $this->db->like('a.nama_pegawai', $yangdicari);
                $this->db->where('data_transaksi_penjualan_produk.status_penjualan', 'Sudah Selesai');
                $this->db->where('data_pegawai.nama_pegawai !=', $yangdicari);
                $this->db->order_by("data_transaksi_penjualan_produk.id_transaksi_penjualan_produk desc");
                break;

            case "status_pembayaran":
                $this->db->where('data_transaksi_penjualan_produk.status_pembayaran', $yangdicari);
                $this->db->where('data_transaksi_penjualan_produk.status_penjualan', 'Sudah Selesai');
                $this->db->order_by("data_transaksi_penjualan_produk.id_transaksi_penjualan_produk desc");
                break;

            default:
                $this->db->like($berdasarkan, $yangdicari);
                $this->db->where('data_transaksi_penjualan_produk.status_penjualan', 'Sudah Selesai');
                $this->db->order_by("data_transaksi_penjualan_produk.id_transaksi_penjualan_produk desc");
        }
        return $this->db->get();
    }

    public function ambilKode()
    {
        date_default_timezone_set("Asia/Bangkok");
        $query = "SHOW TABLE STATUS LIKE 'data_transaksi_penjualan_produk'";
        $result = $this->db->query($query)->result();
        $hari = date('d');
        $bln = date('m');
        $thn = date('y');
        if ($result[0]->Auto_increment > 9) {
            return ("PR-" . $hari . $bln . $thn . "-" . $result[0]->Auto_increment);
        } else {
            return ("PR-" . $hari . $bln . $thn . "-0" . $result[0]->Auto_increment);
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

    public function select_produk()
    {
        $this->db->select('*');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_produk');
        $query = $this->db->get();
        return $query;
    }


    public function deleteDetailPenjualanProduk($id)
    {

        $kode = $this->db->get_where('data_detail_penjualan_produk', ['id_detail_penjualan_produk' => $id])->row()->kode_transaksi_penjualan_produk_fk;
        $this->db->delete('data_detail_penjualan_produk', ['id_detail_penjualan_produk' => $id]);

        $this->db->delete('data_detail_penjualan_produk', ['id_detail_penjualan_produk' => $id]);
        $rowdelete = $this->db->affected_rows();

        //CARI NILAI TOTAL HARGA UPDATE
        $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
        $this->db->where('data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk', $kode);
        $this->db->from('data_detail_penjualan_produk');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);

        // NILAI TAMPUNG TOTAL HARGA YANG BARU
        $temp = 0;
        for ($i = 0; $i < count($arrTemp); $i++) {
            $temp = $temp + $arrTemp[$i]['jumlah_produk'] * $arrTemp[$i]['harga_produk'];
        }
        //UPDATE NILAI TOTAL PENGADAAN
        $this->db->where('kode_transaksi_penjualan_produk', $kode)->update('data_transaksi_penjualan_produk', ['total_penjualan_produk' => $temp]);
    }

    public function getSemuaNoHpOwner()
    {
        $this->db->select('nomor_hp_pegawai');
        $this->db->where('role_pegawai', 'Owner');
        $this->db->from('data_pegawai');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);
        return $arrTemp; 
    }
}
