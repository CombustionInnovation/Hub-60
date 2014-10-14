<?php
//for twitter information look in   https://dev.twitter.com/docs/api/1.1/get/users/show
header('Content-Type: application/json');
require("user.php");
$user = new user;
require("twitter.php");
$twitter = new twitter;
	$device = $_REQUEST['device'];
	$twitterUser = $_REQUEST['user'];
	$results=$twitter->	getUserInfo($twitterUser);		
	$output=$results;
	$info['id'] = $output['tweets']->id;
	$info['name'] = $output['tweets']->name;
	$picture=str_replace("_normal.jpeg",".jpeg",$output['tweets']->profile_image_url_https);//this line will replace the url
	$info['picture'] = $picture;//of the image of twitter to make the image a little sharper.
	$info['screen_name'] = $output['tweets']->screen_name;
	$friend_array=$output['ids']->ids;
	$loginType ='Twitter';
	$username=$info['name'];
	//echo json_encode($friend_array);
	//echo $info['id'].$info['name'].$info['screen_name'].$info['picture'].$device.' '.$picture;
	if(isset($twitterUser))
	{
		if($twitter->doesTwitterIdExcist($info['id']))
		{
			
			if($twitter->getUserNameFromTwitterId($info['id'])!="")
			{
				$loginStatus='one';
			}
			else
			{
				$loginStatus='two';
			}
			$twitter->updateLastLogIn($info['id']);
			$user_id=$twitter->getUserIdFromTwitterId($info['id']);
			$array=$user->getInfoForUserDisplay($user_id);
			$username=$user->getUsernameFromID($user_id);
			//$user->updatePicture($user_id,$info['picture']);
		}
		else
		{
					//echo $info['id'].$info['name'].$info['screen_name'].$info['picture'].$device.' '.$picture;
					$twitter->addTwitterUser($info['id'],$info['name'],$info['screen_name'],$info['picture'],$device);
					$loginStatus='one';
					$user_id=$twitter->getUserIdFromTwitterId($info['id']);
					$array=$user->getInfoForUserDisplay($user_id);
		}
	}
	else
	{
		$loginStatus='three';
		$user_id=0;
		$email='notEmail';
		$loginType ='none';
	}
	$output   = array(
			'logintype' =>  $loginType,
			'user_id' =>  $user_id,
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
			'bio' => strval($array[0]['bio']),
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