<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function configbuycars()
    {
        $data['title'] = 'Buy Car Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Buy_Model', 'menu');
        $data['dataBeliMobil'] = $this->menu->getDataBeliMobilAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('merk', 'Merk', 'required|trim');
        $this->form_validation->set_rules('type', 'Type', 'required|trim');
        $this->form_validation->set_rules('harga', 'Price', 'required|numeric|trim');
        $this->form_validation->set_rules('nomorhp', 'Phone Number', 'required|min_length[10]|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/configbuycars', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];

            $data = [
                'name' => $this->input->post('name'),
                'merk' => $this->input->post('merk'),
                'type' => $this->input->post('type'),
                'harga' => $this->input->post('harga'),
                'nomorhp' => $this->input->post('nomorhp'),
                'email_pembeli' => $emailPembeli,
            ];

            $this->db->insert('buy_cars', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Cars Added
           </div>');
            redirect('admin/configbuycars');
        }
    }

    public function updateMobilAdmin($id)
    {
        $data['title'] = 'Buy Car';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Buy_Model', 'menu');
        $data['dataBeliMobil'] = $this->menu->getBuyCarById($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('merk', 'Merk', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('nomorhp', 'Nomorhp', 'required|min_length[10]');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('buycars/buycars', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            $data = [
                'name' => $this->input->post('name'),
                'merk' => $this->input->post('merk'),
                'type' => $this->input->post('type'),
                'harga' => $this->input->post('harga'),
                'nomorhp' => $this->input->post('nomorhp'),
                'email_pembeli' => $emailPembeli,
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('buy_cars', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Cars Success Edited!
           </div>');
            redirect('admin/configbuycars');
        }
    }

    public function configsellcars()
    {
        $data['title'] = 'Sell Car Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Jual_Model', 'menu');
        $data['dataJualMobil'] = $this->menu->getDataJualMobilAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('merk', 'Merk', 'required');
        $this->form_validation->set_rules('warna', 'Color', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('bahan_bakar', 'Fuel', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/configsellcars', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];

            $data = [
                'name' => $this->input->post('name'),
                'merk' => $this->input->post('merk'),
                'warna' => $this->input->post('warna'),
                'bahan_bakar' => $this->input->post('bahan_bakar'),
                'harga' => $this->input->post('harga'),
                'email_pembeli' => $emailPembeli,
            ];

            $this->db->insert('sell_cars', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your New Cars Added
           </div>');
            redirect('admin/configsellcars');
        }
    }

    public function configsparepart()
    {
        $data['title'] = 'Sparepart Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Sparepart_Model', 'menu');
        $data['dataBeliSparepart'] = $this->menu->getDataBeliSparepartAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim|alpha');
        $this->form_validation->set_rules('name_sparepart', 'Sparepart Name', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Description', 'required|trim');
        $this->form_validation->set_rules('harga', 'Price', 'required|numeric|trim|min_length[3]');
        $this->form_validation->set_rules('kondisi', 'Condition', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/configsparepart', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];

            $data = [
                'name' => $this->input->post('name'),
                'name_sparepart' => $this->input->post('name_sparepart'),
                'deskripsi' => $this->input->post('deskripsi'),
                'harga' => $this->input->post('harga'),
                'kondisi' => $this->input->post('kondisi'),
                'email_pembeli' => $emailPembeli,
            ];

            $this->db->insert('buy_sparepart', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Sparepart Added!
           </div>');
            redirect('admin/configsparepart');
        }
    }

    public function hapusMobilAdmin($id)
    {
        $this->load->model('Buy_Model');
        $this->Buy_Model->deleteBuyCars($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
               Car Success Deleted!
               </div>');
        redirect('admin/configbuycars');
    }

    public function hapusSparepartAdmin($id)
    {
        $this->load->model('Sparepart_Model');
        $this->Sparepart_Model->deleteBuySparepart($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
               Sparepart Success Deleted!
               </div>');
        redirect('admin/configsparepart');
    }

    public function hapusJualMobilAdmin($id)
    {
        $this->load->model('Jual_Model');
        $this->Jual_Model->deleteJualMobil($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
               Your Car Success Deleted!
               </div>');
        redirect('admin/configsellcars');
    }

    public function updateSparepartAdmin($id)
    {
        $data['title'] = 'Sparepart Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Sparepart_Model', 'menu');
        $data['dataBeliSparepart'] = $this->menu->getBuySparepartById($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim|alpha');
        $this->form_validation->set_rules('name_sparepart', 'Sparepart Name', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Description', 'required|trim');
        $this->form_validation->set_rules('harga', 'Price', 'required|numeric|trim|min_length[3]');
        $this->form_validation->set_rules('kondisi', 'Condition', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('buysparepart/buysparepart', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];

            $data = [
                'name' => $this->input->post('name'),
                'name_sparepart' => $this->input->post('name_sparepart'),
                'deskripsi' => $this->input->post('deskripsi'),
                'harga' => $this->input->post('harga'),
                'kondisi' => $this->input->post('kondisi'),
                'email_pembeli' => $emailPembeli,
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('buy_sparepart', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Sparepart Success Edited!
           </div>');
            redirect('admin/configsparepart');
        }
    }

    public function updateJualMobilAdmin($id)
    {
        $data['title'] = 'Sell Car Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Jual_Model', 'menu');
        $data['dataJualMobil'] = $this->menu->getJualMobilById($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('merk', 'Merk', 'required');
        $this->form_validation->set_rules('warna', 'Color', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('bahan_bakar', 'Fuel', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/configsellcars', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];

            $data = [
                'name' => $this->input->post('name'),
                'merk' => $this->input->post('merk'),
                'warna' => $this->input->post('warna'),
                'bahan_bakar' => $this->input->post('bahan_bakar'),
                'harga' => $this->input->post('harga'),
                'email_pembeli' => $emailPembeli,
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('sell_cars', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your Car Success Edited!
           </div>');
            redirect('admin/configsellcars');
        }
    }

    public function configuser()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Member_Model', 'menu');
        $data['dataMember'] = $this->menu->getMemberAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email already registered!',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('is_active', 'Active', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/configuser', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role_id'),
                'is_active' => $this->input->post('is_active'),
                'image' => 'default.jpg',
                'datecreated' => time(),
            ];

            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New User Created!
           </div>');
            redirect('admin/configuser');
        }
    }

    public function hapusMemberAdmin($id)
    {
        $this->load->model('Member_Model');
        $this->Member_Model->deleteMember($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              User Success Deleted!
               </div>');
        redirect('admin/configuser');
    }

    public function updateMember($id)
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Member_Model', 'menu');
        $data['dataMember'] = $this->menu->getMemberId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('is_active', 'Active', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/configuser', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role_id'),
                'is_active' => $this->input->post('is_active'),
                'image' => 'default.jpg',
                'datecreated' => time(),
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            User Profile Updated!
           </div>');
            redirect('admin/configuser');
        }
    }

    ///////////////////////////////////////////// P3L

    public function kelola_pegawai()
    {
        $data['title'] = 'Kelola Data Pegawai';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Pegawai_Model', 'menu');
        $data['dataPegawai'] = $this->menu->getDataPegawaiAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('nama', 'Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_pegawai', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_pegawai' => $this->input->post('nama'),
                'alamat_pegawai' => $this->input->post('alamat'),
                'tanggal_lahir_pegawai' => $this->input->post('tanggal'),
                'role_pegawai' => $this->input->post('role'),
                'nomor_hp_pegawai' => $this->input->post('nohp'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_pegawai', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Pegawai Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_pegawai');
        }
    }

    public function updatePegawai($id)
    {
        $data['title'] = 'Kelola Data Pegawai';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Pegawai_model', 'menu');
        $data['dataPegawai'] = $this->menu->getPegawaiId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required');
       

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_pegawai', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_pegawai' => $this->input->post('nama'),
                'alamat_pegawai' => $this->input->post('alamat'),
                'tanggal_lahir_pegawai' => $this->input->post('tanggal'),
                'role_pegawai' => $this->input->post('role'),
                'nomor_hp_pegawai' => $this->input->post('nohp'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'updated_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_pegawai', $this->input->post('id'));
            $this->db->update('data_pegawai', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data Pegawai Sukses di Edit!
           </div>');
            redirect('admin/kelola_pegawai');
        }
    }

    public function hapusPegawai($id)
    {
        $this->load->model('Pegawai_Model');
        $this->Pegawai_Model->deletePegawai($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Pegawai Berhasil Di Hapus!
               </div>');
        redirect('admin/kelola_pegawai');
    }


    public function kelola_jenis_hewan()
    {
        $data['title'] = 'Kelola Data Jenis Hewan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('JenisHewan_Model', 'menu');
        $data['dataJenisHewan'] = $this->menu->getDataJenisHewanAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('nama', 'Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_jenis_hewan', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_jenis_hewan' => $this->input->post('nama'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_jenis_hewan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Jenis Hewan Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_jenis_hewan');
        }
    }

    public function updateJenisHewan($id)
    {
        $data['title'] =  'Kelola Data Jenis Hewan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('JenisHewan_Model', 'menu');
        $data['dataJenisHewan'] = $this->menu->getJenisHewanId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required');
       

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_jenis_hewan', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_jenis_hewan' => $this->input->post('nama'),
                'updated_date' => date("Y-m-d H:i:s")
            ];

            $this->db->where('id_jenis_hewan', $this->input->post('id'));
            $this->db->update('data_jenis_hewan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data Jenis Hewan Sukses di Edit!
           </div>');
            redirect('admin/kelola_jenis_hewan');
        }
    }

    public function hapusJenisHewan($id)
    {
        $this->load->model('JenisHewan_Model');
        $this->JenisHewan_Model->deleteJenisHewan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Jenis Hewan Berhasil Di Hapus!
               </div>');
        redirect('admin/kelola_jenis_hewan');
    }


    public function kelola_ukuran_hewan()
    {
        $data['title'] = 'Kelola Data Ukuran Hewan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('UkuranHewan_Model', 'menu');
        $data['dataUkuranHewan'] = $this->menu->getDataUkuranHewanAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('nama', 'Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_ukuran_hewan', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'ukuran_hewan' => $this->input->post('nama'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_ukuran_hewan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Jenis Hewan Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_ukuran_hewan');
        }
    }

    public function updateUkuranHewan($id)
    {
        $data['title'] =  'Kelola Data Ukuran Hewan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('UkuranHewan_Model', 'menu');
        $data['dataUkuranHewan'] = $this->menu->getUkuranHewanId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required');
       

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_ukuran_hewan', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'ukuran_hewan' => $this->input->post('nama'),
                'updated_date' => date("Y-m-d H:i:s")
            ];

            $this->db->where('id_ukuran_hewan', $this->input->post('id'));
            $this->db->update('data_ukuran_hewan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data Ukuran Hewan Sukses di Edit!
           </div>');
            redirect('admin/kelola_ukuran_hewan');
        }
    }

    public function hapusUkuranHewan($id)
    {
        $this->load->model('UkuranHewan_Model');
        $this->UkuranHewan_Model->deleteUkuranHewan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Ukuran Hewan Berhasil Di Hapus!
               </div>');
        redirect('admin/kelola_ukuran_hewan');
    }

    public function kelola_hewan()
    {
        $data['title'] = 'Kelola Data Hewan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Hewan_Model', 'menu');
        // INI UNTUK DROPDOWN
        $data['data_customer']=$this->menu->select_customer();  
        $data['data_ukuran']=$this->menu->select_ukuran();  
        $data['data_jenis']=$this->menu->select_jenis();  
        $data['dataHewan'] = $this->menu->getDataHewanAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('nama', 'Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_hewan', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_hewan' => $this->input->post('nama'),
                'id_jenis_hewan' => $this->input->post('pilih_jenis'),
                'id_ukuran_hewan' => $this->input->post('pilih_ukuran'),
                'id_customer' => $this->input->post('pilih_customer'),
                'tanggal_lahir_hewan' => $this->input->post('tanggal'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_hewan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Hewan Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_hewan');
        }
    }

    public function updateHewan($id)
    {
        $data['title'] =  'Kelola Data Ukuran Hewan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Hewan_Model', 'menu');
        $data['dataHewan'] = $this->menu->getHewanId($id);
        $data['data_customer']=$this->menu->select_customer();  
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required');
       

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_ukuran_hewan', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_hewan' => $this->input->post('nama'),
                'id_jenis_hewan' => $this->input->post('pilih_jenis'),
                'id_ukuran_hewan' => $this->input->post('pilih_ukuran'),
                'id_customer' => $this->input->post('pilih_customer'),
                'tanggal_lahir_hewan' => $this->input->post('tanggal'),
                'updated_date' => date("Y-m-d H:i:s"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->where('id_hewan', $this->input->post('id'));
            $this->db->update('data_hewan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data Hewan Sukses di Edit!
           </div>');
            redirect('admin/kelola_hewan');
        }
    }

    public function hapusHewan($id)
    {
        $this->load->model('Hewan_Model');
        $this->Hewan_Model->deleteHewan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Hewan Berhasil Di Hapus!
               </div>');
        redirect('admin/kelola_hewan');
    }

}