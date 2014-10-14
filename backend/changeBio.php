<?
	header('Content-Type: application/json');
	require("user.php");//require the score php to make a score object
	$user = new user;
	$user_id = $_REQUEST['user_id'];//gather date from user
	$password = $_REQUEST['bio'];//gather date from user
	$user->updateBio($user_id,$bio)
		$status='one';
	$output =array(
			'status'=>$status,
		);
	echo json_encode($output);
?>