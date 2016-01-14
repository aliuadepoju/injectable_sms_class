# Injectable SMS class for Laravel and native PHP
This class would probably makes integration of smslive24 SMS API easier,  can be injected into Laravel controller or include the script for those who prefer native PHP


#How To Use

 - Include SMS.php or Inject class in controller
 - Call  
 
      $sms = new SMS("http://www.smslive247.com/http/index.aspx");
	 		$sms->account("Account Email","Sub-account","password");
	 		$sms->addSender("Sender");
	 		$sms->addMessage("Message here...");
	 		$sms->addRecipient("phone number");
	 		$sms->send();// Return boolean


#Tested
This script works for simple SMS, it subject to modification to suit your needs
