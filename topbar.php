<?php
if (strpos($_SERVER['SERVER_NAME'], "testing") !== false) {
	echo "<h2>Warning: This is a testing server. Go <a href='https://tournament.flltutorials.com'>here</a> for the correct server</h2>";
}
?>
<div class="topbar" id="myTopbar" style="width:100%; height:35px; background-color:#0A122A; top:0;align-items: center;">
	<?php
	// Initialize the session
	session_start();

	// Check if the user is logged in, if not then redirect him to login page
	// if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	//   if (!isset($_SESSION["admin"])) {
	//     header("location: login.php");
	//     exit;
	//   }
	// }
	?>
	<i style="text-align:left; color:white; position: relative; margin:auto;padding-left: 3px;top: 1px;">Tournament:
		<?php
		if (isset($_SESSION["tournament"])) echo htmlspecialchars($_SESSION["tournament"] . " ");
		else echo "None";
		?></i>
	<script>
		document.getElementById('lang').value = language

		q = window.location.search

		function getParameterByName(name, url) {
			if (!url) url = window.location.href;
			name = name.replace(/[\[\]]/g, "\\$&");
			var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
				results = regex.exec(url);
			if (!results) return null;
			if (!results[2]) return '';
			return decodeURIComponent(results[2].replace(/\+/g, " "));
		}

		function changelang(val) {
			if (window.location.search == "") {
				window.location.search = "?lang=" + val
			} else {
				window.location.search = window.location.search.split("&lang=")[0] + "&lang=" + val + "&" + window.location.search.split(language + "&")[1]
			}
		}
	</script>

	<div id="loginstatus" style="text-align:right; color:white; position: relative; margin:auto;padding-right: 3px;top:-20px;">
	<?php

	if (isset($_SESSION["username"]))
		echo "Logged in as: ";


	echo htmlspecialchars($_SESSION["username"] . "");;

	if (!isset($_SESSION["username"])) {
		if (strpos(getcwd(), 'participants') !== false) {
			echo "<a  href='/login.php'>Login</a>";
		} else if (strpos(getcwd(), 'judges') !== false) {
			echo "<a  href='/login.php'>Login</a>";
		} else {
			echo "<a  href='/login.php'>Login</a>";
		}
	} else {
		// if (trim($_SESSION["username"])!=="guest"){
		echo '; <a href="/logout.php"> Logout </a>';
	}

	?>
	</div>

	<script>
          function textFileToArray(filename) {
            var reader = (window.XMLHttpRequest != null) ?
              new XMLHttpRequest() :
              new ActiveXObject("Microsoft.XMLHTTP");
            reader.open("GET", filename, false);
            reader.send();
            return reader.responseText.split(/\r\n|\n|\r/); //split(/(\r\n|\n)/g)
          }

		  function getStatus() {
          	document.getElementById("loginstatus").innerHTML = textFileToArray('/getLogin.php')[0];
			console.log("Fetching login status");
		  }
		  setInterval(function(){ getStatus(); }, 600000);
		//   getStatus()

        </script>

</div>