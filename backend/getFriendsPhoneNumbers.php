<?
header('Content-Type: application/json');
	include("strings.php");
	$string = new Strings;
	include("user.php");
	$user = new User;
	include("friends.php");
	$friend= new friend;
	$phones=$_REQUEST['phones'];//get string og number separated by commas
	$user_id=$_REQUEST['user_id'];//get user id
	$status='three';
	$from='phonebook';
	if(isset($phones) && isset($user_id))//if i dont have any of the values nothing happens
	{
		$status='one';//two means the phones were recieved by no one was on push
		//$filterphones = $string ->cleanPhoneNumbers(explode( ",",$phones));//this filters the phone numbers
		$arrayofIds = explode( ",",$gfusers);//this makes teh string into an array
		for($i=0;$i<sizeof($arrayofIds);$i++)//for loop runs for every number that finds 
		{
			if($user->doesPhoneExcist($arrayofIds[$i]))//the individual number gets a check to see if its existing in the database
			{
				//add phone yto friend table 
				$actual_phone_number=$string->cleanPhoneNumbers($arrayofIds[$i]);
				$user_id_friend=$user->hetUseridFromPhoneNumber($actual_phone_number);//if ot does wxcist we get the user id from ht enumber 
				if(!$friend->doesFriendshipExcist($user_id,$user_id_friend))//then we check if they are already friends if they are not
				{
					$sent=$friend->friend_request($user_id,$user_id_friend,$from);//then we que the friendship.
					$status='one';//status one if everyhting went fine
				}
			}
		}
	}
	$output=array(
		'status'=>$status,
	);
	echo json_encode($output);