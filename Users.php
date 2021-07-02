<?php  

class Users extends CI_Controller
{
    
   public function forgetpassword(){
    $this->load->view('forgetpassword');
}

public function send_otp(){
     
      
      $data['email'] = $this->input->post('email');
       $user = $this->Moduser->senddata($data);
       if(count($user) > 0){   
           $otp = rand(11111,99999);
           $otpdata = array(
                 'otp' => $otp
           );
         //  print_r($otpdata); die;
           $this->Moduser->otpupdate($data,$otpdata);
           redirect('users/otp');
       }else{
         $this->session->set_flashdata('error','your email address is not correct!');
         redirect('users/forgetpassword');
       }
}

public function otp(){
   $this->load->view('enterotp');
}

public function otpcheck()
{
   $data['otp'] = $this->input->post('otp');
   $otpuser = $this->Moduser->getotp($data);
   if(count($otpuser)== 1){
              $session = array(
                
                  'uid'=>$otpuser[0]['uid']
              );
              $this->session->set_userdata($session);
              if($this->session->userdata('uid')){
               
                 redirect('users/forgets');
              }
              else{
                    'session not created';
              }
           
   }
   else{
          $this->session->set_flashdata('error','please enter correct otp');
          redirect('users/otp');
   }
 
}
public function forgets()
{
   $this->load->view('forget');
}

public function changepasswords()
{
 $this->form_validation->set_rules('oldpassword','Old Password','callback_passwordscheck');
 $this->form_validation->set_rules('newpassword','New Password','required');
 $this->form_validation->set_rules('confirmpassword','Confirm Password','required|matches[newpassword]');
 $this->form_validation->set_error_delimiters('<div class="error">');
 if($this->form_validation->run()==false){
        $this->load->view('forget');
 }else{
               $uid = $this->session->userdata('uid');
               $newpass = $this->input->post('newpassword');
                $this->Moduser->updatepass($uid,array('password'=>md5($newpass)));
                $this->session->set_flashdata('error','your password is successfully updated');
                redirect('users/login');
 }
}

public function passwordscheck($oldpass){
  $uid = $this->session->userdata('uid');
 
  $user = $this->Moduser->get_user($uid);

  if($user['password'] !== md5($oldpass)){
      $this->form_validation->set_message('passwordcheck','the field does not match');
      return false;
  }else{
      return true;
  }
}


}



?>