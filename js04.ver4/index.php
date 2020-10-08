<html>
  <head></head>
  <body>

    <script>
    function makeApiCall(action="read") {
     
     
        var ssId = 'xxx;
  var rng = 'Sheet1'; 
 // Writing to sheet
  if(action=="write"){
   var vals = new Array(6);
   for (var row= 0; row <6; row++){
   vals[row] = new Array(3); // new row with 3 columns
   for (var col= 0; col <3; col++){
   vals[row][col]= document.getElementById(row+":"+col).value;
    }
   }
   var params = {
   spreadsheetId: ssId,
   range: rng,
   valueInputOption: 'RAW',
   };
   
  var valueRangeBody ={"values": vals};
 
      var request = gapi.client.sheets.spreadsheets.values.update(params, valueRangeBody);
      request.then(function(response) {
       
        console.log(response.result);
      }, function(reason) {
        console.error('error: ' + reason.result.error.message);
      });
    }
 else{   //Reading from Sheet
  var params = {
   spreadsheetId: ssId,
   range: rng,
   };
  var request = gapi.client.sheets.spreadsheets.values.get(params);
      request.then(function(response) {
        // TODO: Change code below to process the `response` object:
        console.log(response.result);
  populateSheet(response.result);
      }, function(reason) {
        console.error('error: ' + reason.result.error.message);
      });
    }
 }
 function initClient() {
      var API_KEY = 'yyy';  
      var CLIENT_ID = 'zzz'; 


      var SCOPE = 'https://www.googleapis.com/auth/spreadsheets';

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
 
  function handleSaveClick() {
      makeApiCall(action="write");
    } 
 function populateSheet(result) {
   for(var row=0; row< 6; row++) {       //row<result.values.length
  for(var col=0; col< 3; col++) {           //col<result.values[0].length;
  document.getElementById(row+":"+col).value = result.values[row][col];
  }

   }
 }
 
    </script>
    <script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>
   <button id="signin-button" onclick="handleSignInClick()">Sign in</button>
    <button id="signout-button" onclick="handleSignOutClick()">Sign out</button> 
 <button id="save-button" onclick="handleSaveClick()">Save</button> 

 
  <div style="margin-left:auto; margin-right:auto; width:1960px;">
    <?php
    for($row = 0; $row < 6; $row++) {
      echo "<div style='clear:both'>";
      for($col = 0; $col < 3; $col++) {
        echo "<input type='text' style='float:left;' name = '$row:$col' id='$row:$col'>";
      }
      echo "</div>";
    }
    ?>
 </div>
  </body>
</html>
