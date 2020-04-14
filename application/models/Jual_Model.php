<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Jual_model extends CI_Model
{
    public function getDataJualMobil()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('sell_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }


    public function getDataJualMobilAdmin()
    {

        return $this->db->get_where('sell_cars')->result_array();
    }



    public function deleteJualMobil($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('sell_cars');
    }

    public function getJualMobilById($id)
    {
        return $this->db->get_where('sell_cars', ['id' => $id])->result_array();
    }
}
