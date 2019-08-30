<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/welcome
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
//		id 从1开始
		$page = $_GET['page'];
//		数据表总行数
		$count = $this->db->count_all('news');
//		分页数，10行为一页
		if ($count > 10) {
			$pages = ceil($count / 10);
		} else {
			$pages = 1;
		};

		$query  = $this->db->get('news', 10, ($page - 1) * 10);
		if ($query) {
			$result = $query->result();
			$data = array();
			foreach ($data as $key => $value) {

			}


			$this->load->view('welcome');
		}

//		$data = array();
//		for ($i = 0; $i < sizeof($result1); ++$i) {
//
//		};

//		$this->load->view('welcome', $result);
	}

	public function content() {

	}
}
