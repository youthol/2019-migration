<?php


class Migration extends CI_Model
{
	public function articleList($catId)
	{
//		根据catId查取文章
		$query = $this->db->get_where('news', array(
			'catid'  => $catId,
			'sysadd' => 0  // 1表示审核通过
		));

		return $query->result();
	}

	public function articleContent($id)
	{
//		根据文章id查取指定文章
		$query = $this->db->get_where('news_data', array(
			'id' => $id,
		));

		return $query->result();
	}

	public function copyFrom()
	{
//		获取来源
		$this->db->select('id, sitename');
		$query = $this->db->get('copyfrom');
		return $query->result();
	}
}
