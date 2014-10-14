<?php
header('Content-Type: application/json');
require("user.php");
$user = new User;
require("verification.php");
$verification = new verification;
$phone =preg_replace("/[^A-Za-z0-9]/", "", $_REQUEST["phone"]);
$user_id=$_REQUEST['user_id'];
$code=$_REQUEST['code'];
$signupstatus='five';
//echo $username.$name.$phone.$password;
if($user->doesPhoneExcist($phone))
{
	$signupstatus='two';
}
else
{
			if($verification->isCodeForNewPhoneCorrect($phone,$code))
			{
				$user->updatePhoneNumber($phone,$user_id);
				$verification->numberWasVerifiedAndChanged($phone);
				$signupstatus='one';
			}
			else
			{
				$signupstatus='three';
			}
		
}
		$output =array(
			'status'=>$signupstatus,
			/*'user_id' => strval($user_id),
			'rank' => strval($array['rank']),
										'best_score' => strval($array['best_score']),
										'time_passed' => strval($array['time_passed']),
										'username' => strval($array['username']),
										'email' => strval($array['email']),
										'device' => strval($array['device']),
										'picture' => strval($array['picture']),
										'private' =>strval($array['private']),
										'push_notification' => strval($array['push_notification']),
										'best_game_played_date' => strval($array['best_game_played_date']),
										'allScore' => strval($array['allScore']),
										'allTime' => strval($array['allTime']),
										'totalGames' => strval($array['totalGames']),
										'wins' => strval($array['wins']),
										'lost' => strval($array['lost']),
										'phone_number' =>  strval($array['phone_number']),
										'kdr' => strval($array['kdr']),
										'total_multiplayer' => strval($array['total_multiplayer']),*/
		);

	echo json_encode($output);
?> 