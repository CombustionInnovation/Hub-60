<?
	header('Content-Type: application/json');
	require("categories.php");//require the score php to make a score object
	$category = new category;
	$category_name = $_REQUEST['category'];//gather date from user
	if(isset($category_name))
	{
		$category->createCategory($category_name);
			$status='one';
	}else{$status='two';}
	$output =array(
			'status'=>$status,
		);
	echo json_encode($output);
?>