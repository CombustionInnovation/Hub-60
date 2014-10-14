<?
	class api{
		public $key='ve2ebfe3gzt9akcwzr5g26xf';
		function updateHub()
		{
			//$this->emptyTables();
			$this->addMovies();
			$this->addSportEvents();
		}
		
		function getMoviesToday()
		{
			$curDate = date('Y-m-d', time());
			$data=file_get_contents('http://data.tmsapi.com/v1/movies/showings?startDate='.$curDate.'&zip=07055&api_key=ve2ebfe3gzt9akcwzr5g26xf');
			return $data;
		}
		
		function addMovies()
		{
			$movies=$this->getMoviesToday();
			$f = json_decode($movies,true);
			$size=sizeof($f);
			for($i=0;$i<$size;$i++)
			{
				//echo $i.'|';
				if(!$this->doesTmsIdExistMovies($f[$i]['tmsId']))
					{
						$image='http://developer.tmsimg.com'.$f[$i]['preferredImage']['uri'].'?api_key=ve2ebfe3gzt9akcwzr5g26xf';
						if(!$f[$i]['genres']==''){$genres=implode(",",$f[$i]['genres']);}
						if(!$f[$i]['topCast']==''){$cast=implode(",",$f[$i]['topCast']);}
						$this->addAMovie($f[$i]['title'],$f[$i]['tmsId'],$f[$i]['shortDescription'],$f[$i]['longDescription'],$image,$genres,$cast,$f[$i]['releaseYear'],$f[$i]['releaseDate'],$f[$i]['runTime'],$f[$i]['rootId']);
			
					}
			}
		}
		
		function addAMovie($title,$api_id,$short,$long,$picture,$genres,$top_cast,$release_year,$release_date,$run_time,$root_id)
		{
			//echo $api_id.$short.$long.$picture.$genres.$top_cast.$release_year.$run_time.$root_id.'</br>';
			include('account.php');
			$charset = "UTF-8";
			mysqli_set_charset ($link, $charset);
			$shortstr =  mysqli_real_escape_string ($link ,$short);//this chunck of code takes care of any apostrophy issues encountered before
			$shortstr = @trim($shortstr);
			if(get_magic_quotes_gpc()) 
				{
					$shortstr = stripslashes($shortstr);
				}
			$longstr =  mysqli_real_escape_string ($link ,$long);//this chunck of code takes care of any apostrophy issues encountered before
			$longstr = @trim($longstr);
			if(get_magic_quotes_gpc()) 
				{
					$longstr = stripslashes($longstr);
				}
			$cast =  mysqli_real_escape_string ($link ,$top_cast);//this chunck of code takes care of any apostrophy issues encountered before
			$cast = @trim($cast);
			if(get_magic_quotes_gpc()) 
				{
					$cast = stripslashes($cast);
				}
				
			$strtitle =  mysqli_real_escape_string ($link ,$title);//this chunck of code takes care of any apostrophy issues encountered before
			$strtitle = @trim($strtitle);
			if(get_magic_quotes_gpc()) 
				{
					$strtitle = stripslashes($strtitle);
				}
			$q = "INSERT INTO movies (title,category,api_id,short,longD,picture,genres,top_cast,release_year,release_date,run_time,root_id) 
				VALUES ('$strtitle','3','$api_id','$shortstr','$longstr','$picture','$genres','$cast','$release_year','$release_date','$run_time','$root_id')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
			echo $q.' ---- ';
		}
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//Sports
		
		function getSports()
		{
			$curDate = date('Y-m-d', time());
			$data=file_get_contents('http://data.tmsapi.com/v1/sports/58,59/events/airings?lineupId=USA-TX42500-X&startDateTime='.$curDate.'&api_key=ve2ebfe3gzt9akcwzr5g26xf');
			return $data;
		}
		
		function addSportEvents()
		{
			$movies=$this->getSports();
			$f = json_decode($movies,true);
			$size=sizeof($f);
			for($i=0;$i<$size;$i++)
			{
				if($f[$i]['program']['titleLang']=='en')
				{
					//echo $i.'|';
				
					if(!$this->doesTmsIdExistSport($f[$i]['program']['tmsId']))
					{
						$image='http://developer.tmsimg.com'.$f[$i]['program']['preferredImage']['uri'].'?api_key=ve2ebfe3gzt9akcwzr5g26xf';
						$qualifiers=implode(",",$f[$i]['qualifiers']);
						$channels=implode(",",$f[$i]['channels']);
						$genres=implode(",",$f[$i]['program']['genres']);
						$team1['name']=$f[$i]['program']['teams'][0]['name'];
						$team1['id']=$f[$i]['program']['teams'][0]['teamBrandId'];
						$team2['name']=$f[$i]['program']['teams'][1]['name'];
						$team2['id']=$f[$i]['program']['teams'][1]['teamBrandId'];
						$category_id=$this->getCategoryIdForEvent($f[$i]['program']['genres'][0]);
						if($f[$i]['program']['teams'][0]['isHome']=='true'){$home=1;}else if($f[$i]['program']['teams'][1]['isHome']=='true'){$home=2;}
						$this->addAnEvent($category_id,$f[$i]['startTime'],$f[$i]['endTime'],$qualifiers,$channels,$image,$f[$i]['program']['tmsId'],$f[$i]['program']['rootId'],$f[$i]['program']['seriesId'],$f[$i]['program']['title'],$f[$i]['program']['eventTitle'],$$f[$i]['program']['subType'],$team1['name'],$team1['id'],$team2['name'],$team2['id'],$home,$f[$i]['program']['shortDescription'],$f[$i]['program']['longDescription'],$genres);
					}
				}
			}
			
		}
		
		function doesTmsIdExistSport($id)
		{
			
			include ('account.php');
			$q = "SELECT * FROM sports WHERE tms_id='$id'";
			$r = @mysqli_query($link, $q);
			//echo $signIn.' '.$password;
			//echo mysqli_num_rows($r);
			//echo $q;
			if(mysqli_num_rows($r) == 1) {
				return true;
			}
			else
			{
				return false;
			}
		
		}
		
		function doesTmsIdExistMovies($id)
		{
			
			include ('account.php');
			$q = "SELECT * FROM movies WHERE api_id='$id'";
			$r = @mysqli_query($link, $q);
			//echo $signIn.' '.$password;
			//echo mysqli_num_rows($r);
			//echo $q;
			if(mysqli_num_rows($r) == 1) {
				return true;
			}
			else
			{
				return false;
			}
		
		}
		
		function addAnEvent($category_id,$start_time,$end_time,$qualifiers,$channels,$event_image,$tms_id,$root_id,$series_id,$title,$long_title,$subType,$team1,$team1_id,$team2,$team2_id,$home,$shortD,$LongD,$genres)
		{
			//echo $api_id.$short.$long.$picture.$genres.$top_cast.$release_year.$run_time.$root_id.'</br>';
			include('account.php');
			$charset = "UTF-8";
			mysqli_set_charset ($link, $charset);
			$shortstr =  mysqli_real_escape_string ($link ,$shortD);//this chunck of code takes care of any apostrophy issues encountered before
			$shortstr = @trim($shortstr);
			if(get_magic_quotes_gpc()) 
				{
					$shortstr = stripslashes($shortstr);
				}
			$longstr =  mysqli_real_escape_string ($link ,$LongD);//this chunck of code takes care of any apostrophy issues encountered before
			$longstr = @trim($longstr);
			if(get_magic_quotes_gpc()) 
				{
					$longstr = stripslashes($longstr);
				}
			$q = "INSERT INTO sports (category_id,start_time,end_time,qualifiers,channels,event_image,tms_id,root_id,series_id,title,long_title,subType,team1,team1_id,team2,team2_id,home,shortD,LongD,genres) 
				VALUES ('$category_id','$start_time','$end_time','$qualifiers','$channels','$event_image','$tms_id','$root_id','$series_id','$title','$long_title','$subType','$team1','$team1_id','$team2','$team2_id','$home','$shortstr','$longstr','$genres')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
			//echo $q.' ---- ';
		}
		
		function getCategoryIdForEvent($genres)
		{
			include("account.php");
				$q = "SELECT * FROM category WHERE category LIKE '%$genres%'";
				$r = @mysqli_query($link, $q);
				$row = 	mysqli_fetch_array($r);
				if(mysqli_num_rows($r) > 0){
					return $row['category_id'];
				}
				else {
					return '0';
				}
				mysqli_close($link);

		}
		
		
		//////////////////////////////////////////////////////////
		//search for results of subcategories
		
		function findResultsFor($keyword)
		{
			$results['sports']=$this->searchInSPortEvents($keyword);
			$results['movies']=$this->searchinMovies($keyword);
			return $results;
		}
		
		function searchinMovies($keyword)
		{
			include("account.php");
				$q = "SELECT * FROM movies WHERE title LIKE '%$keyword%' OR genres LIKE '%$keyword%' OR top_cast LIKE '%$keyword%' ";
				$r = @mysqli_query($link, $q);
				while($row = 	mysqli_fetch_array($r)) {
					$results=array(
						'movie_id'=>$row['movie_id'],
						'category'=>$row['category'],
						'short_description'=>$row['short'],
						'long_description'=>$row['longD'],
						'picture'=>$row['picture'],
						'genres'=>$row['genres'],
						'top_cast'=>$row['top_cast'],
						'release_date'=>$row['release_date'],
					);
				}
				mysqli_close($link);
				return $results;
		}
		
		function searchInSPortEvents($keyword)
		{
				include("account.php");
				$q = "SELECT * FROM sports WHERE title LIKE '%$keyword%' OR genres LIKE '%$keyword%' OR team1 LIKE '%$keyword%' OR team2 LIKE '%$keyword%'  OR qualifiers LIKE '%$keyword%' ";
				$r = @mysqli_query($link, $q);
				while($row = mysqli_fetch_array($r)) {
					$results=array(
						'event_id'=>$row['event_id'],
						'start_time'=>$row['start_time'],
						'end_time'=>$row['end_time'],
						'qualifiers'=>$row['qualifiers'],
						'channels'=>$row['channels'],
						'event_image'=>$row['event_image'],
						'team1'=>$row['team1'],
						'team2'=>$row['team2'],
						'genres'=>$row['genres'],
						'short_description'=>$row['shortD'],
						'long_description'=>$row['longD'],
					);
				}
				//echo $q;
				mysqli_close($link);
				return $results;
		}
		
		function emptyTables()
		{
			$this->emptyMovies();
			$this->emptySports();
		}
	}
?>