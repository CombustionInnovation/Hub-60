<?
	header('Content-Type: application/json');
	require("user.php");//require the score php to make a score object
	$user = new user;
	$user_id = $_REQUEST['user_id'];//gather date from user
	$username = $_REQUEST['username'];
		if($user->doIHaveUsername($username,$user_id))
		{
			$status='one';
		}
		else
		{
			if (preg_match('/'.preg_quote('^\'£$%^&*()}{@#~?><,@|-=-_+-¬', '/').'/', $username))
			{
				// one or more of the 'special characters' found in $string
				$status='three';
			}
			else
			{
				if($user-> doesUserNameExcist($username))
				{
					$status='two';
				}
				else
				{
					$status='one';
					$user-> updateUsername($user_id,$username);
				}
				
			}
		}
	$ar = array(
		'status'=> $status,
		);
	echo json_encode($ar);
?>