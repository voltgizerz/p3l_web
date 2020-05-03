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
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_ukuran_hewan');
        $this->db->where('id_ukuran_hewan', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_ukuran_hewan', ['id_ukuran_hewan' => $id]) == false) {
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
                'id_ukuran_hewan' => $arrTampData[0]['id_ukuran_hewan'],
                'ukuran_hewan' => $arrTampData[0]['ukuran_hewan'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            // RETURN DATA
            $this->db->insert('data_ukuran_hewan', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                ['created_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_ukuran_hewan', $id);
            $this->db->update('data_ukuran_hewan', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }

    public function deletePermUkuranHewan($id)
    {
        $this->db->where('id_ukuran_hewan', $id);
        $this->db->delete('data_ukuran_hewan');
    }

    public function getUkuranHewanId($id)
    {
        return $this->db->get_where('data_ukuran_hewan', ['id_ukuran_hewan' => $id])->result_array();
    }

    public function cariUkuranHewan($berdasarkan, $yangdicari)
    {
        $this->db->select('*');
        $this->db->from('data_ukuran_hewan');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');

        switch ($berdasarkan) {
            case "":
                $this->db->like('ukuran_hewan', $yangdicari);
                $this->db->or_like('id_ukuran_hewan', $yangdicari);
                break;

            case "id_ukuran_hewan":
                $this->db->where('id_ukuran_hewan', $yangdicari);
                break;
            default:
                $this->db->like($berdasarkan, $yangdicari);
        }
        return $this->db->get();
    }

    public function restoreUkuranHewan($id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $this->db->where('id_ukuran_hewan', $id);
        $this->db->update('data_ukuran_hewan', ['deleted_date' => '0000-00-00 00:00:00', 'created_date' => date("Y-m-d H:i:s")]);

    }

}