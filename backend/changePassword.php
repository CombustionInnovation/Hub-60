<?
	header('Content-Type: application/json');
	require("user.php");//require the score php to make a score object
	$user = new user;
	$user_id = $_REQUEST['user_id'];//gather date from user
	$password = $_REQUEST['oldpassword'];//gather date from user
	$newPassword = $_REQUEST['newpassword'];//gather date from user
	$status='two';
	if($user->pushLoginUserID($user_id,$password))
	{
		$user->updatePasswordUserID($user_id,$newPassword);
		$status='one';
	}
	$output =array(
			'status'=>$status,
		);
	echo json_encode($output);
?>