<?php
$html = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>RingCentral Authorization Code Flow Authentication</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>';
          $html .= 'window.RC_AUTHORIZE_URI='. $authorize_uri;
          $html .= 'window.RC_APP_REDIRECT_URL= '.$redirect_uri;
        $html .= '</script>
        <script src="./js/login.js"></script>
    </head>
    <body onload="login()">
      <h2>RingCentral Authorization Code Flow Authentication</h2>
      <div align="center">
        <h1>Loading...</h1>
        <img src="./img/loading.gif" id="logginIcon" style="width:80px;height:80px;display: block"></img>
        <h1>Please wait!</h1>
      </div>
    </body>
</html>';

echo $html;
