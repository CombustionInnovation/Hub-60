<?php
header('Content-Type: application/json');
require("user.php");
$user = new User;
require("verification.php");
$verification = new verification;
$username=$_REQUEST['username'];
$email =$_REQUEST["email"];
$signupstatus='four';
//echo $username.$name.$phone.$password;
if($user->doesEmailExcist($email))
{
	$signupstatus='three';
}
else
{
	if($user->doesUserNameExcist($username))
		{
			$signupstatus='two';
		}
		else
		{
			if($verification->isEmailPendingVerification($email))
			{
				$verification->newVerificationCodeToPendingEmail($email);
				
			}
			else
			{
				$verification->addVerification($email);
				
			}
			$signupstatus='one';
		}
}
		$output =array(
			'status'=>$signupstatus,
		);

	echo json_encode($output);
?> 