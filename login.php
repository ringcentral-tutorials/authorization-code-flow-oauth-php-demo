<?php
require_once(__DIR__ . '/vendor/autoload.php');
use RingCentral\SDK\SDK;

session_start();

$env_file = "./environment/";
if ($_REQUEST['env'] == "sandbox"){
   $env_file .= ".env-sandbox";
}else{
   $env_file .= ".env-production";
}
$_SESSION['env'] = $env_file;
$dotenv = new Dotenv\Dotenv(__DIR__, $env_file);
$dotenv->load();

$rcsdk = new SDK(getenv('RC_CLIENT_ID'), getenv('RC_CLIENT_SECRET'), getenv('RC_SERVER_URL'));
$platform = $rcsdk->platform();

$authorize_uri = $platform->authUrl(array(
        'redirectUri' => getenv('RC_REDIRECT_URL'),
        'state' => 'initialState',
        'brandId' => '',
        'display' => '',
        'prompt' => ''
    ));
?>
<!DOCTYPE html>
<html>
  <head>
    <title>RingCentral Authorization Code Flow Authentication</title>
    <script>
        var authorize_uri = '<?php echo $authorize_uri; ?>';
        var redirectUri = '<?php echo getenv('RC_REDIRECT_URL'); ?>';
        var config = {
            authUri: authorize_uri,
            redirectUri: redirectUri,
        }
        var OAuthCode = function (config) {
            this.config = config;
            this.loginPopup = function () {
                this.loginPopupUri(this.config['authUri'], this.config['redirectUri']);
            }
            this.loginPopupUri = function (authUri, redirectUri) {
                var win = window.open(authUri, 'windowname1', 'width=800, height=600');
                var pollOAuth = window.setInterval(function () {
                    try {
                        if (win.document.URL.indexOf(redirectUri) != -1) {
                            window.clearInterval(pollOAuth);
                            win.close();
                            window.location.href = "test.php"
                        }
                    } catch (e) {
                        console.log(e);
                    }
                }, 100);

            }
        }
        var oauth = new OAuthCode(config)
        oauth.loginPopup()
    </script>
  </head>
  <body/>
</html>
