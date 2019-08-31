<?php


class Migration extends CI_Model
{
	/**
	 * @param $catId
	 * @param $id
	 *
	 * @return mixed
	 */
	public function articleList($catId, $id)
	{
		if ($catId) {
//		根据catId查取文章（所有文章）
			$query = $this->db->select()->from('news')
				->group_start()
				->where('catid', $catId)
				->where('sysadd', 1)  // 1表示通过审核
				->group_end()
				->count_all_results();

			return $query;
		}

//		根据id查取文章
//		用于文章展示页，用来获取文章的标题等信息
		$query = $this->db->get_where('news', array(
			'id' => $id,
		));

		return $query->result();
	}

	/**
	 * @return mixed
	 */
	public function articleContent()
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

	/**
	 * @param $count
	 * @param $page
	 * @param $catId
	 *
	 * @return mixed
	 */
	public function articlePage($count,$page, $catId)
	{
//		分页数，每一页有10篇文章
		if ($count > 10) {
			$pageNum = ceil($count / 10); // 向上取整
		} else {
			$pageNum = 1;
		};

		$query = $this->db->get_where('news', array(
			'catid'  => $catId,
			'sysadd' => 1,
		), 10, ($page - 1) * 10);

		$data['result'] = $query->result();
		$data['pageNum'] = $pageNum;

		return $data;
	}
}
