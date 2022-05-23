<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct()
    {
        parent::__construct();
        // Cek Login
        if ($this->session->userdata('status') != "login") {
            redirect(base_url() . 'welcome?pesan=belumlogin');
        }
        $this->load->model('Mrental');
    }
    public function index()
    {
        $data['transaksi'] = $this->db->query("select * from transaksi order by transaksi_id desc limit 10")->result();
        $data['kustomer'] = $this->db->query("select * from kustomer order by kustomer_id desc limit 10")->result();
        $data['mobil'] = $this->db->query("select * from mobil order by mobil_id desc limit 10")->result();
        $this->load->view('admin/header');
        $this->load->view('admin/index', $data);
        $this->load->view('admin/footer');
    }
    function ganti_password(){
        $this->load->view('admin/header');
        $this->load->view('admin/ganti_password');
        $this->load->view('admin/footer');
        }
        
    public function test()
    {
        echo "KOK GAK JADI KOCAK";
    }
    function logout(){
        $this->session->sess_destroy();
        redirect(base_url().'welcome?pesan=logout');
        }
        
}
