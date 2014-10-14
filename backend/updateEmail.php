<?
	header('Content-Type: application/json');
	require("user.php");//require the score php to make a score object
	$user = new user;
	require("verification.php");
	$verification = new verification;
	$user_id = $_REQUEST['user_id'];//gather date from user
	$email =$_REQUEST["email"];
	$code =$_REQUEST["code"];
		if($user->doIHaveEmail($email,$user_id))
		{
			$status='one';
		}
		else
		{
			
				if($user-> doesEmailExcist($email))
				{
					$status='two';
				}
				else
				{
					$status='three';
					if($verification->isCodeForNewEmailCorrect($email,$code))
					{
						$status='one';
						$user-> updateEmail($user_id,$email);
						$verification->emailWasVerifiedAndChanged($email);
					}
				}
				
			
		}
	$ar = array(
		'status'=> $status,
		);
	echo json_encode($ar);
?>