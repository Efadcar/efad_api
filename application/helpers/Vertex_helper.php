<?php


if(!function_exists('uploadImageOnBucket'))
{
	function uploadImageOnBucket($image_name,$tmp)
	{
		$image="";
		include(APPPATH . 'libraries/s3upload/s3_config.php');

		if($s3->putObjectFile($tmp, $bucket , $image_name, \S3::ACL_PUBLIC_READ) )
		{
			$image = 'http://'.$bucket.'.s3.amazonaws.com/'.$image_name;
		}
		return $image;   
	}
}

	

