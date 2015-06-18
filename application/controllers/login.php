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
		$errorMsg="";
		if(!$_POST['uNumber']){
			$errorMsg = "请输入您的学号/工号!";
		}elseif(!$_POST['uPassword']){
			$errorMsg = "请输入您的密码！";
		}elseif(!$_POST['captcha']){
			$errorMsg = "请输入验证码！";
		}
		if($errorMsg){
			// echo "<javascript>alert(".$errorMsg.");</javascript>";
			echo "<script type='text/javascript'>alert('".$errorMsg."');</script>";
			$this->load->view('login');
			// $this->load->view("loginError", array('msg' => $errorMsg ));
		}else{
			$userNum = trim($_POST['uNumber']);
			$password = trim($_POST['uPassword']);
			$captcha = trim($_POST['captcha']);
			$this->load->model('userCrud');
			$user = $this->userCrud->read_user_login_info($userNum);
			$errorMsg="";
			if(!$user){
				$errorMsg="该用户不存在！";
			}
			// print_r(expression);
			elseif($user->Password != md5($password)){
				$errorMsg="密码错误！";
			}
			else{				
				$this->load->library("captcha/CaptchaBuilder");
				$this->load->library('session');
				$this->captchabuilder->setPhrase( $this->session->userdata('captcha') );
				if(!$this->captchabuilder->testPhrase( $captcha ) ) {
					$errorMsg="验证码错误！";
				}
				if($this->session->userdata('captcha_time')+300<time()){
					$errorMsg="验证码已过期！";
				}
			}
			if($errorMsg){

				// echo "<javascript>alert(".$errorMsg.");</javascript>";
				echo "<script type='text/javascript'>alert('".$errorMsg."');</script>";
				$this->load->view('login');
				// $this->load->view("loginError", array('msg' => $errorMsg ));
			}else{
				$this->load->library('session');
				$data = array('s_id' => $user->UserNum);
				$this->session->set_userdata($data);
				switch ($user->Type) {
					case '0':redirect('admin');break;
					case '1':redirect('teacher');break;
					case '2':redirect('student');break;
					default:break;
				}
			}
		}
	}

	public function captcha() {
		$this->load->library("captcha/CaptchaBuilder");
		$this->captchabuilder->setBackgroundColor(255,255,255);
		// $this->captchabuilder->setTextColor(238,238,238);
		$this->captchabuilder->setDistortion(false);

		$this->captchabuilder->build(100, 35);

		$content = $this->captchabuilder->getPhrase();

		$this->load->library("session");
		$this->session->set_userdata( array(
			'captcha'		=> $content,
			'captcha_time'	=> time()
		) );
		header("Cache-Control: no-cache, must-revalidate");
		header("Content-Type: image/jpeg");
		$this->captchabuilder->output();
	}

	// function get_CAPTCHA(){
	// 	//未完成
	// 	//用户必须输入学号/工号,并且输入对应邮箱才可以找回密码，
	// 	//找回密码使用验证码的方式，后台向邮箱发送具有时效的验证码，
	// 	//用户输入验证码，后台检验
	// 	$userNum = $_POST["uNumber"];
	// 	$userEmail = $_POST["uEmail"];
	// 	$this->load->model("validation");
	// 	$isValidAccount = $this->validation->is_valid_email($userEmail,$userNum);
	// 	echo $isValidAccount;
	// 	if($isValidAccount){
	// 		$this->load->library("email");
	// 		//设置email参数
	// 		$config["protocol"]="smtp";
	// 		$config["charset"]="utf-8";
	// 		$config["smtp_host"]="smtp.qq.com";
	// 		$config["smtp_port"]="465";
	// 		$config["smtp_user"]="1656016399@qq.com";
	// 		$config["smtp_pass"]="3991qq.www";
	// 		$config['smtp_crypto'] = 'tls';
	// 		$this->load->library("email",$config);
	// 		$this->email->from("1656016399@qq.com","wyc");
	// 		$this->email->to("mudengleyi@163.com","mdly");
	// 		$this->email->subject("test");
	// 		$this->email->message("test content");
	// 		$this->email->send();
	// 		echo "sending an email";
	// 		echo $this->email->print_debugger();
	// 	}
	// }
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