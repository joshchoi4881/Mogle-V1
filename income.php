<!DOCTYPE html>
<?php
    include("classes/Login.php");
    include("classes/Database.php");
    $log;
    $userId;
    $user;
    if(Login::isLoggedIn()) {
      $log = true;
      if(Database::query("SELECT userId FROM loginTokens WHERE token=:token", array(":token"=>sha1($_COOKIE["MOGLE_ID"])))) {
        $userId = Database::query("SELECT userId FROM loginTokens WHERE token=:token", array(":token"=>sha1($_COOKIE["MOGLE_ID"])))[0]["userId"];
        $user = Database::query("SELECT * FROM users WHERE id=:id", array(":id"=>$userId));
      }
    } else { 
      $log = false; header("Location: homepage.php");
    }
?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta
      name="description"
      content="Maximizing Human Capital in the Gig Economy"
    />
    <meta name="keywords" content="Mogle, Gig Economy, Human Capital" />
    <meta name="author" content="Josh Choi" />
    <title>Mogle</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" type="text/css" href="css/mogle.css" />
    <style>
      #incomeLink {
        margin-top: 20px;
      }
      .hidden {
        display: none;
      }
      #user {
        color: #fff;
        background-color: #58d68d;
        margin: auto;
        margin-top: 200px;
        border-radius: 50%;
        width: 200px;
        height: 200px;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
      }
    </style>
    <!-- Bootstrap -->
    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"
    ></script>
    <!-- AnyChart -->
    <script src="https://cdn.anychart.com/releases/8.7.1/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.7.1/js/anychart-pie.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script
      async
      src="https://www.googletagmanager.com/gtag/js?id=UA-138974831-2"
    ></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
        dataLayer.push(arguments);
      }
      gtag("js", new Date());

      gtag("config", "UA-138974831-2");
    </script>
    <!-- Firebase -->
		<!-- The core Firebase JS SDK is always required and must be listed first -->
		<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-app.js"></script>
		<!-- TODO: Add SDKs for Firebase products that you want to use
			https://firebase.google.com/docs/web/setup#available-libraries -->
		<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-analytics.js"></script>
		<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-auth.js"></script>
		<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-firestore.js"></script>
		<script>
			// Your web app's Firebase configuration
			var firebaseConfig = {
				apiKey: "AIzaSyDkdhG0FRBaJ2LlMSLpV3Xd2eqlbKzUnSU",
				authDomain: "mogleapp4881.firebaseapp.com",
				databaseURL: "https://mogleapp4881.firebaseio.com",
				projectId: "mogleapp4881",
				storageBucket: "mogleapp4881.appspot.com",
				messagingSenderId: "619304884169",
				appId: "1:619304884169:web:d0203971e1071253f97a18",
				measurementId: "G-W1HNG10V6G"
			};
			// Initialize Firebase
			firebase.initializeApp(firebaseConfig);
			firebase.analytics();
		</script>
    <!-- Plaid -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="https://cdn.plaid.com/link/v2/stable/link-initialize.js"></script>
  </head>
  <body>
    <header id="header">
      <div id="info">
        <a href="about.php">About</a>
        <!--
        <a href="team.php">Team</a>
        -->
      </div>
      <a href="homepage.php"
        ><img id="logo" src="photos/design/mogle.png" alt="Mogle Logo"
      /></a>
      <div id="account">
        <a href="logout.php">Logout</a>
      </div>
      <nav>
        <a href="profile.php">Profile</a>
        <a href="search.php">Search</a>
        <a href="schedule.php">Schedule</a>
        <a id="income" href="income.php">Income</a>
        <a href="community.php">Community</a>
      </nav>
    </header>
    <section class="center">
      <div id="incomeLink">
        <button id="link-button">Link Account</button>
      </div>
      <div id="pieCharts">
        <div id="pieChartSettings" class="card hidden">
          <h1>Pie Charts</h1>
          <p>See a breakdown of your income and expenses:</p>
          <br/>
            <label>Start Date:</label>
            <input id="startDate" type="date" required autofocus/>
            <br/>
            <br/>
            <label>End Date:</label>
            <input id="endDate" type="date" required/>
            <br/>
            <br/>
            <div class="submitForm">
              <input id="pieChartsButton" type="submit" name="submit" value="Submit"/>
            </div>
        </div>
        <div id="expensesPieChart" class="card hidden">
          <h1>Expenses</h1>
          <div id='container1'>
          </div>
        </div>
        <div id="incomePieChart" class="card hidden">
          <h1>Income</h1>
          <div id='container2'>
          </div>
        </div>
      </div>
    </section>
    <script>
      $(function () {
        $("#income").css({ "background-color": "#800000", color: "#fff" });
      });
    </script>
    <script src="js/mogle.js"></script>
    <script src="js/firebase/auth.js"></script>
    <script src="js/plaid/link.js"></script>
    <script src="js/anychart/pieCharts.js"></script>
  </body>
</html>