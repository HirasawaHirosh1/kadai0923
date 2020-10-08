<html>
  <head></head>
  <body>
 
    <script>
    function makeApiCall() {
      var params = {
        spreadsheetId: '1OYL9SREyA0AvAbc-WCLgRe7x_dySfDPnb481BglbCQM',  
        range: 'Sheet1', 
      };

      var request = gapi.client.sheets.spreadsheets.values.get(params);
      request.then(function(response) {
        console.log(response.result);
        populateSheet(response.result);
  }, function(reason) {
    console.error('error: ' + reason.result.error.message);
  });
}

function populateSheet(result) {
  for(var row=0; row<8; row++) {
    for(var col=0; col<8; col++) {
    document.getElementById(row+":"+col).value = result.values[row][col];
    }

  }
}
    function initClient() {
      var API_KEY = 'AIzaSyCZIpdUblYESIEmROwC2EMdnrwtRi6fQSY';  // TODO: Update placeholder with desired API key.
      var CLIENT_ID = '959118115283-34km09skvuaov3bpc46r68kg77ejv489.apps.googleusercontent.com';  
      var SCOPE = 'https://www.googleapis.com/auth/spreadsheets.readonly';

      gapi.client.init({
        'apiKey': API_KEY,
        'clientId': CLIENT_ID,
        'scope': SCOPE,
        'discoveryDocs': ['https://sheets.googleapis.com/$discovery/rest?version=v4'],
      }).then(function() {
        gapi.auth2.getAuthInstance().isSignedIn.listen(updateSignInStatus);
        updateSignInStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
      });
    }

    function handleClientLoad() {
      gapi.load('client:auth2', initClient);
    }

    function updateSignInStatus(isSignedIn) {
      if (isSignedIn) {
        makeApiCall();
      }
    }

    function handleSignInClick(event) {
      gapi.auth2.getAuthInstance().signIn();
    }

    function handleSignOutClick(event) {
      gapi.auth2.getAuthInstance().signOut();
    }
    </script>
    <script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">

    </script>
    <button id="signin-button" onclick="handleSignInClick()">Sign in</button>
    <button id="signout-button" onclick="handleSignOutClick()">Sign out</button>

    <div style="margin-left:auto; margin-right:auto; width:1500px;">
    <?php
    for($row = 0; $row < 8; $row++) {
      echo "<div style='clear:both'>";
      for($col = 0; $col < 8
      ; $col++) {
        echo "<input type='text' style='float:left;' name = '$row:$col' id='$row:$col'>";
      }
      echo "</div>";
    }
    ?>


  </body>
</html>
