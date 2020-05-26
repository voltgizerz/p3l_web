<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_Model extends CI_Model
{
    public function getDataBeliMobil()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilDataPembeli = $data['user']['email'];
        return $this->db->get_where('buy_cars', ['email_Pembeli' => $tampilDataPembeli])->result_array();
    }

    public function getDataCustomerAdmin()
    {
        return $this->db->get_where('data_customer', ['deleted_date' => '0000-00-00 00:00:00'])->result_array();
    }

    public function getDataLogCustomer()
    {
        return $this->db->get_where('data_customer', ['created_date' => '0000-00-00 00:00:00'])->result_array();
    }

    public function deleteCustomer($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_customer');
        $this->db->where('id_customer', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();
        if ($this->db->delete('data_customer', ['id_customer' => $id]) == false) {
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
                'id_customer' => $arrTampData[0]['id_customer'],
                'nama_customer' => $arrTampData[0]['nama_customer'],
                'alamat_customer' => $arrTampData[0]['alamat_customer'],
                'tanggal_lahir_customer' => $arrTampData[0]['tanggal_lahir_customer'],
                'nomor_hp_customer' => $arrTampData[0]['nomor_hp_customer'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            // RETURN DATA
            $this->db->insert('data_customer', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                [
                    'created_date' => date("0000:00:0:00:00"),
                    'deleted_date' => date("Y-m-d H:i:s"),
                ];

            $this->db->where('id_customer', $id);
            $this->db->update('data_customer', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }

    public function deletePermCustomer($id)
    {
        $this->db->where('id_customer', $id);
        $this->db->delete('data_customer');
    }

    public function getCustomerId($id)
    {
        return $this->db->get_where('data_customer', ['id_customer' => $id])->result_array();
    }

    public function cariCustomer($berdasarkan, $yangdicari)
    {
        $this->db->select('*');
        $this->db->from('data_customer');
        $this->db->where('deleted_date', '0000-00-00 00:00:00');
        switch ($berdasarkan) {
            case "":
                $this->db->like('nama_customer', $yangdicari);
                $this->db->or_like('id_customer', $yangdicari);
                break;

            case "id_customer":
                $this->db->where('id_customer', $yangdicari);

            default:
                $this->db->like($berdasarkan, $yangdicari);
        }
        return $this->db->get();
    }

    public function restoreCustomer($id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $this->db->where('id_customer', $id);
        $this->db->update('data_customer', ['deleted_date' => '0000-00-00 00:00:00', 'created_date' => date("Y-m-d H:i:s")]);
    }
}
