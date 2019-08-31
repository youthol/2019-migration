<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
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

			return;
		}

//		调用模型
		$this->load->model('Migration');
		$count = $this->Migration->articleList($catId, null);  // 文章总数量
		$data = $this->Migration->articlePage($count,$page, $catId);  // 分页数量
		$result = $data['result'];
		$pageNum = $data['pageNum'];

		if (!$result) {
			$err = array(
				'code' => 0,
				'msg'  => '没有数据',
			);
			set_status_header(404);
			echo json_encode($err);

			return;
		}

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
		$data['pageNum'] = $pageNum;
		$data['catId'] = $catId;
		$this->load->view('welcome', $data);


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

			return;
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

			return;
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

//		调用模型
		$this->load->model('Migration');
		$result2 = $this->Migration->articleList(null, $id);

		$data['id']       = $result[0]->id;  // 文章主键
		$data['title']    = $result2[0]->title;  // 文章主键
		$data['content']  = $result[0]->content;  // 文章内容
		$data['copyFrom'] = $copyFrom;  // 文章来源
		$data['author']   = $result[0]->author;  // 文章作者
		$data['editor']   = $result[0]->editor;  // 文章责编
		$data['time']     = date('Y-m-d H:i:s',
			$result2[0]->updatetime);  // 文章发布时间

		$this->load->view('article', $data);
	}
}
