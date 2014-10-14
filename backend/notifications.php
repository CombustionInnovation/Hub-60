<?
	class notification{
		/* Notification Types
		0: Follow Request
		1: Follow Accepted
		2: Story Like
		3: Story Dislike
		4: Reply to story
		5: Reply Like
		6: Reply dislike
		7: Mention on story
		8: Mention on reply*/
		function sendNotification($type,$pin_id,$story_id,$reply_id,$user_id,$user_sending_notification_id,)
		{
			include('account.php');
			$message=$this->getMessage($type,$user_sending_notification_id);
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO games(type,notification_message, pin_id, story_id,reply_id,user_id,notification_from_user_id,created)VALUES('$type','$message','$pin_id','$story_id','$reply_id','$user_id','$user_sending_notification_id','$curDate')";
			$r = @mysqli_query($link, $q);//all values given and calculated are added to the database
			mysqli_close($link);
			$notification_id=$this->getNotificationID($user_id,$user_sending_notification_id,$curDate);
			$this->sendNotification($user_id,$notification_id);
		}
		
		function getMessage($type,$user_sending_notification_id)
		{
			$user_sending_notification_username=$this->getUsernameFromID($user_sending_notification_id);
			$answers[0]=$user_sending_notification_username.' wants to follow you.'
			$answers[1]=$user_sending_notification_username.' accepted your follow request.'
			$answers[2]=$user_sending_notification_username.' liked your story.'
			$answers[3]=$user_sending_notification_username.' disliked your story.'
			$answers[4]=$user_sending_notification_username.' posted a reply on your story.'
			$answers[5]=$user_sending_notification_username.' liked your reply.'
			$answers[6]=$user_sending_notification_username.' disliked your story.'
			$answers[7]=$user_sending_notification_username.' mentioned you on a story.'
			$answers[8]=$user_sending_notification_username.' mentioned you on a reply.'
		}
		
		function getUsernameFromID($user_id)
		{
			include('account.php');
			$q = "SELECT username FROM user WHERE user_id='$user_id'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			$row = mysqli_fetch_array($r)
			if($ttl==1)
			{
				$result=$row['username'];
			}
			return $result;
		}
		
		function getNotificationID($user_id,$sent_from,$created)
		{
			include('account.php');
			$q = "SELECT notification_id FROM notifications WHERE user_id='$user_id' AND notification_from_user_id='$sent_from' AND created='$created'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			$row = mysqli_fetch_array($r)
			if($ttl==1)
			{
				$result=$row['notification_id'];
			}
			return $result;
		}
		
		function getNotificationInfo($notification_id)
		{
			include('account.php');
			$q = "SELECT * FROM notifications WHERE notification_id='$notification_id'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			$row = mysqli_fetch_array($r)
			if($ttl==1)
			{
				$results=array(
					'message'=>$row['notification_message'],
				);
			}
			return $results;
		}
		
		
		function getPushKeyFromUserId($user_id)
		{
			include('account.php');
			$q = "SELECT push_key FROM user WHERE user_id='$user_id'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			$row = mysqli_fetch_array($r)
			if($ttl==1)
			{
				$results=$row['push_key'],
			}
			return $results;
		}
		
		function sendNotification($user_id,$notification_id)
		{
			$key=$this->getPushKeyFromUserId($user_id);
			$notification=$this->getNotificationInfo($notification_id);
			if($key!=null)
			{
				$this->sendPushNotification($key,$notification['message']);
			}
		}
		
		function sendPushNotification($key,$message){
		// Put your device token here (without spaces):
		$deviceToken =$key;

		// Put your private key's passphrase here:
		$passphrase = 'coffee4321';
		
		// Put your alert message here:
		//$message = $name." has reported a burn out!";

		////////////////////////////////////////////////////////////////////////////////

		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);

		

		// Create the payload body
		$body['aps'] = array(
			'alert' => $message,
			'sound' => 'default'
			);

		// Encode the payload as JSON
		$payload = json_encode($body);

		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));

		

		// Close the connection to the server
		fclose($fp);
		}
		
		function showNotificationForUser($user_id)
		{
			include('account.php');
			require('time.php');
			$time=new timer;
			$q = "SELECT * FROM notifications WHERE notification_id='$notification_id'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);s
			while($row = mysqli_fetch_array($r))
				{
					$results=array(
						'notifiaction_id'=>$row['notifiaction_id'],
						'type'=>$row['type'],
						'notification_message'=>$row['notification_message'],
						'pin_id'=>$row['pin_id'],
						'story_id'=>$row['story_id'],
						'reply_id'=>$row[''],
						'user_id'=>$row['reply_id'],
						'notification_from_user_id'=>$row['notification_from_user_id'],
						'created'=>$time->dayDifference($row['created']),
					);
				
				}
			return $results;
		}
		
	}
?>