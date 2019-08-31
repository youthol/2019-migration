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
		$catId = $_GET['catId'];  // 文章类型
		$page  = $_GET['page'];  // 分页

		if (!$catId && !$page) {
			$err = array(
				'code' => 0,
				'msg'  => '参数错误',
			);
			set_status_header(404);
			echo json_encode($err);
		}

//		调用模型
		$this->load->model('Migration');
		$result = $this->Migration->articleList($catId);

		if (!$result) {
			$err = array(
				'code' => 0,
				'msg'  => '没有数据',
			);
			set_status_header(404);
			echo json_encode($err);
		}

//		文章数量
//		$count = count($result);
//		echo $count;


		foreach ($result as $key => $value) {
			unset(
				$value->typeid,
				$value->style,
				$value->thumb,
				$value->keywords,
				$value->posids,
				$value->url,
				$value->listorder,
				$value->status,
				$value->sysadd,
				$value->islink,
				$value->inputtime,
				$value->updatetime
			);
		}

		$data['result'] = $result;
		$this->load->view('welcome', $data);
//		分页数，10行为一页
//		if ($count > 10) {
//			$pages = ceil($count / 10);
//		} else {
//			$pages = 1;
//		};

//		$query  = $this->db->get('news', 10, ($page - 1) * 10);
//		if ($query) {
//			$result = $query->result();
//			$data = array();
//			foreach ($data as $key => $value) {
//
//			}
//		}
//		$data = array();
//		for ($i = 0; $i < sizeof($result1); ++$i) {
//
//		};

	}

	public function article()
	{

		$id = $_GET['id'];

		if (!$id) {
			$err = array(
				'code' => 0,
				'msg'  => '参数错误',
			);
			set_status_header(404);
			echo json_encode($err);
		};

//		调用模型
		$this->load->model('Migration');
		$result = $this->Migration->articleContent($id);

		if (!$result) {
			$err = array(
				'code' => 0,
				'msg'  => '文章不存在',
			);
			set_status_header(404);
			echo json_encode($err);
		}

//		加载模型
		$this->load->model('Migration');
		$copyFromResult = $this->Migration->copyFrom();
//		var_dump($copyFromResult);

//		切割字符串，该数组只有两个元素
		$copyFromArr = explode('|', $result[0]->copyfrom);
//		var_dump($copyFromArr);

		if ($copyFromArr[0]) {
			$copyFrom = $copyFromArr[0];
		} elseif ($copyFromArr[1]) {
			foreach ($copyFromResult as $row) {
				if ($copyFromArr[1] == $row->id) {
					$copyFrom = $row->sitename;
				}
			}
		} else {
			$copyFrom = '未知';
		};

		$info             = array();
		$info['id']       = $result[0]->id;  // 文章主键
		$info['content']  = $result[0]->content;  // 文章内容
		$info['copyFrom'] = $copyFrom;  // 文章来源
		$info['author']   = $result[0]->author;  // 文章作者
		$info['editor']   = $result[0]->editor;  // 文章责编

		var_dump($info);
		$data['info'] = $info;
		$this->load->view('article', $data);
	}
}
