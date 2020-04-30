<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Customer_model extends CI_Model
{
    public function getDataBeliMobil()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataCustomerAdmin()
    {
        return $this->db->get_where('data_customer', ['deleted_date' => '0000-00-00 00:00:00'])->result_array();
    }

    public function deleteCustomer($id)
    {
        $this->db->where('id_customer', $id);
        $this->db->delete('data_customer');
    }

    public function getCustomerId($id)
    {
        return $this->db->get_where('data_customer', ['id_customer' => $id])->result_array();
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

}