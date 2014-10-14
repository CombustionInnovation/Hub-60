<?php
header('Content-Type: application/json');
require("user.php");
$user = new User;
$username=$_REQUEST['username'];
$phone =preg_replace("/[^A-Za-z0-9]/", "", $_REQUEST["phone"]);
//if(!isset($username)){$username=null;}else if(!isset($phone)){$phone=null;}
$password=$_REQUEST['password'];
//echo $username.$name.$phone.$password;

		$signedIn=$user->pinstantUser($username,$phone,$password);
		//echo $signIn.' '.$password;
		if($signedIn)
		{
			$signinstatus='one';
			if(isset($username)){$user_id=$user->getIdFromusername($username);}else if(isset($phone)){$user_id=$user->hetUseridFromPhoneNumber($phone);}
			$array=$user->getInfoForUserDisplay($user_id);
		}
		else
		{
			$signinstatus='two';
		}

		$output =array(
			'status'=>$signinstatus,
			'user_id' => strval($user_id),
			'username' => strval($array[0]['username']),
			'email' => strval($array[0]['email']),
			'device' => strval($array[0]['device']),
			'bio' => strval($array[0]['bio']),
			'picture' => strval($array[0]['picture']),
			'push_notification' => strval($array[0]['push_key']),
			'fb_token' => strval($array[0]['fb_token']),
			'phone_number' =>  strval($array[0]['phone_number']),
		);

	echo json_encode($output);
?> 