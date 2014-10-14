<?
	header('Content-Type: application/json');
	require("user.php");//require the score php to make a score object
	$user = new user;
	$username = $_REQUEST['username'];
	if($user-> doesUserNameExcist($username))
	{
		$status='two';
	}
	else
	{
		$status='one';
	}
	
	
	$ar = array(
		'status'=> $status,
		);
	echo json_encode($ar);
?>