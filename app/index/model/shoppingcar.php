<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use think\Session;
  use app\index\model\shoppingcar;

//购物车
 class shoppingcar extends Model
 {
 	//获取最大id
 	public function getMax()
	{
		$result = Db::table('shoppingcar')
		->order('id desc')
		->limit(1)
		->select();
		return $result;
	}
	
	//加入购物车
	public function savecar($id,$name,$path,$price)
	{
		$memid = Session::get('id');
		$shoppingcar = new shoppingcar;
		$isadd = Db::table('shoppingcar')
		->where('memid',$memid)
		->where('comid',$id)
		->select();
		$result = 0;
		//判断是否存在，存在则原数量加1，不存在则新增
		if($isadd?1:0)
		{
			$result = Db::table('shoppingcar')
			->where('memid',$memid)
			->where('comid',$id)
			->update([
				'count'=>$isadd[0]['count']+1
			]);
		}else{
			$result = $shoppingcar->getMax();
			$num = $result[0]['id']+1;
			$rel = Db::table('shoppingcar')
			->insert([
			'id'=>$num,
			'comid'=>$id,
			'memid'=>$memid,
			'name'=>$name,
			'path'=>$path,
			'price'=>$price,		
			'count'=>1
			]);
		}
		return $result;
	}
	
	//获取购物车列表
	public function getCar($memid)
	{
		$result = Db::table('shoppingcar')
		->where('memid',$memid)
		->select();
		return $result;
	}
	
	
 }
 	