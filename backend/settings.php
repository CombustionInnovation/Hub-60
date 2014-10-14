<?
	header('Content-Type: application/json');
	require("setting.php");//require the score php to make a score object
	$setting = new setting;
	$user_id = $_REQUEST['user_id'];//gather date from user
	$private = $_REQUEST['private'];
	$push_notification = $_REQUEST['push_notification'];
	//$new=false;
	if(isset($user_id))
	{
		if(!$setting->doesUserHaveSettings($user_id))
		{
			$setting->newSetting($user_id);
			//$new=true;
		}
		$results=$setting->getSetting($user_id);
		if(!isset($private))
		{
			$private=$results['private'];
		}
		
		if(!isset($push_notification))
		{
			$push_notification=$results['push_notification'];
		}
	}
	$setting->updateSetting($user_id,$private,$push_notification);
?>