<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
$myfile = fopen('../tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
$tournament = trim(fgets($myfile));
fclose($myfile);

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"] !== $tournament) {
  header("location: ../login.php?auth=" . $_SERVER['REQUEST_URI']);
  exit;
}

if (!($_SESSION["role"] == "Tournament Director" || $_SESSION["role"] == "Judge")) {
  header("location: ../login.php?auth=denied");
  exit;
}
?>

<head>
  <link rel="stylesheet" type="text/css" href="../style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>Rubric Manager</title>

  <style>
  .styled-table {
    /* border-collapse: collapse; */
    margin: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    width:100%;
    font-size:20px;
    border-collapse:collapse;
    border:solid black 1px;
    border-radius:6px;
    -moz-border-radius:6px;
    /* border-collapse: collapse;' */
  }
  .styled-table thead tr {
    background-color: #009879;
    color: #ffffff;
    text-align: left;
  }
  .styled-table th {
    padding: 5px 5px;
    background-color: #ffc107;
    border-top: none;
  }
  .styled-table td {
    padding: 5px 5px;
  }
  .styled-table tbody tr {
    border-bottom: thin solid #dddddd;
  }

  .styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
    color: black !important;
  }

  .styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #000000;
  }
  .styled-table tbody tr.active-row {
    font-weight: bold;
    color: #009879;
  }
  /* tr:nth-child(even) {
  background-color: Lightgreen;
  } */
  </style>


</head>

<body>
  <script>
    $(function() {
      $("#topbar").load("../../../topbar.php");
    });
  </script>
  <div id="topbar"></div><br>
  <div>
    <script>
      $(function() {
        $("#header").load("header.php");
      });
    </script>
    <div id="header"></div><br>
    <section style="padding: 5px 5px 5px 15px;">

      <h2>Rubric Manager</h2>
    </section><br>
    <section>
      <div class="text-body" style="font-size: 12px;">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>

        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>



        <center>
          <html>

          <head>
            <!-- <meta http-equiv="refresh" content="10;">-->
            <script type="text/javascript" src="/gs_sortable.js"></script>
            <script type="text/javascript">
              dir = window.location.hash.substring(1);

              function textFileToArray(filename) {
                var reader = (window.XMLHttpRequest != null) ?
                  new XMLHttpRequest() :
                  new ActiveXObject("Microsoft.XMLHTTP");
                reader.open("GET", filename, false);
                reader.send();
                return reader.responseText.split(/\r\n|\n|\r/); //split(/(\r\n|\n)/g)
              }
              // col = parseInt(textFileToArray("rounds.txt")[0]) + 1;
              col = 3 + 1;
              /*
              tsort = ['my_table', 's'];
              f = 1;
              while (f < col) {
                  tsort.push('i');
                  f++;
              }
                */

              //  var TSort_Data = tsort;
              //  f = 0;
              //  var TSort_Initial =  new Array (''+f+'D');
              //  tsRegister();
              teamScores = [
              <?php
                $handle = fopen("../admin/teams.txt", "r");
                if ($handle) {
                    while (($line = fgets($handle)) !== false) {
                        // process the line read.
                        $teamno = explode(",",$line)[0];
                        //for ($c=0; $c<3; $c++) {

			$c = "rb-cv-s";
                        $file = "../teams/" .$teamno. "/robotScores/" . $c . ".txt";
                        if (file_exists($file)) {
                            $contents = trim(file_get_contents($file));
                            echo "'".$contents."',";
                        } else {
                            echo "'',";
                        }
                        //}
                    }
                    fclose($handle);
                    echo "''";
                } else {
                    // error opening the file.
                }
              ?>
              ]


              if (fileExists("../admin/teams.txt")) {
                teamlist = textFileToArray("../admin/teams.txt");
              } else {
                teamlist = ["<b style='color:red'>Error, teams list has not been created</b>"];
              }
              // teamlist = textFileToArray("../admin/teams.txt");
              function fileExists(file_url) {

                var http = new XMLHttpRequest();

                http.open('HEAD', file_url, false);
                http.send();

                return http.status != 404;

              }

	     function getParameterByName(name, url) {
		 if (!url) url = window.location.href;
		 name = name.replace(/[\[\]]/g, "\\$&");
		 var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
		     results = regex.exec(url);
		 if (!results) return null;
		 if (!results[2]) return '';
		 return decodeURIComponent(results[2].replace(/\+/g, " "));
	     }



function gentable(teamin,n) {
    if (getParameterByName("table")!=null && getParameterByName("table")!='' && String(teamin.split(',')[4])!=getParameterByName("table")) return;

    tourn = window.location.href.split('/')[5]
                fwteam = teamin.split(',')[0];
                team = teamin.split(',')[0] + " - " + teamin.split(',')[1]
                document.write('<tr>');
                c = 1;
                document.write('  <td style="text-align:center">' + fwteam + '</td>');

                document.write('  <td><a target="_blank" href="../teams/' + fwteam + '">' + teamin.split(',')[1] + '</a></td>');
                document.write('  <td style="text-align:center">' + teamin.split(',')[4] + '</td>');
//                if (fileExists("../teams/" + fwteam + "/robotScores/rb-cv-s.txt") == true) {
                if (true) {
                  // console.log("../teams/" +fwteam+ "/robotScores/" +c+ ".txt")
                    teamscore = teamScores[n]
			//textFileToArray("../teams/" + fwteam + "/robotScores/rb-cv-s.txt")[0].split(';')[0];
                  // teamscore = "X";
                } else {
                  teamscore = "0";
                }
                //document.write(' <td id="'+fwteam+'-'+c+'"><a href="/scorer/index.html?tourn='+tourn+'&team='+fwteam+'&round='+c+'">'+String(teamscore)+'</a></td>');
                document.write(' <td id="' + fwteam + '-' + c + '"><button style="background-color:#98c6f7;border-radius:6px;width:100%; height:30px; font-size:20px;margin-top: 3px;margin-bottom: 3px;" onclick="window.parent.location.href = \'rubric.php?tourn=' + tourn + '&team=' + fwteam + '&round=' + c + '\'">' + String(teamscore) + '</button></td>');


                // c++;
                //     }
                document.write('</tr>');
              }
            </script>


          </head>

          <body>
  <p>
Click on any column header to sort by that column.
	    <br>	    
	    Filter by lane:
	    <select onchange="window.location.href='loadrb.php?table='+this.value;" id="filter">
		<option></option>
		<option>1</option>
		<option>2</option>
		<option>3</option>
		<option>4</option>
		<option>5</option>
		<option>6</option>
		<option>7</option>
		<option>8</option>
		<option>9</option>
		<option>10</option>
		<option>11</option>
		<option>12</option>
		<option>13</option>
		<option>14</option>
		<option>15</option>
	    </select></p>
	    <script>
	     if (getParameterByName("table")!=null) document.getElementById("filter").value = getParameterByName("table");
	    </script>

            <br>
            <table class="styled-table" border="1" id="my_table">
              <thead>
                <tr style="background-color: lightgrey;text-align:center;">
                  <th style="max-width: 75px;">
                    <button style="background-color: transparent;border-color: transparent; width: 100%;" onclick="sortTable(0)"> Team No. </button>
                  </th>
                  <th>
                    <button style="background-color: transparent;border-color: transparent; width: 100%;" onclick="sortTable(1)"> Team Name </button>
                  </th>
                  <th style="max-width: 80px;"><button style="background-color: transparent;border-color: transparent; width: 100%;" onclick="sortTable(2)">Judging Lane</button></th>
                  <th style="max-width: 80px;"><button style="background-color: transparent;border-color: transparent; width: 100%;" onclick="sortTable(3)">Rubric</button></th>
                  <!-- <th style="max-width: 80px;"><button style="background-color: transparent;border-color: transparent; width: 100%;" onclick="sortTable(4)">Robot Design</button></th>
                  <th style="max-width: 80px;"><button style="background-color: transparent;border-color: transparent; width: 100%;" onclick="sortTable(5)">Core Values</button></th> -->
                  <!--	   <td>High Score</td>-->
                </tr>
              </thead>
              <script>
                n = 0;
                while (n < teamlist.length) {
                    gentable(teamlist[n],n);
                  n++;
                }
              </script>
            </table>
            <script>
              //language = window.location.hash.substring(1);
              /*
                 scores = textFileToArray("/"+dir+"/scores.txt");
              scores.sort();
              x = 1;
              lastteam = '';
              thisteam = '';
              lastpoints = 0;
              thispoints = 0;
              count = scores.length;
              while (x < count) {
              RoundId = scores[x].split(', ')[0].split(' ')[0] + scores[x].split(', ')[1];
              	   Points = scores[x].split(', ')[2].split(' ')[0];
              	   thisteam = scores[x].split(', ')[0].split(' ')[0];
              	   thispoints = parseInt(Points);
              if (thisteam == lastteam) {
              	   if (thispoints > lastpoints) {
              document.getElementById(scores[x].split(', ')[0].split(' ')[0] + String(col-1)).innerHTML = thispoints;
                   }
                   } else {
              document.getElementById(scores[x].split(', ')[0].split(' ')[0] + String(col-1)).innerHTML = thispoints;
                   }
              	   lastteam =  scores[x].split(', ')[0].split(' ')[0];
              lastpoints = parseInt(scores[x].split(', ')[2].split(' ')[0]);
              	   x = x + 1;
              	   document.getElementById(RoundId).innerHTML = Points;
                   }
              */
            </script>
            <script>
              function sortTable(n) {
                var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                table = document.getElementById("my_table");
                switching = true;
                //Set the sorting direction to ascending:
                dir = "asc";
                /*Make a loop that will continue until
                no switching has been done:*/
                while (switching) {
                  //start by saying: no switching is done:
                  switching = false;
                  rows = table.getElementsByTagName("TR");
                  /*Loop through all table rows (except the
                  first, which contains table headers):*/
                  for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /*check if the two rows should switch place,
                    based on the direction, asc or desc:*/
                    if (dir == "asc") {
                      if (n == 0 || n == 2) {
                        if (parseInt(x.innerHTML) > parseInt(y.innerHTML)) {
                          //if so, mark as a switch and break the loop:
                          shouldSwitch = true;
                          break;
                        }
                      } else if (n >= 3) {
                        // console.log(x.children[0].innerHTML,(parseInt(x.children[0].innerHTML.value)|| 0))
                        if ((parseInt(x.children[0].innerHTML) || 0) > (parseInt(y.children[0].innerHTML) || 0)) {
                          //if so, mark as a switch and break the loop:
                          shouldSwitch = true;
                          break;
                        }
                      } else {
                        if (x.innerText.toLowerCase() > y.innerText.toLowerCase()) {
                          //if so, mark as a switch and break the loop:
                          shouldSwitch = true;
                          break;
                        }
                      }
                    } else if (dir == "desc") {
                      if (n == 0 || n == 2) {
                        if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
                          shouldSwitch = true;
                          break;
                        }
                      } else if (n >= 3) {
                        if ((parseInt(x.children[0].innerHTML) || 0) < (parseInt(y.children[0].innerHTML) || 0)) {
                          shouldSwitch = true;
                          break;
                        }
                      } else {
                        if (x.innerText.toLowerCase() < y.innerText.toLowerCase()) {
                          //if so, mark as a switch and break the loop:
                          shouldSwitch = true;
                          break;
                        }
                      }
                    }
                  }
                  if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    //Each time a switch is done, increase this count by 1:
                    switchcount++;
                  } else {
                    /*If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again.*/
                    if (switchcount == 0 && dir == "asc") {
                      dir = "desc";
                      switching = true;
                    }
                  }
                }
              }
              sortTable(0)
              sortTable(0)
            </script>
          </body>

          </html>
        </center>
      </div>

    </section>
    <br>
    <script>
      $(function() {
        $("#footer").load("../footer.html");
      });
    </script>
    <div id="footer"></div>
  </div>
  <script src='js/accordian.js'></script>

</body>
