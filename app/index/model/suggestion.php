<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use think\Session;
  use app\index\model\suggestion;

//反馈表
 class suggestion extends Model
 {
 	//添加
 	public function insert($connect,$content)
	{
		$suggestion = new suggestion;
		$result1 = $suggestion->getMax();
		$id = $result1[0]['id']+1;
		$member = Session::get('id');
		
		$result = Db::table('suggestion')
		->insert([
			'id'=>$id,
			'memberId'=>$member,
			'connect'=>$connect,
			'content'=>$content,
			'time'=>date('Y-m-d H:i:s')
		]); 
		
		return $result;
	}
	
	//获取最大ID
	public function getMax()
	{
		$result = Db::query("select * from suggestion order by id desc limit 1");
		return $result;
	}
	
	//建议箱
	public function getSuggest()
	{
		$result = Db::table('suggestion')->order('time desc')->paginate(5);
		return $result;
	}
 }
 	