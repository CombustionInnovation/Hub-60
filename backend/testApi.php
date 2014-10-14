<?
	header('Content-Type: application/json');
	require("api.php");
	$api = new api;
	$keyword=$_REQUEST['keyword'];
	//$results=$api->findResultsFor($keyword);
	$results=$api->updateHub();
	echo json_encode($results);
?>