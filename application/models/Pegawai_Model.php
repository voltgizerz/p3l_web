<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{

    public function getDataPegawaiAdmin()
    {
        return $this->db->get_where('data_pegawai', ['deleted_date' => '0000-00-00 00:00:00'])->result_array();
    }

    public function getDataLogPegawai()
    {
        return $this->db->get_where('data_pegawai', ['created_date' => '0000-00-00 00:00:00'])->result_array();
    }

    public function deletePegawai($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_pegawai');
        $this->db->where('id_pegawai', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_pegawai', ['id_pegawai' => $id]) == false) {
            //INI JIKA DATA INI SEDANG DIGUNAKAN
            $rowAffected = $this->db->affected_rows();
            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        } else {
            // DATA BERHASIL DI HAPUS BERARTI TIDAK SEDANG DIGUNAKAN
            $data = [
                'id_pegawai' => $arrTampData[0]['id_pegawai'],
                'nama_pegawai' => $arrTampData[0]['nama_pegawai'],
                'alamat_pegawai' => $arrTampData[0]['alamat_pegawai'],
                'tanggal_lahir_pegawai' => $arrTampData[0]['tanggal_lahir_pegawai'],
                'role_pegawai' => $arrTampData[0]['role_pegawai'],
                'nomor_hp_pegawai' => $arrTampData[0]['nomor_hp_pegawai'],
                'username' => $arrTampData[0]['username'],
                'role_id' => $arrTampData[0]['role_id'],
                'password' => $arrTampData[0]['password'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            // RETURN DATA
            $this->db->insert('data_pegawai', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                ['created_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_pegawai', $id);
            $this->db->update('data_pegawai', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }

    public function deletePermPegawai($id)
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
        $this->db->where('deleted_date','0000-00-00 00:00:00');    

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

    public function restorePegawai($id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $this->db->where('id_pegawai', $id);
        $this->db->update('data_pegawai', ['deleted_date' => '0000-00-00 00:00:00', 'created_date' => date("Y-m-d H:i:s")]);

    }
}