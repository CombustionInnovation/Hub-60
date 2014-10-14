<?
	header('Content-Type: application/json');
	require("likes.php");//require the score php to make a score object
	$like = new like;
	$user_id=$_REQUEST['user_id'];
	$comment_id=$_REQUEST['comment_id'];
	$score=$_REQUEST['score'];
	$status='two';
	if(isset($user_id) && isset($comment_id))
	{
		if($like->doesRankingExist($user_id,$comment_id))
		{
			$like->updatelike($user_id,$comment_id,$score);
		}
		else
		{
			$like->addLike($user_id,$comment_id,$score);
		}
		$status='one';
	}
	$output=array(
		'status'=>$status,
	);
	echo json_encode($output);
?>