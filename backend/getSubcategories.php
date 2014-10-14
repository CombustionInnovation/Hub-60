<?
	header('Content-Type: application/json');
	require("subcategory.php");//require the score php to make a score object
	$subcategory = new subcategory;
	$category_id = $_REQUEST['category_id'];
	$status='two';
	if(isset($category_id))
	{
		$category_id=$category_id+1;
		$output=$subcategory->getSubcategory($category_id);
	}
	else
	{
		$output =array(
				'status'=>$status,
			);
	}

	echo json_encode($output);
?>