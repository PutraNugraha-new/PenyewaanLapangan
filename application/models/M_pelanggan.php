<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pelanggan extends CI_Model {

    public function add($data)
    {
        $this->db->insert('tb_pelanggan',$data);
    }

    public function allData(){
        $this->db->select('*');
        $this->db->from('tb_pelanggan');
        return $this->db->get()->result();
    }

    
    //check is duplicate
    public function isDuplicate($username)
    {     
        $this->db->get_where('tb_pelanggan', array('username' => $username), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }

    function get_detail_modal($id)
    {
        $this->db->select('*');
        $this->db->from('tb_pelanggan');
        $this->db->where('tb_pelanggan.id_pelanggan', $id);
        return $this->db->get()->row();
    }
    
    public function edit($data)
    {
        $this->db->where('id_pelanggan',$data['id_pelanggan']);
        $this->db->update('tb_pelanggan',$data);
    }

    public function deleteUser($id)
    {   
        $this->db->where('id_pelanggan', $id);
        $this->db->delete('tb_pelanggan');
        
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
        $query = $this->db->get('tb_pelanggan');
        $userInfo = $query->row();
        $count = $query->num_rows();
        
        if($count == 1){
            if(!$this->password->validate_password($post['password'], $userInfo->password))
            {
                error_log('Unsuccessful login attempt('.$post['username'].')');
                return false;
            }else{
                $this->updateLoginTime($userInfo->id_pelanggan);
                // return true;
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
        $this->db->where('id_pelanggan', $id);
        $this->db->update('tb_pelanggan', array('last_login' => date('Y-m-d')));
        return;
    }

    public function getUserInfoByEmail($email)
    {
        $q = $this->db->get_where('tb_pelanggan', array('email' => $email), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$email.')');
            return false;
        }
    }

    public function insertToken($user_id)
    {   
        $token = substr(sha1(rand()), 0, 30); 
        $date = date('Y-m-d');
        
        $string = array(
                'token'=> $token,
                'id_pelanggan'=>$user_id,
                'created'=>$date
            );
        $query = $this->db->insert_string('tokens',$string);
        $this->db->query($query);
        return $token . $user_id;
        
    }

    public function isTokenValid($token)
    {
    $tkn = substr($token,0,30);
    $uid = substr($token,30);      
    
        $q = $this->db->get_where('tokens', array(
            'tokens.token' => $tkn, 
            'tokens.id_pelanggan' => $uid), 1);                         

        if($this->db->affected_rows() > 0){
            $row = $q->row();             
            
            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d'); 
            $todayTS = strtotime($today);
            
            if($createdTS != $todayTS){
                return false;
            }
            
            $user_info = $this->getUserInfo($row->id_pelanggan);
            return $user_info;
            
        }else{
            return false;
        }
        
    }   

    public function getUserInfo($id)
    {
        $q = $this->db->get_where('tb_pelanggan', array('id_pelanggan' => $id), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }

    public function updatePassword($post)
    {   
        $this->db->where('id_pelanggan', $post['id_pelanggan']);
        $this->db->update('tb_pelanggan', array('password' => $post['password'])); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updatePassword('.$post['id_pelanggan'].')');
            return false;
        }        
        return true;
    } 
}
