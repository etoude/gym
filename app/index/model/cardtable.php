<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use think\Session;
  use app\index\model\cardtable;
  
//会员卡表
 class cardtable extends Model
 {
 		public function getCardMess()
		{
				$id = Session::get('id');
				$result = Db::query("select * from cardtable where memberId = $id");
				if($result?1:0)
						return $result[0];
				else
					  return 0;
		}
		
		//获取账户余额
		public function getMoney()
		{
				$id = Session::get('id');
				$result = Db::query("select * from cardtable where memberId = $id");
				return $result[0]['balance'];
		}
		
		//获取会员会员卡信息
		public function getmember()
		{
			 $result= Db::table('cardtable')->paginate(6);
			 return $result;
		}
		
		//删除会员信息
		public function deleteMember($id)
		{
				$result = Db::table('cardtable')
				->where('id',$id)
				->delete();
				return $result;
		}
		
		//编辑信息
		public function changeMember($id,$mid,$st,$et,$ct,$ig,$ba)
		{
				$result = Db::table('cardtable')
				->where('id',$id)
				->update(['memberId'=>$mid,
				'startTime'=>$st,
				'endTime'=>$et,
				'cardType'=>$ct,
				'integral'=>$ig,
				'balance'=>$ba
				]);
				
				return $result;
		}
		
		//添加会员卡
		public function setMember($id,$mid,$st,$et,$ct,$ig,$ba)
		{
				$cardtable = new cardtable;
				$result = $cardtable->getId($id);
				if($result?1:0)
				{
					
				}else{
						 $result = Db::table('cardtable')->insert([
						'id'=>$id,
						'memberId'=>$mid,
						'startTime'=>$st,
						'endTime'=>$et,
						'cardType'=>$ct,
						'integral'=>$ig,
						'balance'=>$ba
						]);
				}			
				return $result;
		}
		
		//获取会员Id
		public function getId($id)
		{
				$result = Db::table('cardtable')
				->where('id',$id)
				->select();
				return $result;
		}
			
		//办会员卡
		public function setManage($memberId,$type)
		{
				$cardtable = new cardtable;
	
				//添加会员卡
				$max = $cardtable->getMax();
				$id = $max[0]['id']+1;
				$result = Db::table('cardtable')
				->insert([
					'id'=>$id,
					'memberId'=>$memberId,
					'startTime'=>date('Y-m-d'),
					'endTime'=>date('Y-m-d'),
					'cardType'=>$type,
					'integral'=>0,
					'balance'=>0
				]);
				switch($type){
					case '月卡':
							$result = Db::table('cardtable')->where('id',$id)->update(['endTime'=>date('Y-m-d',strtotime('+1 month'))]);
							break;
					case '季卡':
							$result = Db::table('cardtable')->where('id',$id)->update(['endTime'=>date('Y-m-d',strtotime('+3 month'))]);
							break;
					case '半年卡':
							$result = Db::table('cardtable')->where('id',$id)->update(['endTime'=>date('Y-m-d',strtotime('+6 month'))]);
							break;
					case '年卡':
						  $result = Db::table('cardtable')->where('id',$id)->update(['endTime'=>date('Y-m-d',strtotime('+12 month'))]);
						  break;
				}
				
				return $result;
		}
		
		//获取最大id
		public function getMax()
		{
				$result = Db::query("select * from cardtable order by id desc limit 1");
				return $result;
		}
		
		//付款
		public function getpullMoney($money)
		{
				$memid = Session::get('id');
				$cardtable = new cardtable;
				$money1 = $cardtable->getMoney();
				$mon = $money1-$money;
				$inte = $cardtable->getInte();
				if($mon>0)
				{
						$result = Db::table('cardtable')
						->where('memberId',$memid)
						->update([
						'balance'=>$mon,
						'integral'=>$mon/10+$inte
						]);
						return 1;
				}else{
						return 0;
				}				
		}
		
		//获得积分
		public function getInte()
		{
				$id = Session::get('id');
				$result = Db::query("select * from cardtable where memberId = $id");
				return $result[0]['integral'];
		}
 }
 	