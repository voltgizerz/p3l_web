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

    public function getDataLogJenisHewan()
    {
        return $this->db->get_where('data_jenis_hewan', ['created_date' => '0000-00-00 00:00:00'])->result_array();
    }

    public function deleteJenisHewan($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_jenis_hewan');
        $this->db->where('id_jenis_hewan', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_jenis_hewan', ['id_jenis_hewan' => $id]) == false) {
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
                'id_jenis_hewan' => $arrTampData[0]['id_jenis_hewan'],
                'nama_jenis_hewan' => $arrTampData[0]['nama_jenis_hewan'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            // RETURN DATA
            $this->db->insert('data_jenis_hewan', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                [
                    'created_date' => date("0000:00:0:00:00"),
                    'deleted_date' => date("Y-m-d H:i:s"),
                ];

            $this->db->where('id_jenis_hewan', $id);
            $this->db->update('data_jenis_hewan', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }

    public function deletePermJenisHewan($id)
    {
        $this->db->where('id_jenis_hewan', $id);
        $this->db->delete('data_jenis_hewan');
    }

    public function getJenisHewanId($id)
    {
        return $this->db->get_where('data_jenis_hewan', ['id_jenis_hewan' => $id])->result_array();
    }

    public function cariJenisHewan($berdasarkan, $yangdicari)
    {
        $this->db->select('*');
        $this->db->from('data_jenis_hewan');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');

        switch ($berdasarkan) {
            case "":
                $this->db->like('nama_jenis_hewan', $yangdicari);
                $this->db->or_like('id_jenis_hewan', $yangdicari);
                break;

            case "id_jenis_hewan":
                $this->db->where('id_jenis_hewan', $yangdicari);

            default:
                $this->db->like($berdasarkan, $yangdicari);
        }
        return $this->db->get();
    }

    public function restoreJenisHewan($id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $this->db->where('id_jenis_hewan', $id);
        $this->db->update('data_jenis_hewan', ['deleted_date' => '0000-00-00 00:00:00', 'created_date' => date("Y-m-d H:i:s")]);
    }
}
