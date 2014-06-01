<?php 

require 'vendor/autoload.php';

// Variables

$key = "";
$secret = "";
$bucket = "";
$cfEndPoint = "";


// Instanciate the S3 SDK
use Aws\S3\S3Client;

// Instantiate the S3 client with your AWS credentials
$s3Client = S3Client::factory(array(
    'key'    => $key,
    'secret' => $secret
));

// Parse standard IN for path to file
if(!file_exists($argv[1])) {
	throw new \Exception("File doesn't exist");
}

$file = realpath($argv[1]);

$key = $argv[2];

if(empty($key)) {
	throw new \Exception("No Keyname Provided");
}

// Use Put Object to get the file onto S3
$result = $s3Client->putObject(array(
    'Bucket'     => $bucket,
    'Key'        => $key,
    'SourceFile' => $file
));

// Output the cloud front URL to the command line 

var_dump($result);

echo $cfEndPoint . $key;