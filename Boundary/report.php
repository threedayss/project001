<!DOCTYPE html>

<link rel="stylesheet" href="../css/restauranthome.css">
<link rel="stylesheet" href="../css/report.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/board.css">

<script type="text/javascript" src="../js/report.js"></script>

<body>
    <!-- for the heading of the website -->
    <div class="header">
        <a href="ownerhome.html">
            Dumbledore House
        </a>
        <span class="username">
            Welcome
<!-- to allow user to click on the user icon to logout -->
            <div class="dropdown">
                <button class="dropbtn"><img src="../pictures/apple.png"></button>
                <div class="dropdown-content">
                  <button onclick="displayAlert()";>Logout</button>
                </div>
              </div>
        </span> 
    </div>
	
	<div class="board">
        <a href="viewemail.php" class="owner">
            View Email Record
        </a>
        <a href="report.php" class="owner" id="add">
            Generate Report
		</a>
    </div>

    <form method="post">
    <div class="report">
        <div class="check">
        <label for="period">Period: </label>
            <select name="time" id="period">
                <option value="Hour">Hourly</option>
                <option value="Day">Daily</option>
                <option value="Month">Monthly</option>
            </select>

            <label for="report-type">Reports: </label>
            <select name="name" id="report-type">
                <option value="Sales Report">Sales Report</option>
                <option value="Average Spent">Average Spent</option>
                <option value="Traffic">Traffic</option>
            </select>
        </div>

        <div class="generate">
            <button name="GR" class="button">
                Generate Report
            </button>

            <?php
                require '../Controller/Report-Controller.php';
                
                if(isset($_POST['GR'])) {
                    $RC = new ReportController();
                    $t = $_POST['time'];
                    $n = $_POST['name'];
                    $RC->generateReport($t, $n);
					
					if($n == "Average Spent") {
						if($t == "Hour") {
							echo "<table><tr><th>Hours</th><th>Average Costumer's expenditure/visit</th></tr>";
						} else if ($t == "Day") {
							echo "<table><tr><th>Dates</th><th>Average Costumer's expenditure/visit</th></tr>";
						} else if ($t == "Month") {
							echo "<table><tr><th>Months</th><th>Average Costumer's expenditure/visit</th></tr>";
						}
						
						for($i=0;$i<count($RC->getArray1());$i++) { 
                            echo "<tr><td>".$RC->getArray1()[$i]."</td><td>";
                            echo $RC->getArray2()[$i]."</td></tr>";
                        }

                        echo "</table>";
					}

                    else if($n == "Sales Report") {
						if($t == "Hour") {
							echo "<table><tr><th>Hours / Food Id</th>";
						} else if($t == "Day") {
							echo "<table><tr><th>Hours / Food Id</th>";
						} else if($t == "Month") {
							echo "<table><tr><th>Hours / Food Id</th>";
						}
						
						foreach($RC->getArray2() as $i) {
                            echo "<th>".$i."</th>";
                        }
                        echo "</tr><tr>";

                        foreach($RC->getArray1() as $i) {
                            echo "<th>".$i."</th>";

                            foreach($RC->getArray3() as $j) {
                                echo "<td>".$j."</td>";
                            }

                            echo "</tr>";
                        }
                        
                        echo "</table>";
					}						

                    else if($n == "Traffic") {
						if($t == "Hour") {
							echo "<table><tr><th>Hours</th><th>Average Costumer visit</th></tr>";
						} else if($t == "Day") {
							echo "<table><tr><th>Dates</th><th>Average Costumer visit</th></tr>";
						} else if($t == "Month") {
							echo "<table><tr><th>Months</th><th>Average Costumer visit</th></tr>";
						}
						
						for($i=0;$i<count($RC->getArray1());$i++) { 
                            echo "<tr><td>".$RC->getArray1()[$i]."</td><td>";
                            echo $RC->getArray2()[$i]."</td></tr>";
                        }
                        
                        echo "</table>";
					}						
                }
            ?>
        </div>
    </div>
    </form>
</body>