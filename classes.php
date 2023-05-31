<?php

class Conexao
{
    const link = "https://sandbox.clicksign.com/api/";
    const versao = "v1";
    const token = "9b4dcf83-974b-40ae-8776-88c286791724";

}

class Acoes
{

    public function ConexaoHttpPost($variavel_sys, $parametros)
    {
        $url = sprintf('%s%s/%s?access_token=%s', Conexao::link, Conexao::versao, $variavel_sys, Conexao::token);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parametros));
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Authorization: ' . Conexao::token,
                'Content-Type: application/json',
            )
        );
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception('Erro na conexão: ' . $error);
        }
        return $response;
    }

    public function ConexaoHttpGet($variavel_sys)
    {
        $url = sprintf('%s%s/%saccess_token=%s', Conexao::link, Conexao::versao, $variavel_sys, Conexao::token);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Authorization: ' . Conexao::token,
                'Content-Type: application/json',
            )
        );
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception('Erro na conexão: ' . $error);
        }
        return $response;
    }
}

class Chamada
{
    private Acoes $conexao;

    public function __construct(Acoes $conexao)
    {
        $this->conexao = $conexao;
    }

    public function createDocument()
    {

        $file = $_FILES["file"];
        $objeto = $file["tmp_name"];
        $nome = $file["name"];
        $nextMonth = date(DATE_ATOM, strtotime('+1 month'));

        $documentoBase64 = base64_encode(file_get_contents($objeto));

        $body = [
            "document" => [
                "path" => "/$nome",
                "content_base64" => "data:application/pdf;base64,$documentoBase64",
                'deadline_at' => "$nextMonth",
                'auto_close' => true,
                'locale' => 'pt-BR',
            ]
        ];
        return $this->conexao->ConexaoHttpPost("documents", $body);

    }

    public function createSigner()
    {

        extract($_POST);

        $body = [
            "signer" => [
                "email" => "$email",
                "phone_number" => "$phone",
                "auths" => [
                    $auth
                ],
                "name" => "$name",
                "documentation" => "$cpf",
                "birthday" => "$birthday",
                "has_documentation" => true
            ]
        ];

        // não mostra o erro
        echo (new Db())->createSigner();

        return $this->conexao->ConexaoHttpPost("signers", $body);


    }

    public function listDocuments()
    {
        $page = 1;
        $jsonResponse = $this->conexao->ConexaoHttpGet("documents?page=$page&");
        $jsonObj = json_decode($jsonResponse);
        $documents = $jsonObj->documents;
        while ($jsonObj->page_infos->next_page != null) {
            $page++;
            $jsonResponse = $this->conexao->ConexaoHttpGet("documents?page=$page&");
            $jsonObj = json_decode($jsonResponse);
            array_push($documents, ...$jsonObj->documents);
        }
        $documents = [
            "documents" => $documents
        ];
        return json_encode($documents);
    }

    public function listSigners()
    {
        return $this->conexao->ConexaoHttpGet("signers?");
    }

    public function addDocumentSigner()
    {
        extract($_POST);

        $body = [
            "list" => [
                "document_key" => "$document_key",
                "signer_key" => "$signer_key",
                "sign_as" => "sign",
                "refusable" => true,
            ]
        ];

        return $this->conexao->ConexaoHttpPost("lists", $body);
    }

    public function notifyByEmail()
    {
        extract($_POST);

        $body = [
            "request_signature_key" => $request_signature_key,
            "message" => "Por favor assine este documento"
        ];

        return $this->conexao->ConexaoHttpPost("notifications", $body);
    }

    public function notifyByWhatsApp()
    {
        extract($_POST);

        $body = [
            "request_signature_key" => $request_signature_key
        ];

        return $this->conexao->ConexaoHttpPost("notify_by_whatsapp", $body);
    }
}

class Db
{

    public function conn()
    {
        $host = "localhost";
        $usuario = "root";
        $senha = "";
        $database = "secret_keys";

        return new PDO("mysql:host=$host;dbname=" . $database, $usuario, $senha);
    }

    public function getCredentials()
    {
        $con = $this->conn();
        $request = $con->prepare("SELECT * FROM bucket_keys");
        $request->execute();

        $keys = $request->fetch(PDO::FETCH_ASSOC);

        $access_key = $keys["access_key"];
        $secret_key = $keys["secret_key"];
        return new Aws\Credentials\Credentials($access_key, $secret_key);
    }

    public function createSigner()
    {
        extract($_POST);
        $con = $this->conn();
        $request = $con->prepare("INSERT INTO signers (auths, birthday, documentation, email, name, phone_number) VALUES ($auths, $birthday, $documentation, $email, $has_documentation, $name, $phone_number)");
        $request->execute();
        // TERMINA ESSA PARTE
    }

    public function createSigners()
    {

        $json = file_get_contents('php://input');
        $jsonObj = json_decode($json, true);

        $con = $this->conn();

        $signersArr = [];

        $fields = "";

        foreach ($jsonObj as $index => $value) {


            $values = array_values($value);
            $keys = array_keys($value);

            $fields = implode(", ", $keys);

            $data = "('" . implode("', '", $values) . "')";

            $verify = false;
            foreach ($value as $key => $val) {
                $verify = false;

                if ($key == "documentation") {
                    $verifyPdf = $con->prepare("SELECT * FROM signers WHERE documentation='$val'");
                    $verifyPdf->execute();
                    $verify = $verifyPdf->rowCount();
                }
                if ($verify) {
                    echo "cpf: $val já está em uso<br>";
                    continue 2;
                }
            }
            array_push($signersArr, $data);
        }

        $signers = implode(", ", $signersArr);

        if ($signers == "") {
            return "Nenhum signatário registrado";
        }

        $response = $con->prepare("INSERT INTO signers ($fields) VALUES $signers;");
        try {
            $response->execute();
            return 'Account created with success';
        } catch (Exception $exception) {
            $error = explode(":", $exception);
            return $error[2] . $error[3];
        }
    }

    public function retrieveSigners()
    {

        $con = $this->conn();
        $sql = "SELECT * FROM signers";

        $response = $con->prepare($sql);
        $response->execute();

        if ($response->rowCount()) {

            $data = [];

            while ($user_data = $response->fetch(PDO::FETCH_ASSOC)) {
                extract($user_data);

                array_push($data, $user_data);
            }

            $result = [
                "data" => $data
            ];

            return json_encode($result);

        }
    }
}

class Actions
{
    public $bucket;

    public function __construct($bucket_name)
    {
        $this->bucket = $bucket_name;
    }

    public function put($s3)
    {
        $file = $_FILES["file"];
        $file_name = "treinamento-teste/" . $file["name"];
        $path = $file["tmp_name"];
        $bucket = $this->bucket;

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
    }

    public function listObjects($s3)
    {
        $bucket = $this->bucket;
        $files = [];
        try {
            $contents = $s3->listObjects([
                'Bucket' => $bucket,
            ]);
            // echo "The contents of your bucket are: \n";
            foreach ($contents['Contents'] as $content) {
                echo $content['Key'] . "*-*";
            }
            // echo json_encode($files);
        } catch (Exception $exception) {
            echo "Failed to list objects in $bucket with error: " . $exception->getMessage();
            exit("Please fix error with listing objects before continuing.");
        }
    }

    public function listSignedDocuments($s3)
    {
        $bucket = $this->bucket;
        $files = [];
        try {
            $contents = $s3->listObjects([
                'Bucket' => $bucket,
                'Prefix' => "treinamento-teste/signed-documents/"
            ]);
            // echo "The contents of your bucket are: \n";
            foreach ($contents['Contents'] as $content) {
                echo $content['Key'] . "*-*";
            }
            // echo json_encode($files);
        } catch (Exception $exception) {
            echo "Failed to list objects in $bucket with error: " . $exception->getMessage();
            exit("Please fix error with listing objects before continuing.");
        }
    }

    public function getObject($s3, $file_name)
    {

        $bucket = $this->bucket;
        $f_name = explode("/", $file_name);
        $f_name = end($f_name);

        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $file_name
        ]);

        $request = $s3->createPresignedRequest($cmd, "+10 minutes");
        $presignedUrl = (string) $request->getUri();

        return $presignedUrl;
    }

    public function downloadObject($s3, $file_name)
    {
        $presignedUrl = $this->getObject($s3, $file_name);

        header("Location: " . $presignedUrl);
    }

    public function deleteObject($s3, $file_name)
    {
        $bucket = $this->bucket;

        try {
            $s3->deleteObject([
                'Bucket' => $bucket,
                'Key' => $file_name,
            ]);
            echo "Object $file_name deleted with success from $bucket.";
        } catch (Exception $exception) {
            echo "Failed to delete $file_name from $bucket with error: " . $exception->getMessage();
            exit("Please fix error with object deletion before continuing.");
        }
    }

    public function downloadSignedDocument()
    {

        extract($_POST);
        extract($_GET);

        ////

        // URL do arquivo PDF
        $pdfUrl = $url;

        // Define o cabeçalho Content-Disposition para fazer o download
        header('Content-Disposition: attachment; filename="' . $file_name . '"');

        // Faz o download do arquivo PDF e o envia para o navegador
        readfile($pdfUrl);
    }

    public function sendTelegram($s3, $file_name)
    {
        $presignedUrl = $this->getObject($s3, $file_name);


        // Define as informações necessárias para a conexão com a API do Telegram
        $token = '6019589357:AAFk4LgjZIOPhbBW6yaCKg3AIQMYOyAbQ80'; // Substitua pela chave do seu bot no Telegram
        $chat_id = '6004597012'; // Substitua pelo ID do seu chat com o bot no Telegram

        // Define a URL da imagem a ser baixada
        $image_url = $presignedUrl;


        // Define a URL para enviar a imagem via API do Telegram
        $url = "https://api.telegram.org/bot$token/sendPhoto";

        // Define os parâmetros da mensagem a ser enviada
        $post_fields = array(
            'chat_id' => $chat_id,
            'photo' => new CURLFile($image_url),
        );

        // Envia a mensagem via API do Telegram usando o método "sendPhoto"
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        // Verifica se a mensagem foi enviada com sucesso
        if ($result) {
            echo 'Imagem enviada com sucesso!';
        } else {
            echo 'Erro ao enviar imagem.';
        }

    }
}

?>