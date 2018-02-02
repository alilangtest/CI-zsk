<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class Http_utils {
	
	function do_post($url,$data) 
	{
		$form_data = "";  
		foreach($data as $key => $value) 
		{
			
    		if ($form_data == "") 
    		{      
    			$form_data = $key . "=" . rawurlencode($value);    
    		} 
    		else 
    		{
    			$t = "&" . $key . '=' . rawurlencode($value);      
    			$form_data = $form_data . $t;    
    		}       
		}  
		$ch = curl_init($url);  
		curl_setopt_array($ch, array(      
										CURLOPT_POST => TRUE,
										CURLOPT_RETURNTRANSFER => TRUE,      
										CURLOPT_POSTFIELDS => $form_data  
									)
						 );
		$result = curl_exec($ch);  
		return $result;
	}
	function vpost($url,$data){ // 模拟提交数据函数
	    $curl = curl_init(); // 启动一个CURL会话
	    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
	    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
	    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
	    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
	    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
	    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
	    $tmpInfo = curl_exec($curl); // 执行操作
	    if (curl_errno($curl)) {
	       echo 'Errno'.curl_error($curl);//捕抓异常
	    }
	    curl_close($curl); // 关闭CURL会话
	    return $tmpInfo; // 返回数据
	}
	function vpost_ssl($url,$data,$userpwd)
	{
		$header[]="Content-Type: application/vnd.plcm.plcm-conference-room+xml";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		curl_setopt($curl, CURLOPT_USERPWD,$userpwd);
		$data = curl_exec($curl);
		curl_close($curl);
		return $data;
	}
}
 /* End of file Http_utils.php */