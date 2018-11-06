<?php
  
  namespace app\index\model;
  use think\Model;
  use think\Db;
  use app\index\model\clubcard;
//会员卡类型表
 class clubcard extends Model
 {
 		//获取所有卡类型
 			public function cardType()
			{
				 $result = Db::table('clubcard')->select();
				 return $result;
			}
			
			//添加会员卡类型
			public function addType($type,$price)
			{
					$clubcard = new clubcard;
					$result = $clubcard->getType($type);
					if($result?1:0)
					{
							return 0;
					}else{
							Db::table('clubcard')
							->insert(['type'=>$type,'price'=>$price]);
							return 1;
					}
			}
			
			//判断是否存在该会员卡
			public function getType($type)
			{
					$result = Db::table('clubcard')
					->where('type',$type)
					->select();
					return $result;
					
			}
			
			//删除会员卡
			public function dealtype($type)
			{
					$result = Db::table('clubcard')
					->where('type',$type)
					->delete();	
					return $result;
			}
			
			//修改会员卡类型
			public function updateType($type,$price)
			{
					$result = Db::table('clubcard')
					->where('type',$type)
					->update(['price'=>$price]);
					return $result;
			}
 }
 	