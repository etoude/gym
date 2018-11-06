<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use app\index\model\coach;
//教练表
 class coach extends Model
 {
 		//获取教练
 		public function getcoach()
		{
				$result = Db::table('coach')->paginate(8);
				return $result;
		}
	
		//删除教练
		public function deleteCoach($id)
		{
			$result = Db::table('coash')
				->where('id',$id)
				->delete();
				return $result;
		}
		
		//编辑信息
		public function setCoach($id,$name,$phone,$sex,$age,$pay)
		{
				$coach = new coach;
				$result = $coach->getId($id);
				if($result?1:0)
				{
					
				}else{
						 $result = Db::table('coach')->insert([
						'id'=>$id,
						'name'=>$name,
						'phone'=>$phone,
						'sex'=>$sex,
						'age'=>$age,
						'pay'=>$pay
						]);
				}			
				return $result;
		}
		
		//编辑信息
		public function changeCoach($id,$name,$phone,$sex,$age,$pay)
		{
				$result = Db::table('coach')
				->where('id',$id)
				->update(['name'=>$name,
				'phone'=>$phone,
				'sex'=>$sex,
				'age'=>$age,
				'pay'=>$pay
				]);
				
				return $result;
		}
		
		//获取会员Id
		public function getId($id)
		{
				$result = Db::table('coach')
				->where('id',$id)
				->select();
				return $result;
		}
 }