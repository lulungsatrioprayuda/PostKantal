<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_udah_login();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user_tabel', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'hello ' . $data['user']['name'] . ' !';

        $this->load->view('Element/Elemen_Dashboard/Element_Header', $data);
        $this->load->view('Element/Elemen_Dashboard/Element_Navbar', $data);
        $this->load->view('Element/Elemen_Dashboard/Element_Sidebar', $data);
        $this->load->view('Admin/Index', $data);
        $this->load->view('Element/Elemen_Dashboard/Element_Footer');
    }

    public function Role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user_tabel', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();
        $this->load->view('Element/Elemen_Dashboard/Element_Header', $data);
        $this->load->view('Element/Elemen_Dashboard/Element_Navbar', $data);
        $this->load->view('Element/Elemen_Dashboard/Element_Sidebar', $data);
        $this->load->view('Admin/role', $data);
        $this->load->view('Element/Elemen_Dashboard/Element_Footer');
    }

    public function Roleaccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user_tabel', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->load->view('Element/Elemen_Dashboard/Element_Header', $data);
        $this->load->view('Element/Elemen_Dashboard/Element_Navbar', $data);
        $this->load->view('Element/Elemen_Dashboard/Element_Sidebar', $data);
        $this->load->view('Admin/role-access', $data);
        $this->load->view('Element/Elemen_Dashboard/Element_Footer');
    }

    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">JOS GANDOS MAMANK KEUBAH</div>');
    }
}