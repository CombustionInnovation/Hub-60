<?
	class category{
		function createCategory($category){
			include('account.php');
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO category(category,created) 
				VALUES ('$category','$curDate')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
		}
		
		function getCategoryIdByName($category){
			include("account.php");
				$q = "SELECT * FROM category WHERE category = '$category'";
				$r = @mysqli_query($link, $q);
				$row = 	mysqli_fetch_array($r);
				if(mysqli_num_rows($r) > 0){
					return $row['category_id'];
				}
				else {
					return false;
				}
				mysqli_close($link);
		}
		
		function getCategories(){
			include("account.php");
				$q = "SELECT * FROM category";
				$r = @mysqli_query($link, $q);
				while($row = 	mysqli_fetch_array($r)) {
					$results=array(
						'category_id'=>$row['category_id'],
						'category'=>$row['category'],
						'subcategories'=>$row['sub_categories'],
					);
				}
		}
		
		function numberWasVerified($category_id)
		{
			include("account.php");	
			$q = "DELETE FROM category WHERE category_id='$category_id'";
			$r = @mysqli_query($link, $q);	
		}
		
		
	}
?>