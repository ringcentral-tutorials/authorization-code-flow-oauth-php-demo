<?php
echo '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>RingCentral Authorization Code Flow Authentication</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="./js/login.js"></script>
    </head>
    <body>
        <div align="justify">
          <div style="width:500px">
            <p>
              <b>Important!</b> You need to enable pop-up for this web site in order to login your RingCentral via this Web app.
              After logged in successfully, if the pop-up window is not automatically dismissed,
              you can manually close the pop-up window and reload the page.</br>
            </p>
          </div>
          <h3>Choose your RingCentral Account Environment</h3></br>
          <div id="login">
            <button onclick="chooseEnvironment(\"production\")">Login Production Account</button>
            <button onclick="chooseEnvironment(\"sandbox\")">Login Sandbox Account</button>
          </div>
        </div>
    </body>
</html>';
