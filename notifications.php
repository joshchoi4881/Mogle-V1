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
        $log = false;
        header("Location: homepage.php");
    }
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Maximizing Human Capital in the Gig Economy">
        <meta name="keywords" content="Mogle, Gig Economy, Human Capital">
        <meta name="author" content="Josh Choi">
        <title>Mogle</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
        <link rel="stylesheet" type="text/css" href="css/mogle.css"/>
        <!-- Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-138974831-2"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-138974831-2');
        </script>
    </head>
    <body>
        <header id="header">
            <div id="info">
                <a href="about.php">About</a>
                <!--
                <a href="team.php">Team</a>
                -->
            </div>
            <a href="homepage.php"><img id="logo" src="photos/design/mogle.png" alt="Mogle Logo"/></a>
            <div id="account">
                <a href="logout.php">Logout</a>
            </div>
            <nav>
                <a id="profile" href="profile.php">Profile</a>
                <a href="search.php">Search</a>
                <a href="schedule.php">Schedule</a>
                <a href="income.php">Income</a>
                <a href="community.php">Community</a>
            </nav>
        </header>
        <section class="center">
            <!-- Subcategories -->
            <div class="subtopics">
                <a id="profileButton" class="subtopic" href="profile.php">
                    <h5>Profile</h5>
                </a>
                <a id="uploadButton" class="subtopic" href="upload.php">
                    <h5>Upload</h5>
                </a>
                <a id="questionnaireButton" class="subtopic" href="questionnaire.php">
                    <h5>Questionnaire</h5>
                </a>
                <a id="notificationsButton" class="subtopic" href="notifications.php">
                    <h5>Notifications</h5>
                </a>
                <a id="inboxButton" class="subtopic" href="inbox.php">
                    <h5>Inbox</h5>
                </a>
                <a id="settingsButton" class="subtopic" href="settings.php">
                    <h5>Settings</h5>
                </a>
            </div>
            <br/>
            <!-- Notifications -->
            <div id="notifications">
                <div class="card">
                    <h1>Notifications</h1>
                    <?php
                        if(Database::query("SELECT * FROM notifications WHERE receiver=:userId", array(":userId"=>$userId))) {
                            $notifications = Database::query("SELECT * FROM notifications WHERE receiver=:userId ORDER BY id DESC", array(":userId"=>$userId));
                            foreach($notifications as $n) {
                                $sender = Database::query("SELECT * FROM users WHERE id=:id", array(":id"=>$n["sender"]));
                                $receiver = Database::query("SELECT * FROM users WHERE id=:id", array(":id"=>$n["receiver"]));
                                if($n["type"] == "follow") {
                                    echo "<p><a href=\"profile.php?p=".$sender[0]["id"]."\">".$sender[0]["firstName"]." ".$sender[0]["lastName"]."</a> started following you @ ".$n["date"]."</p>";
                                }
                                else if($n["type"] == "inboxMessage") {
                                    echo "<p><a href=\"profile.php?p=".$sender[0]["id"]."\">".$sender[0]["firstName"]." ".$sender[0]["lastName"]."</a> sent you a <a href=\"inbox.php?mid=".$n["extra"]."\">message</a> @ ".$n["date"]."</p>";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </section>
        <script>
            $(function() {
				$("#profile").css({"background-color": "#800000", "color": "#fff"});
            });
            $(function() {
                $(".subtopic").css({"background-color": "#fff", "color": "#000"});
                $("#notificationsButton").css({"background-color": "#d4af37", "color": "#fff"});
            });
        </script>
        <script src="js/mogle.js"></script>
    </body>
</html>