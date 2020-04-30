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
        return $this->db->get_where('data_ukuran_hewan', ['deleted_date' => '0000-00-00 00:00:00'])->result_array();
    }

    public function getDataLogUkuranHewan()
    {
        return $this->db->get_where('data_ukuran_hewan', ['created_date' => '0000-00-00 00:00:00'])->result_array();
    }

    public function deleteUkuranHewan($id)
    {
        $this->db->where('id_ukuran_hewan', $id);
        $this->db->update('data_ukuran_hewan', ['created_date' => '0000-00-00 00:00:00','deleted_date' => date("Y-m-d H:i:s")]);
    }

    public function getUkuranHewanId($id)
    {
        return $this->db->get_where('data_ukuran_hewan', ['id_ukuran_hewan' => $id])->result_array();
    }

    public function cariUkuranHewan($berdasarkan,$yangdicari){
        $this->db->select('*');
        $this->db->from('data_ukuran_hewan');


        switch($berdasarkan){
            case "":
                $this->db->like('ukuran_hewan',$yangdicari);
                $this->db->or_like('id_ukuran_hewan',$yangdicari);
            break;

            case "id_ukuran_hewan":
                $this->db->where('id_ukuran_hewan',$yangdicari);
            
            default:
            $this->db->like($berdasarkan,$yangdicari);
        }
        return $this->db->get();
    }

}