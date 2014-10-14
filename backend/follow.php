<?
	class follow{
		function follow($follower_id,$followed_id)
		{
			//created follow relationship on follow table
			include('account.php');
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO followers(type,notification_message, pin_id, story_id,reply_id,user_id,notification_from_user_id,created)VALUES('$type','$message','$pin_id','$story_id','$reply_id','$user_id','$user_sending_notification_id','$curDate')";
			$r = @mysqli_query($link, $q);//all values given and calculated are added to the database
			mysqli_close($link);
		}
		
		function requestFollow($follower_id,$requested_id)
		{
			//send follow request
		}
		
		function unfollow($follower_id,$followed_id)
		{
			//delete the follow on the follow table
		}
	}

?>