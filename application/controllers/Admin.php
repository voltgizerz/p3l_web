<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('pdf');
        $this->load->library("pagination");
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
            'is_unique' => 'Username sudah Terdaftar!'
        ]);
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

    public function logPegawai()
    {
        $data['title'] = 'Kelola Data Pegawai';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pegawai_Model', 'menu');
        $data['dataPegawai'] = $this->menu->getDataLogPegawai();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['log'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/logPegawai', $data);
            $this->load->view('templates/footer');
            header("Cache-Control: no cache");
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

    public function restorePegawai($id)
    {
        $data['title'] = 'Kelola Data Pegawai';
        $this->load->model('Pegawai_Model');
        $this->Pegawai_Model->restorePegawai($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Pegawai Berhasil Di Restore!
               </div>');
        redirect('admin/kelola_pegawai');
    }

    public function updatePegawai($id)
    {
        $data['title'] = 'Kelola Data Pegawai';
        $cekUsername = $this->db->get_where('data_pegawai', ['id_pegawai' => $id])->row()->username;

        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pegawai_model', 'menu');
        $data['dataPegawai'] = $this->menu->getPegawaiId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('tanggal', 'tanggal', 'required|trim|regex_match[/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->input->post('username') == $cekUsername) {
            $this->form_validation->set_rules('username', 'Username', 'required');
        } else {
            $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[data_pegawai.username]', [
                'is_unique' => 'Username sudah Terdaftar!'
            ]);
        }
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
        if ($this->Pegawai_Model->deletePegawai($id) == -1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Pegawai Gagal Di Hapus, Data Masih digunakan!
             </div>');
            redirect('admin/kelola_pegawai');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
             Pegawai Berhasil Di Hapus!
               </div>');
            redirect('admin/kelola_pegawai');
        }
    }

    public function deletePermPegawai($id)
    {
        $this->load->model('Pegawai_Model');
        $this->Pegawai_Model->deletePermPegawai($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Pegawai Berhasil Di Hapus!
               </div>');
        redirect('admin/logPegawai');
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

    public function logJenisHewan()
    {
        $data['title'] = 'Kelola Data Jenis Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('JenisHewan_Model', 'menu');
        $data['dataJenisHewan'] = $this->menu->getDataLogJenisHewan();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['log'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/logJenisHewan', $data);
            $this->load->view('templates/footer');
            header("Cache-Control: no cache");
        } else {

            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'jenis_hewan' => $this->input->post('nama'),
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

    public function restoreJenisHewan($id)
    {
        $data['title'] = 'Kelola Data Jenis Hewan';
        $this->load->model('JenisHewan_Model');
        $this->JenisHewan_Model->restoreJenisHewan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Jenis Hewan Berhasil Di Restore!
               </div>');
        redirect('admin/kelola_jenis_hewan');
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
        if ($this->JenisHewan_Model->deleteJenisHewan($id) == -1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Jenis Hewan Gagal Di Hapus, Data Masih digunakan!
             </div>');
            redirect('admin/kelola_jenis_hewan');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Jenis Hewan Berhasil Di Hapus!
               </div>');
            redirect('admin/kelola_jenis_hewan');
        }
    }

    public function deletePermJenisHewan($id)
    {
        $this->load->model('JenisHewan_Model');
        $this->JenisHewan_Model->deletePermJenisHewan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Jenis Hewan Berhasil Di Hapus Permanent!
               </div>');
        redirect('admin/logJenisHewan');
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

        $this->form_validation->set_rules('nama', 'Name', 'required|trim|is_unique[data_ukuran_hewan.ukuran_hewan]', [
            'is_unique' => 'Ukuran Hewan Sudah Ada!',
        ]);

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

    public function logUkuranHewan()
    {
        $data['title'] = 'Kelola Data Ukuran Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('UkuranHewan_Model', 'menu');
        $data['dataUkuranHewan'] = $this->menu->getDataLogUkuranHewan();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['log'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/logUkuranHewan', $data);
            $this->load->view('templates/footer');
            header("Cache-Control: no cache");
        } else {

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

    public function restoreUkuranHewan($id)
    {
        $data['title'] = 'Kelola Data Ukuran Hewan';
        $this->load->model('UkuranHewan_Model');
        $this->UkuranHewan_Model->restoreUkuranHewan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Ukuran Hewan Berhasil Di Restore!
               </div>');
        redirect('admin/kelola_ukuran_hewan');
    }

    public function updateUkuranHewan($id)
    {
        $data['title'] = 'Kelola Data Ukuran Hewan';
        $cekUkuran = $this->db->get_where('data_ukuran_hewan', ['id_ukuran_hewan' => $id])->row()->ukuran_hewan;
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('UkuranHewan_Model', 'menu');
        $data['dataUkuranHewan'] = $this->menu->getUkuranHewanId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        if ($cekUkuran == $this->input->post('nama')) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        } else {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim|is_unique[data_ukuran_hewan.ukuran_hewan]', [
                'is_unique' => 'Ukuran Hewan Sudah Ada!',
            ]);
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_ukuran_hewan', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'ukuran_hewan' => $this->input->post('nama'),
                'updated_date' => date("Y-m-d H:i:s"),
            ];
            date_default_timezone_set("Asia/Bangkok");

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
        if ($this->UkuranHewan_Model->deleteUkuranHewan($id) == -1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Ukuran Hewan Gagal Di Hapus, Data Masih digunakan!
             </div>');
            redirect('admin/kelola_ukuran_hewan');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Ukuran Hewan Berhasil Di Hapus!
               </div>');
            redirect('admin/kelola_ukuran_hewan');
        }
    }

    public function deletePermUkuranHewan($id)
    {
        $this->load->model('UkuranHewan_Model');
        $this->UkuranHewan_Model->deletePermUkuranHewan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Ukuran Hewan Berhasil Di Hapus Permanent!
               </div>');
        redirect('admin/logUkuranHewan');
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

    public function logHewan()
    {
        $data['title'] = 'Kelola Data Hewan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Hewan_Model', 'menu');
        $data['dataHewan'] = $this->menu->getDataLogHewan();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_customer'] = $this->menu->select_customer();
        $data['data_ukuran'] = $this->menu->select_ukuran();
        $data['data_jenis'] = $this->menu->select_jenis();

        if (!isset($_POST['log'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/logHewan', $data);
            $this->load->view('templates/footer');
            header("Cache-Control: no cache");
        } else {

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

    public function restoreHewan($id)
    {
        $data['title'] = 'Kelola Data Hewan';
        $this->load->model('Hewan_Model');
        $this->Hewan_Model->restoreHewan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Hewan Berhasil Di Restore!
               </div>');
        redirect('admin/kelola_hewan');
    }

    public function updateHewan($id)
    {
        $data['title'] = 'Kelola Data  Hewan';
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
        if ($this->Hewan_Model->deleteHewan($id) == -1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Hewan Gagal Di Hapus, Data Masih digunakan!
             </div>');
            redirect('admin/kelola_hewan');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Hewan Berhasil Di Hapus!
               </div>');
            redirect('admin/kelola_hewan');
        }
    }

    public function deletePermHewan($id)
    {
        $this->load->model('Hewan_Model');
        $this->Hewan_Model->deletePermHewan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Hewan Berhasil Di Hapus Permanent!
               </div>');
        redirect('admin/logHewan');
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

    public function logSupplier()
    {
        $data['title'] = 'Kelola Data Supplier';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Supplier_Model', 'menu');
        $data['dataSupplier'] = $this->menu->getDataLogSupplier();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['log'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/logSupplier', $data);
            $this->load->view('templates/footer');
            header("Cache-Control: no cache");
        } else {

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

    public function restoreSupplier($id)
    {
        $data['title'] = 'Kelola Data Supplier';
        $this->load->model('Supplier_Model');
        $this->Supplier_Model->restoreSupplier($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Supplier Berhasil Di Restore!
               </div>');
        redirect('admin/kelola_supplier');
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
        if ($this->Supplier_Model->deleteSupplier($id) == -1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Supplier Gagal Di Hapus, Data Masih digunakan!
             </div>');
            redirect('admin/kelola_supplier');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Supplier Berhasil Di Hapus!
               </div>');
            redirect('admin/kelola_supplier');
        }
    }

    public function deletePermSupplier($id)
    {
        $this->load->model('Supplier_Model');
        $this->Supplier_Model->deletePermSupplier($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Supplier Berhasil Di Hapus Permanent!
               </div>');
        redirect('admin/logSupplier');
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

    public function logCustomer()
    {
        $data['title'] = 'Kelola Data Customer';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Customer_Model', 'menu');
        $data['dataCustomer'] = $this->menu->getDataLogCustomer();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['log'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/logCustomer', $data);
            $this->load->view('templates/footer');
            header("Cache-Control: no cache");
        } else {

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

    public function restoreCustomer($id)
    {
        $data['title'] = 'Kelola Data Customer';
        $this->load->model('Customer_Model');
        $this->Customer_Model->restoreCustomer($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Customer Berhasil Di Restore!
               </div>');
        redirect('admin/kelola_customer');
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
        if ($this->Customer_Model->deleteCustomer($id) == -1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Customer Gagal Di Hapus, Data Masih digunakan!
             </div>');
            redirect('admin/kelola_customer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Customer Berhasil Di Hapus!
               </div>');
            redirect('admin/kelola_customer');
        }
    }

    public function deletePermCustomer($id)
    {
        $this->load->model('Customer_Model');
        $this->Customer_Model->deletePermCustomer($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Customer Berhasil Di Hapus Permanent!
               </div>');
        redirect('admin/logCustomer');
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
        $kode = $this->db->get_where('data_pengadaan', ['id_pengadaan' => $id])->row()->kode_pengadaan;
        $cekDetail = $this->db->get_where('data_detail_pengadaan', ['kode_pengadaan_fk' => $kode])->num_rows();
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Pengadaan_Model', 'menu');
        $data['dataPengadaan'] = $this->menu->getPengadaanId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_supplier'] = $this->menu->select_supplier();

        if ($this->input->post('status') == 'Sudah Diterima') {
            if ($cekDetail == 0) {
                $this->form_validation->set_rules('status', 'status', 'required|equal[Belum Diterima]', [
                    'equal' => 'Gagal Ubah Status Pengadaan, Produk Pengadaan masih Kosong!'
                ]);
                $this->form_validation->set_rules('pilih_supplier', 'pilih_supplier', 'required|trim');
            } else {
                $this->form_validation->set_rules('status', 'status', 'required');
                $this->form_validation->set_rules('pilih_supplier', 'pilih_supplier', 'required|trim');
            }
        } else {
            $this->form_validation->set_rules('status', 'status', 'required');
            $this->form_validation->set_rules('pilih_supplier', 'pilih_supplier', 'required|trim');
        }
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

                if ($this->input->post('status') == 'Sudah Diterima') {
                    $this->db->select('*');
                    $this->db->from('data_detail_pengadaan');
                    $this->db->where('kode_pengadaan_fk', $kode);
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
                redirect('admin/detail_pengadaan/' . $idtrx);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Pengadaan Sukses di Edit!
           </div>');
            redirect('admin/detail_pengadaan/' . $idtrx);
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
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Cache-Control: no cache");
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

    public function kelola_produk()
    {
        $data['title'] = 'Kelola Data Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Produk_Model', 'menu');
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['dataProduk'] = $this->menu->getDataProdukAdmin();
        $this->form_validation->set_rules('nama', 'Name', 'required|trim|is_unique[data_produk.nama_produk]', [
            'is_unique' => 'Gagal Menambahkan Produk Baru, Produk Sudah Ada!',
        ]);
        $this->form_validation->set_rules('harga', 'harga', 'required|trim');
        $this->form_validation->set_rules('stok', 'stok', 'required|trim');
        $this->form_validation->set_rules('stok_minimal', 'stok_minimal', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            //PAGINATION SETTING
            $config = array();
            $config["base_url"] = base_url() . "admin/kelola_produk";
            $config["total_rows"] = $this->menu->get_count();
            $config["per_page"] = 10;
            $config["uri_segment"] = 3;

            $config['first_link'] = 'First';
            $config['last_link'] = 'Last';
            $config['next_link'] = 'Next';
            $config['prev_link'] = 'Prev';
            $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
            $config['full_tag_close'] = '</ul></nav></div>';
            $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close'] = '</span></li>';
            $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close'] = '</span>Next</li>';
            $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close'] = '</span></li>';

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            $data['dataProduk'] = $this->menu->get_produk($config["per_page"], $page);
            $this->load->view('admin/kelola_produk', $data);
            $this->load->view('templates/footer');
        } else {

            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_produk' => $this->input->post('nama'),
                'harga_produk' => $this->input->post('harga'),
                'stok_produk' => $this->input->post('stok'),
                'gambar_produk' => $this->response_upload(),
                'gambar_produk_desktop' => $_FILES["gambar_produk"]["name"],
                'stok_minimal_produk' => $this->input->post('stok_minimal'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_produk', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_produk');
        }
    }

    public function updateProduk($id)
    {
        $data['title'] = 'Kelola Data Produk';
        $cekProduk = $this->db->get_where('data_produk', ['id_produk' => $id])->row()->nama_produk;
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Produk_Model', 'menu');
        $data['dataProduk'] = $this->menu->getProdukId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        if ($cekProduk == $this->input->post('nama')) {

            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
            $this->form_validation->set_rules('harga', 'harga', 'required|trim');
            $this->form_validation->set_rules('stok', 'stok', 'required|trim');
            $this->form_validation->set_rules('stok_minimal', 'stok_minimal', 'required|trim');
        } else {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim|is_unique[data_produk.nama_produk]', [
                'is_unique' => 'Gagal Edit Produk, Nama Produk Sudah Ada!',
            ]);
            $this->form_validation->set_rules('harga', 'harga', 'required|trim');
            $this->form_validation->set_rules('stok', 'stok', 'required|trim');
            $this->form_validation->set_rules('stok_minimal', 'stok_minimal', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_produk', $data);
            $this->load->view('templates/footer');
        } else {
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_produk' => $this->input->post('nama'),
                'harga_produk' => $this->input->post('harga'),
                'stok_produk' => $this->input->post('stok'),
                'gambar_produk' => $this->response_upload_edit($id),
                'gambar_produk_desktop' => $_FILES["gambar_produk"]["name"],
                'stok_minimal_produk' => $this->input->post('stok_minimal'),
                'updated_date' => date("Y-m-d H:i:s"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->where('id_produk', $this->input->post('id'));
            $this->db->update('data_produk', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Berhasil Diedit!
           </div>');
            redirect('admin/kelola_produk');
        }
    }

    public function response_upload_edit($id)
    {
        $this->load->model('Produk_Model', 'menu');
        $part = "upload/gambar_produk/";
        $filename = "img" . rand(9, 9999) . ".jpg";

        if (!file_exists('upload/gambar/')) {
            mkdir('upload/gambar/', 777, true);
        }

        if ($_FILES["gambar_produk"]["name"] != "") {
            if ($this->menu->cekGambar($id) != 1) {
                unlink(FCPATH . $this->menu->cekGambar($id));
            }

            $destinationfile = $part . $filename;
            if (move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $destinationfile)) {
                return $destinationfile;
            } else {
                // gagal upload
                return 'upload/gambar_produk/default.jpg';
            }
        } else {
            //FILE TIDAK ADA DI UPLOAD
            if ($this->menu->cekGambar($id) == 1) {
                return 'upload/gambar_produk/default.jpg';
            } else {

                return $this->menu->cekGambar($id);
            };
        }
    }

    public function response_upload()
    {
        $part = "upload/gambar_produk/";
        $filename = "img" . rand(9, 9999) . ".jpg";

        if (!file_exists('upload/gambar/')) {
            mkdir('upload/gambar/', 777, true);
        }

        if ($_FILES["gambar_produk"]["name"] != "") {
            $destinationfile = $part . $filename;
            if (move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $destinationfile)) {
                return $destinationfile;
            } else {
                // gagal upload
                return 'upload/gambar_produk/default.jpg';
            }
        } else {
            //file upload tidak ada
            return 'upload/gambar_produk/default.jpg';
        }
    }

    public function hapusProduk($id)
    {
        $this->load->model('Produk_Model');
        if ($this->Produk_Model->deleteProduk($id) == -1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Produk Gagal Di Hapus, Data Masih digunakan!
             </div>');
            redirect('admin/kelola_produk');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Produk Berhasil Di Hapus!
               </div>');
            redirect('admin/kelola_produk');
        }
    }

    public function logProduk()
    {
        $data['title'] = 'Kelola Data Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Produk_Model', 'menu');
        $data['dataProduk'] = $this->menu->getDataLogProduk();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['log'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim|is_unique[data_produk.nama_produk]', [
                'is_unique' => 'Gagal Menambahkan Produk Baru, Produk Sudah Ada!',
            ]);
            $this->form_validation->set_rules('harga', 'harga', 'required|trim');
            $this->form_validation->set_rules('stok', 'stok', 'required|trim');
            $this->form_validation->set_rules('stok_minimal', 'stok_minimal', 'required|trim');
        }
        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/logProduk', $data);
            $this->load->view('templates/footer');
        } else {

            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_produk' => $this->input->post('nama'),
                'harga_produk' => $this->input->post('harga'),
                'stok_produk' => $this->input->post('stok'),
                'gambar_produk' => $this->response_upload(),
                'gambar_produk_desktop' => $_FILES["gambar_produk"]["name"],
                'stok_minimal_produk' => $this->input->post('stok_minimal'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_produk', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_produk');
        }
    }

    public function deletePermProduk($id)
    {
        $data['title'] = 'Kelola Data Produk';
        $this->load->model('Produk_Model');
        $this->Produk_Model->deletePermProduk($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Produk Berhasil Di Hapus Permanent!
               </div>');
        redirect('admin/logProduk');
    }

    public function restoreProduk($id)
    {
        $data['title'] = 'Kelola Data Produk';
        $this->load->model('Produk_Model');
        $this->Produk_Model->restoreProduk($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Produk Berhasil Di Restore!
               </div>');
        redirect('admin/kelola_produk');
    }

    public function cariProduk()
    {
        $data['title'] = 'Kelola Data Produk';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Produk_Model', 'menu');

        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");

        $data['menu'] = $this->db->get('user_menu')->result_array();
        if (!isset($_POST['cari'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim|is_unique[data_produk.nama_produk]', [
                'is_unique' => 'Gagal Menambahkan Produk Baru, Produk Sudah Ada!',
            ]);
            $this->form_validation->set_rules('harga', 'harga', 'required|trim');
            $this->form_validation->set_rules('stok', 'stok', 'required|trim');
            $this->form_validation->set_rules('stok_minimal', 'stok_minimal', 'required|trim');
        }
        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);

            $config = array();
            $config["base_url"] = base_url() . "admin/cariProduk";
            $config["total_rows"] = $this->menu->get_count();
            $config["per_page"] = 10;
            $config["uri_segment"] = 3;

            $config['first_link'] = 'First';
            $config['last_link'] = 'Last';
            $config['next_link'] = 'Next';
            $config['prev_link'] = 'Prev';
            $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
            $config['full_tag_close'] = '</ul></nav></div>';
            $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close'] = '</span></li>';
            $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close'] = '</span>Next</li>';
            $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close'] = '</span></li>';

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["dataProduk"] = $this->menu->cariProduk($data['cariberdasarkan'], $data['yangdicari'], $config["per_page"], $page)->result_array();
            $data["jumlah"] = count($data["dataProduk"]);
            $data["links"] = $this->pagination->create_links();

            $this->load->view('admin/cariProduk', $data);
            $this->load->view('templates/footer');
        } else {

            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_produk' => $this->input->post('nama'),
                'harga_produk' => $this->input->post('harga'),
                'stok_produk' => $this->input->post('stok'),
                'gambar_produk' => $this->response_upload(),
                'gambar_produk_desktop' => $_FILES["gambar_produk"]["name"],
                'stok_minimal_produk' => $this->input->post('stok_minimal'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_produk', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_produk');
        }
    }

    #Jasa layanan
    public function kelola_layanan()
    {
        $data['title'] = 'Kelola Data Layanan';
        $layanan = $this->input->post('nama');
        $ukuran = $this->input->post('pilih_ukuran');
        $jenis = $this->input->post('pilih_jenis');
        $query = "SELECT nama_jasa_layanan FROM data_jasa_layanan WHERE nama_jasa_layanan = '$layanan' AND id_jenis_hewan = '$jenis' AND id_ukuran_hewan = '$ukuran' ";
        $result = $this->db->query($query, $layanan);

        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Jasa_Layanan_Model', 'menu');
        // INI UNTUK DROPDOWN
        $data['data_ukuran'] = $this->menu->select_ukuran();
        $data['data_jenis'] = $this->menu->select_jenis();

        $data['dataJasaLayanan'] = $this->menu->getDataJasaLayananAdmin();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        if ($result->num_rows() >= 1) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim|is_unique[data_jasa_layanan.nama_jasa_layanan]', [
                'is_unique' => 'Gagal Menambahkan Layanan Baru, Layanan Sudah Ada!',
            ]);
            $this->form_validation->set_rules('harga', 'harga', 'required|trim');
            $this->form_validation->set_rules('pilih_jenis', 'pilih_jenis', 'required|trim');
            $this->form_validation->set_rules('pilih_ukuran', 'pilih_ukuran', 'required|trim');
        } else {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
            $this->form_validation->set_rules('harga', 'harga', 'required|trim');
            $this->form_validation->set_rules('pilih_jenis', 'pilih_jenis', 'required|trim');
            $this->form_validation->set_rules('pilih_ukuran', 'pilih_ukuran', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_layanan', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_jasa_layanan' => $this->input->post('nama'),
                'harga_jasa_layanan' => $this->input->post('harga'),
                'id_jenis_hewan' => $this->input->post('pilih_jenis'),
                'id_ukuran_hewan' => $this->input->post('pilih_ukuran'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_jasa_layanan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Jasa Layanan Berhasil Ditambahkan!
            </div>');
            redirect('admin/kelola_layanan');
        }
    }

    public function updateJasaLayanan($id)
    {
        $data['title'] = 'Kelola Jasa Layanan';

        $layanan = $this->input->post('nama');
        $ukuran = $this->input->post('pilih_ukuran');
        $jenis = $this->input->post('pilih_jenis');
        $query = "SELECT nama_jasa_layanan FROM data_jasa_layanan WHERE nama_jasa_layanan = '$layanan' AND id_jenis_hewan = '$jenis' AND id_ukuran_hewan = '$ukuran' AND id_jasa_layanan !='$id' ";
        $result = $this->db->query($query, $layanan);

        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Jasa_Layanan_Model', 'menu');
        $data['dataJasaLayanan'] = $this->menu->getJasaLayananId($id);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_ukuran'] = $this->menu->select_ukuran();
        $data['data_jenis'] = $this->menu->select_jenis();

        if ($result->num_rows() >= 1) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim|is_unique[data_jasa_layanan.nama_jasa_layanan]', [
                'is_unique' => 'Gagal Menambahkan Layanan Baru, Layanan Sudah Ada!',
            ]);
            $this->form_validation->set_rules('harga', 'harga', 'required|trim');
            $this->form_validation->set_rules('pilih_jenis', 'pilih_jenis', 'required|trim');
            $this->form_validation->set_rules('pilih_ukuran', 'pilih_ukuran', 'required|trim');
        } else {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
            $this->form_validation->set_rules('harga', 'harga', 'required|trim');
            $this->form_validation->set_rules('pilih_jenis', 'pilih_jenis', 'required|trim');
            $this->form_validation->set_rules('pilih_ukuran', 'pilih_ukuran', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelola_layanan', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_jasa_layanan' => $this->input->post('nama'),
                'harga_jasa_layanan' => $this->input->post('harga'),
                'id_jenis_hewan' => $this->input->post('pilih_jenis'),
                'id_ukuran_hewan' => $this->input->post('pilih_ukuran'),
                'updated_date' => date("Y-m-d H:i:s"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->where('id_jasa_layanan', $this->input->post('id'));
            $this->db->update('data_jasa_layanan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data Jasa Layanan Sukses di Edit!
           </div>');
            redirect('admin/kelola_layanan');
        }
    }

    public function hapusJasaLayanan($id)
    {
        $this->load->model('Jasa_Layanan_Model');
        if ($this->Jasa_Layanan_Model->deleteJasaLayanan($id) == -1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Jasa Layanan Gagal Di Hapus, Data Masih digunakan!
             </div>');
            redirect('admin/kelola_layanan');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Jasa Layanan Berhasil Di Hapus!
               </div>');
            redirect('admin/kelola_layanan');
        }
    }

    public function deletePermJasaLayanan($id)
    {
        $this->load->model('Jasa_Layanan_Model');
        $this->Jasa_Layanan_Model->deletePermJasaLayanan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Jasa Layanan Berhasil Di Hapus!
               </div>');
        redirect('admin/kelola_layanan');
    }

    public function logLayanan()
    {
        $data['title'] = 'Kelola Data Layanan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Jasa_Layanan_Model', 'menu');
        $data['dataJasaLayanan'] = $this->menu->getDataLogLayanan();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['data_ukuran'] = $this->menu->select_ukuran();
        $data['data_jenis'] = $this->menu->select_jenis();

        if (!isset($_POST['log'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim|is_unique[data_jasa_layanan.nama_jasa_layanan]', [
                'is_unique' => 'Gagal Menambahkan Layanan Baru, Layanan Sudah Ada!',
            ]);
            $this->form_validation->set_rules('harga', 'harga', 'required|trim');
            $this->form_validation->set_rules('pilih_jenis', 'pilih_jenis', 'required|trim');
            $this->form_validation->set_rules('pilih_ukuran', 'pilih_ukuran', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/logLayanan', $data);
            $this->load->view('templates/footer');
        } else {

            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_jasa_layanan' => $this->input->post('nama'),
                'harga_jasa_layanan' => $this->input->post('harga'),
                'id_jenis_hewan' => $this->input->post('pilih_jenis'),
                'id_ukuran_hewan' => $this->input->post('pilih_ukuran'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_jasa_layanan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Jasa Layanan Berhasil Ditambahkan!
            </div>');
            redirect('admin/kelola_layanan');
        }
    }

    public function cariJasaLayanan()
    {
        $data['title'] = 'Kelola Data Layanan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Jasa_Layanan_Model', 'menu');
        // INI UNTUK DROPDOWN
        $data['data_ukuran'] = $this->menu->select_ukuran();
        $data['data_jenis'] = $this->menu->select_jenis();

        $data['cariberdasarkan'] = $this->input->post("cariberdasarkan");
        $data['yangdicari'] = $this->input->post("yangdicari");
        $data["dataJasaLayanan"] = $this->menu->cariJasaLayanan($data['cariberdasarkan'], $data['yangdicari'])->result_array();
        $data["jumlah"] = count($data["dataJasaLayanan"]);

        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($_POST['cari'])) {
            $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        }

        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/cariJasaLayanan', $data);
            $this->load->view('templates/footer');
        } else {
            $emailPembeli = $data['user']['email'];
            date_default_timezone_set("Asia/Bangkok");
            $data = [
                'nama_jasa_layanan' => $this->input->post('nama'),
                'harga_jasa_layanan' => $this->input->post('harga'),
                'id_jenis_hewan' => $this->input->post('pilih_jenis'),
                'id_ukuran_hewan' => $this->input->post('pilih_ukuran'),
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];

            $this->db->insert('data_jasa_layanan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Jasa Layanan Berhasil Ditambahkan!
           </div>');
            redirect('admin/kelola_layanan');
        }
    }

    public function restoreJasaLayanan($id)
    {
        $data['title'] = 'Kelola Data Jasa Layanan';
        $this->load->model('Jasa_Layanan_Model');
        $this->Jasa_Layanan_Model->restoreJasaLayanan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Jasa Layanan Berhasil Di Restore!
               </div>');
        redirect('admin/kelola_layanan');
    }

    public function laporan()
    {
        $data['title'] = 'Laporan';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        //VALIDASI TAHUN 
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('pilih_tahun', 'pilih_tahun', 'required');
        } else if (isset($_POST['produk_tahunan'])) {
            $this->form_validation->set_rules('pilih_tahun', 'pilih_tahun', 'required');
        } else if (isset($_POST['pendapatan_tahunan'])) {
            $this->form_validation->set_rules('pilih_tahun', 'pilih_tahun', 'required');
        }
        if ($this->form_validation->run() == false) {
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/laporan', $data);
            $this->load->view('templates/footer');
        } else {
            /// PROSES CETAK LAPORAN
            if (isset($_POST['submit'])) {
                $tahun = $this->input->post('pilih_tahun');
                $this->laporanLayananTerlaris($tahun);
            } else if (isset($_POST['produk_tahunan'])) {
                $tahun = $this->input->post('pilih_tahun');
                $this->laporanProdukTerlaris($tahun);
            } else if (isset($_POST['pendapatan_tahunan'])) {
                $tahun = $this->input->post('pilih_tahun');
                $this->laporanPendapatanTahunan($tahun);
            }
        }
    }

    public function laporanPendapatanTahunan($tahun)
    {
        $cnt = 1;
        $pdf = new FPDF('P', 'mm', array(210, 210));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        //HEADER LAPORAN
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Rect(5, 5, 200, 200, 'D');
        $pdf->Image(base_url('assets/img/headerlaporan.png'), 7, 10, 195, 0, 'PNG');

        //TEXT
        $pdf->Cell(10, 60, '', 0, 1);
        $pdf->Cell(190, 7, 'LAPORAN PENDAPATAN TAHUNAN', 99, 1, 'C');
        $pdf->Cell(10, 15, '', 0, 1);
        $pdf->SetLeftMargin(28);
        $pdf->Cell(190, 0, 'Tahun : ' . $tahun, 99, 5, 'L');
        $pdf->Cell(10, 5, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 5, 'No', 1, 0, 'C');
        $pdf->Cell(30, 5, 'Bulan', 1, 0, 'C');
        $pdf->Cell(40, 5, 'Jasa Layanan', 1, 0, 'C');
        $pdf->Cell(40, 5, 'Produk', 1, 0, 'C');
        $pdf->Cell(35, 5, 'Total', 1, 1, 'C');
        $pdf->SetFillColor(193, 229, 252);

        $query = $this->db->query("SELECT  months.`month` as bulan,IFNULL(jasa_layanan,'0') as jasa_layanan,IFNULL(produk,'0') as produk,COALESCE(sum(jasa_layanan),0)+COALESCE(sum(produk),0) as total
        FROM 
            (SELECT monthname(data_transaksi_penjualan_produk.created_date) AS bulan, sum(data_transaksi_penjualan_produk.total_harga) as produk,sum(data_transaksi_penjualan_jasa_layanan.total_harga) jasa_layanan
            FROM  data_transaksi_penjualan_produk  LEFT JOIN data_transaksi_penjualan_jasa_layanan ON data_transaksi_penjualan_produk.created_date = data_transaksi_penjualan_jasa_layanan.created_date
            WHERE EXTRACT(YEAR FROM data_transaksi_penjualan_produk.created_date) =$tahun AND data_transaksi_penjualan_produk.status_pembayaran ='Lunas'
            GROUP BY monthname(data_transaksi_penjualan_produk.created_date) desc
            UNION
            SELECT monthname(data_transaksi_penjualan_jasa_layanan.created_date)AS bulan, sum(data_transaksi_penjualan_produk.total_harga) as produk,sum(data_transaksi_penjualan_jasa_layanan.total_harga) as jasa_layanan
            FROM  data_transaksi_penjualan_produk  RIGHT JOIN data_transaksi_penjualan_jasa_layanan ON data_transaksi_penjualan_produk.created_date = data_transaksi_penjualan_jasa_layanan.created_date
            WHERE EXTRACT(YEAR FROM data_transaksi_penjualan_jasa_layanan.created_date) =$tahun AND data_transaksi_penjualan_jasa_layanan.status_pembayaran ='Lunas'
            GROUP BY monthname(data_transaksi_penjualan_jasa_layanan.created_date) desc) t
        RIGHT OUTER JOIN months ON months.`month` = bulan
        GROUP BY
            months.`month`
        ORDER BY
            months.no");
        $pendapatanThn = $query->result();
        foreach ($pendapatanThn as $row) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 5, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(30, 5,  $row->bulan, 1, 0, 'L', 0);
            $pdf->Cell(40, 5, ' Rp. ' . number_format($row->jasa_layanan, 0, '', '.') . ', -', 1, 0);
            $pdf->Cell(40, 5, ' Rp. ' . number_format($row->produk, 0, '', '.') . ', -', 1, 0);
            $pdf->Cell(35, 5, ' Rp. ' . number_format($row->total, 0, '', '.') . ', -', 1, 1, 'L');
            $cnt++;
        }
        $pdf->Cell(10, 20, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(262, 0, 'Dicetak Tanggal ' . date('d F Y'), 99, 1, 'C');
        $pdf->Output("I", "[LAPORAN] Pendapatan Tahunan - " . $tahun . ".pdf");
    }

    public function laporanLayananTerlaris($tahun)
    {
        $cnt = 1;
        $pdf = new FPDF('P', 'mm', array(210, 210));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        //HEADER LAPORAN
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Rect(5, 5, 200, 200, 'D');
        $pdf->Image(base_url('assets/img/headerlaporan.png'), 7, 10, 195, 0, 'PNG');

        //TEXT
        $pdf->Cell(10, 60, '', 0, 1);
        $pdf->Cell(190, 7, 'LAPORAN JASA LAYANAN TERLARIS', 99, 1, 'C');
        $pdf->Cell(10, 15, '', 0, 1);
        $pdf->SetLeftMargin(28);
        $pdf->Cell(190, 0, 'Tahun : ' . $tahun, 99, 5, 'L');
        $pdf->Cell(10, 5, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 5, 'No', 1, 0, 'C');
        $pdf->Cell(30, 5, 'Bulan', 1, 0, 'C');
        $pdf->Cell(80, 5, 'Nama Layanan', 1, 0, 'C');
        $pdf->Cell(35, 5, 'Jumlah Penjualan', 1, 1, 'C');
        $pdf->SetFillColor(193, 229, 252);

        $query = $this->db->query("SELECT  months.`month` as bulan,IFNULL(CONCAT(nama_jasa_layanan,' ',nama_jenis_hewan,' ',ukuran_hewan),'-') as nama_jasa_layanan,IFNULL(jumlah,0) as jumlah_penjualan from(
            SELECT data_jasa_layanan.nama_jasa_layanan,data_ukuran_hewan.ukuran_hewan,data_jenis_hewan.nama_jenis_hewan,sum(data_detail_penjualan_jasa_layanan.jumlah_jasa_layanan) as jumlah , monthname(data_transaksi_penjualan_jasa_layanan.created_date) as bulan
            FROM
                data_detail_penjualan_jasa_layanan JOIN data_transaksi_penjualan_jasa_layanan ON data_detail_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan_fk =
                data_transaksi_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan JOIN data_jasa_layanan ON data_jasa_layanan.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk JOIN data_ukuran_hewan ON data_ukuran_hewan.id_ukuran_hewan = data_jasa_layanan.id_ukuran_hewan JOIN data_jenis_hewan ON data_jenis_hewan.id_jenis_hewan = data_jasa_layanan.id_jenis_hewan
            WHERE EXTRACT(YEAR FROM data_transaksi_penjualan_jasa_layanan.created_date) =$tahun AND data_transaksi_penjualan_jasa_layanan.status_pembayaran ='Lunas'
            GROUP BY data_jasa_layanan.`nama_jasa_layanan`,data_jasa_layanan.id_jenis_hewan,data_jasa_layanan.id_ukuran_hewan,monthname(data_transaksi_penjualan_jasa_layanan.created_date) order by jumlah desc ) t
            RIGHT OUTER JOIN months ON months.`month` = bulan
            GROUP BY
                months.`month`
            ORDER BY
                months.no");
        $layananTerlaris = $query->result();
        foreach ($layananTerlaris as $row) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 5, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(30, 5, $row->bulan, 1, 0, 'L', 0);
            $pdf->Cell(80, 5, $row->nama_jasa_layanan, 1, 0);
            $pdf->Cell(35, 5, $row->jumlah_penjualan, 1, 1, 'C');
            $cnt++;
        }
        $pdf->Cell(10, 20, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(262, 0, 'Dicetak Tanggal ' . date('d F Y'), 99, 1, 'C');
        $pdf->Output("I", "[LAPORAN] Terlaris Jasa Layanan - " . $tahun . ".pdf");
    }

    public function laporanProdukTerlaris($tahun)
    {
        $cnt = 1;
        $pdf = new FPDF('P', 'mm', array(210, 210));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        //HEADER LAPORAN
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Rect(5, 5, 200, 200, 'D');
        $pdf->Image(base_url('assets/img/headerlaporan.png'), 7, 10, 195, 0, 'PNG');

        //TEXT
        $pdf->Cell(10, 60, '', 0, 1);
        $pdf->Cell(190, 7, 'LAPORAN PRODUK TERLARIS', 99, 1, 'C');
        $pdf->Cell(10, 15, '', 0, 1);
        $pdf->SetLeftMargin(28);
        $pdf->Cell(190, 0, 'Tahun : ' . $tahun, 99, 5, 'L');
        $pdf->Cell(10, 5, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 5, 'No', 1, 0, 'C');
        $pdf->Cell(30, 5, 'Bulan', 1, 0, 'C');
        $pdf->Cell(80, 5, 'Nama Produk', 1, 0, 'C');
        $pdf->Cell(35, 5, 'Jumlah Penjualan', 1, 1, 'C');
        $pdf->SetFillColor(193, 229, 252);

        $query = $this->db->query("SELECT  months.`month` as bulan,IFNULL(nama_produk,'-') as nama_produk,IFNULL(jumlah,0) as jumlah_penjualan from(
            SELECT data_produk.nama_produk,sum(data_detail_penjualan_produk.jumlah_produk) as jumlah , monthname(data_transaksi_penjualan_produk.created_date) as bulan
            FROM
                data_detail_penjualan_produk JOIN data_transaksi_penjualan_produk ON data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk =
                data_transaksi_penjualan_produk.kode_transaksi_penjualan_produk JOIN data_produk ON data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk
            WHERE EXTRACT(YEAR FROM data_transaksi_penjualan_produk.created_date) =$tahun AND data_transaksi_penjualan_produk.status_pembayaran ='Lunas'
            GROUP BY data_produk.`nama_produk`,monthname(data_transaksi_penjualan_produk.created_date) order by jumlah desc ) t
            RIGHT OUTER JOIN months ON months.`month` = bulan
            GROUP BY
                months.`month`
            ORDER BY
                months.no");
        $layananTerlaris = $query->result();
        foreach ($layananTerlaris as $row) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 5, $cnt, 1, 0, 'C', 0);
            $pdf->Cell(30, 5, $row->bulan, 1, 0, 'L', 0);
            $pdf->Cell(80, 5, $row->nama_produk, 1, 0);
            $pdf->Cell(35, 5, $row->jumlah_penjualan, 1, 1, 'C');
            $cnt++;
        }
        $pdf->Cell(10, 20, '', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(262, 0, 'Dicetak Tanggal ' . date('d F Y'), 99, 1, 'C');
        $pdf->Output("I", "[LAPORAN] Terlaris Produk - " . $tahun . ".pdf");
    }
}
