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
            if(Database::query("SELECT username FROM users WHERE id=:id", array(":id"=>$userId))) {
                $user = Database::query("SELECT * FROM users WHERE id=:id", array(":id"=>$userId));
            }
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
        <link rel="stylesheet" type="text/css" href="css/stripe/charge.css"/>
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
        <!-- Stripe -->
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body>
        <header>
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
                <a id="income" href="income.php">Income</a>
                <a href="community.php">Community</a>
            </nav>
        </header>
        <section>
            <div id="linkBankAccount">
                <form action="charge.php" method="post" id="payment-form">
                  <div class="form-row">
                    <input type="text" name="userId" value="<?php echo $userId; ?>" hidden/>
                    <label for="card-element">
                      Credit or debit card
                    </label>
                    <div id="card-element" class="form-control">
                      <!-- A Stripe Element will be inserted here. -->
                    </div>
                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                  </div>
                  <button>Submit Payment</button>
                </form>
            </div>
        </section>
        <script>
            $(function() {
              $("#income").css({"background-color": "#800000", "color": "#fff"});
            });
        </script>
        <script src="js/mogle.js"></script>
        <script src="js/stripe/charge.js"></script>
    </body>
</html>