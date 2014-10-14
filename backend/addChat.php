<?
	header('Content-Type: application/json');
	require('chat.php');
	$chat_class=new chat;
	require('images.php');
	$image_class= new images;
	require('video.php');
	$video_class= new videos;
	$comment=$_REQUEST['comment'];
	$user_id=$_REQUEST['user_id'];
	$category_id=$_REQUEST['category_id'];
	$subcategory_id=$_REQUEST['subcategory_id'];
	$type=$_REQUEST['type'];
	$picture='';
	$video='';
	$thumbnail='';
	$status='two';
		if(isset($comment) && isset($type)&& isset($category_id)&& isset($subcategory_id))
		{
			if($type==0)//this means the story is only text 
			{
				$chat_class->addChatComment($user_id,$category_id,$subcategory_id,$comment,$picture,$thumbnail,$video,$type);
				$status='one';
			}
			else if($type==1)//this means the story has a picture
			{
				$picture=$image_class->uploadImage($user_id);
				$chat_class->addChatComment($user_id,$category_id,$subcategory_id,$comment,$picture,$thumbnail,$video,$type);
				$status='onee';
			}
			else if($type==2)//this means the story has a video
			{
				$video=$video_class->uploadVideo($user_id);//code to get the video and thumbnail
				$chat_class->addChatComment($user_id,$category_id,$subcategory_id,$comment,$picture,$video['thumbnail'],$video['video'],$type);
				$status='oneee';
			}
			else
			{
				$status='nine';
			}
		}
	
	$output=array(
		'status'=>$status,
	);
	echo json_encode($output);
?>