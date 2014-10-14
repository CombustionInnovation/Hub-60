<?
	class subcategory{
		function createCategory($subcategory){
			include('account.php');
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO subcategory(subcategory,created) 
				VALUES ('$subcategory','$curDate')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
		}
		
		function getCategoryIdByName($subcategory){
			include("account.php");
				$q = "SELECT * FROM subcategory WHERE subcategory = '$subcategory'";
				$r = @mysqli_query($link, $q);
				$row = 	mysqli_fetch_array($r);
				if(mysqli_num_rows($r) > 0){
					return $row['subcategory_id'];
				}
				else {
					return false;
				}
				mysqli_close($link);
		}
		
		function getCategories($category_id){
			include("account.php");
				$q = "SELECT * FROM subcategory WHERE category_id='$category_id'";
				$r = @mysqli_query($link, $q);
				while($row = 	mysqli_fetch_array($r)) {
					$results=array(
						'subcategory_id'=>$row['subcategory_id'],
						'category_id'=>$row['category_id'],
						'subcategory'=>$row['subcategory'],
					);
				}
		}
		
		function numberWasVerified($subcategory_id)
		{
			include("account.php");	
			$q = "DELETE FROM subcategory WHERE subcategory_id='$subcategory_id'";
			$r = @mysqli_query($link, $q);	
		}
		
		function getMovies()
		{
				include("account.php");
				$q = "SELECT * FROM movies ORDER BY movies.release_date DESC ";
				$r = @mysqli_query($link, $q);
				while($row = 	mysqli_fetch_array($r)) {
					$results['results'][]=array(
						'subcategory_id'=>$row['movie_id'],
						'subcategory'=>$row['title'],
						'short_description'=>$row['short'],
						'long_description'=>$row['longD'],
						'picture'=>$row['picture'],
						'genres'=>$row['genres'],
						'top_cast'=>$row['top_cast'],
						'release_date'=>$row['release_date'],
						'category_id'=>$row['category_id'],
					);
				}
				return $results;
		}
		
		function getSports($category_id)
		{
				include("account.php");
				$q = "SELECT * FROM sports WHERE category_id='$category_id' ORDER BY sports.start_time ASC";
				$r = @mysqli_query($link, $q);
				while($row = 	mysqli_fetch_array($r)) {
					$results['results'][]=array(
						'subcategory_id'=>$row['event_id'],
						'start_time'=>$row['start_time'],
						'end_time'=>$row['end_time'],
						'short_description'=>$row['shortD'],
						'long_description'=>$row['longD'],
						'picture'=>$row['event_image'],
						'title'=>$row['title'],
						'subcategory'=>$row['long_title'],
						'team1'=>$row['team1'],
						'team2'=>$row['team2'],
						'genres'=>$row['genres'],
						'category_id'=>$row['category_id'],
					);
				}
				return $results;
		}
		
		function getSubcategory($category_id)
		{
			$table=$this->whatTable($category_id);
			//echo $table;
			if($table=='sports')
			{
				$results=$this->getSports($category_id);
			}
			else if($table=='movies')
			{
				$results=$this->getMovies();
			}
			else if($table=='subcategory')
			{
				$results=$this->getSubcategoryTable($category_id);
			}
			return $results;
		}
		
		function getSubcategoryTable($category_id)
		{
			include("account.php");
				$q = "SELECT * FROM subcategory WHERE category_id='$category_id' ORDER BY sports.created DESC";
				$r = @mysqli_query($link, $q);
				while($row = 	mysqli_fetch_array($r)) {
					$results['results'][]=array(
						'category_id'=>$row['category_id'],
						'subcategory'=>$row['subcategory'],
						'created'=>$row['created'],
					);
				}
				return $results;
		}
		
		function whatTable($category_id)
		{
			$category[1]='subcategory';
			$category[2]='subcategory';
			$category[3]='movies';
			$category[4]='subcategory';
			$category[5]='subcategory';
			$category[6]='subcategory';
			$category[7]='subcategory';
			$category[8]='sports';
			$category[9]='sports';
			$category[10]='sports';
			$category[11]='sports';
			$category[12]='sports';
			$category[13]='sports';
			$category[14]='sports';
			$category[15]='sports';
			$category[16]='sports';
			$category[17]='subcategory';
			$category[18]='subcategory';
			$category[19]='subcategory';
			
			return $category[$category_id];
		}
		
		
	}
?>