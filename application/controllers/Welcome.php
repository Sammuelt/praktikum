<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index()
	{
		$this->load->view('welcome_message');
	}
	


	public function about()
	{
	// fungsi untuk me-load view about.php
	$this->load->view('about');
	}
	public function profile()
	{
	// fungsi untuk me-load view contact.php
	$this->load->view('profile');
	}
	public function menu()
	{
	// fungsi untuk me-load view menu.php
	$this->load->view('template/menu');
	}
}