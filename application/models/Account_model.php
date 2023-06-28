<?php

	class Account_model extends CI_Model
	{
        public function get_where($id, $limit,$offset)
    	{
			$this->db->where('user_id', $id);
			$query = $this->db->get('accounts', $limit, $offset);
			if($query->num_rows() > 0)
			{
				return $query->result_array();
			}
			else return array();
    	}

        public function get_total_amt($user_id) {
            $this->db->where('user_id', $user_id);

            $data = $this->db->get('total_amt')->row_array();

            //echo $this->db->last_query();die;

            return $data;
        }

        public function insert_trans($trans) {
			return $this->db->insert('accounts', $trans);
		}

        public function insert_tot($tot) {
			return $this->db->insert('total_amt', $tot);
		}

        public function update_tot($tot)
    	{
			$this->db->where($tot['condition']);
			$query = $this->db->update('total_amt', $tot['data']);
			if($query) return true;
			else return false;
    	}
 	}
?>