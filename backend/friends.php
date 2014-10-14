<?
 class friend{
	function friend_request($sender,$friended,$from){//sets friend request as accepted because these users are already friends on twitter
		include('account.php');
		$curDate = date('Y-m-d H:i:s', time());
		$q = "INSERT INTO friends(friender,friendee,accepted,date_sent,date_accepted,friend_from) 
		VALUES ('$sender','$friended','1','$curDate','$curDate','$from')";//relationship bettween tehm is sent as one for accepted
		$r = @mysqli_query($link, $q);
		mysqli_close($link);
		return 'sent';
	}
	
	function friend_request_for_request($sender,$friended,$from){//sets friend request as accepted because these users are already friends on twitter
		include('account.php');
		$curDate = date('Y-m-d H:i:s', time());
		$q = "INSERT INTO friends(friender,friendee,date_sent,friend_from) 
		VALUES ('$sender','$friended','$curDate','push')";//relationship bettween tehm is sent as one for accepted
		$r = @mysqli_query($link, $q);
		mysqli_close($link);
		return 'sent';
	}
	
	function doesTwitterUserExcist($twitter_id){//twitter friending
				include("account.php");//we chek if it already excist in the datetabes
				
				$q = "SELECT * FROM user WHERE twitter_id = '$twitter_id'";
				$r = @mysqli_query($link, $q);
				if(mysqli_num_rows($r) > 0){//if teh response is more than zero we return zero
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
			}
 
	function sendTwitterFriendsRequest($twitter_username,$user_id){
		/*require("twitter.php");//require the score php to make a score object
		$twitter = new twitter;
		require("user.php");//require the score php to make a score object
		$user = new user;
		$friends=$twitter->getTwitterFriends($twitter_username);
		$info= $friends->ids;
		for($i=0;$i<count($info);$i++)
		{
			if($this->doesTwitterUserExcist($info[$i]))
			{
				$friendee_id=$user->getIDfromTwitterID($twitter_id);
				$this->friend_request($user_id,$friendee_id);
			}
		}*/
	}
	
	function doesFriendshipExcist($user_id_one,$user_id_two){//twitter friending
				include("account.php");//we chek if it already excist in the datetabes
				
				$q = "SELECT * FROM friends WHERE (friender='$user_id_one' && friendee='$user_id_two') OR (friendee='$user_id_one' && friender='$user_id_two') ";
				//echo $q;
				$r = @mysqli_query($link, $q);
				if(mysqli_num_rows($r) > 0){//if teh response is more than zero we return zero
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
				
			}
			
	function showMyFriends($user_id)
	{
		require ('user.php');
		$user= new User;
		$array=$this->getArrayOfFriends($user_id);
		//echo json_encode($array);
		include("account.php");
			$q = "SELECT * FROM user WHERE user_id in(".implode(',', $array).") ORDER BY best_score DESC";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
				while($row=mysqli_fetch_array($r)) {
					$results[] = array(
	
						'user_id' => $row['user_id'],
						'username' => $row['username'],
						//'rank' => $game->getRankOfGame($row['best_score']),
						'best_score' => $row['best_score'],
						'time_passed' => $row['best_time'],
						'f_name' => $row['f_name'],
						'l_name' => $row['l_name'],
						'name' => $row['full_name'],
						'email' => $row['email'],
						'phone_number' => $row['phone_number'],
						//'password' => $row['password'],
						'first_login' => $row['first_login'],
						'last_login' => $row['last_login'],
						'device' => $row['device'],
						'picture' => $row['picture'],
						'fb_id' => $row['fb_id'],
						'best_game_played_date' => $days,
						'allScore' => $row['allScore'],
						//'allTime' => $time->seconds2time($row['allScore']),
						
					);
				}
		
		return $results;
	}
	
	function showUserInformation($user_id)
		{	
			include("account.php");
			$q = "SELECT * FROM user WHERE user_id='$user_id'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
				while($row=mysqli_fetch_array($r)) {
					$results  = array(
	
						'user_id' => $row['user_id'],
						'username' => $row['username'],
						//'rank' => $game->getRankOfGame($row['best_score']),
						'best_score' => $row['best_score'],
						'time_passed' => $row['best_time'],
						'f_name' => $row['f_name'],
						'l_name' => $row['l_name'],
						'name' => $row['full_name'],
						'email' => $row['email'],
						'phone_number' => $row['phone_number'],
						//'password' => $row['password'],
						'first_login' => $row['first_login'],
						'last_login' => $row['last_login'],
						'device' => $row['device'],
						'picture' => $row['picture'],
						'fb_id' => $row['fb_id'],
						'best_game_played_date' => $days,
						'allScore' => $row['allScore'],
						//'allTime' => $time->seconds2time($row['allScore']),
						
					);
				}
				
			return $results;
		}
	
	function findPeopleYouveRequested($user_id)
	{
		include('account.php');
		$q="SELECT friendee FROM friends WHERE friender='$user_id'";
		$r = @mysqli_query($link, $q);
			while($row =mysqli_fetch_array($r))
			{
				$results[]=array(
					$row['friendee'],
				);
			}
		for($i=0;$i<sizeof($results);$i++)
		{
			$array[$i]=$results[$i][0];
		}
		//echo json_encode($array);
		return $array;
	}
	
	function findPeopleThatRequestedYou($user_id)
	{
		include('account.php');
		$q="SELECT friender FROM friends WHERE friendee='$user_id'";
		$r = @mysqli_query($link, $q);
			while($row = 	mysqli_fetch_array($r))
			{
				$results[]=array(
					$row['friendee'],
				);
			}
		for($i=0;$i<sizeof($results);$i++)
		{
			$array[$i]=$results[$i][0];
		}
		//echo json_encode($array);
		return $array;
	}
	
	function getArrayOfFriends($user_id){
		$array1=$this->findPeopleYouveRequested($user_id);
		$array2=$this->findPeopleThatRequestedYou($user_id);
		//echo sizeof($array1);
		//echo sizeof($array2);
		//echo json_encode($array1);
		if(sizeof($array1)==0)
		{
			$array=$array2;
		} 
		else if(sizeof($array2)==0)
		{
			$array=$array1;
		}
		else
		{
			$array=array_merge($array1, $array2);
		}
		return $array;
	}
	
	function acceptFriendRequest($user_id,$requester)
		{
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			//$password = md5($newPassword);
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE user SET accepted = '1', date_accepted='$curDate' WHERE friender='$requester' AND friendee='$user_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}
 }
?>