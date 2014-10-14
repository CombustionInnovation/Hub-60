<?
	class chat{
		function addChatComment($user_id,$category_id,$subcategory_id,$comment,$picture,$thumbnail,$video,$type)
		{
			include("account.php");	
			$charset = "UTF-8";
			mysqli_set_charset ($link, $charset);
			$str =  mysqli_real_escape_string ($link ,$comment);//this chunck of code takes care of any apostrophy issues encountered before
			 $str = @trim($str);
			 if(get_magic_quotes_gpc()) 
				{
					$str = stripslashes($str);
				}	
			$hashtag=$this->getHashtags($str);
			$tag=$this->getTags($str);
			$curDate = date('Y-m-d H:i:s', time());//current date stamp is added to comments
			$q = "INSERT INTO chat(user_id,category_id,subcategory_id,comment,created,hashtag,tag,picture,thumbnail,video,type)VALUES('$user_id','$category_id','$subcategory_id','$str','$curDate',LOWER('$hashtag'),LOWER('$tag'),'$picture','$thumbnail','$video','$type')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
			//echo $q;
		}
		
		function getHashtags($text)
		{
					  //Match the hashtags
					  preg_match_all('/(^|[^a-z0-9_])#([a-z0-9_]+)/i', $text, $matchedHashtags);
					  $hashtag = '';
					  // For each hashtag, strip all characters but alpha numeric
					  if(!empty($matchedHashtags[0])) {
						  foreach($matchedHashtags[0] as $match) {
							  $hashtag .= preg_replace("/[^a-z0-9]+/i", "", $match).',';
						  }
					  }
					  
						//to remove last comma in a string
					return rtrim($hashtag, ',');
					
		}
		
		function getTags($text)
		{
			//Match the hashtags
					  preg_match_all('/(^|[^a-z0-9_])@([a-z0-9_]+)/i', $text, $matchedHashtags);
					  $hashtag = '';
					  // For each hashtag, strip all characters but alpha numeric
					  if(!empty($matchedHashtags[0])) {
						  foreach($matchedHashtags[0] as $match) {
							  $hashtag .= preg_replace("/[^a-z0-9]+/i", "", $match).',';
						  }
					  }
					  
						//to remove last comma in a string
					return rtrim($hashtag, ',');
		}
		
		function getChat($last,$subcategory_id,$category_id)
		{
				include("account.php");
				$q = "SELECT * FROM chat WHERE subcategory_id = '$subcategory_id' AND category_id='$category_id' ORDER BY created DESC LIMIT $last,25";
				$r = @mysqli_query($link, $q);
				while($row =mysqli_fetch_array($r)) {
						$results []=array(
							'comment_id'=>$row['comment_id'],
							'user_id'=>$row['user_id'],
							'comment'=>$row['comment'],
							'category_id'=>$row['category_id'],
							'picture'=>$row['picture'],
							'thumbnail'=>$row['thumbnail'],
							'video'=>$row['video'],
							'type'=>$row['type'],
						);
					}
					mysqli_close($link);
					echo $q;
					return $results;
				
		}
	}

?>