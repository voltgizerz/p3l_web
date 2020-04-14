<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Pegawai_model extends CI_Model
{
    public function getDataBeliMobil()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataBeliMobilAdmin()
    {
        return $this->db->get_where('data_pegawai')->result_array();
    }

    public function deleteBuyCars($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('buy_cars');
    }

    public function getBuyCarById($id)
    {
        return $this->db->get_where('buy_cars', ['id' => $id])->result_array();
    }
}