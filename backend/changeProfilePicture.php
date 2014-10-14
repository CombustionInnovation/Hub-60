<?
header('Content-Type: application/json');
include("user.php");
	$user = new user;
	$user_id = $_REQUEST['user_id'];
	$folder = "/home/dan/public_html/hub/pictures/";
	if(isset($user_id))
	{
		if (is_uploaded_file($_FILES['filename']['tmp_name'])){
			if (move_uploaded_file($_FILES['filename']['tmp_name'], $folder.$_FILES ['filename'] ['name'])) {
				$fleName="http://combustionlaboratory.com/hub/pictures/".$_FILES ['filename'] ['name'];
				$user ->changeProfilePicture($fleName,$user_id);	
					$status='one';
			} else 
			{
				$status='three';
			}
		} else 
		{
			$status='three';
		}
	}
	else
	{
		$status='two';
	}


    $output=array(
							'url' =>  $fleName,
							'status' => $status,
							'folder' => $folder,
							
							
						);

	echo json_encode($output);
	
	
	
	

	
?>