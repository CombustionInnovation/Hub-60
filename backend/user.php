<?
  class user {
		function addPushUser($username,$name,$email,$pw){
		include ('account.php');
		$password = md5($pw);
		//echo $phone;
		$curDate = date('Y-m-d H:i:s', time());
		$q = "INSERT INTO user(username,full_name,email,password,is_logged_in,last_login,first_login,phonebook_sync) 
			VALUES ('$username','$name','$email','$password','1','$curDate','$curDate','1')";
		$r = @mysqli_query($link, $q);
		mysqli_close($link);
		}
		
		function createUser($f_name,$l_name,$email,$phone_number,$is_logged_in,$picture,$fb_id,$login_type,$device,$fb_token) {

			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			$full_name=$f_name.' '.$l_name;
			//query db

			$q = "INSERT INTO user(full_name,f_name,l_name,email,phone_number,last_login,first_login,is_logged_in,picture,fb_id,login_type,device,fb_token,facebook_sync) 
			VALUES ('$full_name','$f_name','$l_name','$email','$phone_number','$curDate','$curDate','$is_logged_in','$picture','$fb_id','$login_type','$device','$fb_token','1')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
			//echo $q;
		}
		
		function pinstantUser($username,$phone,$pw){
			include ('account.php');
			$password = md5($pw);
			$q = "SELECT * FROM user WHERE password='$password' AND  (username='$username' OR phone_number='$phone')";
			$r = @mysqli_query($link, $q);
			//echo $signIn.' '.$password;
			//echo mysqli_num_rows($r);
			//echo $q;
			if(mysqli_num_rows($r) == 1) {
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function pushLoginUserID($user_id,$pw){
			include ('account.php');
			$password = md5($pw);
			$q = "SELECT * FROM user WHERE user_id='$user_id' AND password='$password'";
			$r = @mysqli_query($link, $q);
			//echo $phone.' '.$password;
			//echo mysqli_num_rows($r);
			if(mysqli_num_rows($r) == 1) {
				return true;
			}
			else
			{
				return false;
			}
		}
		function usernameEmailCheck($username,$email){
			include ('account.php');
			$password = md5($pw);
			$q = "SELECT * FROM user WHERE username='$username' AND email='$email'";
			$r = @mysqli_query($link, $q);
			//echo $phone.' '.$password;
			//echo mysqli_num_rows($r);
			if(mysqli_num_rows($r) == 1) {
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function updatePassword($email,$newPassword)
		{
			include("account.php");
			$password = md5($newPassword);
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET password = '$password' WHERE email='$email'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}
		
		function updateBio($user_id,$bio)
		{
			include("account.php");
			$str =  mysqli_real_escape_string ($link ,$bio);//this chunck of code takes care of any apostrophy issues encountered before
			$str = @trim($str);
			if(get_magic_quotes_gpc()) 
				{
					$str = stripslashes($str);
				}
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET bio = '$str' WHERE user_id='$user_id'");
			$stmt->execute(); 
			$stmt->close();
		}
		
		function updatePasswordUserID($user_id,$newPassword)
		{
			include("account.php");
			$password = md5($newPassword);
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET password = '$password' WHERE user_id = '$user_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}
		
		
		
		function getUsernameFromID($user_id)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM user WHERE user_id='$user_id'";
			$r = @mysqli_query($link, $q);
		
			$row = 	mysqli_fetch_array($r);
			$username = $row['username'];
			if(mysqli_num_rows($r) == 1) {
				return $username;
			}
			else
			{
				return 0;
			}
		
		} 
		
		function updatePicture($user_id,$picture)
		{
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET picture = '$picture' WHERE user_id = '$user_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}
		
	
		
		function updateLastPosted($user_id)
		{
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET last_played = '$curDate' WHERE user_id = '$user_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}
		
		
		
		
		function updateUsername($user_id,$username)
		{
			include("account.php");
			$charset = "UTF-8";
			mysqli_set_charset ($link, $charset);
			$str =  mysqli_real_escape_string ($link ,$username);//this chunck of code takes care of any apostrophy issues encountered before
			$str = @trim($str);
			if(get_magic_quotes_gpc()) 
				{
					$str = stripslashes($str);
				}	
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET username = '$str' WHERE user_id = '$user_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}
		
		function updateEmail($user_id,$email)
		{
			include("account.php");
				
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET email = '$email' WHERE user_id = '$user_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}
		function updateLastLogIn($fb_id,$fb_token)
		{
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET last_login = '$curDate', fb_token='$fb_token' WHERE fb_id = '$fb_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}
		
		function updatePhoneNumber($phone_number,$user_id)
		{
			include("account.php");
			//echo $phone_number.' '.$$user_id;
			$curDate = date('Y-m-d H:i:s', time());
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET phone_number = '$phone_number' WHERE user_id = '$user_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}
		
		function doesFBIDExcist($fb_id){//when facebook does logs in
				include("account.php");//we chek if it already excist in the datetabes
				
				$q = "SELECT * FROM user WHERE fb_id = '$fb_id'";
				$r = @mysqli_query($link, $q);
				
				if(mysqli_num_rows($r) > 0){//if teh response is more than zero we return zero
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
			}
			
		
	function doesUserNameExcist($username){//same check for the facebook 
				include("account.php");
				
				$q = "SELECT * FROM user WHERE username = '$username'";
				$r = @mysqli_query($link, $q);
				
				if(mysqli_num_rows($r) > 0){
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
			}
		function doesEmailExcist($email){//same check for the facebook 
				include("account.php");
				
				$q = "SELECT * FROM user WHERE email = '$email'";
				$r = @mysqli_query($link, $q);
				
				if(mysqli_num_rows($r) > 0){
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
			}
	function doIHaveUsername($username,$user_id){//same check for the facebook 
				include("account.php");
				
				$q = "SELECT * FROM user WHERE username = '$username' AND user_id='$user_id'";
				$r = @mysqli_query($link, $q);
				
				if(mysqli_num_rows($r) > 0){
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
			}
			
		function doIHaveEmail($email,$user_id){//same check for the facebook 
				include("account.php");
				
				$q = "SELECT * FROM user WHERE email = '$email' AND user_id='$user_id'";
				$r = @mysqli_query($link, $q);
				
				if(mysqli_num_rows($r) > 0){
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
			}
	function getUserIdFromEmail($email)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM user WHERE email='$email'";
			$r = @mysqli_query($link, $q);
		
			$row = 	mysqli_fetch_array($r);
			$user_id = $row['user_id'];
		
			return $user_id;
		}
		
		function getTypeFromUserID($user_id)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM user WHERE user_id='$user_id'";
			$r = @mysqli_query($link, $q);
		
			$row = 	mysqli_fetch_array($r);
			$type['log'] = $row['login_type'];
			$type['name'] = $row['f_name'].' '.$row['l_name'];
			$type['token'] = $row['fb_token'];
			$type['fb_id'] = $row['fb_id'];
			$type['t_id'] = $row['twitter_id'];
			return $type;
		}
		
		function hetUseridFromPhoneNumber($phone_number)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM user WHERE phone_number='$phone_number'";
			$r = @mysqli_query($link, $q);
			$row = 	mysqli_fetch_array($r);
			$user_id = $row['user_id'];
			return $user_id;
		}
		
	function getUserNameFromEmail($email)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM user WHERE email='$email'";
			$r = @mysqli_query($link, $q);
		
			$row = 	mysqli_fetch_array($r);
			$username = $row['username'];
		
			return $username;
		}
		
	function getIDfromTwitterID($twitter_id)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM user WHERE twitter_id='$twitter_id'";
			$r = @mysqli_query($link, $q);
		
			$row = 	mysqli_fetch_array($r);
			$user_id = $row['user_id'];
			if(mysqli_num_rows($r) == 1) {
				return $user_id;
			}
			else
			{
				return 12;
			}
		
		} 
		
	function getIDfromTwitterName($twitter_name)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM user WHERE twitter_username='$twitter_name'";
			$r = @mysqli_query($link, $q);
		
			$row = 	mysqli_fetch_array($r);
			$user_id = $row['user_id'];
			if(mysqli_num_rows($r) == 1) {
				return $user_id;
			}
			else
			{
				return 0;
			}
		
		} 
		
		function getIdFromusername($username)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM user WHERE username='$username'";
			$r = @mysqli_query($link, $q);
		
			$row = 	mysqli_fetch_array($r);
			$user_id = $row['user_id'];
			if(mysqli_num_rows($r) == 1) {
				return $user_id;
			}
			else
			{
				return 0;
			}
		
		} 
		
		
		function getIdFromuPhone($phone_number)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM user WHERE phone_number='$phone_number'";
			$r = @mysqli_query($link, $q);
		
			$row = 	mysqli_fetch_array($r);
			$user_id = $row['user_id'];
			if(mysqli_num_rows($r) == 1) {
				return $user_id;
			}
			else
			{
				return 0;
			}
		
		} 
		
		function showUserInformation($user_id)
		{	
			include("account.php");
			$q = "SELECT * FROM user WHERE user_id='$user_id'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
				while($row=mysqli_fetch_array($r)) {
						if($row['allScore']==null)
						{$allscore=0;}else{$allscore=$row['allScore'];}
					$results  = array(
						// to be determined by app
						
					);
				}
				
			return $results;
		}
		function getInfoForUserDisplay($user_id) {
			//echo 'user_id '.$user_id;
			include("account.php");
			require('time.php');
			$time= new timer;
			require('created.php');
			$created= new created;
			//Get userID
			//query db
			$q = "SELECT * FROM user WHERE user_id='$user_id'";
			$r = @mysqli_query($link, $q);
			//There can be only one!
			if(mysqli_num_rows($r) == 1) {

				while($row = 	mysqli_fetch_array($r)) {
					// determined by app design
					
						if($row['push_key']==NULL){$push='no';}else{$push='yes';}
						if($row['fb_token']==NULL){$token='no';}else{$token='yes';}
						if($row['last_posted']=='0000-00-00 00:00:00'){$posted='never';}else{$posted=$row['last_posted'];}
						$results[]=array(
							'user_id'=>$row['user_id'],
							'username'=>$row['username'],
							'fb_id'=>$row['fb_id'],
							'twitter_username'=>$row['twitter_username'],
							'twitter_id'=>$row['twitter_id'],
							'last_posted'=>$posted,
							'full_name'=>$row['full_name'],
							'bio'=>$row['bio'],
							'f_name'=>$row['f_name'],
							'l_name'=>$row['l_name'],
							'email'=>$row['email'],
							'phone_number'=>$row['phone_number'],
							'first_login'=>$row['first_login'],
							'last_login'=>$row['last_login'],
							'is_logged_in'=>$row['is_logged_in'],
							'device'=>$row['device'],
							'login_type'=>$row['login_type'],
							'picture'=>$row['picture'],
							'facebook_sync'=>$row['facebook_sync'],
							'sync_fb_id'=>$row['sync_fb_id'],
							'twitter_sync'=>$row['twitter_sync'],
							'sync_twitter_id'=>$row['sync_twitter_id'],
							'phonebook_sync'=>$row['phonebook_sync'],
							'push_key'=>$push,
							'fb_token'=>$token,
						);

				}
					//echo json_encode($results);
					return $results;
				

			}

			else {

				return $array = [];	

			}

			mysqli_close($link);

		}
		
		function doesUserHaveSettings($user_id)
		{
			include("account.php");
		
			$q = "SELECT * FROM settings WHERE user_id='$user_id'";
			$r = @mysqli_query($link, $q);
		
			$row = 	mysqli_fetch_array($r);
			$output['private'] = $row['private'];
			$output['push_notification'] = $row['push_notification'];
			if(mysqli_num_rows($r) == 1) {
				return $output;
			}
			else
			{	
				$output['private'] = 0;
				$output['push_notification'] = 0;
				return $output;
			}
		}
		function changeProfilePicture($picture,$user_id)
		{
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			$stmt = $link->prepare("UPDATE user SET picture = '$picture' WHERE user_id = '$user_id'");
			$stmt->execute(); 
			$stmt->close();
		}
		
		function sendNewPassword($email,$pass){
				$to  = $email;
			    $subject = 'This is your New Hub 60 password!';
				$message = "
				<html>

					<head>

					</head>


					<body style='background-color:#1b1b1b; font-family:'Helvetica'; font-size:19px;'>
					<div style=' background:#1b1b1b; position:relative; margin:auto; top:0px; height:700px; width:620px; top:20px;'>
						<ul style='position:relative; margin:auto;padding:0;width:90%; top:0px; color:white; list-style:none; '>
							<li style='text-align:center; width:100%'><p>You new password has been generated.</p></li>
							<li><p>password:'$pass'</p></li>
						</ul>
					</div>
					</body>

				</html>";
				
				$headers = 'From: no-reply@hub60.com'  . "\r\n";
				$headers = 'From: "no-reply@hub60.com"'. "\r\n";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: <no-reply@hub60.com>' . "\r\n";
				mail($to, $subject, $message, $headers,"no-reply@hub60.com");
		}
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
		function hasUserPostedRecently($user_id)
		{
			include("account.php");
			require('time.php');
			$time= new timer;
			$q = "SELECT last_posted FROM user WHERE user_id='$user_id'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			while($row =mysqli_fetch_array($r)) 
			{
					$seconds=$time->getSecodsDifference($row['last_posted']);
					if($seconds<=10)
					{
						return true;
					}
					else
					{
						return false;
					}
			}
		}
  }
	
?>