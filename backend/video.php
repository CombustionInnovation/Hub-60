<?php

	

	class videos {
		
		
		public $folder = "/home/dan/public_html/hub/videos/";
		
		
		
		function uploadVideo($user_id) {
			
			
			$folder = "/home/dan/public_html/hub/videos/";
	
			if (is_uploaded_file($_FILES['filename']['tmp_name'].$user_id)){
				 if (move_uploaded_file($_FILES['filename']['tmp_name'].$user_id, $folder.$_FILES ['filename'] ['name'].$user_id)) 
				 {
						$file = "http://combustionlaboratory.com/hub/videos/".$_FILES ['filename'] ['name'].$user_id;
						$thumb = 	$this -> thumbnail($file);
					$output=array(
						'video'=>$file,
						'thumbnail'=>$thumb,
					);
					
					//echo $file.$thumb;
				}
			}
			return $output;
		}
		
		function thumbnail($video){


			$frame = 4;
			$movie = $video;

			$milliseconds = round(microtime(true) * 10);
			$thumbnail = '../thumbnails/'.$milliseconds.'.png';

				$mov = new ffmpeg_movie($movie);
			
				$frame = $mov->getFrame($frame);
				
					if ($frame) {
						$gd_image = $frame->toGDImage();
					
						if ($gd_image) {
							$size = [imagesx($gd_image),imagesy($gd_image)];
							if($size[0]< $size[1] || $size[0] > $size[1])
							{
								$rotate = imagerotate($gd_image, -90, 0);
								imagepng($rotate, $thumbnail);
								imagedestroy($gd_image);
								imagedestroy($rotate);
							}
							else
							{
								imagepng($gd_image, $thumbnail);
								imagedestroy($gd_image);
							}
							
							$path = "http://combustionlaboratory.com/hub/thumbnail/".$milliseconds.'.png';
							return $path;
						}
					} 
			}
		
		
		
		
	}




?>