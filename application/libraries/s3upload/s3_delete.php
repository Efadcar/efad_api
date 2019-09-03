<?php
// Bucket Name
$ci=& get_instance();
$bucket=$ci->config->item('s3_bucket');

$file = APPPATH . 'libraries/s3upload/S3.php';
require_once($file);
			
//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', $ci->config->item('awsAccessKey'));
if (!defined('awsSecretKey')) define('awsSecretKey', $ci->config->item('awsSecretKey'));

//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);

?>