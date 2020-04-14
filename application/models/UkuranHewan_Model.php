<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UkuranHewan_model extends CI_Model
{
    public function getDataUkuranHewan()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataUkuranHewanAdmin()
    {
        return $this->db->get_where('data_ukuran_hewan')->result_array();
    }

    public function deleteUkuranHewan($id)
    {
        $this->db->where('id_ukuran_hewan', $id);
        $this->db->delete('data_ukuran_hewan');
    }

    public function getUkuranHewanId($id)
    {
        return $this->db->get_where('data_ukuran_hewan', ['id_ukuran_hewan' => $id])->result_array();
    }
}