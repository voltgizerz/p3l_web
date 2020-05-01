<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hewan_model extends CI_Model
{
    public function getDataHewan()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataHewanAdmin()
    {
        $this->db->select('id_hewan, nama_hewan, data_hewan.id_jenis_hewan, data_hewan.id_ukuran_hewan, data_hewan.id_customer, tanggal_lahir_hewan, data_hewan.created_date, data_hewan.updated_date, data_hewan.deleted_date,nama_customer, ukuran_hewan,nama_jenis_hewan');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_hewan.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_hewan.id_jenis_hewan');
        $this->db->join('data_customer', 'data_customer.id_customer = data_hewan.id_customer');
        $this->db->where('data_hewan.deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_hewan');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function deleteHewan($id)
    {
        $this->db->db_debug = false;
        if ($this->db->delete('data_hewab', ['id_hewan' => $id]) == false) {
            //INI JIKA DATA INI SEDANG DIGUNAKAN
            $rowAffected = $this->db->affected_rows();
            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }

    public function getHewanId($id)
    {
        return $this->db->get_where('data_hewan', ['id_hewan' => $id])->result_array();
    }

    public function select_customer()
    {
        $this->db->select('*');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_customer');
        $query = $this->db->get();
        return $query;
    }

    public function select_jenis()
    {
        $this->db->select('*');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_jenis_hewan');
        $query = $this->db->get();
        return $query;
    }

    public function select_ukuran()
    {
        $this->db->select('*');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_ukuran_hewan');
        $query = $this->db->get();
        return $query;
    }

    public function cariHewan($berdasarkan,$yangdicari){
        $this->db->select('id_hewan, nama_hewan, data_hewan.id_jenis_hewan, data_hewan.id_ukuran_hewan, data_hewan.id_customer, tanggal_lahir_hewan, data_hewan.created_date, data_hewan.updated_date, data_hewan.deleted_date,nama_customer, ukuran_hewan,nama_jenis_hewan');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_hewan.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_hewan.id_jenis_hewan');
        $this->db->join('data_customer', 'data_customer.id_customer = data_hewan.id_customer');
        $this->db->where('deleted_date','0000-00-00 00:00:00');
        $this->db->from('data_hewan');
        
        switch($berdasarkan){
            case "":
                $this->db->like('nama_hewan',$yangdicari);
                $this->db->or_like('id_hewan',$yangdicari);
                $this->db->or_like('ukuran_hewan',$yangdicari);
                $this->db->or_like('nama_jenis_hewan',$yangdicari);
            break;

            case "id_hewan":
                $this->db->where('id_hewan',$yangdicari);
            
            default:
            $this->db->like($berdasarkan,$yangdicari);
        }
        return $this->db->get();
    }

}