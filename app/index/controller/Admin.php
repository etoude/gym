<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use app\index\model\cardtable;
use app\index\model\member;
use app\index\model\chest;
use app\index\model\lease;
use app\index\model\comsume;
use app\index\model\train;
use app\index\model\traintable;
use app\index\model\clubcard;
use app\index\model\suggestion;
use app\index\model\commodity;
use app\index\model\shoppingcar;

class Admin extends Controller
{
	//用户端
	public function memberpage()
	{
		return $this->fetch('memberpage');
	}
	
	//个人信息及会员信息
	//修改个人信息
	public function personmess()
	{
		$member = new member;
		$result = $member->getInfor();
		$this->assign('name',$result['name']);
		$this->assign('sex',$result['sex']);
		$this->assign('birth',$result['birth']);
		return $this->fetch('personmess');
	}
	
	//查看会员卡信息
	public function personcard()
	{
		$cardtable = new cardtable;
		$result = $cardtable->getCardMess();
		if($result?1:0)
		{
			$this->assign('id',$result['id']);
			$this->assign('type',$result['cardType']);
			$this->assign('start',$result['startTime']);
			$this->assign('end',$result['endTime']);
			$this->assign('integral',$result['integral']);
			$this->assign('balance',$result['balance']);
		}else{
			$this->assign('id',"");
			$this->assign('type',"");
			$this->assign('start',"");
			$this->assign('end',"");
			$this->assign('integral',"");
			$this->assign('balance',"");
		}
		
		$clubcard = new clubcard;
		$result = $clubcard->cardType();
		$this->assign('ctype',$result);
		return $this->fetch('personcard');
	}
	
	//修改个人信息
	public function changeinfor()
	{
		$name = $_POST['name'];
		$sex = $_POST['sex'];
		$birth = $_POST['birth'];
		$member = new member;
		$result = $member->changeInfor($name, $sex, $birth);
		echo $result?1:0;exit;
	}
	
	//修改密码
	public function changemess(Request $request)
	{
		$ymess = $request->post('ymess');
		$xmess = $request->post('xmess');
		$member = new member;
		$result = $member->changeMess($ymess, $xmess);
		echo $result?1:0;exit;
	}
	
	//办理会员卡
	public function manage()
	{
		$type = $_POST['type'];
		$phone = Session::get('id');
		
		$cardtable = new cardtable;
		$result = $cardtable->setManage($phone, $type);
		echo $result?1:0;
	}
	
	//注销
	public function login()
	{
		$this->redirect('Index/login');
	}
	
	//衣柜处理
	//衣柜加载
	public function usechest()
	{
		$chest = new chest;
		$result = $chest->getchest();	
		$lease = new lease;
		$result2 = $lease->getRent();
		$this->assign('chest',$result);
		$this->assign('rent',$result2);
		
		$page = $result->render();
		$this->assign('page', $page);
		return $this->fetch('getchest');
	}
	
	//租赁
	public function setstatus()
	{
		$id = $_POST['id'];
		$chest = new chest;
		$lease = new lease;
		$comsume = new comsume;
		$cardtable = new cardtable;
		//判断是否有在租衣柜
		$result1 = $lease->getRent();
		$have = $result1?1:0;
		//判断余额是否充足
		$result2 = $cardtable->getMoney();	
		$result3 = $chest->getMoney($id);
		if($have == 1||($result3>$result2))
		{
			echo 0;exit;
		}else{
			$chest->rentchest($id);
			$lease->savelease($id);
			$comsume->rentcord($id);
			echo 1;exit;
		}
	}

	//退租
	public function backrent()
	{
		$id = $_POST['id'];
		$chest = new chest;
		$result = $chest->backrent($id);
		$lease = new lease;
		$lease->backRent();
		echo $result?1:0;exit;
	}
	
	
	//选课处理
	//界面加载
	public function getclass()
	{
		$train = new train;
		$result = $train->getClass();	
		$this->assign('class',$result);	
		$page = $result->render();
		$this->assign('page', $page);
		return $this->fetch('getclass');
	}
	
	//选课
	public function setclass()
	{
		$type = $_POST['ctype'];
		$traintable = new traintable;
		$cardtable = new cardtable;
		$comsume = new comsume;
		$isexit = $traintable->ischoose($type);
		
		$train = new train;
		$money = $train->getMoney($type);
		$money1 = $cardtable->getMoney();	
		if($isexit?1:0||($money>$money1))
		{
			echo 0;exit;
		}else{
			$result = $traintable->chooseClass($type);
			$comsume->chooseclass($type);
			echo 1;exit;
		}	
	}
	
	//获取消费记录
	public function getconsume()
	{
		$comsume = new comsume;
		$result = $comsume->getconsume();
		$this->assign('comsume',$result);	
		$page = $result->render();
		$this->assign('page', $page);
		return $this->fetch('getconsume');
	}
	
	//充值
	public function recharge()
	{
		return $this->fetch('recharge');
	}
	
	//意见反馈
	public function suggest()
	{		
		return $this->fetch('suggest');
	}
	
	//提交反馈
	public function sendsuggest()
	{
		$content = $_POST['content'];
		$connect = $_POST['connect'];
		$suggestion = new suggestion;
		$result = $suggestion->insert($connect, $content);
		echo $result?1:0;
	}
	
	//跳转商城
	public function shopping()
	{
		$commodity = new commodity;
		$classf = $commodity->getClassfiy();
		$this->assign('classf',$classf);
		
		$result = $commodity->showThem();
		$this->assign('show',$result);
		$page = $result->render();
		$this->assign('page',$page);
	 	return $this->fetch('shopping');
	}
	
	//获取分类结果
	public function showcom()
	{
		$classfiy = $_GET['num'];
		$commodity = new commodity;
		$classf = $commodity->getClassfiy();
		$this->assign('classf',$classf);
		$result = $commodity->getResult($classfiy);
		$this->assign('classfiy',$result);
		$page = $result->render();
		$this->assign('page',$page);
	 	return $this->fetch();
	}

	//购物车
	public function shoppingcar()
	{
		$comid = $_POST['id'];
		$name = $_POST['name'];
		$path = $_POST['path'];
		$price = $_POST['price'];
		$shoppingcar = new shoppingcar;
		$result = $shoppingcar->savecar($comid, $name, $path, $price);
		echo $result?1:0;
		
	}
	
	public function scar()
	{
		$memid = Session::get('id');
		$shoppingcar = new shoppingcar;
		$result = $shoppingcar->getCar($memid);
		$this->assign('car',$result);
		
		return $this->fetch('getshoppingcar');
	}
	
	//搜索
	public function seekvalue()
	{
		$value = $_GET['value'];
		$commodity = new commodity;
		//select * from commodity where name LIKE '%白%'
		$result = $commodity->seekSearch($value);
		$this->assign('seek',$result);
		$classf = $commodity->getClassfiy();
		$this->assign('classf',$classf);
		$page = $result->render();
		$this->assign('page',$page);
		return $this->fetch();
	}
	
	//购物付款
	public function buysometing()
	{
		$money = $_POST['money'];
		$cardtable = new cardtable;
		$result = $cardtable->getpullMoney($money);
		$comsume = new comsume;
		$comsume->buySomething($money);
		echo $result?1:0;
	}
}
