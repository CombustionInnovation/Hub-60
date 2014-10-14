<?
	class setting{
		function newSetting($user_id){
		include ('account.php');
		$curDate = date('Y-m-d H:i:s', time());
		$q = "INSERT INTO settings(user_id) 
			VALUES ('$user_id')";
		$r = @mysqli_query($link, $q);
		//echo 'asd';
		mysqli_close($link);
		}
		
		function doesUserHaveSettings($user_id){
			
				include("account.php");//we chek if it already excist in the datetabes
				
				$q = "SELECT * FROM settings WHERE user_id = '$user_id'";
				$r = @mysqli_query($link, $q);
				if(mysqli_num_rows($r) > 0){//if teh response is more than zero we return zero
					return true;
				}
				else {
					return false;
				}
				mysqli_close($link);
		}
		
		function updateSetting($user_id,$private,$push_notification){
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE settings SET push_notification='$push_notification',private = '$private' WHERE user_id = '$user_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}
		
		/*function updateNotification($user_id,$notification){
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			//removed picture = 'picture' because I added click icon to change user picture. 
			$stmt = $link->prepare("UPDATE settings SET push_notification = '$notification' WHERE user_id = '$user_id'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}*/
		
		function getSetting($user_id)
		{
			include("account.php");//we chek if it already excist in the datetabes
				
				$q = "SELECT * FROM settings WHERE user_id = '$user_id'";
				$r = @mysqli_query($link, $q);
				$results['bol']=false;
				while($row =mysqli_fetch_array($r)) {
						$results []=array(
							'private'=>$row['private'],
							'push_notification'=>$row['push_notification'],
							'bol'=>true,
						);
					}
					return $results;
				mysqli_close($link);
		}
	
	}
	
}
/* 	This is the SQL script for the settings table
		CREATE TABLE IF NOT EXISTS `settings` (
	  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
	  `user_id` int(11) NOT NULL,
	  `private` int(1) NOT NULL,
	  `push_notification` int(1) NOT NULL,
	  PRIMARY KEY (`setting_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;*/

?>