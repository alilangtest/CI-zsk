<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Phpmail{
		private $_ci = NULL;
		private $_ip = "";
        function  __construct(){
               require_once(dirname(__FILE__)."/phpmailer/class.phpmailer.php");
               $this->_ci =& get_instance();
        }
 
        function send_email($config =array()) {
                global $error;
                if(count($config) < 3)
                {
                	return false;
                }
                $mail = new PHPMailer();  // create a new object
                $mail->IsSMTP(); // enable SMTP
                $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
                $mail->SMTPAuth = true;  // authentication enabled
                $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
                $mail->Host = 'smtp.exmail.qq.com';
                $mail->Port = 465;
                $mail->Username = "service@cloudskysec.com";
                $mail->Password = "1q@W3e\$R5t1q";
                $mail->SetFrom('service@cloudskysec.com');
                $mail->FromName = '山东云天安全';
                $mail->Subject = $config['subject'];
                //$mail->Body = $body;
                $mail->CharSet="utf-8";
                $mail->Encoding = "base64";
                 
                $mail->AltBody = '';
                $mail->WordWrap   = 80;
                $mail->MsgHTML($config['body']);
                $mail->IsHTML(true);
                $mail->AddAddress($config['to']);
//                return $mail->Send();
                $this->_ci->load->model("email/email_log_model","emlog",TRUE);
                
		        $this->_ci->emlog->from_userid=isset($config['from_userid'])?$config['from_userid']:"";
		        $this->_ci->emlog->to_userid=isset($config['to_userid'])?$config['to_userid']:"";
		        $this->_ci->emlog->subject=isset($config['subject'])?$config['subject']:"";
		        $this->_ci->emlog->content=isset($config['body'])?$config['body']:"";
		        $this->_ci->emlog->to=isset($config['to'])?$config['to']:"";
		        if($this->_ip != '')
		        	$this->_ci->emlog->addip=$this->_ip;
                if(!$mail->Send()) {
                       $this->_ci->emlog->status=1;//发送成功
                       $this->_ci->emlog->insert();
                       return FALSE;
                } else {
                        $this->_ci->emlog->status=0;
                        $this->_ci->emlog->insert();
                        return TRUE;
                }
        }
} 
 
 