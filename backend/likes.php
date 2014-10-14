<?
	class like{
		function addLike($user_id,$comment_id,$score)
		{
			include ('account.php');
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO ranking(comment_id,score,user_id,created) 
				VALUES ('$comment_id','$score','$user_id','$curDate')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
		}
		
		
		function doesRankingExist($user_id,$comment_id)
		{
			include('account.php');
			$q="SELECT * from ranking WHERE user_id='$user_id' AND comment_id='$comment_id'";
			$r = @mysqli_query($link, $q);
			$ttl=mysqli_num_rows($r);
			if($ttl>0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function updatelike($user_id,$comment_id,$score)
		{
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			$stmt = $link->prepare("UPDATE ranking SET score='$score' WHERE user_id = '$user_id' AND comment_id='$comment_id'");
			$stmt->execute(); 
			$stmt->close();
		}
		
	}

?>