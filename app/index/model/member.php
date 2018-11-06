<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use think\Session;
  use app\index\model\member;
//会员表
 class member extends Model
 {
 	//判断账号密码是否存在
 	public function ismember($phone,$psw)
	{
		$result = Db::query("select * from member where phone=? AND psw=?",[$phone,$psw]);
		return $result[0]['name'];
	}
	
	//获取个人信息
	public function getInfor()
	{
		$id=Session::get('id');
		$result = Db::table('member')
		->where('phone',$id)
		->select();
		return $result[0];
	}
	
	//修改个人信息
	public function changeInfor($name,$sex,$birth)
	{
		$id=Session::get('id');
		$result = Db::execute("update member set name = '$name',sex = '$sex',birth = '$birth' where phone = $id");
		return $result;
	}
	
	//修改密码
	public function changeMess($ymess,$xmess)
	{
		$id=Session::get('id');
		$result = Db::execute("update member set psw = '$xmess' where phone = '$id' and psw = '$ymess'");
		return $result;
	}
	
	//注册账号
	public function getCount($phone,$name,$sex,$birth,$psw)
	{
			$member = new member;
			$result = $member->getId($phone);
			
			if($result?1:0)
			{
					return 0;
			}else{
				$result = Db::table('member')
				->insert([
				'phone'=>$phone,
				'name'=>$name,
				'sex'=>$sex,
				'birth'=>$birth,
				'psw'=>$psw
				]);
				return 1;
			}
		
	}
	
	//判断是否包含该账号
	public function getId($id)
	{
		$result = Db::table('member')
		->where('phone',$id)
		->select();
		
		return $result;
	}
}
