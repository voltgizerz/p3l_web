<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaan_model extends CI_Model
{
    public function getDataBeliMobil()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataPengadaanAdmin()
    {
        $this->db->select('data_pengadaan.id_pengadaan,data_pengadaan.kode_pengadaan,data_pengadaan.id_supplier,data_supplier.nama_supplier,data_pengadaan.status as status_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.total AS total_pengadaan,data_pengadaan.created_date,data_pengadaan.updated_date');
        $this->db->join('data_supplier', 'data_supplier.id_supplier = data_pengadaan.id_supplier');
        $this->db->from('data_pengadaan');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getDataDetailPengadaanAdmin($id)
    {
        $data = $this->db->get_where('data_pengadaan', ['id_pengadaan' => $id])->row()->kode_pengadaan;

        $this->db->select('data_detail_pengadaan.id_detail_pengadaan,data_detail_pengadaan.id_produk_fk,data_produk.nama_produk,data_produk.gambar_produk,data_detail_pengadaan.kode_pengadaan_fk,data_detail_pengadaan.satuan_pengadaan,data_detail_pengadaan.jumlah_pengadaan,data_detail_pengadaan.tanggal_pengadaan');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
        $this->db->from('data_detail_pengadaan');
        $this->db->where('kode_pengadaan_fk', $data);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function deletePengadaan($id)
    {
        $data = $this->db->get_where('data_pengadaan', ['id_pengadaan' => $id])->row()->kode_pengadaan;
        $this->db->delete('data_detail_pengadaan', ['kode_pengadaan_fk' => $data]);
        $this->db->delete('data_pengadaan', ['id_pengadaan' => $id]);
    }

    public function getPengadaanId($id)
    {
        $this->db->select('data_pengadaan.id_pengadaan,data_pengadaan.kode_pengadaan,data_pengadaan.id_supplier,data_supplier.nama_supplier,data_pengadaan.status as status_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.total AS total_pengadaan,data_pengadaan.created_date,data_pengadaan.updated_date');
        $this->db->join('data_supplier', 'data_supplier.id_supplier = data_pengadaan.id_supplier');
        $this->db->from('data_pengadaan');
        $this->db->where('id_pengadaan', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getDetailPengadaanId($id)
    {
        $this->db->select('data_detail_pengadaan.id_detail_pengadaan,data_detail_pengadaan.id_produk_fk,data_produk.nama_produk,data_produk.gambar_produk,data_detail_pengadaan.kode_pengadaan_fk,data_detail_pengadaan.satuan_pengadaan,data_detail_pengadaan.jumlah_pengadaan,data_detail_pengadaan.tanggal_pengadaan');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
        $this->db->from('data_detail_pengadaan');
        $this->db->where('id_detail_pengadaan', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function ambilKode()
    {
        date_default_timezone_set("Asia/Bangkok");
        $query = "SHOW TABLE STATUS LIKE 'data_pengadaan'";
        $result = $this->db->query($query)->result();
        $hari = date('d');
        $bln = date('m');
        $thn = date('Y');
        if ($result[0]->Auto_increment > 9) {
            return ("PO-" . $thn . "-" . $bln . "-" . $hari . "-" . $result[0]->Auto_increment);
        } else {
            return ("PO-" . $thn . "-" . $bln . "-" . $hari . "-0" . $result[0]->Auto_increment);
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

    public function select_supplier()
    {
        $this->db->select('*');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_supplier');
        $query = $this->db->get();
        return $query;
    }

    public function select_produk()
    {
        $this->db->select('*');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_produk');
        $query = $this->db->get();
        return $query;
    }

    public function deleteDetailPengadaan($id)
    {
        //AMMBIL KODE TRXNYA DLU
        $kode = $this->db->get_where('data_detail_pengadaan', ['id_detail_pengadaan' => $id])->row()->kode_pengadaan_fk;
        $this->db->delete('data_detail_pengadaan', ['id_detail_pengadaan' => $id]);

        //CARI NILAI TOTAL HARGA UPDATE
        $this->db->select('data_detail_pengadaan.id_produk_fk,data_detail_pengadaan.jumlah_pengadaan,data_produk.harga_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
        $this->db->where('data_detail_pengadaan.kode_pengadaan_fk', $kode);
        $this->db->from('data_detail_pengadaan');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);
        // NILAI TAMPUNG TOTAL HARGA YANG BARU
        $temp = 0;
        for ($i = 0; $i < count($arrTemp); $i++) {
            $temp = $temp + $arrTemp[$i]['jumlah_pengadaan'] * $arrTemp[$i]['harga_produk'];
        }
        //UPDATE NILAI TOTAL PENGADAAN
        $this->db->where('kode_pengadaan', $kode)->update('data_pengadaan', ['total' => $temp, 'updated_date' => date("Y-m-d H:i:s")]);

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
                $this->db->like('kode_pengadaan', $yangdicari);
                break;
                
            case "nama_supplier":
                $this->db->like('nama_supplier', $yangdicari);
                break;
                
            case "status":
                $this->db->like('status', $yangdicari);
                break;
                
            default:
                $this->db->like($berdasarkan, $yangdicari);
        }
        return $this->db->get();
    }

}