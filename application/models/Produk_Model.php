<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_model extends CI_Model
{
   
    public function getDataProdukAdmin()
    {
        return $this->db->get_where('data_produk', ['deleted_date' => '0000-00-00 00:00:00'])->result_array();
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
        $this->db->where('deleted_date','0000-00-00 00:00:00');

        switch ($berdasarkan) {
            case "":
                $this->db->like('ukuran_hewan', $yangdicari);
                $this->db->or_like('id_ukuran_hewan', $yangdicari);
                break;

            case "id_ukuran_hewan":
                $this->db->where('id_ukuran_hewan', $yangdicari);

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

    public function getProdukId($id){
        return $this->db->get_where('data_produk', ['id_produk' => $id])->result_array();
    }

    public function cekGambar($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM data_produk WHERE id_produk = $id &&  gambar_produk='upload/gambar_produk/default.jpg'";
        $result = $this->db->query($query, $this->id);

        $this->db->select('gambar_produk');
        $this->db->from('data_produk');
        $this->db->where('id_produk', $id);

        $gambar = $this->db->get()->row('gambar_produk');

        if ($result->num_rows() == 1) {
            return 1;
        } else {
            return $gambar;
        }

    }

}