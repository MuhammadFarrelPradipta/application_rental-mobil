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
    function ganti_password()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/ganti_password');
        $this->load->view('admin/footer');
    }

    public function test()
    {
        echo "KOK GAK JADI KOCAK";
    }
    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'welcome?pesan=logout');
    }
    function ganti_password_act()
    {
        $pass_baru = $this->input->post('pass_baru');
        $ulang_pass = $this->input->post('ulang_pass');
        $this->form_validation->set_rules('pass_baru', 'Password Baru', 'required|matches[ulang_pass]');
        $this->form_validation->set_rules('ulang_pass', 'Ulangi Password Baru', 'required');

        if ($this->form_validation->run() != false) {
            $data = array(
                'admin_password' => md5($pass_baru)
            );
            $w = array(
                'admin_id' => $this->session->userdata('id')
            );
            $this->Mrental->update_data($w, $data, 'admin');
            redirect(base_url() . 'admin/ganti_password?pesan=berhasil');
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/ganti_password');
            $this->load->view('admin/footer');
        }
    }
    function mobil()
    {
        $data['mobil'] = $this->Mrental->get_data('mobil')->result();
        $this->load->view('admin/header');
        $this->load->view('admin/mobil', $data);
        $this->load->view('admin/footer');
    }
    function mobil_add()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/mobil_add');
        $this->load->view('admin/footer');
    }
    function mobil_add_act()
    {
        $merk = $this->input->post('merk');
        $plat = $this->input->post('plat');
        $warna = $this->input->post('warna');
        $tahun = $this->input->post('tahun');
        $status = $this->input->post('status');
        $this->form_validation->set_rules('merk', 'Merk Mobil', 'required');
        $this->form_validation->set_rules('status', 'Status Mobil', 'required');
        if ($this->form_validation->run() != false) {
            $data = array(
                'mobil_merk' => $merk,
                'mobil_plat' => $plat,
                'mobil_warna' => $warna,
                'mobil_tahun' => $tahun,
                'mobil_status' => $status
            );
            $this->Mrental->insert_data($data, 'mobil');
            redirect(base_url() . 'admin/mobil');
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/mobil_add');
            $this->load->view('admin/footer');
        }
    }
    function mobil_edit($id)
    {
        $where = array(
            'mobil_id' => $id
        );
        $data['mobil'] = $this->Mrental->edit_data($where, 'mobil')->result();
        $this->load->view('admin/header');
        $this->load->view('admin/mobil_edit', $data);
        $this->load->view('admin/footer');
    }
    function mobil_update()
    {
        $id = $this->input->post('id');
        $merk = $this->input->post('merk');
        $plat = $this->input->post('plat');
        $warna = $this->input->post('warna');
        $tahun = $this->input->post('tahun');
        $status = $this->input->post('status');
        $this->form_validation->set_rules('merk', 'Merk Mobil', 'required');
        $this->form_validation->set_rules('status', 'Status Mobil', 'required');
        if ($this->form_validation->run() != false) {
            $where = array(
                'mobil_id' => $id
            );
            $data = array(
                'mobil_merk' => $merk,
                'mobil_plat' => $plat,
                'mobil_warna' => $warna,
                'mobil_tahun' => $tahun,
                'mobil_status' => $status
            );
            $this->Mrental->update_data($where, $data, 'mobil');
            redirect(base_url() . 'admin/mobil');
        } else {
            $where = array(
                'mobil_id' => $id
            );
            $data['mobil'] = $this->Mrental->edit_data($where, 'mobil')->result();
            $this->load->view('admin/header');
            $this->load->view('admin/mobil_edit', $data);
            $this->load->view('admin/footer');
        }
    }
    function mobil_hapus($id)
    {
        $where = array(
            'mobil_id' => $id
        );
        $this->Mrental->delete_data($where, 'mobil');
        redirect(base_url() . 'admin/mobil');
    }
    function kostumer()
    {
        $data['kostumer'] = $this->Mrental->get_data('kustomer')->result();
        $this->load->view('admin/header');
        $this->load->view('admin/kostumer', $data);
        $this->load->view('admin/footer');
    }
    function kostumer_add()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/kostumer_add');
        $this->load->view('admin/footer');
    }
    function kostumer_add_act()
    {
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $jk = $this->input->post('jk');
        $hp = $this->input->post('hp');
        $ktp = $this->input->post('ktp');
        $this->form_validation->set_rules('nama', 'nama', 'required');
        if ($this->form_validation->run() != false) {
            $data = array(
                'kustomer_nama' => $nama,
                'kustomer_alamat' => $alamat,
                'kustomer_jk' => $jk,
                'kustomer_hp' => $hp,
                'kustomer_ktp' => $ktp
            );
            $this->Mrental->insert_data($data, 'kustomer');
            redirect(base_url() . 'admin/kostumer');
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/kostumer_add');
            $this->load->view('admin/footer');
        }
    }
    function kostumer_edit($id)
    {
        $where = array(
            'kustomer_id' => $id
        );
        $data['kostumer'] = $this->Mrental->edit_data($where, 'kustomer')->result();
        $this->load->view('admin/header');
        $this->load->view('admin/kostumer_edit', $data);
        $this->load->view('admin/footer');
    }
    function kostumer_update()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $jk = $this->input->post('jk');
        $hp = $this->input->post('hp');
        $ktp = $this->input->post('ktp');
        $this->form_validation->set_rules('nama', 'nama', 'required');
        if ($this->form_validation->run() != false) {
            $where = array(
                'kustomer_id' => $id
            );
            $data = array(
                'kustomer_nama' => $nama,
                'kustomer_alamat' => $alamat,
                'kustomer_jk' => $jk,
                'kustomer_hp' => $hp,
                'kustomer_ktp' => $ktp
            );
            $this->Mrental->update_data($where, $data, 'kustomer');
            redirect(base_url() . 'admin/kostumer');
        } else {
            $where = array(
                'kustomer_id' => $id
            );
            $data['kostumer'] = $this->Mrental->edit_data($where, 'kustomer')->result();
            $this->load->view('admin/header');
            $this->load->view('admin/kostumer_edit', $data);
            $this->load->view('admin/footer');
        }
    }
    function kostumer_hapus($id)
    {
        $where = array(
            'kustomer_id' => $id
        );
        $this->Mrental->delete_data($where, 'kustomer');
        redirect(base_url() . 'admin/kostumer');
    }
    function transaksi()
    {
        $data['transaksi'] = $this->db->query("select * from
        transaksi,mobil,kustomer where transaksi_mobil=mobil_id and
        transaksi_kustomer=kustomer_id")->result();
        $this->load->view('admin/header');
        $this->load->view('admin/transaksi', $data);
        $this->load->view('admin/footer');
    }
    function transaksi_add()
    {
        $w = array('mobil_status' => '1');
        $data['mobil'] = $this->Mrental->edit_data($w, 'mobil')->result();
        $data['kostumer'] = $this->Mrental->get_data('kustomer')->result();
        $this->load->view('admin/header');
        $this->load->view('admin/transaksi_add', $data);
        $this->load->view('admin/footer');
    }
    function transaksi_add_act()
    {
        $kostumer = $this->input->post('kostumer');
        $mobil = $this->input->post('mobil');
        $tgl_pinjam = $this->input->post('tgl_pinjam');
        $tgl_kembali = $this->input->post('tgl_kembali');
        $harga = $this->input->post('harga');
        $denda = $this->input->post('denda');
        $this->form_validation->set_rules('kostumer', 'Kostumer', 'required');
        $this->form_validation->set_rules('mobil', 'Mobil', 'required');
        $this->form_validation->set_rules('tgl_pinjam', 'Tanggal
        Pinjam', 'required');
        $this->form_validation->set_rules('tgl_kembali', 'Tanggal
        Kembali', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required');
        $this->form_validation->set_rules('denda', 'Denda', 'required');
        if ($this->form_validation->run() != false) {
            $data = array(
                'transaksi_karyawan' => $this->session->userdata('id'),
                'transaksi_kustomer' => $kostumer,
                'transaksi_mobil' => $mobil,
                'transaksi_tgl_pinjam' => $tgl_pinjam,
                'transaksi_tgl_kembali' => $tgl_kembali,
                'transaksi_harga' => $harga,
                'transaksi_denda' => $denda,
                'transaksi_tgl' => date('Y-m-d')
            );
            $this->Mrental->insert_data($data, 'transaksi');
            // update status mobil yg di pinjam
            $d = array(
                'mobil_status' => '2'
            );
            $w = array(
                'mobil_id' => $mobil
            );
            $this->Mrental->update_data($w, $d, 'mobil');
            redirect(base_url() . 'admin/transaksi');
        } else {
            $w = array('mobil_status' => '1');
            $data['mobil'] = $this->Mrental->edit_data($w, 'mobil')->result();
            $data['kostumer'] = $this->Mrental->get_data('kostumer')->result();
            $this->load->view('admin/header');
            $this->load->view('admin/transaksi_add', $data);
            $this->load->view('admin/footer');
        }
    }
    function transaksi_hapus($id)
    {
        $w = array(
            'transaksi_id' => $id
        );
        $data = $this->Mrental->edit_data($w, 'transaksi')->row();
        $ww = array(
            'mobil_id' => $data->transaksi_mobil
        );
        $data2 = array(
            'mobil_status' => '1'
        );
        $this->Mrental->update_data($ww, $data2, 'mobil');
        $this->Mrental->delete_data($w, 'transaksi');
        redirect(base_url() . 'admin/transaksi');
    }
    function transaksi_selesai($id)
    {
        $data['mobil'] = $this->Mrental->get_data('mobil')->result();
        $data['kostumer'] = $this->Mrental->get_data('kustomer')->result();
        $data['transaksi'] = $this->db->query("select * from
        transaksi,mobil,kustomer where transaksi_mobil=mobil_id and
        transaksi_kustomer=kustomer_id and transaksi_id='$id'")->result();
        $this->load->view('admin/header');
        $this->load->view('admin/transaksi_selesai', $data);
        $this->load->view('admin/footer');
    }
    function transaksi_selesai_act()
    {
        $id = $this->input->post('id');
        $tgl_dikembalikan = $this->input->post('tgl_dikembalikan');
        $tgl_kembali = $this->input->post('tgl_kembali');
        $mobil = $this->input->post('mobil');
        $denda = $this->input->post('denda');
        $this->form_validation->set_rules('tgl_dikembalikan', 'Tanggal
        Di Kembalikan', 'required');
        if ($this->form_validation->run() != false) {
            // menghitung selisih hari
            $batas_kembali = strtotime($tgl_kembali);
            $dikembalikan = strtotime($tgl_dikembalikan);
            $selisih = abs(($batas_kembali -
                $dikembalikan) / (60 * 60 * 24));
            $total_denda = $denda * $selisih;
            // update status transaksi
            $data = array(
                'transaksi_tgldikembalikan' => $tgl_dikembalikan,
                'transaksi_status' => '1',
                'transaksi_totaldenda' => $total_denda
            );
            $w = array(
                'transaksi_id' => $id
            );
            $this->Mrental->update_data($w, $data, 'transaksi');
            // update status mobil
            $data2 = array(
                'mobil_status' => '1'
            );
            $w2 = array(
                'mobil_id' => $mobil
            );
            $this->Mrental->update_data($w2, $data2, 'mobil');
            redirect(base_url() . 'admin/transaksi');
        } else {
            $data['mobil'] = $this->Mrental->get_data('mobil')->result();
            $data['kostumer'] = $this->Mrental->get_data('kustomer')->result();
            $data['transaksi'] = $this->db->query("select * from
        transaksi,mobil,kustomer where transaksi_mobil=mobil_id and
        transaksi_kustomer=kustomer_id and transaksi_id='$id'")->result();
            $this->load->view('admin/header');
            $this->load->view('admin/transaksi_selesai', $data);
            $this->load->view('admin/footer');
        }
    }
    function laporan()
    {
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        $this->form_validation->set_rules('dari', 'Dari
        Tanggal', 'required');
        $this->form_validation->set_rules('sampai', 'Sampai
        Tanggal', 'required');
        if ($this->form_validation->run() != false) {
            $data['laporan'] = $this->db->query("select * from
        transaksi,mobil,kustomer where transaksi_mobil=mobil_id and
        transaksi_kustomer=kustomer_id and date(transaksi_tgl) >= '$dari'")->result();
            $this->load->view('admin/header');
            $this->load->view('admin/laporan_filter', $data);
            $this->load->view('admin/footer');
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/laporan');
            $this->load->view('admin/footer');
        }
    }
    function laporan_print()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        if ($dari != "" && $sampai != "") {
            $data['laporan'] = $this->db->query("select * from
        transaksi,mobil,kustomer where transaksi_mobil=mobil_id and
        transaksi_kustomer=kustomer_id and date(transaksi_tgl) >= '$dari'")->result();
            $this->load->view('admin/laporan_print', $data);
        } else {
            redirect("admin/laporan");
        }
    }
    function laporan_pdf()
    {
        $this->load->library('dompdf_gen');
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $data['laporan'] = $this->db->query("select * from
        transaksi,mobil,kustomer where transaksi_mobil=mobil_id and
        transaksi_kustomer=kustomer_id and date(transaksi_tgl) >= '$dari'")->result();
        $this->load->view('admin/laporan_pdf', $data);
        $paper_size = 'A4'; // ukuran kertas
        $orientation = 'landscape'; //tipe format kertas potrait atau landscape
        $html = $this->output->get_output();
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("laporan.pdf", array('Attachment' => 0));
        // nama file pdf yang di hasilkan
    }
}
