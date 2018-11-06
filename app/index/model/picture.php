<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use think\Session;
  use app\index\model\commodity;
  use app\index\model\picture;

//商品图片表
 class picture extends Model
 {
 	//保存商品图片名
 	public function savepic($name)
	{
		$commodity = new commodity;
		$result = $commodity->getMax();
		$id = $result[0]['id'];
		$picture = new picture;
		$result1 = $picture->getMax();
		$id1 = $result1[0]['comId'];
		if($id == $id1)
		{
			Db::table('picture')
			->insert([
			'comId'=>$id+1,
			'path'=>$name
			]);
		}else{
			Db::table('picture')
			->where('comId',$id1)
			->update([
			'path'=>$name
			]);
		}		
	}
	
	//获取图片
	public function getpic($comId)
	{
		$result = Db::table('picture')
		->where('comId',$comId)
		->select();
		return $result;
	}
	
	//照片显示
//	public function showThem()
//	{
//		$result = Db::table('picture')->paginate(5);
//		return $result;
//	}
	
	//获取最大ID
	public function getMax()
	{
		$result = Db::table('picture')
		->order("comId desc")
		->limit(1)
		->select();	
		return $result;
	}
 }
 