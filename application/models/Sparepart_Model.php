<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Sparepart_model extends CI_Model
{
    public function getDataBeliSparepart()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_sparepart', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataBeliSparepartAdmin()
    {
        return $this->db->get_where('buy_sparepart')->result_array();
    }

    

    public function deleteBuySparepart($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('buy_sparepart');
    }

    public function getBuySparepartById($id)
    {
        return $this->db->get_where('buy_sparepart', ['id' => $id])->result_array();
    }
}
