<?php
require 'vendor/autoload.php';
include "classes.php";

use Aws\S3\S3Client;

$conexao = new Acoes();

extract($_GET);
extract($_POST);

$db = new Db();
$credentials = $db->getCredentials();

$s3 = new S3Client([
    'version' => 'latest',
    'region' => 'sa-east-1',
    "credentials" => $credentials
]);

$actions = new Actions("bucket-brunorm");

if (!isset($action)) {
    echo "Ação não definida";
    die();
}

if ($action == "upload") {
    $actions->put($s3);
} elseif ($action == "list") {
    $actions->listObjects($s3);
} elseif ($action == "download") {
    $actions->downloadObject($s3, $file_name);
} elseif ($action == "delete") {
    $actions->deleteObject($s3, $file_name);
} elseif ($action == "get") {
    echo $actions->getObject($s3, $file_name);
} elseif ($action == "sendTelegram") {
    $actions->sendTelegram($s3, $file_name);
} elseif ($action == "createDocument") {
    echo (new Chamada($conexao))->createDocument();
} elseif ($action == "createSigner") {
    echo (new Chamada($conexao))->createSigner();
} elseif ($action == "listDocuments") {
    echo (new Chamada($conexao))->listDocuments();
} elseif ($action == "listSigners") {
    echo (new Chamada($conexao))->listSigners();
} elseif ($action == "sendDocumentSigner") {
    echo (new Chamada($conexao))->addDocumentSigner();
} elseif ($action == "notifyByEmail") {
    echo (new Chamada($conexao))->notifyByEmail();
} elseif ($action == "notifyByWhatsApp") {
    echo (new Chamada($conexao))->notifyByWhatsApp();
} elseif ($action == "listSignedDocuments") {
    $actions->listSignedDocuments($s3);
} elseif ($action == "downloadSignedDocument") {
    $actions->downloadSignedDocument();
} elseif ($action == "createSigners") {
    echo (new Db())->createSigners();
} elseif ($action == "retrieveSigners") {
    echo (new Db())->retrieveSigners();
}


?>