<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
	function __construct() {
		parent::__construct();

		$this->load->model('User_model');

        $this->load->model('Account_model');
	}

	function index() {
		$this->load->view("home");
	}

	public function login() {
		$this->load->view('login');
	}

    function generate_string($input, $strength = 16) {

        $input_length = strlen($input);

        $random_string = '';

        for($i = 0; $i < $strength; $i++) {

            $random_character = $input[mt_rand(0, $input_length - 1)];

            $random_string .= $random_character;

        }

        return $random_string;
    }

	public function register() {

		$name = $this->input->post('name');
		$uname = $this->input->post('uname');
		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));
		$mobile = $this->input->post('mobile');

        $usertype = $this->input->post('usertype');

		if($name == "" || $uname == "" || $email == "" || $password == "" || $mobile == "" || $usertype == "")
        {
            echo json_encode(array('status'=>404,'msg'=>'Please Fill all fields'));
            return false;
        }

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            echo json_encode(array('status'=>404,'msg'=>'Please Enter Valid Email ID'));
            return false;
        }

        $userData = array(
            'name' => $name,
            'username' => $uname,
            'email' => $email,
            'password' => $password,
            'mobile' => $mobile,
            'usertype' => $usertype,
            'access_token' => $token
        );

        //echo "<pre>";print_r($userData);die;

        $result = $this->User_model->insert_user($userData);

        if ($result) {
            echo json_encode(array('status'=>200,'msg'=>'User Register Successfully'));
        }
        else {
            echo json_encode(array('status'=>400,'msg'=>'User Registeration Failed'));
			return false;
        }
    }

	public function register_page() {
		$this->load->view('register');
	}

	public function validate_user(){
		$name = $this->input->post('namei');

		$passwordm = md5($this->input->post('passwordi'));

		$user_data = $this->User_model->login($name, $passwordm);

        //echo "<pre>";print_r($user_data);die;

        if($user_data) {
            $user_id = $user_data[0]['user_id'];

            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

            $token = $this->generate_string($permitted_chars, 36);

            $this->User_model->update_token($user_id, $token);

			$_SESSION['uname'] = $name;
            echo json_encode(array('status'=>200,'msg'=>'Logged in Successfully', 'type'=>$user_data[0]['usertype']));
        }

        else {
            echo json_encode(array('status'=>400,'msg'=>'Login Failed'));
			return false;
        }
	}

    public function get_user_detail() {

        $start = intval($_POST['start']);
		$draw = intval($_POST['draw']);
		$limit = intval($_POST['length']);

        $id = $this->session->userdata('uid');

        $total_rows = count($this->User_model->get_where($id, false, false));

        $user_data = $this->User_model->get_where(
            $id,
            $limit,
            $start
        );

        $result=array();
        $count = 1;

        if(!empty($user_data)){
            foreach($user_data as &$users)
		    {
                $show_btn = '<a href="'.base_url().'User/show_user?uid='.$users['user_id'].'" class="btn btn-primary">Show</a>';
                $result[]=array(
                    $count++,
                    $users['username'],
                    $users['mobile'],
                    $show_btn
                );
		    }
		    echo json_encode(array("draw"=>$draw, "recordsTotal"=>$total_rows, "recordsFiltered"=>$total_rows, "data"=>$result));
        }
        else {
            echo json_encode(array('data'=>''));
        }
    }

    function show_user() {
        $mode = $this->session->userdata('mode');

        if($mode !== 'banker') {
            $id = $this->session->userdata('uid');
        }
        else {
            $user_id = $this->input->get('uid');
            $_SESSION['user_id'] = $user_id;
        }

        $data['tot_amt'] = $this->Account_model->get_total_amt($user_id);

        $data['user_id'] = $user_id;

        //echo "<pre>";print_r($data);die;

		$this->load->view("home_user", $data);
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('User/login');
	}
}

?>