<?php
require_once(__DIR__ . '/vendor/autoload.php');
use RingCentral\SDK\Http\HttpException;
use RingCentral\SDK\Http\ApiResponse;
use RingCentral\SDK\SDK;

session_start();

if (isset($_SESSION['env'])){
    $env_file = $_SESSION['env'];
    $dotenv = new Dotenv\Dotenv(__DIR__, $env_file);
    $dotenv->load();
}else{
    unset($_SESSION['tokens']);
    header("Location: http://localhost:5000");
    exit();
}

$rcsdk = new SDK(getenv('RC_CLIENT_ID'), getenv('RC_CLIENT_SECRET'), getenv('RC_SERVER_URL'));
$platform = $rcsdk->platform();

if (isset($_REQUEST['oauth2callback'])){
    if (isset($_GET['code'])) {
      $qs = $platform->parseAuthRedirectUrl($_SERVER['QUERY_STRING']);
      $qs["redirectUri"] = getenv('RC_REDIRECT_URL');
      try {
          $apiResponse = $platform->login($qs);
          echo "Login success";
          $_SESSION['tokens'] = $platform->auth()->data();;
      } catch (\RingCentral\SDK\Http\ApiException $e) {
          print 'Expected HTTP Error: ' . $e->getMessage() . PHP_EOL;
      }
    }
    exit();
}else{
    if (isset($_SESSION['tokens'])){
        $platform->auth()->setData((array)$_SESSION['tokens']);
        if (!$platform->loggedIn()) {
            header("Location: http://localhost:5000");
            exit();
        }
        if (isset($_REQUEST['logout'])){
            unset($_SESSION['tokens']);
            $platform->logout();
            header("Location: http://localhost:5000");
            exit();
        }elseif (isset($_REQUEST['api'])){
            if ($_REQUEST['api'] == "extension") {
                $endpoint = "/restapi/v1.0/account/~/extension";
                callGetRequest($platform, $endpoint, null);
            }elseif ($_REQUEST['api'] == "extension-call-log") {
                $endpoint = "/restapi/v1.0/account/~/extension/~/call-log";
                $params = array(
                    'fromDate' => '2018-12-01T00:00:00.000Z',
                  );
                callGetRequest($platform, $endpoint, $params);
            }elseif ($_REQUEST['api'] == "account-call-log") {
                $endpoint = "/restapi/v1.0/account/~/call-log";
                $params = array(
                    'fromDate' => '2018-12-01T00:00:00.000Z',
                  );
                callGetRequest($platform, $endpoint, $params);
            }
        }
    }else{
        header("Location: http://localhost:5000");
        exit();
    }
}

function callGetRequest($platform, $endpoint, $params){
    try {
        $resp = $platform->get($endpoint, $params);
        echo $resp->text();
    } catch (\RingCentral\SDK\Http\ApiException $e) {
        print 'Expected HTTP Error: ' . $e->getMessage() . PHP_EOL;
    }
}
?>
