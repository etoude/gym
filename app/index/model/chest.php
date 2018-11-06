<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use app\index\model\chest;
//衣柜表
 class chest extends Model
 {
 		//获取衣柜
 			public function getchest()
			{
//					$result = Db::query("select * from chest");
					$result = Db::table('chest')->paginate(8);
					return $result;
			}
	
		//租衣柜
		 public function rentchest($id)
		 {
		 			$status = '已租';
		 			$result = Db::execute("update chest set status = '$status' where id = $id");
					return $result;
		 }
		 
		 //退租
		 public function backrent($id)
		 {
		 			$status = '空闲';
					$result = Db::execute("update chest set status = '$status' where id = $id");
					return $result;
		 }
		 
		 //获取衣柜价格
		 public function getMoney($id)
		 {
		 			$result = Db::query("select * from chest where id = '$id'");
					return $result[0]['prices'];
		 }
		 
		 //更新价格
		 public function updateprice($id,$price)
		 {
		 			$result = Db::table('chest')
					->where('id',$id)
					->update(['prices'=>$price]);
					return $result;
		 }
		 
		 //设置衣柜数
		 public function setChestNum($num)
		 {
		 		$chest = new chest;
				$result1 = $chest->getNum();
				$all = $result1[0]['id'];
				$result = 0;
				if($num>$all)
				{
						for($i=$all+1;$i<=$num;$i++)
						{
								$result = Db::table('chest')
								->insert([
								'id'=>$i,
								'status'=>'空闲',
								'prices'=>'10'
								]);
						}
				}else{
						$result = Db::execute("delete from chest where '$num'<id");
				}
				return $result;
		 }
		 
		 //获取当前衣柜数
		 public function getNum()
		 {		
					$result = Db::query("select * from chest order by id desc limit 1");
					return $result;
		 }
 }
 	