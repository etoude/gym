<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\Response;
use app\index\model\member;
use app\index\model\boss;

class Index extends Controller
{
	//主页
    public function index()
    {
		return $this->fetch('interface');
   	}
	//常识
	public function about()
	{
		return $this->fetch('about');
	}
	//器械
	public function action()
	{
		return $this->fetch('action');
	}
	//动作
	public function equipment()
	{
		return $this->fetch('equipment');
	}
	//登录
	public function login()
	{
		return $this->fetch('login');
	}
	//注册
	public function register()
	{
		return $this->fetch('register');
	}
	
	//判断账号密码是否正确
	public function memberdata()
	{	
		$phone = $_POST['phone'];
		$psw = $_POST['psw'];
		$member = new member;//实例化member对象
		$result = $member->ismember($phone,$psw);
		
		if($result?1:0)
		{
			Session::set('name',$result);
			Session::set('id',$phone);
			echo 1;exit;	
		}else{
			echo 0;exit;
		}
		
	}
	
	public function loginsuccess()
	{
		//重定向，跳转会员界面
		$this->redirect('Admin/memberpage');
	}
	
	//判断管理员账号密码是否正确
	public function admindata()
	{
		$id = $_POST['id'];
		$psw = $_POST['psw'];
		$boss = new boss;
		$result = $boss->isBoss($id, $psw);
		if($result?1:0)
		{
			Session::set('name',$result);
			Session::set('aid',$id);
			echo 1;exit;
		}else{
			echo 0;exit;
		}
	}
	
	//跳转成功界面
	public function loginadmin()
	{
		//重定向
		$this->redirect('Datadeal/admin');
	}
	
	//注册
	public function setregister()
	{
		$phone = $_POST['phone'];
		$name = $_POST['name']; 
		$sex = $_POST['sex']; 
		$birth = $_POST['birth']; 
		$psw = $_POST['psw'];  
		
		$member = new member;
		$result = $member->getCount($phone, $name, $sex, $birth, $psw);
		return $result;
		
	}
	
	
	
	
	
	public function index1()
	{
		$this->assign('email','260245463@qq.com');
		$this->assign('time',time());
		$this->assign('user','mwt');

		$list = [
			'user1'=>[
				'name'=>'mwt',
				'email'=>'110@qq.com'
			],
			'user2'=>[
				'name'=>'cggg',
				'email'=>'119@qq.com'
			]
		];
		$this->assign('list',$list);
		$this->assign('a',10);
		$this->assign('b',10);
		return $this->fetch();
	}
	
	public function index3(Request $request)
	{
		#默认模板地址
    	#app/index/view/index/index.html    	
    	#传递第一个参数，修改模板目录文件
    	#('interface')app/index/view/index/interface.html
    	#('html/about')app/index/view/html/about.html
    	#return view('html/about');
    	#如果以./开头找到入口文件同级开始的模板文件，要带html	
//  	return view('interface');
		#向页面中传递参数
		#return view('interface',['a'=>'666','b'=>'777']);		
		#继承think\Controller后，直接使用,用法与view()一样
		#页面赋值
//		$this->assign('a','6666');
//		$this->view->key2 = 'value2';
//  	return view();	
//		获取浏览器输入框的值
//		dump($request->domain());
//		dump($request->pathinfo());
//		dump($request->path());//不含后缀
		$res = input('get.id');
		dump($res);
		dump($request->get('id'));
		$res1 = input('post.sid',100);//若没有默认值100
//		$res1 = input('post.sid',100，'intval');//强制过滤取整
		dump($res1);
	}
	
	public function index4(Request $request)
	{
		echo "今天:",date('Y-m-d'),"<br>";
		echo "明天:",date('Y-m-d',strtotime('+30 day'));
	}
	
}
