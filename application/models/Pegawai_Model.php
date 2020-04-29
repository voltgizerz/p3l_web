<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{

    public function getDataPegawaiAdmin()
    {
        return $this->db->get_where('data_pegawai')->result_array();
    }

    public function deletePegawai($id)
    {
        $this->db->where('id_pegawai', $id);
        $this->db->delete('data_pegawai');
    }

    public function getPegawaiId($id)
    {
        return $this->db->get_where('data_pegawai', ['id_pegawai' => $id])->result_array();
    }

    public function cariPegawai($berdasarkan,$yangdicari){
        $this->db->select('*');
        $this->db->from('data_pegawai');


        switch($berdasarkan){
            case "":
                $this->db->like('nama_pegawai',$yangdicari);
                $this->db->or_like('id_pegawai',$yangdicari);
                $this->db->or_like('alamat_pegawai',$yangdicari);
                $this->db->or_like('tanggal_lahir_pegawai',$yangdicari);
                $this->db->or_like('role_pegawai',$yangdicari);
                $this->db->or_like('username',$yangdicari);
            break;

            case "id_pegawai":
                $this->db->where('id_pegawai',$yangdicari);
            
            default:
            $this->db->like($berdasarkan,$yangdicari);
        }
        return $this->db->get();
    }
}