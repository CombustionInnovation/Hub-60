<?
	header('Content-Type: application/json');
	require("user.php");//require the score php to make a score object
	$user = new user;
	//$phone_number =  preg_replace("/[^A-Za-z0-9]/", "", $_REQUEST["phone"]);
	$email =  $_REQUEST["email"]);
	//$password = $_REQUEST['password'];//gather date from user
	//$newPassword = $_REQUEST['newPassword'];//gather date from user
	$username = $_REQUEST['username'];//gather date from user
	$status='two';
	if(isset($username) && isset($email))
	{
		if($user->usernameEmailCheck($username,$email))
		{
			
			$random =  rand(1000 ,20000);
			$np = "HUB".$random;
			//echo $username.' '.$phone_number.' '.$np;
			$user ->sendNewPassword($email,$np);
			$user->updatePassword($email,$np);
			$status='one';
		}
	}

	$output =array(
			'status'=>$status,
		);
	echo json_encode($output);
?>