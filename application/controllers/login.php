<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index(){	
		//$this->load->library('session');
		// 载入CI的session库
		//if($this->session->userdata('u_id')){}
		$this->load->view('login');
		//$this->load->view('echo');
	}
	function check(){
		$this->load->model('crud');
		//加载ucrud模块，该模块用于用户的crud
		$sql = array('*','users','UserNum',$_POST['uNumber']);
		$user = $this->crud->select($sql);
		//调用u_crud模型的u_select方法查询提交的学号/工号信息
		if ($user){
			//如果用户存在
			//echo $user[0]->Password;
			if ($user[0]->Password == md5($_POST['uPassword'])){
				//如果密码一致，创建session
				$this->load->library('session');
				//载入CI的session库
				$arr = array('s_id' => $user[0]->UserNum);
				//把用户Num存入数组
				$this->session->set_userdata($arr);
				//设置session				
				if ($user[0]->Type == '0'){
					//echo "admin user login";
					//$this->load->view('/admin/admin');
					redirect('admin');
				}
			}else{
				echo 'pw wrong';
				echo '用户数据库中密码'.$user[0]->Password;
				echo '用户输入的'.$_POST['password'];					
			}
		}else{
			echo 'name wrong';
		}
	}
	function load_set_password_page(){
		$this->load->view("forgetPassword");
	}
	function get_CAPTCHA(){
		//用户必须输入学号/工号,并且输入对应邮箱才可以找回密码，
		//找回密码使用验证码的方式，后台向邮箱发送具有时效的验证码，
		//用户输入验证码，后台检验
		$userNum = $_POST["uNumber"];
		$userEmail = $_POST["uEmail"];
		$this->load->model("validation");
		$isValidAccount = $this->validation->is_valid_email($userEmail,$userNum);
		echo $isValidAccount;
		if($isValidAccount){
			$this->load->library("email");
			//设置email参数
			$config["protocol"]="smtp";
			$config["charset"]="utf-8";
			$config["smtp_host"]="smtp.qq.com";
			$config["smtp_port"]="465";
			$config["smtp_user"]="1656016399@qq.com";
			$config["smtp_pass"]="3991qq.www";
			$this->load->library("email",$config);
			$this->email->from("1656016399@qq.com","wyc");
			$this->email->to("mudengleyi@163.com","mdly");
			$this->email->subject("test");
			$this->email->message("test content");
			$this->email->send();
			echo "sending an email";
			echo $this->email->print_debugger();
		}
	}
	function is_login() {
		$this->load->library('session');
		// 载入CI的session库
		if ($this->session->userdata('s_id')) {
		// 如果能取得这个ID的session，就意味着处于登录状态
			return true;
		} else {
			return false;
		}
	}
	function logout() {
		$this->load->library('session');
		// 载入CI的session库
		$this->session->unset_userdata('s_id');
		// 删除此ID是session
		$this->load->view('login');
		//跳转至登陆界面
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */