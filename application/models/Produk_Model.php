<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_model extends CI_Model
{

    protected $table = 'data_produk';
    public function getDataProdukAdmin()
    {
        $this->db->select('*');
        $this->db->where('deleted_date', '0000:00:0:00:00');
        $this->db->from('data_produk');
        $this->db->order_by("id_produk desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDataLogProduk()
    {
        $this->db->select('*');
        $this->db->where('created_date', '0000:00:0:00:00');
        $this->db->from('data_produk');
        $this->db->order_by("id_produk desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function deleteProduk($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_produk');
        $this->db->where('id_produk', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_produk', ['id_produk' => $id]) == false) {
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
                'id_produk' => $arrTampData[0]['id_produk'],
                'nama_produk' => $arrTampData[0]['nama_produk'],
                'harga_produk' => $arrTampData[0]['harga_produk'],
                'stok_produk' => $arrTampData[0]['stok_produk'],
                'gambar_produk' => $arrTampData[0]['gambar_produk'],
                'gambar_produk_desktop' => file_get_contents($arrTampData[0]['gambar_produk']),
                'stok_minimal_produk' => $arrTampData[0]['stok_minimal_produk'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];

            // RETURN DATA
            $this->db->insert('data_produk', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                [
                    'created_date' => date("0000:00:0:00:00"),
                    'deleted_date' => date("Y-m-d H:i:s"),
                ];

            $this->db->where('id_produk', $id);
            $this->db->update('data_produk', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }

    public function deletePermProduk($id)
    {
        $this->db->where('id_produk', $id);
        $this->db->delete('data_produk');
    }

    public function getUkuranHewanId($id)
    {
        return $this->db->get_where('data_ukuran_hewan', ['id_ukuran_hewan' => $id])->result_array();
    }

    public function cariProduk($berdasarkan, $yangdicari, $limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->select('*');
        $this->db->from('data_produk');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');

        switch ($berdasarkan) {
            case "":
                $this->db->like('nama_produk', $yangdicari);
                $this->db->or_like('id_produk', $yangdicari);
                $this->db->where('deleted_date', '0000-00-00 00:00:00');
                break;

            case "id_produk":
                $this->db->where('id_produk', $yangdicari);
                $this->db->where('deleted_date', '0000-00-00 00:00:00');
                break;

            case "nama_produk":
                $this->db->where('nama_produk', $yangdicari);
                $this->db->where('deleted_date', '0000-00-00 00:00:00');
                break;

            case "harga_produk":
                $this->db->order_by("harga_produk asc");
                $this->db->where('deleted_date', '0000-00-00 00:00:00');
                break;

            case "harga_produk_mahal":
                $this->db->order_by("harga_produk desc");
                $this->db->where('deleted_date', '0000-00-00 00:00:00');
                break;

            case "stok_produk":
                $this->db->order_by("stok_produk desc");
                $this->db->where('deleted_date', '0000-00-00 00:00:00');
                break;

            case "stok_produk_sedikit":
                $this->db->order_by("stok_produk asc");
                $this->db->where('deleted_date', '0000-00-00 00:00:00');
                break;

            default:
                $this->db->like($berdasarkan, $yangdicari);
                $this->db->where('deleted_date', '0000-00-00 00:00:00');
        }
        return $this->db->get();
    }

    public function restoreProduk($id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $this->db->where('id_produk', $id);
        $this->db->update('data_produk', ['deleted_date' => '0000-00-00 00:00:00', 'created_date' => date("Y-m-d H:i:s")]);
    }

    public function getProdukId($id)
    {
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


    public function get_produk($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->select('*');
        $this->db->where('deleted_date', '0000:00:0:00:00');
        $this->db->order_by("id_produk desc");
        $query = $this->db->get('data_produk');

        return $query->result_array();
    }

    public function get_count()
    {
        return $this->db->count_all('data_produk');
    }
}
