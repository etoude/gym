<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use think\Session;
  use app\index\model\lease;
//衣柜租赁表
 class lease extends Model
 {
 			//保存入表
 			public function savelease($id)
			{
					$member = Session::get('id');
					$lease = new lease;
					$num = $lease->getMax();
					Db::execute('insert into lease (id,chestId,memberId,startTime) values (?,?,?,?)',[$num+1,$id,$member,date('Y-m-d')]);
					
			}
			//获取最大id
			public function getMax()
			{
					$result = Db::query("select * from lease order by id desc limit 1");
					return $result[0]['id'];
			}
			
			//获取当前已租
			public function getRent()
			{
					$member = Session::get('id');
					$result = Db::query("select * from lease where memberId = '$member'");
					return $result;
			}
			
			//退租，删除记录表
			public function backRent()
			{
					$member = Session::get('id');
					$result = Db::table('lease')
					->where('memberId',$member)
					->delete();
					return $result;
			}
 }
 	