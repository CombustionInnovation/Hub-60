<?
	header('Content-Type: application/json');
	require("reports.php");//require the reported php to make a reported object
	$report = new report;
	$user_id=$_REQUEST['user_id'];
	$comment_id=$_REQUEST['comment_id'];
	$reported=$_REQUEST['reported'];
	$status='two';
	if(isset($user_id) && isset($comment_id))
	{
		if($report->doesReportExist($user_id,$comment_id))
		{
			$report->updateReport($user_id,$comment_id,$reported);
		}
		else
		{
			$report->addReport($user_id,$comment_id,$reported);
		}
		$status='one';
	}
	$output=array(
		'status'=>$status,
	);
	echo json_encode($output);
?>