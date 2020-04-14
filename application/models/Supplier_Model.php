<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Supplier_model extends CI_Model
{
    public function getDataBeliMobil()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataSupplierAdmin()
    {
        return $this->db->get_where('data_supplier')->result_array();
    }

    public function deleteSupplier($id)
    {
        $this->db->where('id_supplier', $id);
        $this->db->delete('data_supplier');
    }

    public function getSupplierId($id)
    {
        return $this->db->get_where('data_supplier', ['id_supplier' => $id])->result_array();
    }
}