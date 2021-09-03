<?php
    require 'vendor/autoload.php';

    function chekAuth($user_Id, $tokenKey) {
        try {
            if ($user_Id == '' && $tokenKey == '') {
                return array("result" => false, "status" => "Invalid Datas");
            }
            $secretKey  = ' your sceret key';
            $factory = new \PsrJwt\Factory\Jwt();

            $parser = $factory->parser($tokenKey, $secretKey);
            
            $parser->validate();
            $parsed = $parser->parse();
            if (is_object($parsed)) {
                if ($parsed->getExpiresIn() > 0) {
                    $payload = $parsed->getPayload();
                    // print_r($payload);die();
                    $now = new DateTimeImmutable();
                    $serverName = "https://".$_SERVER['HTTP_HOST']; //"https://web.sicsglobal.com";
                    $userId = $payload['userId'];
                    $exp = $payload['exp'];
                    $iat = $payload['iat'];
                    $iss = $payload['iss'];
                    if ($serverName == $iss && $user_Id == $userId && $exp > $now->getTimestamp() ) {
                        return 'true';
                    } else {
                        return array("result" => false, "status" => "Invalid Token");
                    }
                }else {
                    return array("result" => false, "status" => "Invalid Token");
                }
            } else {
                return array("result" => false, "status" => "Invalid Token");
            }
        } catch (\Throwable $th) {
            // echo $th->getMessage();
            return array("result" => false, "status" => "Invalid Token");
        }
       
    }
?>