<?php

require __DIR__ . '/vendor/autoload.php';

include 'convert.php';


putenv('GOOGLE_APPLICATION_CREDENTIALS=service-account.json');

use Google\Cloud\Storage\StorageClient;


$target_dir = "video/";

$target_file = $target_dir . basename($_FILES["file"]["name"]);

$rawName = basename($_FILES["file"]["name"],".flac");

$newName = $rawName.'.txt';

$allowed = array('flac');

$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

if(in_array($fileType, $allowed) && !file_exists($target_file)) {

    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

    $storage = new StorageClient();

	$bucket = $storage->bucket('anwar-ibrahim');

	// Upload a file to the bucket.
	$bucket->upload(
	    fopen($target_file , 'r')
	);

    $status = 'success';

} else {

    $status = 'fail';

}


if($status=='success'){


    $url = transcribe_async_gcs('gs://anwar-ibrahim/'.basename($_FILES["file"]["name"]).'',$newName);

    $hostname = getenv('HTTP_HOST').'/gcp_speechtotext/'.'text/'.$url;

    echo $hostname;
}

else{

    echo $status;

}

?>