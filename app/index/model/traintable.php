<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use app\index\model\traintable;
  use think\Session;
//训练表
 class traintable extends Model
 {
 			//选课进表
 			public function chooseClass($type)
			{
					$traintable = new traintable;
					$num = $traintable->getMax();
					$member = Session::get('id');
					$cid = Db::query("select * from train where trainType = '$type'");
					$cid1 = $cid[0]['coach'];
					$cid2 = Db::query("select * from coach where name = '$cid1'");
					$cid3 = $cid2[0]['id'];
					$result = Db::execute('insert into traintable (id,coashId,memberId,trainType) values (?,?,?,?)',[$num+1,$cid3,$member,$type]);
					return $result;
			}
			
			//判断选课是否选过
			public function ischoose($type)
			{
					$member = Session::get('id');
					$result = Db::query("select * from traintable where trainType = '$type' and memberId = '$member'");
					return $result;
			}
			
			//获取最大id
			public function getMax()
			{
					$result = Db::query("select * from traintable order by id desc limit 1");
					return $result[0]['id'];
		  }
 }
 	