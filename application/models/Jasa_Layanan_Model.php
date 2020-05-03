
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

    public function getDataJasaLayananAdmin()
    {
        $this->db->select('id_jasa_layanan, 
        nama_jasa_layanan, 
        harga_jasa_layanan,
        data_jasa_layanan.id_jenis_hewan, 
        data_jasa_layanan.id_ukuran_hewan, 
        data_jasa_layanan.created_date, 
        data_jasa_layanan.updated_date, 
        data_jasa_layanan.deleted_date,
        ukuran_hewan,nama_jenis_hewan');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_jasa_layanan.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_jasa_layanan.id_jenis_hewan');
        $this->db->from('data_jasa_layanan');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function deleteJasaLayanan($id)
    {
        $this->db->where('id_jasa_layanan', $id);
        $this->db->delete('data_jasa_layanan');
    }

    public function getJasaLayananId($id)
    {
        return $this->db->get_where('data_jasa_layanan', ['id_jasa_layanan' => $id])->result_array();
    }

    public function select_jenis()
    {
        $query = $this->db->get('data_jenis_hewan');
        return $query;
    }

    public function select_ukuran()
    {
        $query = $this->db->get('data_ukuran_hewan');
        return $query;
    }

    public function cariJasaLayanan($berdasarkan,$yangdicari){
        $this->db->select('id_jasa_layanan, 
        nama_jasa_layanan, 
        harga_jasa_layanan,
        data_jasa_layanan.id_jenis_hewan, 
        data_jasa_layanan.id_ukuran_hewan, 
        data_jasa_layanan.created_date, 
        data_jasa_layanan.updated_date, 
        data_jasa_layanan.deleted_date,
        ukuran_hewan,nama_jenis_hewan');
        $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_jasa_layanan.id_ukuran_hewan');
        $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_jasa_layanan.id_jenis_hewan');
        $this->db->from('data_jasa_layanan');

        switch($berdasarkan){
            case "":
                $this->db->like('nama_jasa_layanan',$yangdicari);
                $this->db->or_like('id_jasa_layanan',$yangdicari);
                $this->db->or_like('ukuran_hewan',$yangdicari);
                $this->db->or_like('nama_jenis_hewan',$yangdicari);
            break;

            case "id_jasa_layanan":
                $this->db->where('id_jasa_layanan',$yangdicari);
            
            default:
            $this->db->like($berdasarkan,$yangdicari);
        }
        return $this->db->get();
    }

}