<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JenisHewan_model extends CI_Model
{
    public function getDataJenisHewan()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataJenisHewanAdmin()
    {
        return $this->db->get_where('data_jenis_hewan', ['deleted_date' => '0000-00-00 00:00:00'])->result_array();
    }

    public function deleteJenisHewan($id)
    {
        $this->db->where('id_jenis_hewan', $id);
        $this->db->delete('data_jenis_hewan');
    }

    public function getJenisHewanId($id)
    {
        return $this->db->get_where('data_jenis_hewan', ['id_jenis_hewan' => $id])->result_array();
    }

    public function cariJenisHewan($berdasarkan,$yangdicari){
        $this->db->select('*');
        $this->db->from('data_jenis_hewan');


        switch($berdasarkan){
            case "":
                $this->db->like('nama_jenis_hewan',$yangdicari);
                $this->db->or_like('id_jenis_hewan',$yangdicari);
            break;

            case "id_jenis_hewan":
                $this->db->where('id_jenis_hewan',$yangdicari);
            
            default:
            $this->db->like($berdasarkan,$yangdicari);
        }
        return $this->db->get();
    }
}