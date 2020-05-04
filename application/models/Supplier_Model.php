<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
    public function getDataBeliMobil()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataSupplierAdmin()
    {
        return $this->db->get_where('data_supplier', ['deleted_date' => '0000-00-00 00:00:00'])->result_array();
    }

    public function getDataLogSupplier()
    {
        return $this->db->get_where('data_supplier', ['created_date' => '0000-00-00 00:00:00'])->result_array();
    }

    public function deleteSupplier($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_supplier');
        $this->db->where('id_supplier', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_supplier', ['id_supplier' => $id]) == false) {
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
                'id_supplier' => $arrTampData[0]['id_supplier'],
                'nama_supplier' => $arrTampData[0]['nama_supplier'],
                'alamat_supplier' => $arrTampData[0]['alamat_supplier'],
                'nomor_telepon_supplier' => $arrTampData[0]['nomor_telepon_supplier'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            // RETURN DATA
            $this->db->insert('data_supplier', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                ['created_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_supplier', $id);
            $this->db->update('data_supplier', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }

    public function deletePermSupplier($id)
    {
        $this->db->where('id_supplier', $id);
        $this->db->delete('data_supplier');
    }

    public function getSupplierId($id)
    {
        return $this->db->get_where('data_supplier', ['id_supplier' => $id])->result_array();
    }

    public function cariSupplier($berdasarkan, $yangdicari)
    {
        $this->db->select('*');
        $this->db->from('data_supplier');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');

        switch ($berdasarkan) {
            case "":
                $this->db->like('nama_supplier', $yangdicari);
                $this->db->or_like('data_supplier', $yangdicari);
                break;

            case "nama_supplier":
                $this->db->where('nama_supplier', $yangdicari);
                break;
            default:
                $this->db->like($berdasarkan, $yangdicari);
        }
        return $this->db->get();
    }

    public function restoreSupplier($id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $this->db->where('id_supplier', $id);
        $this->db->update('data_supplier', ['deleted_date' => '0000-00-00 00:00:00', 'created_date' => date("Y-m-d H:i:s")]);

    }

}