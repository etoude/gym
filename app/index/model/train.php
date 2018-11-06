<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use app\index\model\train;
//训练课程表
 class train extends Model
 {
 		//获取课表
 		public function getClass()
		{
				$result = Db::table('train')->paginate(8);
				return $result;
		}
	
		//获取选课价格
		public function getMoney($type)
		{
				$result = Db::query("select * from train where trainType = '$type'");
				return $result[0]['price'];
		}
		
		
		//删除课程
		public function deleteClass($type)
		{
				$result = Db::table('train')
				->where('trainType',$type)
				->delete();
				return $result;
		}
		
		//编辑课程
		public function changeClass($type,$price,$start,$end,$coach)
		{
				$result = Db::table('train')
				->where('trainType',$type)
				->update([
				'trainType'=>$type,
				'price'=>$price,
				'startTime'=>$start,
				'endTime'=>$end,
				'coach'=>$coach
				]);
				return $result;
		}
		
		//添加课程
		public function addClass($type,$price,$start,$end,$coach)
		{
				$train = new train;
				$istype = $train->getId($type);
				if($istype?1:0)
				{
					return 0;
				}else{
					$result = Db::table('train')			
						->insert([
						'trainType'=>$type,
						'trainType'=>$type,
						'price'=>$price,
						'startTime'=>$start,
						'endTime'=>$end,
						'coach'=>$coach
						]);
						return 1;
				}
		}
		
		//判断是否包含该课程
		public function getId($type)
		{
			$result = Db::table('train')
			->where('trainType',$type)
			->select();
			
			return $result;
		}
		
		//查询教练课表
		public function getCoach($coach)
		{
			$result = Db::table('train')
			->where('coach',$coach)
			->select();
			
			return $result;
		}
 }
 	