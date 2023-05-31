<?php

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Credentials\Credentials;

$json = file_get_contents('php://input');
$jsonObj = json_decode($json);

$urlAssinada = null;

while (!$urlAssinada) {
    if (property_exists($jsonObj->document->downloads, 'signed_file_url')) {
        $signedFileUrl = $jsonObj->document->downloads->signed_file_url;

        $fileName = $jsonObj->document->filename;

        $tempFilePath = "./$fileName";
        file_put_contents($tempFilePath, file_get_contents($signedFileUrl));

        require 'vendor/autoload.php';
        include "classes.php";

        $db = new Db();
        $credentials = $db->getCredentials();

        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'sa-east-1',
            "credentials" => $credentials
        ]);

        $file_name = "treinamento-teste/signed-documents/" . $fileName;
        $path = $tempFilePath;
        $bucket = "bucket-brunorm";

        try {
            $s3->putObject([
                'Bucket' => $bucket,
                'Key' => $file_name,
                'SourceFile' => $path
            ]);
            echo "Uploaded $file_name to $bucket.\n";
        } catch (Exception $exception) {
            echo "Failed to upload $file_name with error: " . $exception->getMessage();
            exit("Please fix error with file upload before continuing.");
        }

        unlink($tempFilePath);
    } else {
        sleep(20);
    }
}
?>