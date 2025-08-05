<?php
if (strpos($_SERVER['SERVER_NAME'], "testing") !== false) {
	echo "<h2>Warning: This is a testing server. Go <a href='https://tournament.flltutorials.com'>here</a> for the correct server</h2>";
}
?>

<script src="/js/download.js"></script>

<script>
language = "en"
</script>
<script src="/js/languages.js"></script>
<script src="/js/language-detector.js"></script>

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
	<i id="langs" style="z-index:10000;text-align:left; color:white; position: relative; margin:auto;padding-left: 3px;top: 1px;">

		<!-- <div id="langs"></div> -->
	</i>
	<!-- Tournament:
		<?php
		if (isset($_SESSION["tournament"])) echo htmlspecialchars($_SESSION["tournament"] . " ");
		else echo "None";
		?> -->
	<script>
		var page = '';
		//              var page = window.location.href.split("?")[0].split("#")[0] + '?lang=';
		var i;
		for (i = 0; i < langs.length; i++) {
			window[langs[i].split(':')[0].split('-')[0]] = page + langs[i].split(':')[0];
		}
		var i;
		// if ((navigator.userAgent.indexOf("MSIE") != -1) || (!!document.documentMode == true)) { // DCR is buggy in MSIE, use classic switcher
		// 	var i;
		// 	for (i = 0; i < langs.length; i++) {
		// 		document.write('\
		//                     <a class="no-print no-mobile" data-ajax="false" href="?lang=' + window[langs[i].split(":")[0].split("-")[0]] + '" onclick="createCookie(\'' + langs[i].split(":")[0] + '\');window.location.href="' + window[langs[i].split(":")[0].split("-")[0]] + '";setTimeout(function(){location.reload(true);},100)" style=" text-decoration: none">\
		//                     <img src="/images/icons/countries/small/' + langs[i].split(":")[1] + '.png" alt="' + langs[i].split(":")[2] + '" title="' + langs[i].split(":")[2] + '" width="26" height="26" border="0">\
		//                     </a>\
		//                     ')
		// 	}
		// } else {
		buf = ""
		for (i = 0; i < langs.length; i++) {
			buf += '\
                                    <a class="no-print " style="cursor:pointer;" data-ajax="false"  onclick="createCookie(\'' + langs[i].split(":")[0] + '\');language=\'' + window[langs[i].split(":")[0].split("-")[0]] + '\';switchLanguage();" style=" text-decoration: none">\
                                    <img src="/langs/' + langs[i].split(":")[3] + '.svg" alt="' + langs[i].split(":")[2] + '" title="' + langs[i].split(":")[2] + '" width="26" height="26" style="object-fit:cover;border-radius:30%;" border="0">\
                                    </a>\
                                '
		}
		document.getElementById("langs").innerHTML = buf;
		// }
	
	</script>

	<!-- <script>
		// document.getElementById('lang').value = language

		// q = window.location.search

		// function getParameterByName(name, url) {
		// 	if (!url) url = window.location.href;
		// 	name = name.replace(/[\[\]]/g, "\\$&");
		// 	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
		// 		results = regex.exec(url);
		// 	if (!results) return null;
		// 	if (!results[2]) return '';
		// 	return decodeURIComponent(results[2].replace(/\+/g, " "));
		// }

		// function changelang(val) {
		// 	if (window.location.search == "") {
		// 		window.location.search = "?lang=" + val
		// 	} else {
		// 		window.location.search = window.location.search.split("&lang=")[0] + "&lang=" + val + "&" + window.location.search.split(language + "&")[1]
		// 	}
		// }
	</script> -->

	<div id="loginstatus" style="text-align:right; color:white; position: relative; margin:auto;padding-right: 3px;top:-20px;">
		<?php

		// if (isset($_SESSION["username"]))
		// 	echo "Logged in as: ";


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
		setInterval(function() {
			getStatus();
		}, 600000);
		//   getStatus()
	</script>

</div>

<script src="/js/translate.js"></script>
