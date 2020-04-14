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
        $this->db->from('data_hewan');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function deleteHewan($id)
    {
        $this->db->where('id_hewan', $id);
        $this->db->delete('data_hewan');
    }

    public function getHewanId($id)
    {
        return $this->db->get_where('data_hewan', ['id_hewan' => $id])->result_array();
    }

    public function select_customer()
    {
        $query = $this->db->get('data_customer');
        return $query;
    }

    public function select_jenis()
    {
        $query = $this->db->get('data_jenis_hewan');
        return $query;
    }

    public function select_ukuran()
    {
        $query = $this->db->get('data_ukuran_hewan');
        return $query;
    }

}