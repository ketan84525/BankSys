<?php

	class User_model extends CI_Model
	{

		public function insert_user($user) {
			return $this->db->insert('users', $user);
		}

		public function login($name, $password) {
			$this->db->where('username', $name);
			$this->db->where('password', $password);
			$query = $this->db->get('users');
	 
			if($query->num_rows() > 0) {

                $userdata = $query->result_array();

                $userdataSes = array(
                    'uid' => $userdata[0]['user_id'],
					'name' => $userdata[0]['name'],
                    'username' => $userdata[0]['username'],
                    'email' => $userdata[0]['email'],
                    'token' => $userdata[0]['access_token'],
					'mode' => $userdata[0]['usertype']
				);

				$this->session->set_userdata($userdataSes);

				return $userdata;
			}

			else {
				return 0;
			}
		}

		public function get_where($id, $limit,$offset)
    	{
			$this->db->where('user_id !=', $id);
			$query = $this->db->get('users', $limit, $offset);
			if($query->num_rows() > 0)
			{
				return $query->result_array();
			}
			else return array();
    	}

		public function update_token($id, $token)
    	{
			$this->db->where('user_id', $id);
            $query = $this->db->update('users', array('access_token' => $token));
			if($query) return true;
			else return false;
    	}
	}
?>