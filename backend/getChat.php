<?
	header('Content-Type: application/json');
	require('chat.php');
	$chat_class=new chat;
	$user_id=$_REQUEST['user_id'];
	$category_id=$_REQUEST['category_id'];
	$subcategory_id=$_REQUEST['subcategory_id'];
	$last=$_REQUEST['last'];
	$picture='';
	$video='';
	$thumbnail='';
	$status='two';
		if( isset($category_id)&& isset($subcategory_id))
		{
			$results=$chat_class->getChat($last,$subcategory_id,$category_id);
		}
		else
		{
			$results=array(
				'status'=>$status,
			);
		}
	
	echo json_encode($results);
?>