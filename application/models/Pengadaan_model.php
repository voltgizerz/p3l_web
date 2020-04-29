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

    public function deletePengadaan($id)
    {
        $data = $this->db->get_where('data_pengadaan', ['id_pengadaan' => $id])->result_array();
        $this->db->delete('data_detail_pengadaan', ['kode_pengadaan_fk' => $data['kode_pengadaan']]);
        $this->db->delete('data_pengadaan', ['id_pengadaan' => $id]);
    }

    public function getPengadaanId($id)
    {
        $this->db->select('data_pengadaan.id_pengadaan,data_pengadaan.kode_pengadaan,data_pengadaan.id_supplier,data_supplier.nama_supplier,data_pengadaan.status as status_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.total AS total_pengadaan,data_pengadaan.created_date,data_pengadaan.updated_date');
        $this->db->join('data_supplier', 'data_supplier.id_supplier = data_pengadaan.id_supplier');
        $this->db->from('data_pengadaan');
        $this->db->where('id_pengadaan',$id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function cariCustomer($berdasarkan,$yangdicari){
        $this->db->select('*');
        $this->db->from('data_customer');


        switch($berdasarkan){
            case "":
                $this->db->like('nama_customer',$yangdicari);
                $this->db->or_like('id_customer',$yangdicari);
            break;

            case "id_customer":
                $this->db->where('id_customer',$yangdicari);
            
            default:
            $this->db->like($berdasarkan,$yangdicari);
        }
        return $this->db->get();
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

    public function select_supplier(){
        $query = $this->db->get('data_supplier');
        return $query;
    }

}