<?php
require 'vendor/autoload.php';

try {
    
    $factory = new \PsrJwt\Factory\Jwt();
    $builder = $factory->builder();
    $userId = $_POST['userId'];
    $issuedAt   = new DateTimeImmutable();
    $expire     = $issuedAt->modify('+6 minutes')->getTimestamp();      // Add 60 seconds
    $secretKey  = 'your sceret key';
    $serverName = "https://".$_SERVER['HTTP_HOST']; //"https://web.sicsglobal.com";
    $tokenId    = base64_encode(random_bytes(16));
    $token = $builder->setSecret($secretKey)
        ->setPayloadClaim('userId', $userId)
        ->setExpiration($expire)
        ->setJwtId($tokenId)
        ->setIssuer($serverName)
        ->setIssuedAt($issuedAt->getTimestamp())
        ->build();
        $post1 =  array("result" => false, "status" => 'Token Genrated successfully', 'token' => $token->getToken());
        echo json_encode($post1);
} catch (\Throwable $th) {
    $post1 =  array("result" => false, "status" => $th->getMessage(), 'token' => '');
    echo json_encode($post1);
}




