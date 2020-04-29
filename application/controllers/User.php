<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit', $data);
            $this->load->view('templates/footer');
        } else {

            $new_password = $this->input->post('password');
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $this->db->set('password', $password_hash);
            $this->db->where('username', $this->session->userdata('username'));
            $this->db->update('user');

            $name = $this->input->post('name');
            $username = $this->input->post('username');

            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['upload_path']          = './assets/img/profile/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 90000;
                $config['max_width']            = 5000;
                $config['max_height']           = 5000;

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) { 
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $this->load->library('image_lib');
                    $image_data =   $this->upload->data();

                    $configer =  array(
                        'image_library'   => 'gd2',
                        'source_image'    =>  $image_data['full_path'],
                        'maintain_ratio'  =>  TRUE,
                        'width'           =>  200,
                        'height'          =>  200,
                    );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configer);
                    $this->image_lib->resize();

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('username', $username);
            $this->db->update('user');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Profile Updated!  </div>');
            redirect('user');
        }
    }

    public function buycars()
    {
        $data['title'] = 'Buy Car';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Buy_Model', 'menu');
        $data['dataBeliMobil'] = $this->menu->getDataBeliMobil();
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
            $this->load->view('buycars/buycars', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];

            $data = [
                'name' => $this->input->post('name'),
                'merk' => $this->input->post('merk'),
                'type' => $this->input->post('type'),
                'harga' => $this->input->post('harga'),
                'nomorhp' => $this->input->post('nomorhp'),
                'username_pembeli' => $usernamePembeli
            ];

            $this->db->insert('buy_cars', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Cars Added
           </div>');
            redirect('user/buycars');
        }
    }

    public function updateMobil($id)
    {
        $data['title'] = 'Buy Car';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
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
            $usernamePembeli = $data['user']['username'];
            $data = [
                'name' => $this->input->post('name'),
                'merk' => $this->input->post('merk'),
                'type' => $this->input->post('type'),
                'harga' => $this->input->post('harga'),
                'nomorhp' => $this->input->post('nomorhp'),
                'username_pembeli' => $usernamePembeli
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('buy_cars', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Cars Success Edited!
           </div>');
            redirect('user/buycars');
        }
    }

    public function sellcars()
    {
        $data['title'] = 'Sell Car';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Jual_Model', 'menu');
        $data['dataJualMobil'] = $this->menu->getDataJualMobil();
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
            $this->load->view('sellcars/sellcars', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];

            $data = [
                'name' => $this->input->post('name'),
                'merk' => $this->input->post('merk'),
                'warna' => $this->input->post('warna'),
                'bahan_bakar' => $this->input->post('bahan_bakar'),
                'harga' => $this->input->post('harga'),
                'username_pembeli' => $usernamePembeli
            ];

            $this->db->insert('sell_cars', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Cars Added
           </div>');
            redirect('user/sellcars');
        }
    }

    public function buysparepart()
    {
        $data['title'] = 'Sell Sparepart';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Sparepart_Model', 'menu');
        $data['dataBeliSparepart'] = $this->menu->getDataBeliSparepart();
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
            $usernamePembeli = $data['user']['username'];

            $data = [
                'name' => $this->input->post('name'),
                'name_sparepart' => $this->input->post('name_sparepart'),
                'deskripsi' => $this->input->post('deskripsi'),
                'harga' => $this->input->post('harga'),
                'kondisi' => $this->input->post('kondisi'),
                'username_pembeli' => $usernamePembeli
            ];

            $this->db->insert('buy_sparepart', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Sparepart Added!
           </div>');
            redirect('user/buysparepart');
        }
    }

    public function hapusMobil($id)
    {
        $this->load->model('Buy_Model');
        $this->Buy_Model->deleteBuyCars($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
               Car Success Deleted!
               </div>');
        redirect('user/buycars');
    }

    public function hapusSparepart($id)
    {
        $this->load->model('Sparepart_Model');
        $this->Sparepart_Model->deleteBuySparepart($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
               Sparepart Success Deleted!
               </div>');
        redirect('user/buysparepart');
    }

    public function hapusJualMobil($id)
    {
        $this->load->model('Jual_Model');
        $this->Jual_Model->deleteJualMobil($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
               Your Car Success Deleted!
               </div>');
        redirect('user/sellcars');
    }


    public function updateSparepart($id)
    {
        $data['title'] = 'Sell Sparepart';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
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
            $usernamePembeli = $data['user']['username'];

            $data = [
                'name' => $this->input->post('name'),
                'name_sparepart' => $this->input->post('name_sparepart'),
                'deskripsi' => $this->input->post('deskripsi'),
                'harga' => $this->input->post('harga'),
                'kondisi' => $this->input->post('kondisi'),
                'username_pembeli' => $usernamePembeli
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('buy_sparepart', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Sparepart Success Edited!
           </div>');
            redirect('user/buysparepart');
        }
    }

    public function updateJualMobil($id)
    {
        $data['title'] = 'Sell Car';
        $data['user'] = $this->db->get_where('data_pegawai', ['username' => $this->session->userdata('username')])->row_array();
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
            $this->load->view('sellcars/sellcars', $data);
            $this->load->view('templates/footer');
        } else {
            $usernamePembeli = $data['user']['username'];

            $data = [
                'name' => $this->input->post('name'),
                'merk' => $this->input->post('merk'),
                'warna' => $this->input->post('warna'),
                'bahan_bakar' => $this->input->post('bahan_bakar'),
                'harga' => $this->input->post('harga'),
                'username_pembeli' => $usernamePembeli
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('sell_cars', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your Car Success Edited!
           </div>');
            redirect('user/sellcars');
        }
    }

    function map()
    {
        $data['title'] = 'Map Location';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Jual_Model', 'menu');
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

            $this->load->library('googlemaps');
            $config = array();
            $config['center'] = "-6.1807975,106.7659006";
            $config['zoom'] = 17;
            $config['map_height'] = "400px";
            $this->googlemaps->initialize($config);
            $marker = array();
            $marker['position'] = "-6.1807975,106.7659006";
            $this->googlemaps->add_marker($marker);
            $data['map'] = $this->googlemaps->create_map();
            $this->load->view('maps/map', $data);
            $this->load->view('templates/footer');
        }
    }
}