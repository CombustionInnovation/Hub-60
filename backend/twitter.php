<?php
	class twitter
{
	function addTwitterUser($twitter_id,$Tname,$twitter_name,$picture,$device){
		include("account.php");
		
			//Gather data
			
			$device=$device;
			$picture=$picture;
			$twitter_id=$twitter_id;
			$twitter_name=$twitter_name;
			$name = explode(" ", $Tname);
			$f_name=$name[0]; // George 
			$l_name=$name[1]; // Washington
			$login_type='twitter';
			$curDate = date('Y-m-d H:i:s', time());
			//echo $f_name.$l_name.$login_type.$twitter_name.$twitter_id.$curDate.$curDate.$device.$picture.$Tname;
			$q = "INSERT INTO user(full_name,f_name,l_name,login_type,twitter_username,twitter_id,first_login,last_login,device,picture) 
			VALUES ('$Tname','$f_name','$l_name','$login_type','$twitter_name','$twitter_id','$curDate','$curDate','$device','$picture')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
			//echo $q;
	}
	function getUserInfo($user){
		session_start();
		require_once("tphp/twitteroauth/twitteroauth.php"); //Path to twitteroauth library
		 
		$twitteruser = $user;
		$consumerkey = "Kd5QkPm5YnrCcytywvIb9iZDd";
		$consumersecret = "zOOdLDIsmwAQ65txaZdTZSybKAYCCmFMtwfcIknv9dXbqakWsE";
		$accesstoken = "1309908991-n7VGfSowlJiGZC30JRo604hydwFH4qmlxDcXmZB";
		$accesstokensecret = "oECwYecoSqgLcS4E9GqDpHEZjQKSB7m7ZN058x4cD8TdD";
		 
		function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		  return $connection;
		}
		 
		$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
		// echo json_encode($connection);
		$tweets ['tweets']= $connection->get("https://api.twitter.com/1.1/users/show.json?screen_name=".$twitteruser."&sizing=bigger");
		$tweets ['ids']= $connection->get("https://api.twitter.com/1.1/friends/ids.json?cursor=-1&screen_name=".$twitteruser."&count=5000");
		return $tweets;
	}
	
	/*function \($user,$game){
		session_start();
		require_once("tphp/twitteroauth/twitteroauth.php"); //Path to twitteroauth library
		 
		$twitteruser = $user;
		$consumerkey = "Kd5QkPm5YnrCcytywvIb9iZDd";
		$consumersecret = "zOOdLDIsmwAQ65txaZdTZSybKAYCCmFMtwfcIknv9dXbqakWsE";
		$accesstoken = "1309908991-n7VGfSowlJiGZC30JRo604hydwFH4qmlxDcXmZB";
		$accesstokensecret = "oECwYecoSqgLcS4E9GqDpHEZjQKSB7m7ZN058x4cD8TdD";
		//$message='Yay congratulations to @'.$user.' for PUSHiing for more than 30 minutes! Check out your score http://pushlonger.com/game/?g='.$game.' @Pushtheapp';
		function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		  return $connection;
		}
		
		$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
		 //echo json_encode($connection);
		$parameters=array('status'=>$message,);
		$tweet=$connection->post('statuses/update', $parameters);
		return $tweet;
	}*/
	
	function doesTwitterIdExcist($twitter_id)
	{
				include("account.php");//we chek if it already excist in the datetabes
				$q = "SELECT * FROM user WHERE twitter_id = '$twitter_id'";
				$r = @mysqli_query($link, $q);
				//echo $q.' '.mysqli_num_rows($r);
				if(mysqli_num_rows($r) > 0){//if teh response is more than zero we return zero
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
	}
	
	function doesUserNeedSync($user_id)
	{
				include("account.php");//we chek if it already excist in the datetabes
				
				$q = "SELECT * FROM user WHERE user_id='$user_id' AND  sync_twitter_id=''";
				$r = @mysqli_query($link, $q);
				
				if(mysqli_num_rows($r) > 0){//if teh response is more than zero we return zero
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
	}
	
	function updateLastLogIn($twitter_id)
		{
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET last_login ='$curDate'WHERE twitter_id ='$twitter_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
			//echo "UPDATE user SET last_login = ".$curDate." WHERE twitter_id = ".$twitter_id;
		}
			
	function getUserIdFromTwitterId($twitter_id)
		{
			include("account.php");
			$q = "SELECT * FROM user WHERE twitter_id='$twitter_id'";
			$r = @mysqli_query($link, $q);
			$row = 	mysqli_fetch_array($r);
			$user_id = $row['user_id'];
			return $user_id;
		} 
		
	function getUserNameFromTwitterId($twitter_id)
		{
			include("account.php");
			$q = "SELECT * FROM user WHERE twitter_id='$twitter_id'";
			$r = @mysqli_query($link, $q);
			$row = 	mysqli_fetch_array($r);
			$username = $row['username'];
			return $username;
		} 
		
	function syncTwitterInfoAndFriends($twitter_username,$twitter_id,$user_id) 
	{
		include("account.php");
			//echo $phone_number.' '.$$user_id;
			$curDate = date('Y-m-d H:i:s', time());
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET twitter_sync='1' ,twitter_username = '$twitter_username', sync_twitter_id='$twitter_id' WHERE user_id = '$user_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
	}
}
?>