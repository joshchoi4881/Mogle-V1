<!DOCTYPE html>
<?php
    include("classes/Image.php");
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
    }
    if(isset($_POST["postsPost"])) {
		if(isset($_POST["postsTags"])) {
			$tags = $_POST["postsTags"];
        }
        $headline = $_POST["headline"];
        $body = $_POST["postsBody"];
        $media = $_POST["chooseMedia"];
        $video = $_POST["video"];
		$timeZone = "America/New_York";
        $timeStamp = time();
        $dateTime = new DateTime("now", new DateTimeZone($timeZone));
        $dateTime->setTimestamp($timeStamp);
        if(strlen($headline) < 1 || strlen($headline) > 100) {
            echo "Please keep your headline under 100 characters long";
        } else {
            if(strlen($body) > 500) {
                echo "Please keep your body under 500 characters long";
            } else {
                $postId = Database::query("INSERT INTO posts VALUES (:id, :userId, :headline, :body, :media, :postsImage, :video, :d8)", array(":id"=>null, ":userId"=>$userId, ":headline"=>$headline, ":body"=>$body, ":media"=>$media, ":postsImage"=>null, ":video"=>$video, ":d8"=>$dateTime->format("h:i:s A, m-d-y")));
                if($_FILES["postsImage"]["size"] && $_FILES["postsImage"]["size"] != 0) {
                    Image::uploadImage("postsImage", "UPDATE posts SET postsImage=:postsImage WHERE id=:id", array(":id"=>$postId));
                }
                if(isset($_POST["postsTags"])) {
                    for($i = 0; $i < count(array_filter($tags)); $i++) {
                        Database::query("INSERT INTO communityTags VALUES (:id, :communityType, :communityId, :tag)", array(":id"=>null, ":communityType"=>"post", ":communityId"=>$postId, ":tag"=>$tags[$i]));
                    }
                }
            }
        }
    }
    if(isset($_POST["earningsPost"])) {
		if(isset($_POST["earningsTags"])) {
			$tags = $_POST["earningsTags"];
        }
        $earnings = $_POST["earnings"];
        $gigDate = $_POST["gigDate"];
        $gigDateFormat = new DateTime($gigDate);
        $startTime = $_POST["startTime"];
        $start = new DateTime($startTime);
        $endTime = $_POST["endTime"];
        $end = new DateTime($endTime);
        $location = $_POST["location"];
		$body = $_POST["earningsBody"];
		$timeZone = "America/New_York";
        $timeStamp = time();
        $dateTime = new DateTime("now", new DateTimeZone($timeZone));
        $dateTime->setTimestamp($timeStamp);
        if(strlen($location) < 1 || strlen($location) > 50) {
            echo "Please keep your location under 50 characters long";
        } else {
            if(strlen($body) > 500) {
                echo "Please keep your body under 500 characters long";
            } else {
                $earningId = Database::query("INSERT INTO earnings VALUES (:id, :userId, :earnings, :gigDate, :startTime, :endTime, :loc, :body, :earningsImage, :d8)", array(":id"=>null, ":userId"=>$userId, ":earnings"=>$earnings, ":gigDate"=>$gigDateFormat->format("m-d-y"), ":startTime"=>$start->format("h:i:s A"), ":endTime"=>$end->format("h:i:s A"), ":loc"=>$location, ":body"=>$body, ":earningsImage"=>null, ":d8"=>$dateTime->format("h:i:s A, m-d-y")));
                if($_FILES["earningsImage"]["size"] && $_FILES["earningsImage"]["size"] != 0) {
                    Image::uploadImage("earningsImage", "UPDATE earnings SET earningsImage=:earningsImage WHERE id=:id", array(":id"=>$earningId));
                }
                if(isset($_POST["earningsTags"])) {
                    for($i = 0; $i < count(array_filter($tags)); $i++) {
                        Database::query("INSERT INTO communityTags VALUES (:id, :communityType, :communityId, :tag)", array(":id"=>null, ":communityType"=>"earning", ":communityId"=>$earningId, ":tag"=>$tags[$i]));
                    }
                }
            }
        }
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
        <style>
            #switchDiv {
                display: flex;
                justify-content: center;
            }
            .tagDiv {
                margin-top: 50px;
                margin-left: 5%;
                margin-right: 5%;
                height: 400px;
                display: inline-block;
                float: left;
            }
            #media {
                display: inline-block;
                width: 100%;
            }
            #earnings {
                display: inline-block;
            }
            #earningsImageDiv {
                display: inline-block;
                width: 100%;
                float: right;
            }
            .submitForm {
                display: block;
                width: 100%;
                float: right;
            }
            .post {
                display: inline-block;
                text-align: center;
                border-radius: 10%;
            }
            .earning {
                display: inline-block;
                text-align: center;
                border-radius: 10%;
            }
            img {
                width: 200px;
                height: 400px;
            }
        </style>
        <!-- Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!-- Vue.js -->
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
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
                <a href="profile.php">Profile</a>
                <a href="search.php">Search</a>
                <a href="schedule.php">Schedule</a>
                <a href="income.php">Income</a>
                <a id="community" href="community.php">Community</a>
            </nav>
        </header>
        <section class="center">
            <!-- Subcategories -->
            <div class="subtopics">
                <div id="feed" class="subtopic">
                    <h5>Feed</h5>
                </div>
                <div id="uber" class="subtopic">
                    <h5>Uber</h5>
                </div>
                <div id="lyft" class="subtopic">
                    <h5>Lyft</h5>
                </div>
                <div id="uberEats" class="subtopic">
                    <h5>Uber Eats</h5>
                </div>
                <div id="doorDash" class="subtopic">
                    <h5>DoorDash</h5>
                </div>
                <div id="postmates" class="subtopic">
                    <h5>Postmates</h5>
                </div>
                <div id="grubhub" class="subtopic">
                    <h5>Grubhub</h5>
                </div>
            </div>
            <!-- Rounded switch -->
            <br/>
            <div id="switchDiv">
                <label class="switch">
                    <input id="toggle" type="checkbox">
                    <span class="slider round"></span>
                </label>
            </div>
            <br/>
            <small>Toggle between posts (gray) and earnings (blue)</small>
            <?php
                if($log) {
                    echo '<div class="card posts">
                            <h1>Post something!</h1>
                            <form action="community.php" method="POST" enctype="multipart/form-data">
                                <div id="postsForm">
                                    <div class="tagDiv">
                                        <p>Tags:</p>
                                        <input class="check" type="checkbox" name="postsTags[]" value="uber">Uber
                                        <br/>
                                        <input class="check" type="checkbox" name="postsTags[]" value="lyft">Lyft
                                        <br/>
                                        <input class="check" type="checkbox" name="postsTags[]" value="uberEats">Uber Eats
                                        <br/>
                                        <input class="check" type="checkbox" name="postsTags[]" value="doorDash">DoorDash
                                        <br/>
                                        <input class="check" type="checkbox" name="postsTags[]" value="postmates">Postmates
                                        <br/>
                                        <input class="check" type="checkbox" name="postsTags[]" value="grubhub">Grubhub
                                        <br/>
                                    </div>
                                    <div>
                                        <p>*Headline:</p>
                                        <textarea v-model="headline" rows="1" cols="50" name="headline" value="" placeholder="" required></textarea>
                                        <p>{{ headlineCharacterCount }}/100</p>
                                    </div>
                                    <div>
                                        <p>*Body:</p>
                                        <textarea v-model="postsBody" rows="4" cols="50" name="postsBody" value="" placeholder="" required></textarea>
                                        <p>{{ postsBodyCharacterCount }}/500</p>
                                    </div>
                                    <div id="media">
                                        <p>Media:</p>
                                        <select id="chooseMedia" v-on:click="clearMedia" name="chooseMedia" required>
                                            <option value="none">None</option>
                                            <option value="image">Image</option>
                                            <option value="video">Video</option>
                                        </select>
                                        <br/>
                                        <br/>
                                        <div id="image" class="mediaSelect">
                                            <p>*Upload Image:</p>
                                            <input type="file" name="postsImage" value="" required/>
                                        </div>
                                        <div id="video" class="mediaSelect">
                                            <p>*Video:</p>
                                            <small>Note: Currently only YouTube videos are supported. Click "Share" under the YouTube video, then <br/>the "Embed" button, then copy and paste the code below</small>
                                            <textarea v-model="video" rows="4" cols="50" name="video" value="" placeholder="Ex: <iframe width=\'560\' height=\'315\' src=\'https://www.youtube.com/embed/tvTRZJ-4EyI\' frameborder=\'0\' allow=\'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\' allowfullscreen></iframe>" required></textarea>
                                            <p>{{ videoCharacterCount }}/500</p>
                                        </div>
                                        <br/>
                                        <br/>
                                    </div>
                                </div>
                                <div class="submitForm">
                                    <input type="submit" name="postsPost" value="Post"/>
                                </div>
                            </form>
                        </div>
                        <div class="card earnings">
                            <h1>Share your earnings!</h1>
                            <form action="community.php" method="POST" enctype="multipart/form-data">
                                <div id="earningsForm">
                                    <div class="tagDiv">
                                        <p>Tags:</p>
                                        <input class="check" type="checkbox" name="earningsTags[]" value="uber">Uber
                                        <br/>
                                        <input class="check" type="checkbox" name="earningsTags[]" value="lyft">Lyft
                                        <br/>
                                        <input class="check" type="checkbox" name="earningsTags[]" value="uberEats">Uber Eats
                                        <br/>
                                        <input class="check" type="checkbox" name="earningsTags[]" value="doorDash">DoorDash
                                        <br/>
                                        <input class="check" type="checkbox" name="earningsTags[]" value="postmates">Postmates
                                        <br/>
                                        <input class="check" type="checkbox" name="earningsTags[]" value="grubhub">Grubhub
                                        <br/>
                                    </div>
                                    <br/>
                                    <br/>
                                    <div>
                                        <p>*Earnings:</p>
                                        $<input id="earnings" name="earnings" value="" placeholder="9.75" required/>
                                    </div>
                                    <br/>
                                    <br/>
                                    <div>
                                        <p>*Date:</p>
                                        <input type="date" name="gigDate" required/>
                                    </div>
                                    <br/>
                                    <br/>
                                    <div>
                                        <p>*Time:</p>
                                        Start: <input type="time" name="startTime" required/>
                                        <br/>
                                        <br/>
                                        End: <input type="time" name="endTime" required/>
                                        <br/>
                                        <br/>
                                        <p>Ex: 08:30 PM</p>
                                    </div>
                                    <br/>
                                    <br/>
                                    <div>
                                        <p>*Location:</p>
                                        <input v-model="location" name="location" value="" placeholder="New York, New York" required/>
                                        <p>{{ locationCharacterCount }}/50</p>
                                    </div>
                                    <br/>
                                    <br/>
                                    <div>
                                        <p>Body:</p>
                                        <textarea v-model="earningsBody" rows="4" cols="50" name="earningsBody" value="" placeholder=""></textarea>
                                        <p>{{ earningsBodyCharacterCount }}/500</p>
                                    </div>
                                    <br/>
                                    <br/>
                                    <div id="earningsImageDiv">
                                        <p>Image: <input id="earningsImage" type="file" name="earningsImage" value=""/></p>
                                    </div>
                                    <br/>
                                    <br/>
                                </div>
                                <div class="submitForm">
                                    <input type="submit" name="earningsPost" value="Post"/>
                                </div>
                            </form>
                        </div>';
                } else {
                    echo '<div class="card">
                        <h1><a href="login.php">Log in</a> to post!</h1>
                        </div>';
                }
                $posts = Database::query("SELECT posts.* FROM posts ORDER BY posts.date DESC;");
                foreach($posts as $p) {
                    $user = Database::query("SELECT users.* FROM users WHERE id=:id", array(":id"=>$p["userId"]));
                    $tags = Database::query("SELECT communityTags.* FROM communityTags WHERE communityType='post' AND communityId=".$p["id"]."");
                    echo "<!-- Post ".$p["id"]." -->
                        <section id='".$p["id"]."' class='card post ";
                    foreach($tags as $t) {
                        echo " ".$t["tag"]."";
                    }
                    echo "'>
                        <h3>".$p["headline"]."</h3>
                        <br/>
                        <blockquote>
                            ".$p["body"]."
                        </blockquote>";
                    if($p["media"] == "image") {
                        echo "<img class='images' src='".$p["postsImage"]."' alt='Picture'/>";
                    }
                    else if($p["video"] != "") {
                        echo $p["video"];
                    }
                    echo "<br/>
                        <br/>
                        <p>Posted by ".$user[0]["firstName"]." ".$user[0]["lastName"]." on ".$p["date"]."</p>
                        <br/>
                        </section>";
                }
                $earnings = Database::query("SELECT earnings.* FROM earnings ORDER BY earnings.date DESC;");
                foreach($earnings as $e) {
                    $user = Database::query("SELECT users.* FROM users WHERE id=:id", array(":id"=>$e["userId"]));
                    $tags = Database::query("SELECT communityTags.* FROM communityTags WHERE communityType='earning' AND communityId=".$e["id"]."");
                    echo "<!-- Post ".$e["id"]." -->
                        <section id='".$e["id"]."' class='card earning ";
                    foreach($tags as $t) {
                        echo " ".$t["tag"]."";
                    }
                    echo "'>
                        <h3>".$e["location"].": $".$e["earnings"]."</h3>
                        <br/>
                        Time: ".$e["startTime"]." - ".$e["endTime"]."
                        <br/>
                        Date: ".$e["gigDate"]."
                        <br/>
                        <br/>";
                    if($e["body"] != "") {
                        echo "<blockquote>
                                ".$e["body"]."
                            </blockquote>";
                    }
                    if($e["earningsImage"] != null) {
                        echo "<img class='images' src='".$e["earningsImage"]."' alt='Picture'/>
                            <br/>
                            <br/>";
                    }
                    echo "<p>Posted by ".$user[0]["firstName"]." ".$user[0]["lastName"]." on ".$e["date"]."</p>
                        <br/>
                        </section>";
                }
            ?>
        </section>
        <script>
            $(function() {
                $("#community").css({"background-color": "#800000", "color": "#fff"});
                $(".post").show();
                $(".earning").hide();
                $(".subtopic").css({"background-color": "#fff", "color": "#000"});
                $("#feed").css({"background-color": "#d4af37", "color": "#fff"});
                $("#headline").removeAttr("required");
                $("#earnings").removeAttr("required");
                $("#gigDates").removeAttr("required");
                $("#startTime").removeAttr("required");
                $("#endTime").removeAttr("required");
                $("#location").removeAttr("required");
                $(".earnings").hide();
                $(".posts").show();
                $("#image input").removeAttr("required");
                $("#video textarea").removeAttr("required");
                $(".mediaSelect").hide();
                $("#chooseMedia").val("none");
                $("#chooseMedia").change(function() {
                    if($(this).val() === "none") {
                        $("#image input").val("");
                        $("#image input").removeAttr("required");
                        $("#video textarea").val("");
                        $("#video textarea").removeAttr("required");
                        $(".mediaSelect").hide();
                    }
                    else if($(this).val() === "image") {
                        $("#video textarea").val("");
                        $("#video textarea").removeAttr("required");
                        $(".mediaSelect").hide();
                        $("#image input").attr("required", "true");
                        $("#image").show();
                    }
                    else if($(this).val() === "video") {
                        $("#image input").val("");
                        $("#image input").removeAttr("required");
                        $(".mediaSelect").hide();
                        $("#video textarea").attr("required", "true");
                        $("#video").show();
                    }
                });
                $(".post").show();
                $(".earning").hide();
                // Subtopics
				$("#feed").on("click", function() {
                    if($("#toggle").is(":checked")) {
                        $(".post").hide();
                        $(".earning").show();
                    } else {
                        $(".post").show();
                        $(".earning").hide();
                    }
                    $(".subtopic").css({"background-color": "#fff", "color": "#000"});
                    $("#feed").css({"background-color": "#d4af37", "color": "#fff"});
				});
				$("#uber").on("click", function() {
                    if($("#toggle").is(":checked")) {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.uber").show();
                    } else {
                        $(".post").hide();
                        $(".post.uber").show();
                        $(".earning").hide();
                    }
                    $(".subtopic").css({"background-color": "#fff", "color": "#000"});
                    $("#uber").css({"background-color": "#d4af37", "color": "#fff"});
				});
				$("#lyft").on("click", function() {
					if($("#toggle").is(":checked")) {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.lyft").show();
                    } else {
                        $(".post").hide();
                        $(".post.lyft").show();
                        $(".earning").hide();
                    }
                    $(".subtopic").css({"background-color": "#fff", "color": "#000"});
                    $("#lyft").css({"background-color": "#d4af37", "color": "#fff"});
				});
				$("#uberEats").on("click", function() {
					if($("#toggle").is(":checked")) {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.uberEats").show();
                    } else {
                        $(".post").hide();
                        $(".post.uberEats").show();
                        $(".earning").hide();
                    }
                    $(".subtopic").css({"background-color": "#fff", "color": "#000"});
                    $("#uberEats").css({"background-color": "#d4af37", "color": "#fff"});
				});
				$("#doorDash").on("click", function() {
					if($("#toggle").is(":checked")) {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.doorDash").show();
                    } else {
                        $(".post").hide();
                        $(".post.doorDash").show();
                        $(".earning").hide();
                    }
                    $(".subtopic").css({"background-color": "#fff", "color": "#000"});
                    $("#doorDash").css({"background-color": "#d4af37", "color": "#fff"});
				});
				$("#postmates").on("click", function() {
					if($("#toggle").is(":checked")) {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.postmates").show();
                    } else {
                        $(".post").hide();
                        $(".post.postmates").show();
                        $(".earning").hide();
                    }
                    $(".subtopic").css({"background-color": "#fff", "color": "#000"});
                    $("#postmates").css({"background-color": "#d4af37", "color": "#fff"});
				});
				$("#grubhub").on("click", function() {
					if($("#toggle").is(":checked")) {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.grubhub").show();
                    } else {
                        $(".post").hide();
                        $(".post.grubhub").show();
                        $(".earning").hide();
                    }
                    $(".subtopic").css({"background-color": "#fff", "color": "#000"});
                    $("#grubhub").css({"background-color": "#d4af37", "color": "#fff"});
				});
            });
            // Posts or Earnings
            $("#toggle").click(function() {
                if($(this).is(":checked")) {
                    $("#headline").removeAttr("required");
                    $("#postsBody").removeAttr("required");
                    $("#chooseMedia").removeAttr("required");
                    $("#image input").removeAttr("required");
                    $("#video textarea").removeAttr("required");
                    $(".posts").hide();
                    $(".earnings").show();
                    if($("#feed").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".earning").show();
                    }
                    else if($("#uber").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.uber").show();
                    }
                    else if($("#lyft").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.lyft").show();
                    }
                    else if($("#uberEats").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.uberEats").show();
                    }
                    else if($("#doorDash").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.doorDash").show();
                    }
                    else if($("#postmates").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.postmates").show();
                    }
                    else if($("#grubhub").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".earning").hide();
                        $(".earning.grubhub").show();
                    }
                } else {
                    $("#earnings").removeAttr("required");
                    $("#gigDates").removeAttr("required");
                    $("#startTime").removeAttr("required");
                    $("#endTime").removeAttr("required");
                    $("#location").removeAttr("required");
                    $(".earnings").hide();
                    $(".posts").show();
                    $("#image input").removeAttr("required");
                    $("#video textarea").removeAttr("required");
                    $(".mediaSelect").hide();
                    $("#chooseMedia").val("none");
                    $("#chooseMedia").change(function() {
                        if($(this).val() === "none") {
                            $("#image input").val("");
                            $("#image input").removeAttr("required");
                            $("#video textarea").val("");
                            $("#video textarea").removeAttr("required");
                            $(".mediaSelect").hide();
                        }
                        else if($(this).val() === "image") {
                            $("#video textarea").val("");
                            $("#video textarea").removeAttr("required");
                            $(".mediaSelect").hide();
                            $("#image input").attr("required", "true");
                            $("#image").show();
                        }
                        else if($(this).val() === "video") {
                            $("#image input").val("");
                            $("#image input").removeAttr("required");
                            $(".mediaSelect").hide();
                            $("#video textarea").attr("required", "true");
                            $("#video").show();
                        }
                    });
                    if($("#feed").css("color") === "rgb(255, 255, 255)") {
                        $(".post").show();
                        $(".earning").hide();
                    }
                    else if($("#uber").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".post.uber").show();
                        $(".earning").hide();
                    }
                    else if($("#lyft").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".post.lyft").show();
                        $(".earning").hide();
                    }
                    else if($("#uberEats").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".post.uberEats").show();
                        $(".earning").hide();
                    }
                    else if($("#doorDash").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".post.doorDash").show();
                        $(".earning").hide();
                    }
                    else if($("#postmates").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".post.postmates").show();
                        $(".earning").hide();
                    }
                    else if($("#grubhub").css("color") === "rgb(255, 255, 255)") {
                        $(".post").hide();
                        $(".post.grubhub").show();
                        $(".earning").hide();
                    }
                }
            });
            var info = new Vue({
  				el: "#postsForm",
  				data: {
                    headline: "",
                    postsBody: "",
                    video: ""
				},
				computed: {
                    headlineCharacterCount() {
						return this.headline.length;
					},
					postsBodyCharacterCount() {
						return this.postsBody.length;
                    },
                    videoCharacterCount() {
						return this.video.length;
					}
                },
                methods: {
					clearMedia: function() {
						this.video = "";
                    }
                }
            });
  			var info = new Vue({
  				el: "#earningsForm",
  				data: {
                    location: "",
                    earningsBody: "",
                    video: ""
				},
				computed: {
                    locationCharacterCount() {
						return this.location.length;
					},
					earningsBodyCharacterCount() {
						return this.earningsBody.length;
                    },
                    videoCharacterCount() {
						return this.video.length;
					}
                }
            });
        </script>
        <script src="js/mogle.js"></script>
    </body>
</html>