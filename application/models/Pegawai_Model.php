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

    public function getDataPegawaiAdmin()
    {
        return $this->db->get_where('data_pegawai')->result_array();
    }

    public function deletePegawai($id)
    {
        $this->db->where('id_pegawai', $id);
        $this->db->delete('data_pegawai');
    }

    public function getBuyCarById($id)
    {
        return $this->db->get_where('data_pegawai', ['id_pegawai' => $id])->result_array();
    }
}