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
    # Profile
	$profile;
	$following;
	if(isset($_GET["p"])) {
		if(Database::query("SELECT id FROM users WHERE id=".$_GET["p"]."")) {
			if($_GET["p"] === $user[0]["id"]) {
				$profile = $user;
				$following = false;
			} else {
				$targetId = Database::query("SELECT id FROM users WHERE id=".$_GET["p"]."")[0]["id"];
				$profile = Database::query("SELECT * FROM users WHERE id=".$_GET["p"]."");
				if(Database::query("SELECT id FROM followers WHERE userId=".$userId." AND followingId=".$targetId."")) {
					$following = true;
				} else {
					$following = false;
				}
			}
		} else {
			die("User does not exist");
		}
	} else {
		$profile = Database::query("SELECT * FROM users WHERE id=".$userId."");
		$following = false;
	}
    $extraInfo = Database::query("SELECT * FROM userProfiles WHERE userId=".$profile[0]["id"]."");
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
        <link rel="stylesheet" type="text/css" href="css/profile.css"/>
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
            <?php
                if($profile[0]["id"] !== $user[0]["id"]) {
                    echo "";
                } else {
                    echo '<div class="subtopics">
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
                        </div>';
                }
            ?>
            <br/>
            <!-- Profile -->
            <div id="profileSearch">
                <h3>Search For User</h3>
                <?php
                    echo "<form action=\"profile.php?p=".$profile[0]["id"]."\" method=\"POST\">
                            <input type=\"text\" name=\"profileSearchbox\" value=\"\">
                            <input type=\"submit\" name=\"profileSubmit\" value=\"Search\">
                        </form>";
                    if(isset($_POST["profileSearchbox"])) {
                        $toSearch = explode(" ", $_POST["profileSearchbox"]);
                        if(count($toSearch) == 1) {
                                $toSearch = str_split($toSearch[0], 2);
                        }
                        $whereClause1 = "";
                        $whereClause2 = "";
                        $paramsArray = array(":firstName"=>"%".$_POST["profileSearchbox"]."%", ":lastName"=>"%".$_POST["profileSearchbox"]."%");
                        for($i = 0; $i < count($toSearch); $i++) {
                            $whereClause1 .= " OR firstName LIKE :u$i ";
                            $whereClause2 .= " OR lastName LIKE :u$i ";
                            $paramsArray[":u$i"] = $toSearch[$i];
                        }
                        $searchUsers = Database::query("SELECT * FROM users WHERE (firstName LIKE :firstName ".$whereClause1.") OR (lastName LIKE :lastName ".$whereClause2.")", $paramsArray);
                        foreach($searchUsers as $s) {
                            echo "<a href=profile.php?p=".$s["id"].">".$s["firstName"]." ".$s["lastName"]."</a><br/>";
                        }
                    }
                ?>
            </div>
            <br/>
            <div id="overview">
                <h3>Overview</h3>
                <?php
                    $followers = Database::query("SELECT userId FROM followers WHERE followingId=".$profile[0]["id"]."");
                    $followerCount = count($followers);
                    $followings = Database::query("SELECT followingId FROM followers WHERE userId=".$profile[0]["id"]."");
                    $followingCount = count($followings);
                    echo "<div id=\"profile\">
                            <div id=\"profileInfo\">
                                <div id=\"imageContainer\">
                                    <img class=\"images\" src=\"".$profile[0]["profilePicture"]."\" alt=\"".$profile[0]["firstName"]." ".$profile[0]["lastName"]."\"/>
                                </div>
                                <div id=\"infoContainer\">
                                    <h1>".$profile[0]["firstName"]." ".$profile[0]["lastName"]."</h1>
                                    <p>".$extraInfo[0]["bio"]."</p>
                                </div>
                            </div>
                            <div id=\"network\">";
                    if($profile[0]["id"] !== $user[0]["id"]) {
                        echo "<div id=\"changeStatusButton\">";
                        if(!$following) {
                            echo "<input id=\"followButton\" class=\"btn btn-primary\" onclick=\"changeFollowStatus('follow', ".$userId.", ".$profile[0]["id"].", ".$followerCount.")\" type=\"button\" name=\"follow\" value=\"Follow\"/>";
                        } else {
                            echo "<input id=\"unfollowButton\" class=\"btn btn-primary\" onclick=\"changeFollowStatus('unfollow', ".$userId.", ".$profile[0]["id"].", ".$followerCount.")\" type=\"button\" name=\"unfollow\" value=\"Unfollow\"/>";
                        }
                        echo "</div>";
                    }
                    // Followers list
                    echo "<div id=\"followers\">
                            <h3>Followers (<span id=\"followerCount\">".$followerCount."</span>)</h3>";
                    foreach($followers as $follower) {
                        $f = Database::query("SELECT users.* FROM users WHERE id=:id", array(":id"=>$follower["userId"]));
                        if($f[0]["id"] == $userId) {
                            echo "<div id=\"myIcon\" class=\"followerListItem\">";
                        } else {
                            echo "<div class=\"followerListItem\">";
                        }
                        echo "<a href=\"profile.php?p=".$f[0]["id"]."\"><img class=\"icon\" src=\"".$f[0]["profilePicture"]."\" alt=\"".$f[0]["firstName"]." ".$f[0]["lastName"]."\"/></a>
                                <div class=\"iconInfo\">
                                    <p><a href=\"profile.php?p=".$f[0]["id"]."\">".$f[0]["firstName"]." ".$f[0]["lastName"]."</a></p>
                                    <p>".$f[0]["firstName"]." ".$f[0]["lastName"]."</p>
                                </div>
                            </div>";
                    }
                    echo "<p id=\"insertIcon\"></p>
                        </div>";
                    // Following list
                    echo "<div id=\"following\">
                            <h3>Following (".$followingCount.")</h3>";
                    foreach($followings as $following) {
                        $f = Database::query("SELECT users.* FROM users WHERE id=:id", array(":id"=>$following["followingId"]));
                        echo "<div class=\"followingListItem\">
                            <a href=\"profile.php?p=".$f[0]["id"]."\"><img class=\"icon\" src=\"".$f[0]["profilePicture"]."\" alt=\"".$f[0]["firstName"]." ".$f[0]["lastName"]."\"/></a>
                                <div class=\"iconInfo\">
                                    <p><a href=\"profile.php?p=".$f[0]["id"]."\">".$f[0]["firstName"]." ".$f[0]["lastName"]."</a></p>
                                </div>
                            </div>";
                    }
                    echo "</div>
                        </div>
                        </div>";
                ?>
            </div>
        </section>
        <script>
            $(function() {
				$("#profile").css({"background-color": "#800000", "color": "#fff"});
            });
            $(function() {
                $(".subtopic").css({"background-color": "#fff", "color": "#000"});
                $("#profileButton").css({"background-color": "#d4af37", "color": "#fff"});
            });
            /* Changes follow status (follow or unfollow)
            status is whether user is following or unfollowing target, userId is the id of the user, followingId is the id of the target */
            function changeFollowStatus(status, userId, followingId, followerCount) {
                var xhttp;
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if(this.readyState == 4 && this.status == 200) {
                        if(status == "follow") {
                            $("#followButton").attr({
                                "id" : "unfollowButton",
                                "onclick" : "changeFollowStatus('unfollow', " + userId + ", " + followingId + ")",
                                "name" : "unfollow",
                                "value" : "Unfollow"
                            });
                            <?php
                                echo "$(\"#insertIcon\").append(\"<div id='myIcon' class='followerListItem'><a href='profile.php?p=".$user[0]["id"]."'><img class='icon' src='".$user[0]["profilePicture"]."' alt='".$user[0]["firstName"]." ".$user[0]["lastName"]."'/></a><div class='iconInfo'><p><a href='profile.php?p=".$user[0]["id"]."'>".$user[0]["firstName"]." ".$user[0]["lastName"]."</a></p></div></div>\");";
                            ?>
                            $("#followerCount").html(this.responseText);
                            $("#unfollowButton").attr({
                                "onclick" : "changeFollowStatus('unfollow', " + <?php echo $userId; ?> + ", " + <?php echo $profile[0]["id"]; ?> + ", " + this.responseText + ")"
                            });
                        }
                        else if(status == "unfollow") {
                            $("#unfollowButton").attr({
                                "id" : "followButton",
                                "onclick" : "changeFollowStatus('follow', " + userId + ", " + followingId + ")",
                                "name" : "follow",
                                "value" : "Follow"
                            });
                            $("#myIcon").remove();
                            $("#followerCount").html(this.responseText);
                            $("#followButton").attr({
                                "onclick" : "changeFollowStatus('follow', " + <?php echo $userId; ?> + ", " + <?php echo $profile[0]["id"]; ?> + ", " + this.responseText + ")"
                            });
                        }
                    }
                };
                xhttp.open("GET", "AJAX/network.php?status=" + status + "&userId=" + userId + "&followingId=" + followingId + "&followerCount=" + followerCount, true);
                xhttp.send();
            }
        </script>
        <script src="js/mogle.js"></script>
    </body>
</html>