<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct()
    {
    parent::__construct();
    $this->load->library('form_validation');
    }

    public function index()
	{
		$this->form_validation->set_rules('email','email','required|trim');
        $this->form_validation->set_rules('password','password','required|trim');
        if (this->form_validation->run()==false){
            $this->load->view('login/index');
        }else{
            $this->dologin();
        }
	}
    public function dologin();{
    $user = $this->input->post('email');
    $user = $this->input->post('password');
    //cari user berdasarkan email
    $user = $this->db->get_where('tb_user',['email' => $user])->row_array();
    if($user){
        if(password_verify($pswd,$user['password'])){
            $data=[
                'id' => $user['id'],
                'email' => $user['email'],
                'username' => $user['username'],
                'role' => $user ['role'],
            ];
            $userid = $user['id'];
            $this->session->sey_userdata($data);
            //periksa rolenya
            if($user['role'] == 'admin'){
                $this->_updateLastLogin($userid);
                redirect('admin/menu');
            }else if($user['role']== 'sekretaris'){
                $this->_udateLastLogin($userid);
                redirect('surat');
            }
        }else{
            //jika password salah
            $this->session->set_flashdata('message','<div class="alert-danger" role="alert"> <b>Error</b> password Salah. </d>');
            redirect('/');
        }
    }else{
        //jika user tidak terdaftar
        $this->session->set_flashdata('message','<div class="alert-danger" role="alert"> <b>Error</b> User Tidak Terdaftar. </d>');
            redirect('/');
    }

    }
    private function _updateLastLogin($userid){
        $sql = "UPDATE tb_user SET las_login=now () WHERE id=$userid";
        $this->db->query($sql);
    }

    public function logout(){
        $this->session->sess_destory();
        redirect(site_url('login'));
    }
    public function logout(){
        $data = array(
            'user' =>infoLogin(),
            'title' =>'Access Denied!'
        );
        $this->load->view('login/error404',$data);
}

?>


