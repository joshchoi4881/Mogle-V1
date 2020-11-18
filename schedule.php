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
    }
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Income Stability for Freelancers">
        <meta name="keywords" content="Mogle">
        <meta name="author" content="Josh Choi">
        <title>Mogle</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
        <link rel="stylesheet" type="text/css" href="css/mogle.css"/>
        <!-- Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!-- Axios -->
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
            </div>
            <a href="homepage.php"><img id="logo" src="photos/design/mogle.png" alt="Mogle Logo"/></a>
            <div id="account">
                <a href="logout.php">Logout</a>
            </div>
            <nav>
              <?php
                if($log) {
                    echo "<a href='profile.php'>Profile</a>
                        <a href='search.php'>Search</a>
                        <a id='schedule' href='schedule.php'>Schedule</a>
                        <a href='income.php'>Income</a>
                        <a href='community.php'>Community</a>";
                } else {
                    echo "<a href='homepage.php'>Demo</a>
                        <a href='questionnaire.php'>Questionnaire</a>
                        <a href='search.php'>Search</a>
                        <a id='schedule' href='schedule.php'>Schedule</a>";
                }
              ?>
            </nav>
        </header>
        <section class="center">
            <div class="card">
                <h1>Schedule Demo</h1>
                <p>Fill out your schedule below and we'll give you a quote.</p>
                <p>Location:</p>
                <select id="location">
                    <option value="Kenosha;WI">Kenosha, WI</option>
                    <option value="Hackensack;NJ">Hackensack, NJ</option>
                    <option value="St. Louis;MO">St. Louis, MO</option>
                    <option value="Ellicott City;MD">Ellicott City, MD</option>
                    <option value="North Bethesda;MD">North Bethesda, MD</option>
                    <option value="Baltimore;MD">Baltimore, MD</option>
                    <option value="Catonsville;MD">Catonsville, MD</option>
                    <option value="Los Angeles;CA">Los Angeles, CA</option>
                    <option value="Columbia;MD">Columbia, MD</option>
                </select>
                <br/>
                <div class="scheduleGigs">
                    <button id="UberX" class="gigs btn btn-primary">UberX</button>
                    <button id="Lyft" class="gigs btn btn-secondary" style="display:none;">Lyft</button>
                    <button id="Uber_Eats" class="gigs btn btn-success">Uber Eats</button>
                    <button id="Postmates" class="gigs btn btn-warning" style="display:none;">Postmates</button>
                    <button id="DoorDash" class="gigs btn btn-danger">DoorDash</button>
                    <button id="Grubhub" class="gigs btn btn-info" style="display:none;">Grubhub</button>
                </div>
                </br>
                <button id="clear" class="gigs btn btn-dark" style="width:200px;">Clear</button>
                </br>
                <h3 id="date"></h3>
                <br/>
                <p id="hours"></p>
                <p>Earnings: <span id="earnings"></span></p>
                <p>Premium: <span id="premium"></span></p>
                <table>
                <tr>
                    <th class="block"></th>
                    <th id="sunday" class="block">Sunday</th>
                    <th id="monday" class="block">Monday</th>
                    <th id="tuesday" class="block">Tuesday</th>
                    <th id="wednesday" class="block">Wednesday</th>
                    <th id="thursday" class="block">Thursday</th>
                    <th id="friday" class="block">Friday</th>
                    <th id="saturday" class="block">Saturday</th>
                </tr>
                <tr>
                    <th class="block"></th>
                    <th id="sunday_date" class="block"></th>
                    <th id="monday_date" class="block"></th>
                    <th id="tuesday_date" class="block"></th>
                    <th id="wednesday_date" class="block"></th>
                    <th id="thursday_date" class="block"></th>
                    <th id="friday_date" class="block"></th>
                    <th id="saturday_date" class="block"></th>
                </tr>
                <script>
                    let date = new Date();
                    console.log(date);

                    const month_names = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    const current_month = month_names[date.getMonth()];
                    const current_day = date.getDate();
                    const current_year = date.getFullYear();
                    $("#date").html("Today: " + current_month + " " + current_day + ", " + current_year);
                    let dateFormat = date.getFullYear() + "-"
                    + (date.getMonth()+1) + "-"
                    + date.getDate() + "T"
                    + date.getHours() + ":"
                    + date.getMinutes() + "Z";
                    let first = date.getDate() - date.getDay();
                    console.log("First: ", first);
                    
                    // Sunday
                    let sunday = new Date(date.setDate(first));
                    console.log(sunday);
                    const sunday_month = month_names[sunday.getMonth()].substring(0, 3);
                    const sunday_day = sunday.getDate();
                    const sunday_year = sunday.getFullYear();
                    $("#sunday_date").html(sunday_month + " " + sunday_day + ", " + sunday_year);
                    
                    // Monday
                    date = new Date();
                    let monday = new Date(date.setDate(first + 1));
                    console.log(monday);
                    const monday_month = month_names[monday.getMonth()].substring(0, 3);
                    const monday_day = monday.getDate();
                    const monday_year = monday.getFullYear();
                    $("#monday_date").html(monday_month + " " + monday_day + ", " + monday_year);
                    
                    // Tuesday
                    date = new Date();
                    let tuesday = new Date(date.setDate(first + 2));
                    console.log(tuesday);
                    const tuesday_month = month_names[tuesday.getMonth()].substring(0, 3);
                    const tuesday_day = tuesday.getDate();
                    const tuesday_year = tuesday.getFullYear();
                    $("#tuesday_date").html(tuesday_month + " " + tuesday_day + ", " + tuesday_year);
                    
                    // Wednesday
                    date = new Date();
                    let wednesday = new Date(date.setDate(first + 3));
                    console.log(wednesday);
                    const wednesday_month = month_names[wednesday.getMonth()].substring(0, 3);
                    const wednesday_day = wednesday.getDate();
                    const wednesday_year = wednesday.getFullYear();
                    $("#wednesday_date").html(wednesday_month + " " + wednesday_day + ", " + wednesday_year);
                    
                    // Thursday
                    date = new Date();
                    let thursday = new Date(date.setDate(first + 4));
                    console.log(thursday);
                    const thursday_month = month_names[thursday.getMonth()].substring(0, 3);
                    const thursday_day = thursday.getDate();
                    const thursday_year = thursday.getFullYear();
                    $("#thursday_date").html(thursday_month + " " + thursday_day + ", " + thursday_year);
                    
                    // Friday
                    date = new Date();
                    let friday = new Date(date.setDate(first + 5));
                    console.log(friday);
                    const friday_month = month_names[friday.getMonth()].substring(0, 3);
                    const friday_day = friday.getDate();
                    const friday_year = friday.getFullYear();
                    $("#friday_date").html(friday_month + " " + friday_day + ", " + friday_year);
                    
                    // Saturday
                    date = new Date();
                    let saturday = new Date(date.setDate(first + 6));
                    console.log(saturday);
                    const saturday_month = month_names[saturday.getMonth()].substring(0, 3);
                    const saturday_day = saturday.getDate();
                    const saturday_year = saturday.getFullYear();
                    $("#saturday_date").html(saturday_month + " " + saturday_day + ", " + saturday_year);
                    
                    // Next Sunday
                    date = new Date();
                    let nextSunday = new Date(date.setDate(first + 7));
                    sunday = sunday.getFullYear() + "-"
                    + (sunday.getMonth()+1) + "-"
                    + sunday.getDate() + "T";
                    monday = monday.getFullYear() + "-"
                    + (monday.getMonth()+1) + "-"
                    + monday.getDate() + "T";
                    tuesday = tuesday.getFullYear() + "-"
                    + (tuesday.getMonth()+1) + "-"
                    + tuesday.getDate() + "T";
                    wednesday = wednesday.getFullYear() + "-"
                    + (wednesday.getMonth()+1) + "-"
                    + wednesday.getDate() + "T";
                    thursday = thursday.getFullYear() + "-"
                    + (thursday.getMonth()+1) + "-"
                    + thursday.getDate() + "T";
                    friday = friday.getFullYear() + "-"
                    + (friday.getMonth()+1) + "-"
                    + friday.getDate() + "T";
                    saturday = saturday.getFullYear() + "-"
                    + (saturday.getMonth()+1) + "-"
                    + saturday.getDate() + "T";
                    nextSunday = nextSunday.getFullYear() + "-"
                    + (nextSunday.getMonth()+1) + "-"
                    + nextSunday.getDate() + "T";
                </script>
                <tr>
                    <td class="block">12:00 AM</td>
                    <td id="sunday+00" class="block cell"></td>
                    <td id="monday+00" class="block cell"></td>
                    <td id="tuesday+00" class="block cell"></td>
                    <td id="wednesday+00" class="block cell"></td>
                    <td id="thursday+00" class="block cell"></td>
                    <td id="friday+00" class="block cell"></td>
                    <td id="saturday+00" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">1:00 AM</td>
                    <td id="sunday+01" class="block cell"></td>
                    <td id="monday+01" class="block cell"></td>
                    <td id="tuesday+01" class="block cell"></td>
                    <td id="wednesday+01" class="block cell"></td>
                    <td id="thursday+01" class="block cell"></td>
                    <td id="friday+01" class="block cell"></td>
                    <td id="saturday+01" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">2:00 AM</td>
                    <td id="sunday+02" class="block cell"></td>
                    <td id="monday+02" class="block cell"></td>
                    <td id="tuesday+02" class="block cell"></td>
                    <td id="wednesday+02" class="block cell"></td>
                    <td id="thursday+02" class="block cell"></td>
                    <td id="friday+02" class="block cell"></td>
                    <td id="saturday+02" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">3:00 AM</td>
                    <td id="sunday+03" class="block cell"></td>
                    <td id="monday+03" class="block cell"></td>
                    <td id="tuesday+03" class="block cell"></td>
                    <td id="wednesday+03" class="block cell"></td>
                    <td id="thursday+03" class="block cell"></td>
                    <td id="friday+03" class="block cell"></td>
                    <td id="saturday+03" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">4:00 AM</td>
                    <td id="sunday+04" class="block cell"></td>
                    <td id="monday+04" class="block cell"></td>
                    <td id="tuesday+04" class="block cell"></td>
                    <td id="wednesday+04" class="block cell"></td>
                    <td id="thursday+04" class="block cell"></td>
                    <td id="friday+04" class="block cell"></td>
                    <td id="saturday+04" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">5:00 AM</td>
                    <td id="sunday+05" class="block cell"></td>
                    <td id="monday+05" class="block cell"></td>
                    <td id="tuesday+05" class="block cell"></td>
                    <td id="wednesday+05" class="block cell"></td>
                    <td id="thursday+05" class="block cell"></td>
                    <td id="friday+05" class="block cell"></td>
                    <td id="saturday+05" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">6:00 AM</td>
                    <td id="sunday+06" class="block cell"></td>
                    <td id="monday+06" class="block cell"></td>
                    <td id="tuesday+06" class="block cell"></td>
                    <td id="wednesday+06" class="block cell"></td>
                    <td id="thursday+06" class="block cell"></td>
                    <td id="friday+06" class="block cell"></td>
                    <td id="saturday+06" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">7:00 AM</td>
                    <td id="sunday+07" class="block cell" ></td>
                    <td id="monday+07" class="block cell"></td>
                    <td id="tuesday+07" class="block cell"></td>
                    <td id="wednesday+07" class="block cell"></td>
                    <td id="thursday+07" class="block cell"></td>
                    <td id="friday+07" class="block cell"></td>
                    <td id="saturday+07" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">8:00 AM</td>
                    <td id="sunday+08" class="block cell" ></td>
                    <td id="monday+08" class="block cell"></td>
                    <td id="tuesday+08" class="block cell"></td>
                    <td id="wednesday+08" class="block cell"></td>
                    <td id="thursday+08" class="block cell"></td>
                    <td id="friday+08" class="block cell"></td>
                    <td id="saturday+08" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">9:00 AM</td>
                    <td id="sunday+09" class="block cell" ></td>
                    <td id="monday+09" class="block cell"></td>
                    <td id="tuesday+09" class="block cell"></td>
                    <td id="wednesday+09" class="block cell"></td>
                    <td id="thursday+09" class="block cell"></td>
                    <td id="friday+09" class="block cell"></td>
                    <td id="saturday+09" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">10:00 AM</td>
                    <td id="sunday+10" class="block cell" ></td>
                    <td id="monday+10" class="block cell"></td>
                    <td id="tuesday+10" class="block cell"></td>
                    <td id="wednesday+10" class="block cell"></td>
                    <td id="thursday+10" class="block cell"></td>
                    <td id="friday+10" class="block cell"></td>
                    <td id="saturday+10" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">11:00 AM</td>
                    <td id="sunday+11" class="block cell" ></td>
                    <td id="monday+11" class="block cell"></td>
                    <td id="tuesday+11" class="block cell"></td>
                    <td id="wednesday+11" class="block cell"></td>
                    <td id="thursday+11" class="block cell"></td>
                    <td id="friday+11" class="block cell"></td>
                    <td id="saturday+11" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">12:00 PM</td>
                    <td id="sunday+12" class="block cell" ></td>
                    <td id="monday+12" class="block cell"></td>
                    <td id="tuesday+12" class="block cell"></td>
                    <td id="wednesday+12" class="block cell"></td>
                    <td id="thursday+12" class="block cell"></td>
                    <td id="friday+12" class="block cell"></td>
                    <td id="saturday+12" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">1:00 PM</td>
                    <td id="sunday+13" class="block cell" ></td>
                    <td id="monday+13" class="block cell"></td>
                    <td id="tuesday+13" class="block cell"></td>
                    <td id="wednesday+13" class="block cell"></td>
                    <td id="thursday+13" class="block cell"></td>
                    <td id="friday+13" class="block cell"></td>
                    <td id="saturday+13" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">2:00 PM</td>
                    <td id="sunday+14" class="block cell" ></td>
                    <td id="monday+14" class="block cell"></td>
                    <td id="tuesday+14" class="block cell"></td>
                    <td id="wednesday+14" class="block cell"></td>
                    <td id="thursday+14" class="block cell"></td>
                    <td id="friday+14" class="block cell"></td>
                    <td id="saturday+14" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">3:00 PM</td>
                    <td id="sunday+15" class="block cell" ></td>
                    <td id="monday+15" class="block cell"></td>
                    <td id="tuesday+15" class="block cell"></td>
                    <td id="wednesday+15" class="block cell"></td>
                    <td id="thursday+15" class="block cell"></td>
                    <td id="friday+15" class="block cell"></td>
                    <td id="saturday+15" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">4:00 PM</td>
                    <td id="sunday+16" class="block cell" ></td>
                    <td id="monday+16" class="block cell"></td>
                    <td id="tuesday+16" class="block cell"></td>
                    <td id="wednesday+16" class="block cell"></td>
                    <td id="thursday+16" class="block cell"></td>
                    <td id="friday+16" class="block cell"></td>
                    <td id="saturday+16" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">5:00 PM</td>
                    <td id="sunday+17" class="block cell" ></td>
                    <td id="monday+17" class="block cell"></td>
                    <td id="tuesday+17" class="block cell"></td>
                    <td id="wednesday+17" class="block cell"></td>
                    <td id="thursday+17" class="block cell"></td>
                    <td id="friday+17" class="block cell"></td>
                    <td id="saturday+17" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">6:00 PM</td>
                    <td id="sunday+18" class="block cell" ></td>
                    <td id="monday+18" class="block cell"></td>
                    <td id="tuesday+18" class="block cell"></td>
                    <td id="wednesday+18" class="block cell"></td>
                    <td id="thursday+18" class="block cell"></td>
                    <td id="friday+18" class="block cell"></td>
                    <td id="saturday+18" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">7:00 PM</td>
                    <td id="sunday+19" class="block cell" ></td>
                    <td id="monday+19" class="block cell"></td>
                    <td id="tuesday+19" class="block cell"></td>
                    <td id="wednesday+19" class="block cell"></td>
                    <td id="thursday+19" class="block cell"></td>
                    <td id="friday+19" class="block cell"></td>
                    <td id="saturday+19" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">8:00 PM</td>
                    <td id="sunday+20" class="block cell" ></td>
                    <td id="monday+20" class="block cell"></td>
                    <td id="tuesday+20" class="block cell"></td>
                    <td id="wednesday+20" class="block cell"></td>
                    <td id="thursday+20" class="block cell"></td>
                    <td id="friday+20" class="block cell"></td>
                    <td id="saturday+20" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">9:00 PM</td>
                    <td id="sunday+21" class="block cell" ></td>
                    <td id="monday+21" class="block cell"></td>
                    <td id="tuesday+21" class="block cell"></td>
                    <td id="wednesday+21" class="block cell"></td>
                    <td id="thursday+21" class="block cell"></td>
                    <td id="friday+21" class="block cell"></td>
                    <td id="saturday+21" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">10:00 PM</td>
                    <td id="sunday+22" class="block cell" ></td>
                    <td id="monday+22" class="block cell"></td>
                    <td id="tuesday+22" class="block cell"></td>
                    <td id="wednesday+22" class="block cell"></td>
                    <td id="thursday+22" class="block cell"></td>
                    <td id="friday+22" class="block cell"></td>
                    <td id="saturday+22" class="block cell"></td>
                </tr>
                <tr>
                    <td class="block">11:00 PM</td>
                    <td id="sunday+23" class="block cell" ></td>
                    <td id="monday+23" class="block cell"></td>
                    <td id="tuesday+23" class="block cell"></td>
                    <td id="wednesday+23" class="block cell"></td>
                    <td id="thursday+23" class="block cell"></td>
                    <td id="friday+23" class="block cell"></td>
                    <td id="saturday+23" class="block cell"></td>
                </tr>
                </table>
                <br/>
                <br/>
            </div>
        </section>
        <script src="js/mogle.js"></script>
        <script src="js/mogle/schedule.js"></script>
    </body>
</html>