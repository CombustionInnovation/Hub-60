<?
	
	class facebookFriending{
		function getListOfFacebookFriends($id,$access_token){
		$file=file_get_contents('https://graph.facebook.com/'.$id.'/friends?access_token='.$access_token);
		$f = json_decode($file,true);
		//echo $size.'    ';
		for($i=0;$i<sizeof($f);$i++)
		{
			$ids[]=array(
				'id'=>$f["data"][$i]['id'],
				);
		}
		return $ids;
		}
		
		function doesFacebookIdExist($fb_id){
				include("account.php");
				
				$q = "SELECT * FROM user WHERE fb_id = '$fb_id'";
				$r = @mysqli_query($link, $q);
				
				if(mysqli_num_rows($r) > 0){
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
			
		}
		
		function getIDfromFacebookID($fb_id)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM user WHERE fb_id='$fb_id'";
			$r = @mysqli_query($link, $q);
		
			$row = 	mysqli_fetch_array($r);
			$user_id = $row['user_id'];
			if(mysqli_num_rows($r) == 1) {
				return $user_id;
			}
			else
			{
				return 0;
			}
		
		}
		
		function syncFacebookinfo($user_id,$fb_id) 
	{
		include("account.php");
			//echo $phone_number.' '.$$user_id;
			$curDate = date('Y-m-d H:i:s', time());
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET sync_fb_id=$fb_id,facebook_sync='1' WHERE user_id = '$user_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
	}
	
	
	function doesUserNeedSync($user_id)
	{
		include("account.php");
				
				$q = "SELECT * FROM user WHERE facebook_sync ='1' AND user_id='$user_id'";
				$r = @mysqli_query($link, $q);
				
				if(mysqli_num_rows($r) > 0){
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
	}
	
	function congratulateUserReachingTop100($user_id)
	{
		/*include('facebook/autoload.php');
		use Facebook\FacebookRequest;
		use Facebook\GraphObject;
		use Facebook\FacebookRequestException;
		FacebookSession::setDefaultApplication('843758675645109','4cc2fc7708b958ff0c068befdc225ca2');

		// Use one of the helper classes to get a FacebookSession object.
		//   FacebookRedirectLoginHelper
		//   FacebookCanvasLoginHelper
		//   FacebookJavaScriptLoginHelper
		// or create a FacebookSession with a valid access token:
		$session = new FacebookSession('CAALZCZAOAjUrUBAFpB5SmdWutG6alOfCDWrm3kSPWpGQKWvqFtMF3XE1Ntb9qoau4atEg0XBySo896NcfCmKIG48ZACGQ0DlEZBt4BwxTIRNacnRCKj9bzIPv0XXqdVrfHZCyysffRy7ZCm4X4OSs2hqrvzFbXgQ3YgnsxfUIB7zx8jJ3yt6XZAPjChNFf9nv8n5A31EodfrJZBogKLmjDN2XZCZCanW40EH2IZAzVzH1wSuQZDZD');
		
		
		if($session) {

		  try {

			$response = (new FacebookRequest(
			  $session, 'POST', '/me/feed', array(
				'link' => 'www.example.com',
				'message' => 'User provided message '.$user_id
			  )
			))->execute()->getGraphObject();

			echo "Posted with id: " . $response->getProperty('id');

		  } catch(FacebookRequestException $e) {

			echo "Exception occured, code: " . $e->getCode();
			echo " with message: " . $e->getMessage();

		  }   

		}*/
	}
	
	/*include('facebook/autoload.php');
	use Facebook\FacebookSession;
	use Facebook\FacebookRequest;
	use Facebook\GraphUser;
	use Facebook\FacebookRequestException;
	
	FacebookSession::setDefaultApplication('843758675645109','4cc2fc7708b958ff0c068befdc225ca2');

	// Use one of the helper classes to get a FacebookSession object.
	//   FacebookRedirectLoginHelper
	//   FacebookCanvasLoginHelper
	//   FacebookJavaScriptLoginHelper
	// or create a FacebookSession with a valid access token:
	$session = new FacebookSession('CAALZCZAOAjUrUBAFpB5SmdWutG6alOfCDWrm3kSPWpGQKWvqFtMF3XE1Ntb9qoau4atEg0XBySo896NcfCmKIG48ZACGQ0DlEZBt4BwxTIRNacnRCKj9bzIPv0XXqdVrfHZCyysffRy7ZCm4X4OSs2hqrvzFbXgQ3YgnsxfUIB7zx8jJ3yt6XZAPjChNFf9nv8n5A31EodfrJZBogKLmjDN2XZCZCanW40EH2IZAzVzH1wSuQZDZD');


	// Get the GraphUser object for the current user:


	try {

	$user_friends = (new FacebookRequest(
	  $session, 'GET', '/me/friends?limit=5000'
	))->execute()->getGraphObject(GraphUser::className());
	//echo json_encode($user_friends);
	echo '<pre>';
	print_r($user_friends);
	
	 } catch(FacebookRequestException $e) {

	echo "Exception occured, code: " . $e->getCode();
	echo " with message: " . $e->getMessage();
	//echo json_encode($user_friends);
	} 

	//
	*/
	
	

		
		
	}
	?>