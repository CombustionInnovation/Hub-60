<?php
header('Content-Type: application/json');
require("user.php");
$user = new User;
require("verification.php");
$verification = new verification;
$user_id=$_REQUEST['user_id'];
$email = $_REQUEST["email"];
$signupstatus='four';
//echo $username.$name.$phone.$password;
if($user->doesEmailExcist($email))
{
	$signupstatus='two';
}
else
{
			if($verification->isNewNumberPendingVerification($email))
			{
				$verification->newVerificationCodeToPendingNewNumber($email,$user_id);
				
			}
			else
			{
				$verification->addNewNumberVerification($email,$user_id);
				
			}
			$signupstatus='one';
}
		$output =array(
			'status'=>$signupstatus,
		);

	echo json_encode($output);
?> 