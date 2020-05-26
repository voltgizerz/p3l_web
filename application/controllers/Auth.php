<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('role_id') == '1') {
            redirect('admin');
        } else if ($this->session->userdata('role_id') == '2') {
            redirect('cs');
        } else if ($this->session->userdata('role_id') == '3') {
            redirect('kasir');
        }
        //validasi login
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Kouvee Pet Shop - Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('data_pegawai', ['username' => $username])->row_array();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'username' => $user['username'],
                    'role_id' => $user['role_id'],
                    'id_pegawai' => $user['id_pegawai'],
                    'nama_pegawai'  => $user['nama_pegawai'],
                    'role'  => $user['role']
                ];
                $this->session->set_userdata($data);

                if ($user['role_id'] == 1) {
                    redirect('admin');
                } else if ($user['role_id'] == 2) {
                    redirect('cs');
                } else if ($user['role_id'] == 3) {
                    redirect('kasir');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Anda Salah!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username Tidak Terdaftar!</div>');
            redirect('auth');
        }
    }

    public function registration()
    {
        if ($this->session->userdata('username')) {
            redirect('user');
        }
        //validasi registrasi
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'RichzAuto - Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {

            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'datecreated' => time()
            ];

            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->sendEmail($token, 'verify');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">  Success! Created Your Account Please Check Your Email to activate your account!  </div>');
            redirect('auth');
        }
    }

    public function home()
    {
        //validasi registrasi
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Kouvee Pet Shop - HomePage';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/home');
            $this->load->view('templates/auth_footer');
        } else {

            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'datecreated' => time()
            ];

            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->sendEmail($token, 'verify');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">  Success! Created Your Account Please Check Your Email to activate your account!  </div>');
            redirect('auth');
        }
    }

    private function sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'richzautopaw@gmail.com',
            'smtp_pass' => 'richzauto12345',
            'smtp_port' => '465',
            'maitype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];
        $this->load->library('email', $config);

        $this->email->from('richzautopaw@gmail.com', 'RichzAuto - PAW');
        $this->email->to($this->input->post('email'));
        $this->email->Subject('Account Verification - RichzAuto');

        $this->email->message('Click This Link To Verify Your Account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');

        if ($this->email->send()) {
            return true;
        } else {
        }
    }

    public function verify()
    {

        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->db->set('is_active', 1);
                $this->db->where('email', $email);
                $this->db->update('user');

                $this->db->delete('user_token', ['email' => $email]);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Activated Account!</div>');
                redirect('auth');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Invalid Token!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account Activation Failed! Wrong Email!</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('id_pegawai');
        $this->session->unset_userdata('nama_pegawai');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Berhasil Logout!
      </div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
