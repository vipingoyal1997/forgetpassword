<?php
class Moduser extends CI_Model
{
    public function senddata($data){
        return $this->db->get_where('users',$data)->row_array();
                    
      }

      public function otpupdate($data,$otpdata){
             $this->db->where('email',$data['email']);
          $this->db->update('users',$otpdata);
      }

     public function getotp($data)
     {
        return $this->db->get_where('users',$data)->result_array();
        
                    
     }

   //fetch password of users

   public function  get_user($uid){
    $this->db->where('uid',$uid);
   return $this->db->get('users')->row_array();
}
public function updatepass($uid,$data){
    $this->db->where('uid',$uid);
    $this->db->update('users',$data);
}

} 



?>