<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use think\Session;
  use app\index\model\commodity;
   use app\index\model\picture;

//商品表
 class commodity extends Model
 {
 	//获取最大商品编号
 	public function getMax()
	{
		$result = Db::table('commodity')
		->order("id desc")
		->limit(1)
		->select();		
		return $result;
	}
	
	//保存商品信息
	public function saveMess($name,$price,$repertory,$describe,$classf,$status)
	{
		$commodity = new commodity;
		$result = $commodity->getMax();
		$id = $result[0]['id'];		
//		$picture = new picture;
//		$result1 = $picture->getMax();
//		$id1 = $result1[0]['comId'];
//		if(($id+1)==$id1)
//		{
//			$rel = Db::table('commodity')
//			->insert([
//			'id'=>$id+1,
//			'name'=>$name,
//			'price'=>$price,
//			'repertory'=>$repertory,
//			'market'=>0,
//			'time'=>date('Y-m-d H:i:s'),
//			'describe'=>$describe,
//			'status'=>$status
//			]);
//		}	
			$rel = Db::table('commodity')
			->where('id',$id)
			->update([
			'name'=>$name,
			'price'=>$price,
			'repertory'=>$repertory,
			'market'=>0,
			'time'=>date('Y-m-d H:i:s'),
			'describe'=>$describe,
			'status'=>$status,
			'classfiy'=>$classf
			]);
		return $rel;	
	}
	
	//保存商品图片名
 	public function savepic($name)
	{
		$commodity = new commodity;
		$result = $commodity->getMax();
		$id = $result[0]['id'];
//		$picture = new picture;
//		$result1 = $picture->getMax();
//		$id1 = $result1[0]['comId'];

		if($result[0]['name'] != "")
		{
			Db::table('commodity')
			->insert([
			'id'=>$id+1,
			'name'=>0,
			'price'=>0,
			'repertory'=>0,
			'market'=>0,
			'time'=>date('Y-m-d H:i:s'),
			'describe'=>0,
			'status'=>0,
			'path'=>$name,
			'classfiy'=>0
			]);
		}else{
			Db::table('commodity')
			->where('id',$id)
			->update([
			'path'=>$name
			]);
		}		
	}
	
	//商品显示
	public function showThem()
	{
		$result = Db::table('commodity')
		->where('status','发布')
		->paginate(5);
		return $result;
	}
	
	//返回结果
//	public function show()
//	{
//		$result = Db::query("select * from commodity,picture
//		where commodity.id=picture.comId");
//		return $result;	
//	}
	
	//获取返回个数
//	public function getCount()
//	{
//		$result = Db::query("select count(*) from commodity");
//		return $result[0];
//	}

			//商品下架
			public function delcom($id)
			{
				$result = Db::table('commodity')
				->where('id',$id)
				->delete();
				return $result;
			}
			
			//编辑商品信息
			public function changeCom($id,$name,$price,$kc,$ms,$status)
			{
					$result = Db::table('commodity')
					->where('id',$id)
					->update([
					'name'=>$name,
					'price'=>$price,
					'repertory'=>$kc,
					'describe'=>$ms,
					'status'=>$status
					]);
					return $result;
			}
			
			//获取商品分类
			public function getClassfiy()
			{
				$result = Db::table('commodity')
				->distinct(true)
				->field('classfiy')
				->select();
				return $result;
			}
			
			//获取分类结果
			public function getResult($classfiy)
			{
				$result = 0;
				if($classfiy == '最新商品')
				{
					$result = Db::table('commodity')
					->order('time desc')
					->where('status','发布')
					->paginate(4);
				}else if($classfiy == '热销商品')
				{
					$result = Db::table('commodity')
					->order('market desc')
					->where('status','发布')
					->paginate(4);
				}else{
					$result = Db::table('commodity')
					->where('classfiy',$classfiy)
					->where('status','发布')
					->paginate(4);
				}			
				return $result;
			}
			
			public function seekSearch($value){
				//var sql = printf("select * from commodity where name LIKE ''");
				$result = Db::table('commodity')
				->where('name','like',"%$value%")
				->paginate(4);
				return $result;
			}
 }
 