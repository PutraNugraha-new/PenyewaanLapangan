<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {
    public function addUser($d)
    {  
            $string = array(
                'nama'=>$d['nama'],
                'username'=>$d['username'],
                'password'=>$d['password'], 
            );
            $q = $this->db->insert_string('tb_admin',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
    }

    public function allData(){
        $this->db->select('*');
        $this->db->from('tb_admin');
        return $this->db->get()->result();
    }

    
    //check is duplicate
    public function isDuplicate($username)
    {     
        $this->db->get_where('tb_admin', array('username' => $username), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }

    function get_detail_modal($id)
    {
        $this->db->select('*');
        $this->db->from('tb_admin');
        $this->db->where('tb_admin.id_admin', $id);
        return $this->db->get()->row();
    }
    
    public function edit($data)
    {
        $this->db->where('id_admin',$data['id_admin']);
        $this->db->update('tb_admin',$data);
    }

    public function deleteUser($id)
    {   
        $this->db->where('id_admin', $id);
        $this->db->delete('tb_admin');
        
        if ($this->db->affected_rows() == '1') {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    public function checkLogin($post)
    {
        $this->load->library('password');       
        $this->db->select('*');
        $this->db->where('username', $post['username']);
        $query = $this->db->get('tb_admin');
        $userInfo = $query->row();
        $count = $query->num_rows();
        
        if($count == 1){
            if(!$this->password->validate_password($post['password'], $userInfo->password))
            {
                error_log('Unsuccessful login attempt('.$post['username'].')');
                return false;
            }else{
                $this->updateLoginTime($userInfo->id_admin);
            }
        }else{
            error_log('Unsuccessful login attempt('.$post['username'].')');
            return false;
        }
        
        unset($userInfo->password);
        return $userInfo; 
    }

    //update time login
    public function updateLoginTime($id)
    {
        $this->db->where('id_admin', $id);
        $this->db->update('tb_admin', array('last_login' => date('Y-m-d')));
        return;
    }
}
