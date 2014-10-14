<?
	class verification{
		function addVerification($email)
		{
			include('account.php');
			$code = $this->makeCode();
			$q = "INSERT INTO non_verified(email,code) 
				VALUES ('$email','$code')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
			$this->sendUserCode($email,$code);
		}
		function addNewNumberVerification($email,$user_id)
		{
			include('account.php');
			$code = $this->makeCode();
			$q = "INSERT INTO user_non_verified(email,code,user_id) 
				VALUES ('$email','$code','$user_id')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
			$this->sendUserCode($email,$code);
		}
		
		function newVerificationCodeToPendingEmail($email)
		{
			include('account.php');
			$code = $this->makeCode();
			//echo $email.' '.$code;
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE non_verified SET code = '$code' WHERE email = '$email'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
			$this->sendUserCode($email,$code);
		
		}
		
		function newVerificationCodeToPendingNewNumber($email,$user_id)
		{
			include('account.php');
			$code = $this->makeCode();
			//echo $email.' '.$code;
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user_non_verified SET code='$code', user_id='$user_id' WHERE email='$email' ");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
			$this->sendUserCode($email,$code);
		
		}
		
		function makeCode()
		{
			$random = rand(1000,20000);
			return $random;
		}
		
		function isEmailPendingVerification($email){
			include ('account.php');
			$password = md5($pw);
			$q = "SELECT * FROM non_verified WHERE email='$email'";
			$r = @mysqli_query($link, $q);
			if(mysqli_num_rows($r) == 1){
				return true;
			}
			else
			{
				return false;
			}
		}
		
		
		function isNewNumberPendingVerification($email){
			include ('account.php');
			$password = md5($pw);
			$q = "SELECT * FROM user_non_verified WHERE email='$email'";
			$r = @mysqli_query($link, $q);
			if(mysqli_num_rows($r) == 1){
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function isCodeCorrect($email,$code){
			include ('account.php');
			$q = "SELECT * FROM non_verified WHERE email='$email' AND code='$code'";
			//echo $email.' '.$code;
			$r = @mysqli_query($link, $q);
			//echo $q . mysqli_num_rows($r);
			if(mysqli_num_rows($r) == 1){
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function isCodeForNewEmailCorrect($email,$code){
			include ('account.php');
			$q = "SELECT * FROM user_non_verified WHERE email='$email' AND code='$code'";
			//echo $email.' '.$code;
			$r = @mysqli_query($link, $q);
			if(mysqli_num_rows($r) == 1){
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function sendUserCode($email,$code){
				/*require('text/pushText.php');
				$text = new text;
				$text->sendText($email,$code);*/
				
				$to  = $email;
			    $subject = 'This isyour Hub 60 verifcation code!';
				$message = "
				<html>
					<head>

					</head>
					<body style='background-color:#1b1b1b; font-family:'Helvetica'; font-size:19px;'>
					<div style=' background:#1b1b1b; position:relative; margin:auto; top:0px; height:700px; width:620px; top:20px;'>
						<ul style='position:relative; margin:auto;padding:0;width:90%; top:0px; color:white; list-style:none; '>
							<li style='text-align:center; width:100%'><p>You new code has been generated.</p></li>
							<li><p>Code:'$code'</p></li>
						</ul>
					</div>
					</body>

				</html>";
				
				$headers = 'From: no-reply@PUSH.com'  . "\r\n";
				$headers = 'From: "no-reply@PUSH.com"'. "\r\n";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: <no-reply@PUSH.com>' . "\r\n";
				mail($to, $subject, $message, $headers,"no-reply@PUSH.com");
		}
	
		function numberWasVerified($email)
		{
			include("account.php");	
			$q = "DELETE FROM non_verified WHERE email='$email'";
			$r = @mysqli_query($link, $q);	
		}
		
		function emailWasVerifiedAndChanged($email)
		{
			include("account.php");	
			$q = "DELETE FROM user_non_verified WHERE email='$email'";
			$r = @mysqli_query($link, $q);	
		}
	}

?>