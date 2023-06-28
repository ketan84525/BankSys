<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller
{
	function __construct() {
		parent::__construct();

		$this->load->model('Account_model');
	}

	function index() {
        $id = $this->session->userdata('uid');
        $data['tot_amt'] = $this->Account_model->get_total_amt($id);

        //echo "<pre>";print_r($data);die;

		$this->load->view("home_user", $data);
	}

    function bankerpage() {
        $id = $this->session->userdata('uid');

		$this->load->view("home_banker");
	}

    public function get_trans_detail()
    {
        $start = intval($_POST['start']);
		$draw = intval($_POST['draw']);
		$limit = intval($_POST['length']);

        $mode = $this->session->userdata('mode');

        if($mode !== 'banker') {
            $id = $this->session->userdata('uid');
        }
        else {
            $id = $this->session->userdata('user_id');
        }

        $total_rows = count($this->Account_model->get_where($id, false, false));

        $trans_data = $this->Account_model->get_where(
            $id,
            $limit,
            $start
        );

        $result=array();
        $count = 1;

        if(!empty($trans_data)){
            foreach($trans_data as &$trans)
		    {
                $result[]=array(
                    $count++,
                    $trans['mode'],
                    $trans['amount'],
                    $trans['created_on']
                );
		    }
		    echo json_encode(array("draw"=>$draw, "recordsTotal"=>$total_rows, "recordsFiltered"=>$total_rows, "data"=>$result));
        }
        else {
            echo json_encode(array('data'=>''));
        }
    }

    public function deposit_amt() {
        $amount = $this->input->post('amti');

        $mode = $this->input->post('modei');

        if($amount == "")
        {
            echo json_encode(array('status'=>404,'msg'=>'Please Fill all fields'));
            return false;
        }

        $id = $this->session->userdata('uid');

        $depositData = array(
            'user_id' => $id,
            'mode' => $mode,
            'amount' => $amount
        );

        //echo "<pre>";print_r($depositData);die;

        $result = $this->Account_model->insert_trans($depositData);

        $tot_amt = $this->Account_model->get_total_amt($id);

        if(isset($tot_amt)) {
            $totData['data'] = array(
                'total_amt' => $tot_amt['total_amt'] + $amount,
                'updated_on' => time()
            );
    
            $totData['condition'] = array('user_id'=>$id);
    
            $result = $this->Account_model->update_tot($totData);
        }

        else {
            $totData = array(
                'user_id' => $id,
                'total_amt' => isset($tot_amt['total_amt']) ? $tot_amt['total_amt'] : $amount,
                'created_on' => time()
            );
    
            $result = $this->Account_model->insert_tot($totData);
        }

        if ($result) {
            echo json_encode(array('status'=>200,'msg'=>'Deposited Successfully'));
        }
        else {
            echo json_encode(array('status'=>400,'msg'=>'Deposited Failed'));
			return false;
        }
    }

    public function withdraw_amt() {
        $amount = $this->input->post('amti');

        $mode = $this->input->post('modei');

        if($amount == "")
        {
            echo json_encode(array('status'=>404,'msg'=>'Please Fill all fields'));
            return false;
        }

        $id = $this->session->userdata('uid');

        $total_amt = $this->Account_model->get_total_amt($id);

        if($amount > $total_amt['total_amt'])
        {
            echo json_encode(array('status'=>404,'msg'=>'Insufficient Funds'));
            return false;
        }

        $withdrawData = array(
            'user_id' => $id,
            'mode' => $mode,
            'amount' => $amount
        );

        //echo "<pre>";print_r($withdrawData);die;

        $result = $this->Account_model->insert_trans($withdrawData);

        $tot_amt = $this->Account_model->get_total_amt($id);

        $totData['data'] = array(
            'total_amt' => $tot_amt['total_amt'] - $amount,
            'updated_on' => time()
        );

        $totData['condition'] = array('user_id'=>$id);

        $result = $this->Account_model->update_tot($totData);
		
        if ($result) {
            echo json_encode(array('status'=>200,'msg'=>'Withdraw Successfully'));
        }
        else {
            echo json_encode(array('status'=>400,'msg'=>'Withdraw Failed'));
			return false;
        }
    }

	public function logout() {
		$this->session->sess_destroy();
		redirect('User/login');
	}
}

?>