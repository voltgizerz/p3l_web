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
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function configuser()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Member_Model', 'menu');
        $data['dataMember'] = $this->menu->getMemberAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('username', 'username', 'required|trim|valid_username|is_unique[user.username]', [
            'is_unique' => 'This username already registered!',
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
                'username' => $this->input->post('username'),
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
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
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
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pegawai_Model', 'menu');
        $data['dataPegawai'] = $this->menu->getDataPegawaiAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('tanggal', 'tanggal', 'required|trim|regex_match[/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/]');
        $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[data_pegawai.username]', [
            'is_unique' => 'Username sudah Terdaftar!']);
        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_pegawai', $data);
            $this->load->view('templates/footer');
        } else {

            if ($this->input->post('role') == 'Owner') {
                $role_id = 1;
            } else if ($this->input->post('role') == 'Customer Service') {
                $role_id = 2;
            } else {
                $role_id = 3;
            }

            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_pegawai' => $this->input->post('nama'),
                'alamat_pegawai' => $this->input->post('alamat'),
                'tanggal_lahir_pegawai' => $this->input->post('tanggal'),
                'role_pegawai' => $this->input->post('role'),
                'nomor_hp_pegawai' => $this->input->post('nohp'),
                'username' => $this->input->post('username'),
                'role_id' => $role_id,
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
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
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pegawai_model', 'menu');
        $data['dataPegawai'] = $this->menu->getPegawaiId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('tanggal', 'tanggal', 'required|trim|regex_match[/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_pegawai', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];

            if ($this->input->post('role') == 'Owner') {
                $role_id = 1;
            } else if ($this->input->post('role') == 'Customer Service') {
                $role_id = 2;
            } else {
                $role_id = 3;
            }

            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_pegawai' => $this->input->post('nama'),
                'alamat_pegawai' => $this->input->post('alamat'),
                'tanggal_lahir_pegawai' => $this->input->post('tanggal'),
                'role_pegawai' => $this->input->post('role'),
                'role_id' => $role_id,
                'nomor_hp_pegawai' => $this->input->post('nohp'),
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
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

    public function cariPegawai()
    {
        $data['title'] = 'Kelola Data Pegawai';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pegawai_Model', 'menu');
        // INI UNTUK DROPDOWN

        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");
        $data["dataPegawai"] = $this->menu->cariPegawai($data['cariberdasarkan'], $data['yangdicari'])->result_array();
        $data["jumlah"] = count($data["dataPegawai"]);

        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['cari'])) {
            $this->form_validation->set_rules('tanggal', 'tanggal', 'required|trim|regex_match[/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/]');
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/cariPegawai', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];
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

    public function kelola_jenis_hewan()
    {
        $data['title'] = 'Kelola Data Jenis Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
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
            $usernamePembeli = $data['user']['username'];
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
        $data['title'] = 'Kelola Data Jenis Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
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
            $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_jenis_hewan' => $this->input->post('nama'),
                'updated_date' => date("Y-m-d H:i:s"),
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

    public function cariJenisHewan()
    {
        $data['title'] = 'Kelola Data Jenis Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('JenisHewan_Model', 'menu');
        // INI UNTUK DROPDOWN

        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");
        $data["dataJenisHewan"] = $this->menu->cariJenisHewan($data['cariberdasarkan'], $data['yangdicari'])->result_array();
        $data["jumlah"] = count($data["dataJenisHewan"]);

        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['cari'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/cariJenisHewan', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];
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

    public function kelola_ukuran_hewan()
    {
        $data['title'] = 'Kelola Data Ukuran Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
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
            $usernamePembeli = $data['user']['username'];
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
        $data['title'] = 'Kelola Data Ukuran Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
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
            $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'ukuran_hewan' => $this->input->post('nama'),
                'updated_date' => date("Y-m-d H:i:s"),
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

    public function cariUkuranHewan()
    {
        $data['title'] = 'Kelola Data Ukuran Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('UkuranHewan_Model', 'menu');
        // INI UNTUK DROPDOWN

        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");
        $data["dataUkuranHewan"] = $this->menu->cariUkuranHewan($data['cariberdasarkan'], $data['yangdicari'])->result_array();
        $data["jumlah"] = count($data["dataUkuranHewan"]);

        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['cari'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/cariUkuranHewan', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [

                'nama_ukuran_hewan' => $this->input->post('nama'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_ukuran_hewan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Ukuran Hewan Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_ukuran_hewan');
        }
    }

    public function kelola_hewan()
    {
        $data['title'] = 'Kelola Data Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Hewan_Model', 'menu');
        // INI UNTUK DROPDOWN
        $data['data_customer'] = $this->menu->select_customer();
        $data['data_ukuran'] = $this->menu->select_ukuran();
        $data['data_jenis'] = $this->menu->select_jenis();

        $data['dataHewan'] = $this->menu->getDataHewanAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|trim|regex_match[/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/]');
        $this->form_validation->set_rules('nama', 'Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_hewan', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];
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
        $data['title'] = 'Kelola Data Ukuran Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Hewan_Model', 'menu');
        $data['dataHewan'] = $this->menu->getHewanId($id);
        $data['data_customer'] = $this->menu->select_customer();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|trim|regex_match[/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_hewan', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];
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
    public function kelola_supplier()
    {
        $data['title'] = 'Kelola Data Supplier';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Supplier_Model', 'menu');
        $data['dataSupplier'] = $this->menu->getDataSupplierAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('nama_supplier', 'nama_supplier', 'required|trim');
        // $this->form_validation->set_rules('alamat_customer', 'alamat_customer', 'required|trim');
        // $this->form_validation->set_rules('tanggal_lahir_customer', 'tanggal_lahir_customer', 'required|trim');
        // $this->form_validation->set_rules('nomor_hp_customer', 'nomor_hp_customer', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_supplier', $data);
            $this->load->view('templates/footer');
        } else {
            // $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_supplier' => $this->input->post('nama_supplier'),
                'alamat_supplier' => $this->input->post('alamat_supplier'),
                'nomor_telepon_supplier' => $this->input->post('nomor_telepon_supplier'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),

            ];

            $this->db->insert('data_supplier', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Supplier Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_supplier');
        }
    }

    public function updateSupplier($id)
    {
        $data['title'] = 'Kelola Data Supplier';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Supplier_Model', 'menu');
        $data['dataSupplier'] = $this->menu->getSupplierId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_supplier', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_supplier' => $this->input->post('nama'),
                'alamat_supplier' => $this->input->post('alamat_supplier'),
                'nomor_telepon_supplier' => $this->input->post('nomor_telepon_supplier'),
                'updated_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_supplier', $this->input->post('id'));
            $this->db->update('data_supplier', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data Supplier Sukses di Edit!
           </div>');
            redirect('admin/kelola_supplier');
        }
    }

    public function hapusSupplier($id)
    {
        $this->load->model('Supplier_Model');
        $this->Supplier_Model->deleteSupplier($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Supplier Berhasil Di Hapus!
               </div>');
        redirect('admin/kelola_supplier');
    }

    public function cariSupplier()
    {
        $data['title'] = 'Kelola Data Supplier';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Supplier_Model', 'menu');
        // INI UNTUK DROPDOWN

        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");
        $data["dataSupplier"] = $this->menu->cariSupplier($data['cariberdasarkan'], $data['yangdicari'])->result_array();
        $data["jumlah"] = count($data["dataSupplier"]);

        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['cari'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/cariSupplier', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_supplier' => $this->input->post('nama_supplier'),
                'alamat_supplier' => $this->input->post('alamat_supplier'),
                'nomor_telepon_supplier' => $this->input->post('nomor_telepon_supplier'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_supplier', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Supplier Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_supplier');
        }
    }

    public function kelola_customer()
    {
        $data['title'] = 'Kelola Data Customer';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Customer_Model', 'menu');
        $data['dataCustomer'] = $this->menu->getDataCustomerAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('tanggal_lahir_customer', 'tanggal_lahir_customer', 'required|trim|regex_match[/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/]');
        $this->form_validation->set_rules('nama_customer', 'nama_customer', 'required|trim');
        // $this->form_validation->set_rules('alamat_customer', 'alamat_customer', 'required|trim');
        // $this->form_validation->set_rules('tanggal_lahir_customer', 'tanggal_lahir_customer', 'required|trim');
        // $this->form_validation->set_rules('nomor_hp_customer', 'nomor_hp_customer', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_customer', $data);
            $this->load->view('templates/footer');
        } else {
            // $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_customer' => $this->input->post('nama_customer'),
                'alamat_customer' => $this->input->post('alamat_customer'),
                'tanggal_lahir_customer' => $this->input->post('tanggal_lahir_customer'),
                'nomor_hp_customer' => $this->input->post('nomor_hp_customer'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),

            ];

            $this->db->insert('data_customer', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Customer Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_customer');
        }
    }

    public function updateCustomer($id)
    {
        $data['title'] = 'Kelola Data Customer';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Customer_Model', 'menu');
        $data['dataCustomer'] = $this->menu->getCustomerId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('tanggal_lahir_customer', 'tanggal_lahir_customer', 'required|trim|regex_match[/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_customer', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_customer' => $this->input->post('nama'),
                'alamat_customer' => $this->input->post('alamat_customer'),
                'tanggal_lahir_customer' => $this->input->post('tanggal_lahir_customer'),
                'nomor_hp_customer' => $this->input->post('nomor_hp_customer'),
                'updated_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_customer', $this->input->post('id'));
            $this->db->update('data_customer', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data Customer Sukses di Edit!
           </div>');
            redirect('admin/kelola_customer');
        }
    }

    public function hapusCustomer($id)
    {
        $this->load->model('Customer_Model');
        $this->Customer_Model->deleteCustomer($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Customer Berhasil Di Hapus!
               </div>');
        redirect('admin/kelola_customer');
    }

    public function cariCustomer()
    {
        $data['title'] = 'Kelola Data Customer';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Customer_Model', 'menu');
        // INI UNTUK DROPDOWN

        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");
        $data["dataCustomer"] = $this->menu->cariCustomer($data['cariberdasarkan'], $data['yangdicari'])->result_array();
        $data["jumlah"] = count($data["dataCustomer"]);

        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['cari'])) {
            $this->form_validation->set_rules('tanggal_lahir_customer', 'tanggal_lahir_customer', 'required|trim|regex_match[/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/]');
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/cariCustomer', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_customer' => $this->input->post('nama_customer'),
                'alamat_customer' => $this->input->post('alamat_customer'),
                'tanggal_lahir_customer' => $this->input->post('tanggal_lahir_customer'),
                'nomor_hp_customer' => $this->input->post('nomor_hp_customer'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_customer', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Customer Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_customer');
        }
    }

    public function cariHewan()
    {
        $data['title'] = 'Kelola Data Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Hewan_Model', 'menu');
        // INI UNTUK DROPDOWN
        $data['data_customer'] = $this->menu->select_customer();
        $data['data_ukuran'] = $this->menu->select_ukuran();
        $data['data_jenis'] = $this->menu->select_jenis();

        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");
        $data["dataHewan"] = $this->menu->cariHewan($data['cariberdasarkan'], $data['yangdicari'])->result_array();
        $data["jumlah"] = count($data["dataHewan"]);

        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['cari'])) {
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|trim|regex_match[/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/]');
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/cariHewan', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];
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

    /////////////////////////////////TRANSAKSI/////////////////////////////////////////

    public function transaksi_pengadaan()
    {
        $data['title'] = 'Transaksi Pengadaan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pengadaan_Model', 'menu');
        $data['dataPengadaan'] = $this->menu->getDataPengadaanAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_supplier'] = $this->menu->select_supplier();

        $this->form_validation->set_rules('pilih_supplier', 'pilih_supplier', 'required|trim');
        //$this->form_validation->set_rules('nama_customer', 'nama_customer', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/transaksi_pengadaan', $data);
            $this->load->view('templates/footer');
        } else {
            // $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'kode_pengadaan' => $this->menu->ambilKode(),
                'id_supplier' => $this->input->post('pilih_supplier'),
                'status' => 'Belum Diterima',
                'tanggal_pengadaan' => date("0000:00:0:00:00"),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'total' => $this->menu->totalBayarPengadaan($this->menu->ambilKode()),
            ];

            $this->db->insert('data_pengadaan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Transaksi Pengadaan Berhasil Ditambahkan!
           </div>');
            redirect('admin/transaksi_pengadaan');
        }
    }

    public function hapusPengadaan($id)
    {
        $this->load->model('Pengadaan_Model');
        $this->Pengadaan_Model->deletePengadaan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Sukses Hapus Transaksi Pengadaan!
               </div>');
        redirect('admin/transaksi_pengadaan');
    }

    public function updatePengadaan($id)
    {
        $data['title'] = 'Transaksi Pengadaan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pengadaan_Model', 'menu');
        $data['dataPengadaan'] = $this->menu->getPengadaanId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_supplier'] = $this->menu->select_supplier();

        $this->form_validation->set_rules('pilih_supplier', 'pilih_supplier', 'required|trim');
        $this->form_validation->set_rules('status', 'status', 'required');
        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/transaksi_pengadaan', $data);
            $this->load->view('templates/footer');
        } else {
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'id_supplier' => $this->input->post('pilih_supplier'),
                'status' => $this->input->post('status'),
                'updated_date' => date("Y-m-d H:i:s"),
                'tanggal_pengadaan' => date("Y-m-d H:i:s"),
            ];

            if ($this->db->where('id_pengadaan', $id)->update('data_pengadaan', $data)) {

                $data = $this->db->get_where('data_pengadaan', ['id_pengadaan' => $id])->result_array();

                if ($data['status'] == "Sudah Diterima") {
                    $this->db->select('*');
                    $this->db->from('data_detail_pengadaan');
                    $this->db->where('kode_pengadaan_fk', $data['kode_pengadaan']);
                    $query = $this->db->get();
                    $arrProdukPengadaan = $query->result_array();
                    //memasukan stok produk ke data produk
                    for ($i = 0; $i < count($arrProdukPengadaan); $i++) {
                        //AMBIL STOK PRODUK LAMA
                        $this->db->select('stok_produk');
                        $this->db->from('data_produk');
                        $this->db->where('id_produk', $arrProdukPengadaan[$i]['id_produk_fk']);
                        $arrStokLama = $this->db->get()->result_array();
                        // TAMBAH STOK PRODUK
                        $this->db->where('id_produk', $arrProdukPengadaan[$i]['id_produk_fk'])->update('data_produk', ['stok_produk' => $arrStokLama[0]['stok_produk'] + $arrProdukPengadaan[$i]['jumlah_pengadaan']]);
                    }
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Transaksi Pengadaan Sukses di Edit!
           </div>');
                    redirect('admin/transaksi_pengadaan');
                } else {

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Transaksi Pengadaan Sukses di Edit!
           </div>');
                    redirect('admin/transaksi_pengadaan');
                }
            }

        }
    }

    public function detail_pengadaan($id)
    {
        $data['title'] = 'Transaksi Pengadaan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pengadaan_Model', 'menu');
        $data['dataDetailPengadaan'] = $this->menu->getDataDetailPengadaanAdmin($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_produk'] = $this->menu->select_produk();
        $kode = $this->db->get_where('data_pengadaan', ['id_pengadaan' => $id])->row()->kode_pengadaan;
        $data['kode_pengadaan'] = $kode;
        $data['id_pengadaan'] = $id;
        $this->form_validation->set_rules('pilih_produk', 'pilih_produk', 'required|trim');
        $this->form_validation->set_rules('satuan', 'satuan', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/detail_pengadaan', $data);
            $this->load->view('templates/footer');
        } else {
            // $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'id_produk_fk' => $this->input->post('pilih_produk'),
                'kode_pengadaan_fk' => $kode,
                'satuan_pengadaan' => $this->input->post('satuan'),
                'jumlah_pengadaan' => $this->input->post('jumlah_pengadaan'),
                'tanggal_pengadaan' => date("Y-m-d H:i:s"),
            ];

            $this->db->insert('data_detail_pengadaan', $data);

            $this->db->select('data_detail_pengadaan.id_produk_fk,data_detail_pengadaan.jumlah_pengadaan,data_produk.harga_produk');
            $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
            $this->db->where('data_detail_pengadaan.kode_pengadaan_fk', $data['kode_pengadaan_fk']);
            $this->db->from('data_detail_pengadaan');
            $query = $this->db->get();
            $arrTemp = json_decode(json_encode($query->result()), true);
            // NILAI TAMPUNG TOTAL HARGA YANG BARU
            $temp = 0;
            for ($i = 0; $i < count($arrTemp); $i++) {
                $temp = $temp + $arrTemp[$i]['jumlah_pengadaan'] * $arrTemp[$i]['harga_produk'];
            }
            //UPDATE NILAI TOTAL PENGADAAN
            $this->db->where('kode_pengadaan', $data['kode_pengadaan_fk'])->update('data_pengadaan', ['total' => $temp]);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Pengadaan Berhasil Ditambahkan!
           </div>');
            redirect('admin/detail_pengadaan/' . $id);
        }
    }

    public function hapusDetailPengadaan($id)
    {
        $kode = $this->db->get_where('data_detail_pengadaan', ['id_detail_pengadaan' => $id])->row()->kode_pengadaan_fk;
        $idtrx = $this->db->get_where('data_pengadaan', ['kode_pengadaan' => $kode])->row()->id_pengadaan;
        $this->load->model('Pengadaan_Model');
        $this->Pengadaan_Model->deleteDetailPengadaan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Sukses Hapus Produk Transaksi Pengadaan!
               </div>');
        redirect('admin/detail_pengadaan/' . $idtrx);
    }

    public function updateDetailPengadaan($id)
    {
        $kode = $this->db->get_where('data_detail_pengadaan', ['id_detail_pengadaan' => $id])->row()->kode_pengadaan_fk;
        $idtrx = $this->db->get_where('data_pengadaan', ['kode_pengadaan' => $kode])->row()->id_pengadaan;
        $data['title'] = 'Transaksi Pengadaan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pengadaan_Model', 'menu');
        $data['dataDetailPengadaan'] = $this->menu->getDetailPengadaanId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_produk'] = $this->menu->select_produk();
        $data['kode_pengadaan'] = $kode;
        $data['id_pengadaan'] = $id;

        $this->form_validation->set_rules('pilih_produk', 'pilih_produk', 'required');
        $this->form_validation->set_rules('satuan', 'satuan', 'required');
        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/detail_pengadaan', $data);
            $this->load->view('templates/footer');
        } else {
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'id_produk_fk' => $this->input->post('pilih_produk'),
                'satuan_pengadaan' => $this->input->post('satuan'),
                'jumlah_pengadaan' => $this->input->post('jumlah_pengadaan'),
            ];
            
            if ($this->db->where('id_detail_pengadaan', $id)->update('data_detail_pengadaan', $data)) {
                //CARI NILAI TOTAL HARGA UPDATE
                $this->db->select('data_detail_pengadaan.id_produk_fk,data_detail_pengadaan.jumlah_pengadaan,data_produk.harga_produk');
                $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
                $this->db->where('data_detail_pengadaan.kode_pengadaan_fk', $kode);
                $this->db->from('data_detail_pengadaan');
                $query = $this->db->get();
                $arrTemp = json_decode(json_encode($query->result()), true);
                // NILAI TAMPUNG TOTAL HARGA YANG BARU
                $temp = 0;
                for ($i = 0; $i < count($arrTemp); $i++) {
                    $temp = $temp + $arrTemp[$i]['jumlah_pengadaan'] * $arrTemp[$i]['harga_produk'];
                }
                //UPDATE NILAI TOTAL PENGADAAN
                $this->db->where('kode_pengadaan', $kode)->update('data_pengadaan', ['total' => $temp, 'updated_date' => date("Y-m-d H:i:s")]);

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Pengadaan Sukses di Edit!
           </div>');
                redirect('admin/detail_pengadaan/'.$idtrx);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Pengadaan Sukses di Edit!
           </div>');
            redirect('admin/detail_pengadaan/'.$idtrx);
        }
    }

    public function cariPengadaan()
    {
        $data['title'] = 'Transaksi Pengadaan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pengadaan_Model', 'menu');
        //SEARCHING
        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");
        $data['dataPengadaan'] = $this->menu->cariPengadaan($data['cariberdasarkan'], $data['yangdicari'])->result_array();
        
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_supplier'] = $this->menu->select_supplier();

        

        if (!isset($_POST['cari'])) {
        $this->form_validation->set_rules('pilih_supplier', 'pilih_supplier', 'required|trim');
        //$this->form_validation->set_rules('nama_customer', 'nama_customer', 'required|trim');
        }
        
        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/transaksi_pengadaan', $data);
            $this->load->view('templates/footer');
        } else {
            // $usernamePembeli = $data['user']['username'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'kode_pengadaan' => $this->menu->ambilKode(),
                'id_supplier' => $this->input->post('pilih_supplier'),
                'status' => 'Belum Diterima',
                'tanggal_pengadaan' => date("0000:00:0:00:00"),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'total' => $this->menu->totalBayarPengadaan($this->menu->ambilKode()),
            ];

            $this->db->insert('data_pengadaan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Transaksi Pengadaan Berhasil Ditambahkan!
           </div>');
            redirect('admin/transaksi_pengadaan');
        }
    }

}