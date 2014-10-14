<?php
header('Content-Type: application/json');
require("user.php");
$user = new User;
require("facebook.php");
$facebook = new facebookFriending;


//user data from the phone most will be aggregated from facebook.
$user_id = $_REQUEST['user_id'];
$first_name = $_REQUEST['fname'];
$last_name = $_REQUEST['lname'];
$email = $_REQUEST['email'];
$device = $_REQUEST['device'];
$picture = $_REQUEST['picture'];
$fb_token = $_REQUEST['token'];
$login_type = $_REQUEST['type'];
$fb_id = $_REQUEST['fb_id'];
//echo $fb_id.'fb_id';
$from='facebook';

		$loginType = 'facebook';
		if(!isset($user_id)&&!isset($email))
		{
			$user_id=0;
			$email='noEmail';
			$loginType ='none';
		}
			
			if($user->doesFBIDExcist($fb_id))
			{
			//do update
				//echo 'doesFBIDExcist';
				if($user->getUserNameFromEmail($email)=="")
										{
											$loginStatus='one';
										}
										else
										{
											$loginStatus='two';
										}
				$user->updateLastLogIn($fb_id,$fb_token);
				$user_id=$user->getUserIdFromEmail($email);
				$array=$user->getInfoForUserDisplay($user_id);
				//$username=$user->getUsernameFromID($user_id);
				$user->updatePicture($user_id,$picture);
				$output   = array(
					'logintype' =>  $loginType,
					'user_id' =>  $user_id,
					'loginstatus' => $loginStatus,
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
					'bio' => strval($array[0]['bio']),
					'picture'=>strval($array[0]['picture']),
					'facebook_sync'=>strval($array[0]['facebook_sync']),
					'sync_fb_id'=>strval($array[0]['sync_fb_id']),
					'twitter_sync'=>strval($array[0]['twitter_sync']),
					'sync_twitter_id'=>strval($array[0]['sync_twitter_id']),
					'phonebook_sync'=>strval($array[0]['phonebook_sync']),
					'push_key'=>strval($array[0]['push_key']),
					'fb_token'=>strval($array[0]['fb_token']),		
					'fname' => ifNull($first_name),
					'lname' => ifNull($last_name),
					'email' => ifNull($email),
										//'username' => ifNull($username),
									);
				
			}
			else
			{
			//create new facebook user
			
				//this means that they are not logging in with facebook and using group flight
					if(isset($email))
					{
						
									//echo 'why';
									$user->createUser($first_name,$last_name,$email,$phone_number,$is_logged_in,$picture,$fb_id,$loginType,$device,$fb_token);
											
									//one means creating a user was successful
									if($user->getUserNameFromEmail($email)=="")
										{
											$loginStatus='one';
											
										}
										else
										{
											$loginStatus='two';
										}
									$user_id = $user -> getUserIdFromEmail($email);	
									$array=$user->getInfoForUserDisplay($user_id);
					}
					else
					{
					//for some reason an error occured			
										$loginStatus = "four";
					}	

										//$myusername = $username;
										//$phone = $phone_number;
				
				
				$output   = array(
										'logintype' =>  $loginType,
										'loginstatus' => $loginStatus,
										'user_id'=>$user_id,
										'username'=>strval($array[0]['username']),
										'fb_id'=>strval($array[0]['fb_id']),
										'twitter_username'=>strval($array[0]['twitter_username']),
										'twitter_id'=>strval($array[0]['twitter_id']),
										'last_posted'=>strval($array[0]['last_posted']),
										'full_name'=>strval($array[0]['full_name']),
										'f_name'=>strval($array[0]['f_name']),
										'l_name'=>strval($array[0]['l_name']),
										'email'=>strval($array[0]['email']),
										'bio' => strval($array[0]['bio']),
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
										//'username' => $username,
									);
							
									
			}
			echo json_encode($output);
	function ifNull($value)
	{
		if($value == null)
		{
			return "";
		}
		else
		{
			return $value;
		}
	}
	
	
	


?>	