<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use think\Session;
  
//会员卡表
 class boss extends Model
 {
 	//判断账号密码是否存在
 	public function isBoss($id,$psw)
	{
		$result = Db::query("select * from boss where id=? AND psw=?",[$id,$psw]);
		return $result[0]['name'];
	}
	
	//页面加载数据
	public function getInfor()
	{
		$id=Session::get('aid');
		$result = Db::table('boss')
		->where('id',$id)
		->select();
		return $result[0];
	}
	
	
	//修改管理员信息
	public function changeInfor($name,$phone)
	{
		$id=Session::get('aid');
		$result = Db::execute("update boss set name = '$name',phone = '$phone' where id = $id");
		return $result;
	}
	
	//修改密码
	public function changeMess($ymess,$xmess)
	{
		$id=Session::get('aid');
		$result = Db::execute("update boss set psw = '$xmess' where id = '$id' and psw = '$ymess'");
		return $result;
	}
 }
 	