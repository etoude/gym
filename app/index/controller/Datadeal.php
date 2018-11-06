<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use app\index\model\boss;
use app\index\model\member;
use app\index\model\cardtable;
use app\index\model\coach;
use app\index\model\clubcard;
use app\index\model\chest;
use app\index\model\suggestion;
use app\index\model\train;
use app\index\model\picture;
use app\index\model\commodity;

class Datadeal extends Controller
{
	//主界面
	public function admin()
	{
		return $this->fetch('adminpage');
	}
	//注销
	public function login()
	{
		$this->redirect('Index/login');
	}
	
	//修改管理员信息页面
	public function adminmess()
	{
		$boss = new boss;
		$result = $boss->getInfor();
		$this->assign('name',$result['name']);
		$this->assign('phone',$result['phone']);
		return $this->fetch();
	}
	
	//修改个人信息
	public function changeinfor()
	{
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$boss = new boss;
		$result = $boss->changeInfor($name, $phone);
		echo $result?1:0;exit;
	}
	
	//修改密码
	public function changemess(Request $request)
	{
		$ymess = $request->post('ymess');
		$xmess = $request->post('xmess');
		$boss = new boss;
		$result = $boss->changeMess($ymess, $xmess);
		echo $result?1:0;exit;
	}
	
	//会员账号管理
	public function membernum()
	{
		$cardtable = new cardtable;
		$result = $cardtable->getmember();
		$this->assign('member',$result);	
		$page = $result->render();
		$this->assign('page', $page);
		return $this->fetch('membernum');		
	}
	
	//删除会员卡
	public function dealmember()
	{
		$id = $_POST['id'];
		$cardtable = new cardtable;
		$result = $cardtable->deleteMember($id);
		echo $result?1:0;exit;
	}
	
	//编辑会员卡信息
	public function changemember()
	{	
		$id = $_POST['id'];
		$mid = $_POST['mid'];
		$st = $_POST['st'];
		$et = $_POST['et'];
		$ct = $_POST['ct'];
		$ig = $_POST['ig'];
		$ba = $_POST['ba'];
		$cardtable = new cardtable;
		$result = $cardtable->changeMember($id, $mid, $st, $et, $ct, $ig, $ba);
		echo $result?1:0;exit;
	}
	
	//添加会员卡
	public function setmember()
	{
		$id = $_POST['id'];
		$mid = $_POST['mid'];
		$st = $_POST['st'];
		$et = $_POST['et'];
		$ct = $_POST['ct'];
		$ig = $_POST['ig'];
		$ba = $_POST['ba'];
		$cardtable = new cardtable;
		$result = $cardtable->setMember($id, $mid, $st, $et, $ct, $ig, $ba);
		echo $result?1:0;exit;
	}
	
	//获取会员信息
	public function getMem()
	{
		$id = $_GET['id'];
		$cardtable = new cardtable;
		$result = $cardtable->getId($id);
		$this->assign("mem",$result);
		return $this->fetch('showget');
	}
	
	//教练信息管理
	public function coachmess()
	{
		$coach = new coach;
		$result = $coach->getcoach();
		$this->assign('coach',$result);	
		$page = $result->render();
		$this->assign('page', $page);
		return $this->fetch('coachmess');		
	}
	
	//删除教练
	public function dealcoach()
	{
		$id = $_POST['id'];
		$coach = new coach;
		$result = $coach->deleteCoach($id);
		echo $result?1:0;exit;
	}
	
	//编辑教练信息
	public function changecoach()
	{
		$id = $_POST['id'];
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$sex = $_POST['sex'];
		$age = $_POST['age'];
		$pay = $_POST['pay'];
		$coach = new coach;
		$result = $coach->changeCoach($id,$name,$phone,$sex,$age,$pay);
		echo $result?1:0;exit;
	}
	
	public function setCoach()
	{
		$id = $_POST['id'];
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$sex = $_POST['sex'];
		$age = $_POST['age'];
		$pay = $_POST['pay'];
		$coach = new coach;
		$result = $coach->setCoach($id,$name,$phone,$sex.$age,$pay);
		echo $result?1:0;exit;
	}
	
	//获取教练信息
	public function getCoach()
	{
		$id = $_GET['id'];
		$coach = new coach;
		$result = $coach->getId($id);
		$this->assign("coa",$result);
		return $this->fetch('getcoach');
	}

	//会员卡类型设置
	public function cardtype()
	{
		$clubcard = new clubcard;
		$result = $clubcard->cardType();
		$this->assign('card',$result);
		return $this->fetch();
	}
	
	//添加会员卡类型
	public function addtype()
	{
		$type = $_POST['type'];
		$price = $_POST['price'];
		$clubcard = new clubcard;
		$result = $clubcard->addType($type, $price);
		echo $result;
	}
	
	//删除会员卡类型
	public function dealtype()
	{
		$type = $_POST['type'];
		$clubcard = new clubcard;
		$result = $clubcard->dealtype($type);
		echo $result?1:0;
	}
	
	//修改类型
	public function updatetype()
	{
		$type = $_POST['type'];
		$price = $_POST['price'];
		$clubcard = new clubcard;
		$result = $clubcard->updateType($type, $price);
		echo $result?1:0;
	}
	
	//衣柜设置
	public function chestset()
	{
		$chest = new chest;
		$result = $chest->getchest();
		$this->assign('chest',$result);
		$page = $result->render();
		$this->assign('page', $page);
		return $this->fetch();
	}
	
	//设置单个衣柜价格
	public function updateprice()
	{
		$id = $_POST['id'];
		$price = $_POST['price'];
		
		$chest = new chest;
		$result = $chest->updateprice($id, $price);
		echo $result?1:0;
	}
	
	//设置衣柜数
	public function setchestnum()
	{
		$num = $_POST['num'];
		$chest = new chest;
		$result = $chest->setChestNum($num);
		echo $result?1:0;
	}
	
	//建议箱
	public function suggestbox()
	{
		$suggestion = new suggestion;
		$result = $suggestion->getSuggest();
		$this->assign('sug',$result);
		$page = $result->render();
		$this->assign('page', $page);
		
		return $this->fetch();
	}
	
	//排课
	public function setclass()
	{
		$train = new train;
		$result = $train->getClass();
		$this->assign('class',$result);
		$page = $result->render();
		$this->assign('page', $page);
		
		return $this->fetch();
	}
	
	//删除课程
	public function dealclass()
	{
		$train = new train;
		$type = $_POST['type'];
		$result = $train->deleteClass($type);
		echo $result?1:0;exit;
	}
	
	//编辑课程
	public function changeClass()
	{
		$type = $_POST['type'];
		$price = $_POST['price'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$coach = $_POST['coach'];
		$train = new train;
		$result = $train->changeClass($type, $price, $start, $end, $coach);
		echo $result?1:0;exit;
	}
	
	//添加课程
	public function setit()
	{
		$type = $_POST['type'];
		$price = $_POST['price'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$coach = $_POST['coach'];
		$train = new train;
		$result = $train->addClass($type, $price, $start, $end, $coach);
		echo $result;
	}
	
	//查询教练课表
	public function getC()
	{
		$coach = $_GET['coach'];
		$train = new train;
		$result = $train->getCoach($coach);
		$this->assign("coach",$result);
		return $this->fetch('showcoach');
	}
	
	//商品上架
	public function putaway()
	{
		return $this->fetch();
	}
	
	//商品下架
	public function soldout()
	{
		$commodity = new commodity;
		$result1 = $commodity->showThem();
		$this->assign('commod', $result1);
		$page = $result1->render();
		$this->assign('page', $page);

		return $this->fetch();
	}
	
	//图片上传
	public function sendpic(){
		$ret = array();  //返回的上传文件状态数组
        if ($_FILES["file"]["error"] > 0)
        {
            $ret["message"] =  $_FILES["file"]["error"] ;
            $ret["status"] = 0; 
            $ret["src"] = "";
            return json($ret);   
        }else{
               $pic =  $this->upload();
               if($pic['info']== 1){ 
                   $url = '/uploads/'.$pic['savename'];
               }  else {
                   $ret["message"] = $this->error($pic['err']);
                    $ret["status"] = 0;   
               }
                $ret["message"]= "图片上传成功！";
                $ret["status"] = 1;   
                $ret["src"] = $url; 
                return json($ret);
        } 
	}
	
	 //图片上传代码
     private  function upload(){
        $file = request()->file('file'); 
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        $reubfo = array();  //定义一个返回的数组
        if($info){
            $reubfo['info']= 1;
            $reubfo['savename'] = $info->getSaveName();
			
			$commodity = new commodity;
			$result = $commodity->savepic($reubfo['savename']);			
        }else{
            // 上传失败获取错误信息
            $reubfo['info']= 0;
            $reubfo['err'] = $file->getError();;
        }
        return $reubfo;
    }
	 
	 //保存商品信息
	 public function savecom()
	 {
	 	$name = $_POST['name'];
		$price = $_POST['price'];
		$rep = $_POST['rep'];
		$desc = $_POST['desc'];
		$status = $_POST['status'];
		$classf = $_POST['classf'];
		$commodity = new commodity;
		$result = $commodity->saveMess($name, $price, $rep, $desc, $classf, $status);
		echo $result?1:0;
	 }
	 
	 //商品下架
	 public function comnum()
	 {
	 	$id = $_POST['id'];
	 	$commodity = new commodity;
		$result = $commodity->delcom($id);
		echo $result?1:0;
	 }
	 
	 //编辑商品信息
	 public function changecom()
	 {
	 	$id=$_POST['id'];
		$name=$_POST['name'];
		$price=$_POST["price"];
		$kc=$_POST['kc'];
		$ms=$_POST['ms'];
		$status=$_POST['status'];
		$commodity = new commodity;
		$result = $commodity->changeCom($id, $name, $price, $kc, $ms, $status);
		echo $result?1:0;
	 }
	 

	 
}
	