<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jasa_Layanan_model extends CI_Model
{
    public function getDataJasaLayanan()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataLogLayanan()
    {

        $this->db->select('data_jasa_layanan.id_jasa_layanan,data_jasa_layanan.nama_jasa_layanan,data_jasa_layanan.harga_jasa_layanan,data_jasa_layanan.id_jenis_hewan,data_jasa_layanan.id_ukuran_hewan,data_jasa_layanan.created_date,data_jasa_layanan.updated_date,data_jasa_layanan.deleted_date,data_ukuran_hewan.ukuran_hewan,data_jenis_hewan.nama_jenis_hewan');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_jasa_layanan.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_jasa_layanan.id_jenis_hewan');
        $this->db->where('data_jasa_layanan.created_date', '0000:00:0:00:00');
        $this->db->from('data_jasa_layanan');
        $this->db->order_by("data_jasa_layanan.id_jasa_layanan desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDataJasaLayananAdmin()
    {
        $this->db->select('data_jasa_layanan.id_jasa_layanan,data_jasa_layanan.nama_jasa_layanan,data_jasa_layanan.harga_jasa_layanan,data_jasa_layanan.id_jenis_hewan,data_jasa_layanan.id_ukuran_hewan,data_jasa_layanan.created_date,data_jasa_layanan.updated_date,data_jasa_layanan.deleted_date,data_ukuran_hewan.ukuran_hewan,data_jenis_hewan.nama_jenis_hewan');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_jasa_layanan.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_jasa_layanan.id_jenis_hewan');
        $this->db->where('data_jasa_layanan.deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_jasa_layanan');
        $this->db->order_by("data_jasa_layanan.id_jasa_layanan desc");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function deleteJasaLayanan($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_jasa_layanan');
        $this->db->where('id_jasa_layanan', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_jasa_layanan', ['id_jasa_layanan' => $id]) == false) {
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
                'id_jasa_layanan' => $arrTampData[0]['id_jasa_layanan'],
                'nama_jasa_layanan' => $arrTampData[0]['nama_jasa_layanan'],
                'harga_jasa_layanan' => $arrTampData[0]['harga_jasa_layanan'],
                'id_jenis_hewan' => $arrTampData[0]['id_jenis_hewan'],
                'id_ukuran_hewan' => $arrTampData[0]['id_ukuran_hewan'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            // RETURN DATA
            $this->db->insert('data_jasa_layanan', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                [
                    'created_date' => date("0000:00:0:00:00"),
                    'deleted_date' => date("Y-m-d H:i:s"),
                ];

            $this->db->where('id_jasa_layanan', $id);
            $this->db->update('data_jasa_layanan', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }

    public function deletePermJasaLayanan($id)
    {
        $this->db->where('id_jasa_layanan', $id);
        $this->db->delete('data_jasa_layanan');
    }

    public function getJasaLayananId($id)
    {

        $this->db->select('data_jasa_layanan.id_jasa_layanan,data_jasa_layanan.nama_jasa_layanan,data_jasa_layanan.harga_jasa_layanan,data_jasa_layanan.id_jenis_hewan,data_jasa_layanan.id_ukuran_hewan,data_jasa_layanan.created_date,data_jasa_layanan.updated_date,data_jasa_layanan.deleted_date,data_ukuran_hewan.ukuran_hewan,data_jenis_hewan.nama_jenis_hewan');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_jasa_layanan.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_jasa_layanan.id_jenis_hewan');
        $this->db->where('id_jasa_layanan', $id);
        $this->db->from('data_jasa_layanan');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function select_jenis()
    {
        $this->db->select('*');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_jenis_hewan');
        $query = $this->db->get();
        return $query;
    }

    public function select_ukuran()
    {
        $this->db->select('*');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_ukuran_hewan');
        $query = $this->db->get();
        return $query;
    }

    public function cariJasaLayanan($berdasarkan, $yangdicari)
    {
        $this->db->select('data_jasa_layanan.id_jasa_layanan,data_jasa_layanan.nama_jasa_layanan,data_jasa_layanan.harga_jasa_layanan,data_jasa_layanan.id_jenis_hewan,data_jasa_layanan.id_ukuran_hewan,data_jasa_layanan.created_date,data_jasa_layanan.updated_date,data_jasa_layanan.deleted_date,data_ukuran_hewan.ukuran_hewan,data_jenis_hewan.nama_jenis_hewan');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_jasa_layanan.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_jasa_layanan.id_jenis_hewan');
        $this->db->where('data_jasa_layanan.deleted_date', '0000-00-00 00:00:00');
        $this->db->from('data_jasa_layanan');

        switch ($berdasarkan) {
            case "":
                $this->db->like('nama_jasa_layanan', $yangdicari);
                $this->db->or_like('id_jasa_layanan', $yangdicari);
                $this->db->or_like('ukuran_hewan', $yangdicari);
                $this->db->or_like('nama_jenis_hewan', $yangdicari);
                break;

            case "id_jasa_layanan":
                $this->db->where('id_jasa_layanan', $yangdicari);
                break;

            default:
                $this->db->like($berdasarkan, $yangdicari);
        }
        return $this->db->get();
    }

    public function restoreJasaLayanan($id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $this->db->where('id_jasa_layanan', $id);
        $this->db->update('data_jasa_layanan', ['deleted_date' => '0000-00-00 00:00:00', 'created_date' => date("Y-m-d H:i:s")]);
    }
}
