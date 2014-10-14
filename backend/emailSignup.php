<?php
header('Content-Type: application/json');
require("user.php");
$user = new User;
require("verification.php");
$verification = new verification;
$username=$_REQUEST['username'];
$name=$_REQUEST['name'];
$email =$_REQUEST["email"];
$password=$_REQUEST['password'];
$code=$_REQUEST['code'];
$signupstatus='five';
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
			if($verification->isCodeCorrect($email,$code))
			{
				$verification->numberWasVerified($email);
				$user->addPushUser($username,$name,$email,$password);
				$signupstatus='one';
				$user_id=$user->getIdFromusername($username);
				$array=$user->getInfoForUserDisplay($user_id);
			}
			else
			{
				$signupstatus='four';
			}
		}
}
		$output =array(
			'status'=>$signupstatus,
			'user_id'=>strval($array[0]['user_id']),
			'username'=>strval($array[0]['username']),
			'fb_id'=>strval($array[0]['fb_id']),
			'twitter_username'=>strval($array[0]['twitter_username']),
			'twitter_id'=>strval($array[0]['twitter_id']),
			'last_posted'=>strval($array[0]['last_posted']),
			'full_name'=>strval($array[0]['full_name']),
			'f_name'=>strval($array[0]['f_name']),
			'l_name'=>strval($array[0]['l_name']),
			'email'=>strval($array[0]['email']),
			'phone_number'=>strval($array[0]['phone_number']),
			'first_login'=>strval($array[0]['first_login']),
			'last_login'=>strval($array[0]['last_login']),
			'is_logged_in'=>strval($array[0]['is_logged_in']),
			'device'=>strval($array[0]['device']),
			'login_type'=>strval($array[0]['login_type']),
			'picture'=>strval($array[0]['picture']),
			'facebook_sync'=>strval($array[0]['facebook_sync']),
			'sync_fb_id'=>strval($array[0]['sync_fb_id']),
			'twitter_sync'=>strval($array[0]['twitter_sync']),
			'sync_twitter_id'=>strval($array[0]['sync_twitter_id']),
			'phonebook_sync'=>strval($array[0]['phonebook_sync']),
			'push_key'=>strval($array[0]['push_key']),
			'fb_token'=>strval($array[0]['fb_token']),	
		);

	echo json_encode($output);
?> 