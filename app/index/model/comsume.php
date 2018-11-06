<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use think\Session;
  use app\index\model\comsume;
//消费记录表
 class comsume extends Model
 {
 	//租赁衣柜记录
 	public function rentcord($id)
	{
		$member = Session::get('id');
		$comsume = new comsume;
		$num = $comsume->getMax();
		$direc = "租衣柜";
		$result = Db::query("select * from chest where id = '$id'");
		$money = $result[0]['prices'];
		Db::execute('insert into comsume (id,memberId,comtime,direc,money,integral) values (?,?,?,?,?,?)',[$num+1,$member,date('Y-m-d'),$direc,$money,$money/10]);
		
		//更新会员积分
		$inter = Db::query("select * from cardtable where memberId = '$member'");
		$inter1 = $inter[0]['integral'];
		$interg = $inter1+$money/10;
		Db::execute("update cardtable set integral = '$interg' where memberId = '$member'");
		//更新账户余额
		$balan = $inter[0]['balance'];
		$balanc = $balan-$money;
		Db::execute("update cardtable set balance = '$balanc' where memberId = '$member'");
	}
	
	//选课消费记录
	public function chooseclass($type)
	{
		$member = Session::get('id');
		$comsume = new comsume;
		//添加进消费记录表
		$num = $comsume->getMax();
		$result = Db::query("select * from train where trainType = '$type'");
		$money = $result[0]['price'];
		Db::execute('insert into comsume (id,memberId,comtime,direc,money,integral) values (?,?,?,?,?,?)',[$num+1,$member,date('Y-m-d'),$type,$money,$money/10]);
		//更新会员积分
		$inter = Db::query("select * from cardtable where memberId = '$member'");
		$inter1 = $inter[0]['integral'];
		$interg = $inter1+$money/10;
		Db::execute("update cardtable set integral = '$interg' where memberId = '$member'");
		//更新账户余额
		$balan = $inter[0]['balance'];
		$balanc = $balan-$money;
		Db::execute("update cardtable set balance = '$balanc' where memberId = '$member'");
	}
	
	//获取最大id
	public function getMax()
	{
		$result = Db::query("select * from comsume order by id desc limit 1");
		return $result[0]['id'];
	}
	
	//获取个人消费记录
	public function getconsume()
	{
		$member = Session::get('id');
		$result = Db::table('comsume')
		->where('memberId',$member)
		->paginate(5);
		return $result;
	}
	
	//商城消费
	public function buySomething($money)
	{
		$member = Session::get('id');
		$comsume = new comsume;
		//添加进消费记录表
		$type="购物";
		$num = $comsume->getMax();
		$result = Db::execute('insert into comsume (id,memberId,comtime,direc,money,integral) values (?,?,?,?,?,?)',[$num+1,$member,date('Y-m-d'),$type,$money,$money/10]);
		return $result;
	}
 }