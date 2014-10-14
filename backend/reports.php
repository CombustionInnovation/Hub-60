<?
	class report{
		function addReport($reporter,$comment_id,$reported)
		{
			//echo $reporter.' '.$comment_id.' '.$reported;
			include ('account.php');
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO reports(comment_id,reporter,created) 
				VALUES ('$comment_id','$reporter','$curDate')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
		}
		
		
		function doesReportExist($reporter,$comment_id)
		{
			//echo $reporter.' |'.$comment_id.' |';
			include('account.php');
			$q="SELECT * from reports WHERE reporter='$reporter' AND comment_id='$comment_id'";
			$r = @mysqli_query($link, $q);
			$ttl=mysqli_num_rows($r);
			//echo '|'.$ttl.'|';
			if($ttl>0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function updateReport($reporter,$comment_id,$reported)
		{
			//echo $reporter.' '.$comment_id.' '.$reported.' updated';
			include("account.php");
			$q = "DELETE FROM reports WHERE reporter = '$reporter' AND comment_id='$comment_id'";
			$r = @mysqli_query($link, $q);	
		}
		
	}

?>