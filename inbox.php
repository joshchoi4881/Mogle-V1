<!DOCTYPE html>
<?php
    include("classes/Notify.php");
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
            <!-- Inbox -->
            <div id="inbox">
                <div id="inboxSearch">
                    <h3>Search For User</h3>
                    <?php
                        echo "<form action=\"inbox.php\" method=\"POST\">
                                <input type=\"text\" name=\"inboxSearchbox\" value=\"\">
                                <input type=\"submit\" name=\"inboxSubmit\" value=\"Search\">
                            </form>";
                        if(isset($_POST["inboxSearchbox"])) {
                            $toSearch = explode(" ", $_POST["inboxSearchbox"]);
                            if(count($toSearch) == 1) {
                                    $toSearch = str_split($toSearch[0], 2);
                            }
                            $whereClause1 = "";
                            $whereClause2 = "";
                            $paramsArray = array(":firstName"=>"%".$_POST["inboxSearchbox"]."%", ":lastName"=>"%".$_POST["inboxSearchbox"]."%");
                            for($i = 0; $i < count($toSearch); $i++) {
                                $whereClause1 .= " OR firstName LIKE :u$i ";
                                $whereClause2 .= " OR lastName LIKE :u$i ";
                                $paramsArray[":u$i"] = $toSearch[$i];
                            }
                            $searchUsers = Database::query("SELECT * FROM users WHERE (firstName LIKE :firstName ".$whereClause1.") OR (lastName LIKE :lastName ".$whereClause2.")", $paramsArray);
                            foreach($searchUsers as $s) {
                                echo "<a href=inbox.php?r=".$s["id"].">".$s["firstName"]." ".$s["lastName"]."</a><br/>";
                            }
                        }
                    ?>
                </div>
                <div id="sendMessage" class="card">
                    <?php
                        if(isset($_GET["mid"])) {
                            Database::query("UPDATE messages SET messageRead=1 WHERE id=:id", array(":id"=>$_GET["mid"]));
                            $message = Database::query("SELECT * FROM messages WHERE id=:id AND (senderId=:senderId OR receiverId=:receiverId)", array(":id"=>$_GET["mid"], ":senderId"=>$userId, ":receiverId"=>$userId))[0];
                            if($message["senderId"] == $userId) {
                                $id = $message["receiverId"];
                                $other = Database::query("SELECT * FROM users WHERE id=".$id."");
                                $text = "Sent by <a href=\"profile.php?p=".$user[0]["id"]."\">".$user[0]["firstName"]." ".$user[0]["lastName"]."</a> to <a href=\"profile.php?p=".$other[0]["id"]."\">".$other[0]["firstName"]." ".$other[0]["lastName"]."</a> @ ".$message["date"]."<hr />";
                            } else {
                                $id = $message["senderId"];
                                $other = Database::query("SELECT * FROM users WHERE id=".$id."");
                                $text = "Sent by <a href=\"profile.php?p=".$other[0]["id"]."\">".$other[0]["firstName"]." ".$other[0]["lastName"]."</a> to <a href=\"profile.php?p=".$user[0]["id"]."\">".$user[0]["firstName"]." ".$user[0]["lastName"]."</a> @ ".$message["date"]."<hr />";
                            }
                            $receiver = Database::query("SELECT * FROM users WHERE id=".$id."");
                            echo "<h1>View Message</h1>
                                    <hr/>
                                    ".htmlspecialchars($message["messageBody"])."
                                    <hr/>
                                    ".$text."
                                    <p>Receiver: ".$receiver[0]["firstName"]." ".$receiver[0]["lastName"]."</p>
                                    <form action=\"inbox.php?r=".$id."\" method=\"POST\">
                                        <textarea name=\"messageBody\" rows=\"8\" cols=\"80\"></textarea>
                                        <br/>
                                        <br/>
                                        <input type=\"submit\" name=\"send\" value=\"Send Message\">
                                    </form>";
                        } else {
                            echo "<h1>Send Message</h1>";
                            if(isset($_GET["r"])) {
                                if($_GET["r"] == $userId) {
                                    echo "<p style='color:maroon'>You cannot send a message to yourself</p>
                                        <p>Select a user to send a message to through the search box</p>";
                                } else {
                                    $receiver = Database::query("SELECT * FROM users WHERE id=".$_GET["r"]."");
                                    echo "<p>Receiver: ".$receiver[0]["firstName"]." ".$receiver[0]["lastName"]."</p>";
                                }
                            } else {
                                echo "<p>Select a user to send a message to through the search box</p>";
                            }
                            if(isset($_POST["send"])) {
                                $senderId = $userId;
                                $receiverId = $_GET["r"];
                                $messageBody = $_POST["messageBody"];
                                $messageRead = 0;
                                $timeZone = "America/New_York";
                                $timeStamp = time();
                                $dateTime = new DateTime("now", new DateTimeZone($timeZone));
                                $dateTime->setTimestamp($timeStamp);
                                if(Database::query("SELECT id FROM users WHERE id=:receiver", array(":receiver"=>$_GET["r"]))) {
                                    $messageId = Database::query("INSERT INTO messages VALUES (:id, :senderId, :receiverId, :messageBody, :messageRead, :d8)", array(":id"=>null, ":senderId"=>$senderId, ":receiverId"=>$receiverId, ":messageBody"=>$messageBody, ":messageRead"=>$messageRead, ":d8"=>$dateTime->format("m-d-y, h:i:s A")));
                                    Notify::createNotify("inboxMessage", $senderId, $receiverId, $messageId);
                                    echo "Message sent";
                                } else {
                                    die("Invalid ID");
                                }
                            }
                            echo "<form action=\"inbox.php";
                            if(isset($_GET["r"])) {
                                echo "?r=".$_GET["r"]."";
                            }
                            echo "\" method=\"POST\">
                                    <textarea name=\"messageBody\" rows=\"8\" cols=\"50\"></textarea>
                                    <br/>
                                    <br/>
                                    <input type=\"submit\" name=\"send\" value=\"Send Message\">
                                </form>
                                <br/>";
                        }
                    ?>
                </div>
                <div id="myReceivedMessages" class="card">
                    <h3>My Received Messages</h3>
                    <?php
                        $messages = Database::query("SELECT users.*, messages.* FROM users, messages WHERE users.id=messages.senderId AND receiverId=".$userId." ORDER BY messages.date DESC");
                        foreach($messages as $message) {
                            if(strlen($message["messageBody"]) > 10) {
                                $m = substr($message["messageBody"], 0, 10)." ...";
                            } else {
                                $m = $message["messageBody"];
                            }
                            if($message["messageRead"] == 0) {
                                echo "<a href=\"inbox.php?mid=".$message["id"]."\"><strong>".$m."</strong></a> sent by <a href=\"profile.php?p=".$message[0]."\">".$message["firstName"]." ".$message["lastName"]."</a> to <a href=\"profile.php?p=".$user[0]["id"]."\">".$user[0]["firstName"]." ".$user[0]["lastName"]."</a> @ ".$message["date"]."<hr />";
                            } else {
                                echo "<a href=\"inbox.php?mid=".$message["id"]."\">".$m."</a> sent by <a href=\"profile.php?p=".$message[0]."\">".$message["firstName"]." ".$message["lastName"]."</a> to <a href=\"profile.php?p=".$user[0]["id"]."\">".$user[0]["firstName"]." ".$user[0]["lastName"]."</a> @ ".$message["date"]."<hr />";
                            }
                        }
                    ?>
                </div>
                <div id="mySentMessages" class="card">
                    <h3>My Sent Messages</h3>
                    <?php
                        $messages = Database::query("SELECT users.*, messages.* FROM users, messages WHERE users.id=messages.receiverId AND senderId=".$userId." ORDER BY messages.date DESC");
                        foreach($messages as $message) {
                            if(strlen($message["messageBody"]) > 10) {
                                $m = substr($message["messageBody"], 0, 10)." ...";
                            } else {
                                $m = $message["messageBody"];
                            }
                            if($message["messageRead"] == 0) {
                                echo "<a href=\"inbox.php?mid=".$message["id"]."\"><strong>".$m."</strong></a> sent by <a href=\"profile.php?p=".$user[0]["id"]."\">".$user[0]["firstName"]." ".$user[0]["lastName"]."</a> to <a href=\"profile.php?p=".$message[0]."\">".$message["firstName"]." ".$message["lastName"]."</a> @ ".$message["date"]."<hr />";
                            } else {
                                echo "<a href=\"inbox.php?mid=".$message["id"]."\">".$m."</a> sent by <a href=\"profile.php?p=".$user[0]["id"]."\">".$user[0]["firstName"]." ".$user[0]["lastName"]."</a> to <a href=\"profile.php?p=".$message[0]."\">".$message["firstName"]." ".$message["lastName"]."</a> @ ".$message["date"]."<hr />";
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
                $("#inboxButton").css({"background-color": "#d4af37", "color": "#fff"});
            });
        </script>
        <script src="js/mogle.js"></script>
    </body>
</html>