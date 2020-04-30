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
        return $this->db->get_where('data_supplier', ['deleted_date' => '0000-00-00 00:00:00'])->result_array();
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

    public function cariSupplier($berdasarkan,$yangdicari){
        $this->db->select('*');
        $this->db->from('data_supplier');


        switch($berdasarkan){
            case "":
                $this->db->like('nama_supplier',$yangdicari);
                $this->db->or_like('data_supplier',$yangdicari);
            break;

            case "data_supplier":
                $this->db->where('data_supplier',$yangdicari);
            
            default:
            $this->db->like($berdasarkan,$yangdicari);
        }
        return $this->db->get();
    }
}