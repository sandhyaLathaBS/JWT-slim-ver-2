<?php

    include('slim/Slim/Slim.php');

    include('validate_jwt_token.php');

    \Slim\Slim::registerAutoloader();
    $app = new \slim\Slim();

    $app->map('/averageresponsetime/', function () use ($app) {
        $UserId =''; $token = '';
        $token = $app->request->headers->get('Authorization');
        $UserId = $app->request()->post('UserId');
        $ret_res = chekAuth($UserId, $token);
            if (is_array($ret_res)) {
                $app->response()->header('Content-Type', 'application/json');
                echo json_encode($ret_res);
                exit;
            }


            // do ur stuff
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode($post1);
    })->via('POST');
    $app->run();


?>