<?php

//namespace App\Utils;

class SMS{
	var $url,$messages=[];
	public function __construct($url){
		$this->url=$url;
		$this->data=["msgtype"=>0,"cmd"=>"sendquickmsg"];
		$this->recipients=[];
		$this->response=[];
	}
	
	function addParams($params){
		foreach($params as $key=>$value){
			$this->data[$key]=$value;
		}
	}

	function account($email,$user,$password){
		$this->data["owneremail"]=$email;	
		$this->data["subacct"]=$user;
		$this->data["subacctpwd"]=$password;
	}

	function setRecipients($recipients=[]){
		$this->recipients=$recipients;
		$this->data["sendto"]=implode(",",array_unique($this->recipients));
	}
	

	function addRecipient($recipient){
		array_push($this->recipients, $recipient);
		$this->data["sendto"]=implode(",",array_unique($this->recipients));
	}
	
	function addSender($sender){
		$this->data["sender"]=$sender;
	}
	

	function addMessage($msg,$chunk=false){
		$msg=preg_replace("/http(s)?:\/\//","www.", addslashes($msg));
		$this->messages=$chunk == true?str_split($msg,160):[$msg];
	}

	function send(){
		preg_match("/(http:\/\/)?(www.)?(.*)/",$this->url,$match);
		$uri=$match[3];
		
		foreach ($this->messages as $msg){
			$this->data["message"]=$msg;
			$data=http_build_query($this->data);
			$this->response[] = exec("curl -X GET -d '$data' {$uri}");
		}
		
		if(strpos(strtolower(implode("\n",$this->response)),"ok") !== false) return true;
		return false;
	}

	function getResponse(){
		return implode("\n",$this->response);
	}
}

/* 
 * $sms = new SMS("http://www.smslive247.com/http/index.aspx");
	 		$sms->account("Account Email","Sub-account","password");
	 		$sms->addSender("Sender");
	 		$sms->addMessage("Message here...");
	 		$sms->addRecipient("phone number");
	 		$sms->send();// Return boolean
 *  */
