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
        <meta name="description" content="Maximizing Human Capital in the Gig Economy">
        <meta name="keywords" content="Mogle, Gig Economy, Human Capital">
        <meta name="author" content="Josh Choi">
        <title>Mogle</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
        <link rel="stylesheet" type="text/css" href="css/mogle.css"/>
        <link rel="stylesheet" type="text/css" href="css/yourGigs.css"/>
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
                <?php
                    if($log) {
                        echo "<a href='logout.php'>Logout</a>";
                    } else {
                        echo "<a href='signUp.php'>Sign Up</a>
                            <a href='login.php'>Login</a>";
                    }
                ?>
            </div>
            <nav>
                <?php
                    if($log) {
                        echo "<a id='profile' href='profile.php'>Profile</a>
                            <a href='search.php'>Search</a>
                            <a href='schedule.php'>Schedule</a>
                            <a href='income.php'>Income</a>
                            <a href='community.php'>Community</a>";
                    } else {
                        echo "<a href='homepage.php'>Demo</a>
                            <a id='questionnaire' href='questionnaire.php'>Questionnaire</a>
                            <a href='search.php'>Search</a>
                            <a href='schedule.php'>Schedule</a>";
                    }
                ?>
            </nav>
        </header>
        <section class="center">
            <!-- Subcategories -->
            <?php
                if($log) {
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
                    </div>
                    <br/>';
                }
            ?>
            <!-- Questionnaire -->
            <?php
                if($log) {
                    echo '<div id="yourGigs">
                        <h1>Your Gigs</h1>';
                    if(Database::query("SELECT userId FROM gigs WHERE userId=:userId", array(":userId"=>$userId))) {
                        $gigs = Database::query("SELECT gig FROM gigs WHERE userId=:userId", array(":userId"=>$userId));
                        foreach($gigs as $g) {
                            echo "<div class='gigDiv'>
                                    <p>".$g["gig"]."</p>";
                            if(!Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>$g["gig"]))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            echo "<button class='btn ".$btn." ".$g["gig"]."' onclick=\"addOrRemove(".$userId.", '".$g["gig"]."')\">".$text."</button>
                                </div>
                                <br/>
                                <script>
                                    $('#yourGigs .".$g["gig"]."').click(function() {
                                        $('.".$g["gig"]."').toggleClass('btn-primary');
                                        $('.".$g["gig"]."').toggleClass('btn-danger');
                                        if($('.".$g["gig"]."').hasClass('btn-primary')) {
                                            $('.".$g["gig"]."').html('Add');
                                        } else {
                                            $('.".$g["gig"]."').html('Remove');
                                        }
                                    });
                                </script>";
                        }
                        echo "<br/>";
                    }
                    echo '</div>';
                }
            ?>
            <br/>
            <br/>
            <div id="questionnaire">
                <div class="card">
                    <h1>Questionnaire Demo</h1>
                    <p>Learn which platforms you can use to start earning income:</p>
                    <div id="skills">
                        <input id="COVID-19" type="checkbox" value="COVID-19"/> COVID-19 Filter*
                        <br/>
                        <strong style="color:maroon;">*This filter only eliminates the most obvious contact-based opportunities (like massage therapy)
                        and services greatly affected by the COVID-19 outbreak (like rideshare). This filter is not a guarantee that
                        the opportunities listed with the COVID-19 Filter will present zero risk for contracting COVID-19. Please
                        do your own research and use your own discretion in choosing opportunities. Most importantly, stay safe and
                        put the health of you, your loved ones, and your community above all else.</strong>
                        <br/>
                        <br/>
                        <h2>Skills</h2>
                        <div id="skillSelect">
                            <h3>What skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <input id="driving" type="checkbox" name="skillSelect[]" value="Driving"/> Driving
                                <br/>
                                <input id="labor" type="checkbox" name="skillSelect[]" value="Labor"/> Labor
                                <br/>
                                <div id="careDiv">
                                    <input id="care" type="checkbox" name="skillSelect[]" value="Care"/> Care
                                </div>
                                <br/>
                                <div id="massageDiv">
                                    <input id="massage" type="checkbox" name="skillSelect[]" value="Massage"/> Massage
                                </div>
                                <br/>
                                <input id="language" type="checkbox" name="skillSelect[]" value="Language"/> Language
                                <br/>
                                <input id="writing" type="checkbox" name="skillSelect[]" value="Writing"/> Writing
                                <br/>
                                <input id="art" type="checkbox" name="skillSelect[]" value="Art"/> Art
                                <br/>
                                <input id="music" type="checkbox" name="skillSelect[]" value="Music"/> Music
                                <br/>
                                <input id="finance" type="checkbox" name="skillSelect[]" value="Finance"/> Finance
                                <br/>
                                <input id="tech" type="checkbox" name="skillSelect[]" value="Tech"/> Tech
                                <br/>
                                <input id="engineering" type="checkbox" name="skillSelect[]" value="Engineering"/> Engineering
                                <br/>
                                <input id="business" type="checkbox" name="skillSelect[]" value="Business"/> Business
                                <br/>
                                <input id="legal" type="checkbox" name="skillSelect[]" value="Legal"/> Legal
                            </div>
                        </div>
                        <br/>
                        <div id="specificDriving" class="specificSkills">
                            <h3>Which driving skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- Rideshare -->
                                    <!-- Uber -->
                                    <!-- Lyft -->
                                    <!-- HopSkipDrive -->
                                <div id="rideshareDiv">
                                    <input id="RideshareOption" type="checkbox" name="driving[]" value="Rideshare"/> Rideshare
                                </div>
                                <br/>
                                <!-- Delivery -->
                                    <!-- AmazonDelivers.Jobs -->
                                    <!-- Amazon Flex -->
                                    <!-- Dolly -->
                                <input id="DeliveryOption" type="checkbox" name="driving[]" value="Delivery"/> Delivery
                                <br/>
                                <!-- Food Delivery -->
                                    <!-- Uber Eats -->
                                    <!-- Grubhub -->
                                    <!-- DoorDash -->
                                    <!-- Caviar -->
                                    <!-- Postmates -->
                                    <!-- Waitr -->
                                    <!-- Bite Squad -->
                                    <!-- Favor -->
                                    <!-- Food Dudes -->
                                    <!-- Foodjets -->
                                <input id="FoodDeliveryOption" type="checkbox" name="driving[]" value="FoodDelivery"/> Food Delivery
                                <br/>
                                <!-- Grocery Delivery -->
                                    <!-- AmazonDelivers.Jobs -->
                                    <!-- Amazon Flex -->
                                    <!-- Instacart -->
                                    <!-- Shipt -->
                                    <!-- Grocery Chimps -->
                                <input id="GroceryDeliveryOption" type="checkbox" name="driving[]" value="GroceryDelivery"/> Grocery Delivery
                            </div>
                        </div>
                        <br/>
                        <div id="specificLabor" class="specificSkills">
                            <h3>What labor skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- AmazonDelivers.Jobs -->
                                <input id="AmazonDeliversWarehouseOption" type="checkbox" name="labor[]" value="AmazonDelivers"/> Warehouse
                                <br/>
                                <!-- Dolly -->
                                <input id="DollyHandsOption" type="checkbox" name="labor[]" value="Dolly"/> Moving
                                <br/>
                                <!-- TaskEasy -->
                                <input id="TaskEasyOption" type="checkbox" name="labor[]" value="TaskEasy"/> Lawn Care
                                <br/>
                                <!-- Handy -->
                                <div id="HandyDiv">
                                    <input id="HandyOption" type="checkbox" name="labor[]" value="Handy"/> Cleaner / Electrician /
                                    Garage Door Installation / Handyman / Home Improvement / Lawn Care / Plumber / Pool Services /
                                    Smart Home / Technology Services
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div id="specificCare" class="specificSkills">
                            <h3>What care skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- Wag -->
                                <input id="WagOption" type="checkbox" name="care[]" value="Wag"/> For Dogs: Walking / Sitting /
                                Boarding / Daycare / Drop-In
                                <br/>
                                <!-- Rover -->
                                <input id="RoverOption" type="checkbox" name="care[]" value="Rover"/> For Dogs and Cats: Dog Boarding /
                                House Sitting / Drop-In Visits / Doggy Daycare / Dog Walking
                                <br/>
                                <!-- Care -->
                                <input id="CareOption" type="checkbox" name="care[]" value="Care"/> Babysitter or Nanny / Special Needs
                                / Tutor and Private / Child Care Center / Senior Care and Nursing / Housekeeping
                                / In Home Day Care / Pet Care / Errands and Odd Jobs
                            </div>
                        </div>
                        <br/>
                        <div id="specificMassage" class="specificSkills">
                            <h3>What massage skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- Zeel -->
                                <input id="ZeelOption" type="checkbox" name="massage[]" value="Zeel"/> Esthetics / Massage Therapist /
                                Mindfulness / Personal Training / Yoga (w/ Yoga Alliance)
                            </div>
                        </div>
                        <br/>
                        <div id="specificLanguage" class="specificSkills">
                            <h3>What language skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- Freelancer -->
                                <input id="LanguageFreelancerOption" type="checkbox" name="writing[]" value="Freelancer"/> Translation & Languages
                                <br/>
                                <!-- Translate -->
                                <input id="TranslateOption" type="checkbox" name="writing[]" value="Translate"/> Translation
                                <br/>
                                <!-- Italki -->
                                <input id="ItalkiOption" type="checkbox" name="writing[]" value="Italki"/> Teaching & Tutoring
                            </div>
                        </div>
                        <br/>
                        <div id="specificWriting" class="specificSkills">
                            <h3>What writing skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- Freelancer -->
                                <input id="WritingFreelancerOption" type="checkbox" name="writing[]" value="Freelancer"/> Writing & Content
                                <br/>
                                <!-- Upwork -->
                                <input id="WritingUpworkOption" type="checkbox" name="writing[]" value="Upwork"/> Writing  
                                (Academic Writing & Research / Article & Blog Writing / Copywriting / Creative Writing /
                                Editing & Proofreading / Grant Writing / Other - Writing / Resumes & Cover Letters /
                                Technical Writing / Web Content)
                                <br/>
                                <!-- Fiverr -->
                                <input id="WritingFiverrOption" type="checkbox" name="writing[]" value="Fiverr"/> Writing & Translation 
                                (Articles & Blog Posts / Resume Writing / Proofreading & Editing / Brand Voice & Tone /
                                Technical Writing / Cover Letters / LinkedIn Profiles / Translation /
                                White Papers / UX Writing / Podcast Writing / Case Studies / Grant Writing /
                                Social Media Copy / Press Releases / Research & Summaries / Transcripts /
                                Legal Writing / Product Descriptions / Website Content / Business Names & Slogans /
                                Scriptwriting / Book & eBook Writing / Email Copy / Speechwriting /
                                Creative Writing / Beta Reading / Other)
                            </div>
                        </div>
                        <br/>
                        <div id="specificArt" class="specificSkills">
                            <h3>What art skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- Fiverr -->
                                <input id="ArtGraphicsFiverrOption" type="checkbox" name="art[]" value="Fiverr"/> Graphics & Design 
                                (Logo Design / Brand Style Guides / Game Design / Graphics for Streamers /
                                Business Cards & Stationery / Illustration / Brochure Design / Poster Design /
                                Flyer Design / Book Design / Podcast Cover Art / Packaging Design / Storyboards /
                                Web & Mobile Design / Social Media Design / Postcard Design / Catalog Design /
                                Menu Design / Invitation Design / Portraits & Caricatures / Cartoons & Comics /
                                Tattoo Design / Banner Ads / Photoshop Editing / Architecture & Interior Design /
                                Landscape Design / Building Information Modeling / Character Modeling / 3D Model
                                & Product Design / T-Shirts & Merchandise / Presentation Design / Infographic Design /
                                Car Wraps / Vector Tracing / Twitch Store / Other)
                                <br/>
                                <!-- Fiverr -->
                                <input id="ArtVideoFiverrOption" type="checkbox" name="art[]" value="Fiverr"/> Video & Animation
                                (Whiteboard & Animated Explainers / Video Editing / Short Video Ads / Animated GIFs /
                                Logo Animation / Intros & Outros / App & Website Previews / Live Action Explainers /
                                Character Animation / 3D Product Animation / Lyric & Music Videos / Spokespersons Videos /
                                Subtitles & Captions / Visual Effects / Animation for Kids / Slideshows Videos /
                                Game Trailers / Book Trailers / Animation for Streamers / Product Photography /
                                Local Photography / Other)
                                <br/>
                                <!-- Etsy -->
                                <input id="EtsyOption" type="checkbox" name="art[]" value="Etsy"/> Crafts & E-commerce
                            </div>
                        </div>
                        <br/>
                        <div id="specificMusic" class="specificSkills">
                            <h3>What music skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- BeatStars -->
                                <input id="BeatStarsOption" type="checkbox" name="music[]" value="BeatStars"/> Beat Production
                                <br/>
                                <!-- Fiverr -->
                                <input id="MusicFiverrOption" type="checkbox" name="music[]" value="Fiverr"/> Music & Audio
                                (Voice Over / Mixing & Mastering / Producers & Composers / Singers & Vocalists /
                                Session Musicians / Songwriters / Podcast Editing / Audiobook Production /
                                Audio Ads Production / DJ Drops & Tags / Dialogue Editing / Music Transcription /
                                Vocal Tuning / Jingles & Intros / Sound Effects / Other)
                                <!-- GigFinesse -->
                                <div id="GigFinesseDiv">
                                    <input id="GigFinesseOption" type="checkbox" name="music[]" value="GigFinesse"/> Live Music Gigs
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div id="specificFinance" class="specificSkills">
                            <h3>What finance skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- Upwork -->
                                <input id="FinanceUpworkOption" type="checkbox" name="finance[]" value="Upwork"/> Accounting & Consulting 
                                (Accounting / Financial Planning / Human Resources / Management Consulting / Other - Accounting & Consulting)
                                <br/>
                                <!-- Graphite -->
                                <input id="GraphiteOption" type="checkbox" name="finance[]" value="Graphite"/> Investment Banking / Management Consulting
                                / Investment Management (e.g. Private Equity/Hedge Fund) / Marketing / Venture Capital/Entrepreneurship
                                / Corporate Development
                            </div>
                        </div>
                        <br/>
                        <div id="specificTech" class="specificSkills">
                            <h3>What tech skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- Freelancer -->
                                <input id="WebFreelancerOption" type="checkbox" name="tech[]" value="Freelancer"/> Websites, IT & Software
                                <br/>
                                <!-- Freelancer -->
                                <input id="MobileFreelancerOption" type="checkbox" name="tech[]" value="Freelancer"/> Mobile Phones & Computing
                                <br/>
                                <!-- Upwork -->
                                <input id="ITUpworkOption" type="checkbox" name="tech[]" value="Upwork"/> IT & Networking
                                (Database Administration / ERP/CRM Software / Information Security / Network & System Administration /
                                Other - IT & Networking)
                                <br/>
                                <!-- Upwork -->
                                <input id="WebUpworkOption" type="checkbox" name="tech[]" value="Upwork"/> Web, Mobile & Software Dev
                                (Desktop Software Development / E-commerce Development / Game Development / Mobile Development /
                                Other - Software Development / Product Management / QA & Testing / Scripts & Utilities / Web & Mobile Design / 
                                Web Development)
                                <br/>
                                <!-- Upwork -->
                                <input id="DataUpworkOption" type="checkbox" name="tech[]" value="Upwork"/> Data Science & Analytics
                                (A/B Testing / Data Extraction/ETL / Data Mining & Management / Data Visualization /
                                Machine Learning / Other - Data Science & Analytics / Quantitative Analysis)
                                <br/>
                                <!-- Fiverr -->
                                <input id="TechFiverrOption" type="checkbox" name="tech[]" value="Fiverr"/> Tech
                                (WordPress / Website Builders & CMS / Game Development / Web Programming /
                                E-Commerce Development / Mobile Apps / Desktop Applications / Support & IT /
                                Chatbots / Cybersecurity & Data Protection / Data Analysis & Reports / Convert Files /
                                Databases / User Testing / QA / Other)
                            </div>
                        </div>
                        <br/>
                        <div id="specificEngineering" class="specificSkills">
                            <h3>What engineering skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- Freelancer -->
                                <input id="EngineeringFreelancerOption" type="checkbox" name="tech[]" value="Freelancer"/> Engineering & Science
                                <br/>
                                <!-- Upwork -->
                                <input id="EngineeringUpworkOption" type="checkbox" name="tech[]" value="Upwork"/> Engineering & Architecture 
                                (3D Modeling & CAD, Architecture, Chemical Engineering, Civil & Structural Engineering, Contract Manufacturing,
                                Electrical Engineering, Interior Design, Mechanical Engineering, Other - Engineering & Architecture,
                                Product Design)
                            </div>
                        </div>
                        <br/>
                        <div id="specificBusiness" class="specificSkills">
                            <h3>What business skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- Freelancer -->
                                <input id="SalesFreelancerOption" type="checkbox" name="business[]" value="Freelancer"/> Sales & Marketing
                                <br/>
                                <!-- Freelancer -->
                                <input id="BusinessFreelancerOption" type="checkbox" name="business[]" value="Freelancer"/> Business, Accounting, Human Resources & Legal
                                <br/>
                                <!-- Upwork -->
                                <input id="SalesUpworkOption" type="checkbox" name="business[]" value="Upwork"/> Sales & Marketing
                                (Display Advertising / Email & Marketing Automation / Lead Generation / Market & Customer Research / 
                                Marketing Strategy / Other - Sales & Marketing / Public Relations / SEM - Search Engine Marketing / 
                                SEO - Search Engine Optimization / SMM - Social Media Marketing / Telemarketing & Telesales)
                                <br/>
                                <!-- Fiverr -->
                                <input id="MarketingFiverrOption" type="checkbox" name="business[]" value="Fiverr"/> Digital Marketing
                                (Social Media Marketing / SEO / Social Media Advertising / Public Relations / Content Marketing / Podcast Marketing / 
                                Video Marketing / Email Marketing / Crowdfunding / SEM / Marketing Strategy / Surveys / Web Analytics / 
                                Influencer Marketing / Local SEO / Domain Research / E-Commerce Marketing / Mobile Marketing & Advertising /
                                Music Promotion / Web Traffic / Other)
                                <br/>
                                <!-- Fiverr -->
                                <input id="BusinessFiverrOption" type="checkbox" name="business[]" value="Fiverr"/> Business
                                (Virtual Assistant / Data Entry / Market Research / Product Research /
                                Business Plans / Project Management / HR Consulting / Branding Services /
                                Legal Consulting / Financial Consulting / Business Consulting / Presentations /
                                Career Advice / Flyer Distribution / Lead Generation / Other)
                            </div>
                        </div>
                        <div id="specificLegal" class="specificSkills">
                            <h3>What legal skills do you have?</h3>
                            <br/>
                            <div class="left">
                                <!-- Upwork -->
                                <input id="LegalUpworkOption" type="checkbox" name="business[]" value="Upwork"/> Legal 
                                (Contract Law / Corporate Law / Criminal Law / Family Law / Intellectual Property Law / Other - Legal / 
                                Paralegal Services)
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div id="assets">
                        <h2>Assets</h2>
                        <div id="assetSelect">
                            <h3>What assets would you be willing to rent?</h3>
                            <br/>
                            <div class="left">
                                <!-- Turo -->
                                <!-- Getaround -->
                                <input id="AssetCarOption" type="checkbox" name="assetSelect[]" value="Car"/> Car
                                <br/>
                                <!-- Airbnb -->
                                <input id="AirbnbOption" type="checkbox" name="assetSelect[]" value="House"/> House
                            </div>
                        </div>
                    </div>
                    <br/>
                    <h5 style="color:#d4af37;">Scroll down after selecting your skills to see the platforms that match your skills</h5>
                    <h6 style="color:#d4af37;">Click the links (titles of the platforms) to apply</h6>
                </div>
                <div id="rideshareCards">
                    <div class="card questionnaire gig UberCard">
                        <h1><a href="https://www.uber.com/us/en/drive/" target="_blank">Uber</a></h1>
                        <h3>Rideshare</h3>
                        <div class="left">
                            <p>Hourly Wage: In our 2020 RIDES Survey, we found that Uber drivers across all service levels
                            experienced a 31.4% increase in earnings for a total of $19.36 per hour when base rate, tips,
                            and Uber bonuses were factored in.
                            (<a href="https://www.ridester.com/how-much-do-uber-drivers-make/#5" target="_blank">Source</a>)
                            <br/>
                            <a href="https://gridwise.io/how-much-do-rideshare-drivers-make#section1" target="_blank">Find the hourly wage for your specific city here</a></p>
                            <p>Required:</p>
                            <ul>
                                <li>Background Check</li>
                                <li>Driver’s License</li>
                                <li>Vehicle Information</li>
                                <li>Vehicle Insurance</li>
                                <li>Vehicle Registration</li>
                                <li>VA/MD/PA State Inspection Certificate</li>
                                <li>Profile Photo</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Uber"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Uber' class='btn ".$btn." Uber' onclick=\"addOrRemove(".$userId.", 'Uber')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig LyftCard">
                        <h1><a href="https://www.lyft.com/driver" target="_blank">Lyft</a></h1>
                        <h3>Rideshare</h3>
                        <div class="left">
                            <p>Hourly Wage: "On average, Lyft drivers make about $17.50 an hour!"
                            (<a href="https://rideshareapps.com/how-much-do-lyft-drivers-make/" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Aged 21 or older with 1+ years U.S license</li>
                                <li>Valid personal auto insurance that meets or exceeds state requirements</li>
                                <li>No more than 3 moving violations in the past 3 years</li>
                                <li>No major violations in the past 3 years</li>
                                <li>No DUIs or drug-related driving offenses in the last 7 years</li>
                                <li>No extreme infractions in the last 7 years</li>
                                <li><a href="https://www.rideshareconsulting.com/aarp/how-to-apply-to-be-a-lyft-driver/" target="_blank">Source</a></li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Lyft"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Lyft' class='btn ".$btn." Lyft' onclick=\"addOrRemove(".$userId.", 'Lyft')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig HopSkipDriveCard">
                        <h1><a href="https://www.hopskipdrive.com/driver-sign-up" target="_blank">HopSkipDrive</a></h1>
                        <h3>Rideshare</h3>
                        <div class="left">
                            <p>Hourly Wage: "About $14-$18 hourly"
                            (<a href="https://www.glassdoor.com/Salary/HopSkipDrive-Salaries-E1353826.htm" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Must be at least 23 years old</li>
                                <li>Driver’s License</li>
                                <li>More than 1 year experience driving</li>
                                <li>4-door vehicle that is 2010 or newer</li>
                                <li>Cannot have been convicted of a major moving violation (DUI, Hit & Run, Reckless driving) in the last 7 years</li>
                                <li>Smartphone</li>
                                <li>Criminal Background Check and Motor Vehicle Report Check</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"HopSkipDrive"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='HopSkipDrive' class='btn ".$btn." HopSkipDrive' onclick=\"addOrRemove(".$userId.", 'HopSkipDrive')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="deliveryCards">
                    <div class="card questionnaire gig AmazonDeliversDeliveryCard">
                        <h1><a href="https://www.amazondelivers.jobs/about/driver-jobs/" target="_blank">AmazonDelivers.Jobs</a></h1>
                        <h3>Package Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: Claims their deliverers earn up to $17/hr (Plus an added $2/hr through April)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Depends on the job</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"AmazonDelivers"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='AmazonDelivers' class='btn ".$btn." AmazonDelivers' onclick=\"addOrRemove(".$userId.", 'AmazonDelivers')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig AmazonFlexDeliveryCard">
                        <h1><a href="https://flex.amazon.com/get-started" target="_blank">Amazon Flex</a></h1>
                        <h3>Package and/or Store Orders Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: "Most delivery partners earn $18 - $25 per hour delivering with Amazon Flex. 
                            Actual earnings will depend on your location, any tips you receive, how long it takes 
                            you to complete your deliveries, and other factors."
                            (<a href="https://flex.amazon.com/faqs" target="_blank">Source</a>)</p>
                            <p>"Amazon.com: Pick up packages from an Amazon delivery station and deliver directly to customers. 
                            Delivery blocks are typically 3-6 hours."
                            <br/>
                            <br/>
                            "Store Orders: Pick up orders from local stores and deliver directly to customers. Delivery blocks are 
                            typically 2-4 hours."
                            (<a href="https://flex.amazon.com/faqs" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Only available in certain cities (Check on the website)</li>
                                <li>Smartphone</li>
                                <li>"If you are delivering Amazon.com orders, you'll need to use a 4-door, mid-sized 
                                sedan or larger vehicle, such as a truck with a covered bed, SUV, or a van. 
                                Smaller cars and trucks with open beds do not qualify. Motorcycles, motorized bicycles, 
                                and motorized scooters do not qualify at this time."</li>
                                <li>"As a delivery partner, you must maintain the required insurance for delivering packages in your area."</li>
                                <li>(<a href="https://flex.amazon.com/faqs" target="_blank">Source</a>)</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Amazon_Flex"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Amazon_Flex' class='btn ".$btn." Amazon_Flex' onclick=\"addOrRemove(".$userId.", 'Amazon_Flex')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig DollyHelpersCard">
                        <h1><a href="https://dolly.com/helpers/" target="_blank">Dolly</a></h1>
                        <h3>Truck Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: Claims their "Helpers" earn up to $30/hr or more</p>
                            <p>Required:</p>
                            <ul>
                                <li>21+ years of age</li>
                                <li>Have a valid driver’s license and auto insurance</li>
                                <li>Have a pickup truck, cargo van, box truck, or vehicle w/ trailer model 
                                year 2000 or newer that is capable of safely and reliably moving items like 
                                a couch, bed, or desk</li>
                                <li>Have an Android or iOS smartphone with Android 5.0/iOS 11 or newer</li>
                                <li>Be able to pass a background check</li>
                                <li>Willing and able to lift/carry large bulky items like couches and desks (at least 75 lbs)</li>
                                <li>Have a PayPal account or be able to set one up to get paid</li>
                                <li>(<a href="https://dolly.com/helpers/" target="_blank">Source</a>)</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"DollyHelpers"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='DollyHelpers' class='btn ".$btn." DollyHelpers' onclick=\"addOrRemove(".$userId.", 'DollyHelpers')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="foodDeliveryCards">
                    <div class="card questionnaire gig Uber_EatsCard">
                        <h1><a href="https://www.uber.com/a/signup/drive/deliver/" target="_blank">Uber Eats</a></h1>
                        <h3>Food Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: "Uber Eats drivers earn around $8 – $12 per hour after accounting for vehicle expenses"
                            (<a href="https://www.ridesharingdriver.com/driving-for-ubereats-what-its-like-delivering-food-for-uber/" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Background Check</li>
                                <li>Driver’s License</li>
                                <li>Vehicle Information</li>
                                <li>Vehicle Insurance</li>
                                <li>Vehicle Registration</li>
                                <li>VA/MD/PA State Inspection Certificate</li>
                                <li>Profile Photo</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Uber_Eats"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Uber_Eats' class='btn ".$btn." Uber_Eats' onclick=\"addOrRemove(".$userId.", 'Uber_Eats')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig GrubhubCard">
                        <h1><a href="https://driver.grubhub.com/" target="_blank">Grubhub</a></h1>
                        <h3>Food Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: "According to 73 salaries on Glassdoor, Grubhub drivers
                            typically make $12 per hour. According to 92 reported salaries on Indeed, the average
                            hourly pay for Grubhub drivers was $11.05."
                            (<a href="https://www.usatoday.com/story/tech/talkingtech/2018/09/28/how-much-money-can-delivering-food-grubhub-and-doordash-make/1436841002/" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Only available in certain cities (Check on the website)</li>
                                <li>Must be at least 19 years old</li>
                                <li>Car / scooter / motorcycle / bike</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Grubhub"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Grubhub' class='btn ".$btn." Grubhub' onclick=\"addOrRemove(".$userId.", 'Grubhub')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig DoorDashCard">
                        <h1><a href="https://www.doordash.com/dasher/signup/ge/5761dc?utm_source=ge_t_v1" target="_blank">DoorDash</a></h1>
                        <h3>Food Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: "Delivering for DoorDash is an appealing job because it is easy to get hired, the pay is
                            around $10–$15/hour, and you can set your own hours."
                            (<a href="https://www.ridesharingdriver.com/doordash-driver-requirements-how-to-become-a-delivery-driver/" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>You must be 18 years or older</li>
                                <li>Have access to a vehicle</li>
                                    <ul>
                                        <li>Any car, truck, or van qualifies</li>
                                        <li>You can deliver on a scooter or bicycle in some markets</li>
                                    </ul>
                                <li>A valid driver’s license</li>
                                <li>Current insurance — Name on policy</li>
                                <li>Own an iPhone or Android smartphone to run the DoorDash partner app</li>
                                <li>Complete an orientation or request an activation kit</li>
                                <li>(<a href="https://www.ridesharingdriver.com/doordash-driver-requirements-how-to-become-a-delivery-driver/" target="_blank">Source</a>)</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"DoorDash"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='DoorDash' class='btn ".$btn." DoorDash' onclick=\"addOrRemove(".$userId.", 'DoorDash')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig CaviarCard">
                        <h1><a href="https://www.trycaviar.com/apply" target="_blank">Caviar</a></h1>
                        <h3>Food Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: Claims their couriers can make up to $25/hr
                            <p>Required:</p>
                            <ul>
                                <li>Only available in certain cities (Check on the website)</li>
                                <li>Car / bike or cargo bike / motorcycle / scooter</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Caviar"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Caviar' class='btn ".$btn." Caviar' onclick=\"addOrRemove(".$userId.", 'Caviar')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig PostmatesCard">
                        <h1><a href="https://fleet.postmates.com/" target="_blank">Postmates</a></h1>
                        <h3>Food Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: "Postmates drivers can expect to make $8–$15 per hour in most markets"
                            (<a href="https://www.ridesharingdriver.com/be-a-delivery-driver-for-postmates-or-doordash/" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Must be 18 years or older</li>
                                <li>Have access to an insured vehicle, or a bicycle</li>
                                <li>You can deliver with a car, truck, van, bicycle, motorcycle, or scooter</li>
                                <li>Pass a background check</li>
                                <li>(<a href="https://www.ridesharingdriver.com/be-a-delivery-driver-for-postmates-or-doordash/" target="_blank">Source</a>)</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Postmates"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Postmates' class='btn ".$btn." Postmates' onclick=\"addOrRemove(".$userId.", 'Postmates')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig WaitrCard">
                        <h1><a href="https://waitrapp.com/driver" target="_blank">Waitr</a></h1>
                        <h3>Food Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: "Average Waitr Inc Delivery Driver hourly pay in the United States
                            is approximately $14.78, which is 6% below the national average."
                            (<a href="https://www.indeed.com/cmp/Waitr-Inc/salaries/Delivery-Driver" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Only available in certain cities (Check on the website)</li>
                                <li>Must be at least 18 years old</li>
                                <li>Driver’s License</li>
                                <li>Auto insurance</li>
                                <li>Car</li>
                                <li>Smartphone</li>
                                <li>Criminal Background Check and Motor Vehicle Report Check</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Waitr"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Waitr' class='btn ".$btn." Waitr' onclick=\"addOrRemove(".$userId.", 'Waitr')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig Bite_SquadCard">
                        <h1><a href="https://www.bitesquad.com/apply" target="_blank">Bite Squad</a></h1>
                        <h3>Food Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: "Average Bite Squad hourly pay ranges from approximately $12.57
                            per hour for Driver to $23.68 per hour for Photographer."
                            (<a href="https://www.indeed.com/cmp/Bite-Squad/salaries" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Only available in certain cities (Check on the website)</li>
                                <li>Must be at least 18 years old</li>
                                <li>Driver’s License</li>
                                <li>Auto insurance</li>
                                <li>Car</li>
                                <li>Smartphone</li>
                                <li>Criminal Background Check and Motor Vehicle Report Check</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Bite_Squad"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Bite_Squad' class='btn ".$btn." Bite_Squad' onclick=\"addOrRemove(".$userId.", 'Bite_Squad')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig FavorCard">
                        <h1><a href="https://apply.favordelivery.com/" target="_blank">Favor</a></h1>
                        <h3>Food Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: "Average Favor hourly pay ranges from approximately $13.70 per
                            hour for Runner to $15.00 per hour for Personal Assistant."
                            (<a href="https://www.indeed.com/cmp/Favor/salaries" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Only available in certain cities (Check on the website)</li>
                                <li>Car / bike</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Favor"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Favor' class='btn ".$btn." Favor' onclick=\"addOrRemove(".$userId.", 'Favor')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig Food_DudesCard">
                        <h1><a href="https://fooddudesdelivery.com/becomeadriver" target="_blank">Food Dudes</a></h1>
                        <h3>Food Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: "Average Food Dudes Delivery Delivery Driver hourly pay in the United States
                            is approximately $17.32, which is 10% above the national average."
                            (<a href="https://www.indeed.com/cmp/Food-Dudes-Delivery/salaries/Delivery-Driver" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Only available in certain cities (Check on the website)</li>
                                <li>Must be least 21 years old</li>
                                <li>Valid driver's license</li>
                                <li>Clean driving record</li>
                                <li>Reliable vehicle</li>
                                <li>Valid proof of insurance</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Food_Dudes"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Food_Dudes' class='btn ".$btn." Food_Dudes' onclick=\"addOrRemove(".$userId.", 'Food_Dudes')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig FoodjetsCard">
                        <h1><a href="https://www.foodjets.com/careers" target="_blank">Foodjets</a></h1>
                        <h3>Food Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: Average FoodJets Delivery Driver hourly pay in the United States is
                            approximately $17.19, which is 9% above the national average.
                            (<a href="https://www.indeed.com/cmp/Foodjets/salaries/Delivery-Driver" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Only available in certain cities (Check on the website)</li>
                                <li>Must be at least 18 years old</li>
                                <li>Driver’s license</li>
                                <li>Car</li>
                                <li>Smartphone</li>
                                <li>Criminal Background Check and Motor Vehicle Report Check</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Foodjets"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Foodjets' class='btn ".$btn." Foodjets' onclick=\"addOrRemove(".$userId.", 'Foodjets')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="groceryDeliveryCards">
                    <div class="card questionnaire gig AmazonDeliversShopperCard">
                        <h1><a href="https://www.amazondelivers.jobs/" target="_blank">AmazonDelivers.Jobs</a></h1>
                        <h3>Grocery Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: Claims their shoppers earn up to $17/hr (Plus an added $2/hr through April)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Depends on the job</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"AmazonDelivers"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='AmazonDelivers' class='btn ".$btn." AmazonDelivers' onclick=\"addOrRemove(".$userId.", 'AmazonDelivers')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig AmazonFlexGroceryCard">
                        <h1><a href="https://flex.amazon.com/get-started" target="_blank">Amazon Flex</a></h1>
                        <h3>Grocery Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: "Most delivery partners earn $18 - $25 per hour delivering with Amazon Flex. 
                            Actual earnings will depend on your location, any tips you receive, how long it takes 
                            you to complete your deliveries, and other factors."
                            (<a href="https://flex.amazon.com/faqs" target="_blank">Source</a>)</p>
                            <p>"Prime Now and Amazon Fresh: Pick up groceries or household items from an Amazon delivery 
                            station and deliver directly to customers. Delivery blocks are typically 2-4 hours."
                            (<a href="https://flex.amazon.com/faqs" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Only available in certain cities (Check on the website)</li>
                                <li>Smartphone</li>
                                <li>"If you are delivering Prime Now orders, you can use any car that can safely and reliably transport 
                                Amazon orders to customers."</li>
                                <li>"As a delivery partner, you must maintain the required insurance for delivering packages in your area."</li>
                                <li>(<a href="https://flex.amazon.com/faqs" target="_blank">Source</a>)</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Amazon Flex"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Amazon_Flex' class='btn ".$btn." Amazon_Flex' onclick=\"addOrRemove(".$userId.", 'Amazon Flex')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig InstacartCard">
                        <h1><a href="https://shoppers.instacart.com/apps" target="_blank">Instacart</a></h1>
                        <h3>Grocery Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: "Average Instacart hourly pay ranges from approximately $9.81 per hour for
                            Independent Contractor to $17.32 per hour for Grocery Associate."
                            (<a href="https://www.indeed.com/cmp/Instacart/salaries" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Must be at least 18 years old</li>
                                <li>Able to life 40 lbs.</li>
                                <li>Eligible to work in U.S.</li>
                            </ul>
                            <p>Required for Full-Service Shopper (Shop & Drive):</p>
                            <ul>
                                <li>Access to a car</li>
                                <li>Valid driver's license</li>
                                <li>Auto insurance coverage</li>
                            </ul>
                            <p>Required for In-Store Shopper (Shop Only):</p>
                            <ul>
                                <li>Available to work Sundays or Mondays</li>
                                <li>Be able to work at least 15-20 hours per week</li>
                                <li>Attend interview and training sessions</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Instacart"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Instacart' class='btn ".$btn." Instacart' onclick=\"addOrRemove(".$userId.", 'Instacart')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig ShiptCard">
                        <h1><a href="https://www.shipt.com/be-a-shopper/" target="_blank">Shipt</a></h1>
                        <h3>Grocery Delivery</h3>
                        <div class="left">
                            <p>Hourly Wage: Claims their shoppers earn up to $22/hr</p>
                            <p>Required:</p>
                            <ul>
                                <li>Only available in certain cities (Check on the website)</li>
                                <li>Must be at least 18 years old</li>
                            </ul>
                            <p>Optional:</p>
                            <ul>
                                <li>Must be at least 21 years old to participate in Shipt's alcohol delivery program</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Shipt"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Shipt' class='btn ".$btn." Shipt' onclick=\"addOrRemove(".$userId.", 'Shipt')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig Grocery_ChimpsCard">
                        <h1><a href="https://grocerychimps.com/account/sign-up" target="_blank">Grocery Chimps</a></h1>
                        <h3>Grocery Delivery</h3>
                        <div class="left">
                            <p>Note: Grocery Chimps does not take a cut of your pay; you keep 100% of your earnings. However,
                            they do ask for a monthly ($5 one time activation fee + $12.99 monthly fee) or annual
                            ($34.99 annual fee) subscription payment for using their service</p>
                            <p>Hourly Wage: N/A</p>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Grocery_Chimps"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Grocery_Chimps' class='btn ".$btn." Grocery_Chimps' onclick=\"addOrRemove(".$userId.", 'Grocery_Chimps')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="laborCards">
                    <div class="card questionnaire gig AmazonDeliversWarehouseCard">
                        <h1><a href="https://www.amazondelivers.jobs/" target="_blank">AmazonDelivers.Jobs</a></h1>
                        <h3>Warehouse</h3>
                        <div class="left">
                            <p>Hourly Wage: Claims their workers earn up to $17/hr (Plus an added $2/hr through April)</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Ability to move packages and other items</li>
                            </ul>
                            <p>Required:</p>
                            <ul>
                                <li>Depends on the job</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"AmazonDelivers"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='AmazonDelivers' class='btn ".$btn." AmazonDelivers' onclick=\"addOrRemove(".$userId.", 'AmazonDelivers')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig DollyHandsCard">
                        <h1><a href="https://dolly.com/helpers/" target="_blank">Dolly</a></h1>
                        <h3>Moving</h3>
                        <div class="left">
                            <p>Hourly Wage: Claims their "Hands" earn up to $15/hr or more</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Willing and able to lift/carry large bulky items like couches and desks (at least 75 lbs)</li>
                            </ul>
                            <p>Required:</p>
                            <ul>
                                <li>18+ years of age</li>
                                <li>Have a valid driver’s license</li>
                                <li>Have a car, mini-van, SUV, or motorcycle/scooter to get you to and from Dolly locations</li>
                                <li>Have an Android or iOS smartphone with Android 5.0/iOS 11 or newer</li>
                                <li>Be able to pass a background check</li>
                                <li>Willing and able to lift/carry large bulky items like couches and desks (at least 75 lbs)</li>
                                <li>Have a PayPal account or be able to set one up to get paid</li>
                                <li>(<a href="https://dolly.com/helpers/" target="_blank">Source</a>)</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"DollyHands"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='DollyHands' class='btn ".$btn." DollyHands' onclick=\"addOrRemove(".$userId.", 'DollyHands')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig TaskEasyCard">
                        <h1><a href="https://www.taskeasy.com/contractors" target="_blank">TaskEasy</a></h1>
                        <h3>Lawn Care</h3>
                        <div class="left">
                            <p>Hourly Wage: N/A</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Lawn Care</li>
                            </ul>
                            <p>Required:</p>
                            <ul>
                                <li>“I confirm that neither I nor any of my employees have been convicted of a felony
                                within the last seven years or have ever been convicted of a sex offense. I confirm
                                there are no civil judgments, pending legal actions against me or my business, and
                                that I have not declared bankruptcy in the last three years.”</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"TaskEasy"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='TaskEasy' class='btn ".$btn." TaskEasy' onclick=\"addOrRemove(".$userId.", 'TaskEasy')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig HandyCard">
                        <h1><a href="https://www.handy.com/apply" target="_blank">Handy</a></h1>
                        <h3>Cleaning</h3>
                        <div class="left">
                            <p>Hourly Wage: "Handy cleaners are paid one of four hourly rates between $15 and $22
                            based on how highly rated they are and how many jobs they’ve worked in the past 28 days.
                            The average cleaner makes around $17 an hour, Handy says."
                            (<a href="https://slate.com/business/2015/07/handy-a-hot-startup-for-home-cleaning-has-a-big-mess-of-its-own.html" target="_blank">Source</a>)</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Cleaner</li>
                                <li>Electrician</li>
                                <li>Garage Door Installation</li>
                                <li>Handyman</li>
                                <li>Home Improvement</li>
                                <li>Lawn Care</li>
                                <li>Plumber</li>
                                <li>Pool Services</li>
                                <li>Smart Home</li>
                                <li>Technology Services</li>
                            </ul>
                            <p>Required for some tasks:</p>
                            <ul>
                                <li>Basic tools (drill, wrench, hammer, level, etc.)</li>
                                <li>Power tools (circular/table saw, nail gun, shop vac, etc.)</li>
                                <li>Painting supplies (roller, brush, drop cloth, tape, etc.)</li>
                                <li>Lawn care equipment (mower, leaf blower, string trimmer, hand tools, etc.)</li>
                                <li>Ladder</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Handy"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Handy' class='btn ".$btn." Handy' onclick=\"addOrRemove(".$userId.", 'Handy')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="careCards">
                    <div class="card questionnaire gig WagCard">
                        <h1><a href="https://wagwalking.com/dog-walker" target="_blank">Wag</a></h1>
                        <h3>Dog Care</h3>
                        <div class="left">
                            <p>Hourly Wage: "Wag cofounder and CEO Joshua Viner told BuzzFeed News that
                            “on average, a walker makes around $17.50 per walk.” Private, professional walkers,
                            however, can make between $20 and $40 — and, because they don’t need to pay Wag a cut,
                            they keep more of that cash for themselves. Plus, if a professional walker takes on
                            multiple dogs at a time, which they often do, their payment increases with each furry,
                            four-legged creature."
                            (<a href="https://www.buzzfeednews.com/article/allysonlaquian/can-you-make-real-money-on-a-dog-walking-app" target="_blank">Source</a>)</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Walking</li>
                                <li>Sitting</li>
                                <li>Boarding</li>
                                <li>Daycare</li>
                                <li>Drop-In</li>
                            </ul>
                            <p>Required:</p>
                            <ul>
                                <li>Smartphone</li>
                                <li>Transportation</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Wag"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Wag' class='btn ".$btn." Wag' onclick=\"addOrRemove(".$userId.", 'Wag')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig RoverCard">
                        <h1><a href="https://www.rover.com/become-a-sitter/" target="_blank">Rover</a></h1>
                        <h3>Dog and Cat Care</h3>
                        <div class="left">
                            <p>Hourly Wage: "According to Forecki, sitters that treat Rover like a part-time job
                            and take two or three dogs for two weeks out of the month earn an average of $1,000 per month.
                            Meanwhile, those that treat Rover like a full-time job, working 4 weeks out of the month and
                            taking 2-3 dogs at a time, earn an average of $3,300/month."
                            (<a href="https://www.thesimpledollar.com/make-money/how-to-make-money-dog-sitting-through-rover/" target="_blank">Source</a>)</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Dog Boarding</li>
                                <li>House Sitting</li>
                                <li>Drop-In Visits</li>
                                <li>Doggy Daycare</li>
                                <li>Dog Walking</li>
                            </ul>
                            <p>Required:</p>
                            <ul>
                                <li>Smartphone</li>
                                <li>Transportation</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Rover"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Rover' class='btn ".$btn." Rover' onclick=\"addOrRemove(".$userId.", 'Rover')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig CareCard">
                        <h1><a href="https://www.care.com/" target="_blank">Care</a></h1>
                        <h3>Child, Senior, and Pet Care</h3>
                        <div class="left">
                            <p>Hourly Wage: "Average Care.com hourly pay ranges from approximately $13.28 per hour
                            for Nursing Assistant to $16.97 per hour for Household Manager."
                            (<a href="https://www.indeed.com/cmp/Care.com/salaries" target="_blank">Source</a>)</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Babysitter or Nanny</li>
                                <li>Special Needs</li>
                                <li>Tutor and Private</li>
                                <li>Child Care Center</li>
                                <li>Senior Care and Nursing</li>
                                <li>Housekeeping</li>
                                <li>In Home Day Care</li>
                                <li>Pet Care</li>
                                <li>Errands and Odd Jobs</li>
                            </ul>
                            <p>Optional:</p>
                            <ul>
                                <li>$19 Motor Vehicle Records Check</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Care"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Care' class='btn ".$btn." Care' onclick=\"addOrRemove(".$userId.", 'Care')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="massageCards">
                    <div class="card questionnaire gig ZeelCard">
                        <h1><a href="https://www.zeel.com/apply" target="_blank">Zeel</a></h1>
                        <h3>Massage</h3>
                        <div class="left">
                            <p>Hourly Wage: "Average Zeel hourly pay ranges from approximately
                            $10.00 per hour for Marketing Intern to $75.25 per hour for Massage Therapist."
                            (<a href="https://www.indeed.com/cmp/Zeel/salaries" target="_blank">Source</a>)</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Esthetics</li>
                                <li>Massage Therapist</li>
                                <li>Mindfulness</li>
                                <li>Personal Training</li>
                                <li>Yoga (w/ Yoga Alliance)</li>
                            </ul>
                            <p>Required:</p>
                            <ul>
                                <li>Photo ID</li>
                                <li>Professional license information</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Zeel"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Zeel' class='btn ".$btn." Zeel' onclick=\"addOrRemove(".$userId.", 'Zeel')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="languageCards">
                    <div class="card questionnaire gig LanguageFreelancerCard">
                        <h1><a href="https://www.freelancer.com/signup" target="_blank">Freelancer</a></h1>
                        <h3>Translation & Languages</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Freelancer"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Freelancer' class='btn ".$btn." Freelancer' onclick=\"addOrRemove(".$userId.", 'Freelancer')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig TranslateCard">
                        <h1><a href="https://www.translate.com/users/translator_create" target="_blank">Translate</a></h1>
                        <h3>Translation</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Translate"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Translate' class='btn ".$btn." Translate' onclick=\"addOrRemove(".$userId.", 'Translate')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig ItalkiCard">
                        <h1><a href="https://teach.italki.com/application" target="_blank">Italki</a></h1>
                        <h3>Teaching & Tutoring</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Professional Teacher:</p>
                            <ul>
                                <li>Skills:
                                    <ul>
                                        <li>English</li>
                                        <li>Spanish</li>
                                        <li>French</li>
                                        <li>Japanese</li>
                                        <li>German</li>
                                        <li>Chinese</li>
                                        <li>Italian</li>
                                        <li>Russian</li>
                                        <li>Portuguese</li>
                                    </ul>
                                </li>
                                <li>Required:
                                    <ul>
                                        <li>Type 1 - University Qualification
                                            <ul>
                                                <li>18+ years old</li>
                                                <li>Bachelor’s Degree</li>
                                                <li>1 - 3 minute Introduction Video</li>
                                                <li>CV</li>
                                                <li>References/Employment Statements</li>
                                                <li>Priority is given to applicants who have Education, Cultural, Linguistics, 
                                                Language or specialized background (e.g. Asian Studies, Speech Therapy etc).</li>
                                                <li>Native or C2 in your teaching language(s)</li>
                                                <li>You are required to upload copies of all your relevant documents (for CV, 
                                                References and Employment Statements upload them under Certificates)</li>
                                            </ul>
                                        </li>
                                        <li>Type 2 - Teaching Qualification
                                            <ul>
                                                <li>18+ years old</li>
                                                <li>Teaching Qualification (e.g. Teaching Licence, PGCE, DELTA, CELTA, TEFL etc).</li>
                                                <li>1 - 3 minute Introduction Video</li>
                                                <li>CV</li>
                                                <li>References/Employment Statements</li>
                                                <li>Native or C2 in your teaching language(s)</li>
                                                <li>You are required to upload copies of all your relevant documents (for CV, 
                                                References and Employment Statements upload them under Certificates)</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <p>Community Tutor:</p>
                            <ul>
                                <li>Skills:
                                    <ul>
                                        <li>English</li>
                                        <li>Spanish</li>
                                        <li>French</li>
                                        <li>Japanese</li>
                                        <li>German</li>
                                        <li>Italian</li>
                                    </ul>
                                </li>
                                <li>Required:
                                    <ul>
                                        <li>18+ years old</li>
                                        <li>1 - 3 minute introduction video</li>
                                        <li>Native or C2 in your teaching language(s)</li>
                                        <li>18+ years old</li>
                                    </ul>
                                </li>
                            </ul>
                            <p>(<a href="https://support.italki.com/hc/en-us/articles/115001499873" target="_blank">Source</a>)</p>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Italki"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Italki' class='btn ".$btn." Italki' onclick=\"addOrRemove(".$userId.", 'Italki')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="writingCards">
                    <div class="card questionnaire gig WritingFreelancerCard">
                        <h1><a href="https://www.freelancer.com/signup" target="_blank">Freelancer</a></h1>
                        <h3>Writing & Content</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Freelancer"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Freelancer' class='btn ".$btn." Freelancer' onclick=\"addOrRemove(".$userId.", 'Freelancer')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig WritingUpworkCard">
                        <h1><a href="https://www.fiverr.com/start_selling" target="_blank">Upwork</a></h1>
                        <h3>Writing</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Academic Writing & Research</li>
                                <li>Article & Blog Writing</li>
                                <li>Copywriting</li>
                                <li>Creative Writing</li>
                                <li>Editing & Proofreading</li>
                                <li>Grant Writing</li>
                                <li>Other - Writing</li>
                                <li>Resumes & Cover Letters</li>
                                <li>Technical Writing</li>
                                <li>Web Content</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Upwork"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Upwork' class='btn ".$btn." Upwork' onclick=\"addOrRemove(".$userId.", 'Upwork')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>     
                    <div class="card questionnaire gig WritingFiverrCard">
                        <h1><a href="https://www.fiverr.com/start_selling" target="_blank">Fiverr</a></h1>
                        <h3>Writing & Translation</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Articles & Blog Posts</li>
                                <li>Resume Writing</li>
                                <li>Proofreading & Editing</li>
                                <li>Brand Voice & Tone</li>
                                <li>Technical Writing</li>
                                <li>Cover Letters</li>
                                <li>LinkedIn Profiles</li>
                                <li>Translation</li>
                                <li>White Papers</li>
                                <li>UX Writing</li>
                                <li>Podcast Writing</li>
                                <li>Case Studies</li>
                                <li>Grant Writing</li>
                                <li>Social Media Copy</li>
                                <li>Press Releases</li>
                                <li>Research & Summaries</li>
                                <li>Transcripts</li>
                                <li>Legal Writing</li>
                                <li>Product Descriptions</li>
                                <li>Website Content</li>
                                <li>Business Names & Slogans</li>
                                <li>Scriptwriting</li>
                                <li>Book & eBook Writing</li>
                                <li>Email Copy</li>
                                <li>Speechwriting</li>
                                <li>Creative Writing</li>
                                <li>Beta Reading</li>
                                <li>Other</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Fiverr"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Fiverr' class='btn ".$btn." Fiverr' onclick=\"addOrRemove(".$userId.", 'Fiverr')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="artCards">
                    <div class="card questionnaire gig ArtGraphicsFiverrCard">
                        <h1><a href="https://www.fiverr.com/start_selling" target="_blank">Fiverr</a></h1>
                        <h3>Graphics & Design</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:
                            <ul>
                                <li>Logo Design</li>
                                <li>Brand Style Guides</li>
                                <li>Game Design</li>
                                <li>Graphics for Streamers</li>
                                <li>Business Cards & Stationery</li>
                                <li>Illustration</li>
                                <li>Brochure Design</li>
                                <li>Poster Design</li>
                                <li>Flyer Design</li>
                                <li>Book Design</li>
                                <li>Podcast Cover Art</li>
                                <li>Packaging Design</li>
                                <li>Storyboards</li>
                                <li>Web & Mobile Design</li>
                                <li>Social Media Design</li>
                                <li>Postcard Design</li>
                                <li>Catalog Design</li>
                                <li>Menu Design</li>
                                <li>Invitation Design</li>
                                <li>Portraits & Caricatures</li>
                                <li>Cartoons & Comics</li>
                                <li>Tattoo Design</li>
                                <li>Banner Ads</li>
                                <li>Photoshop Editing</li>
                                <li>Architecture & Interior Design</li>
                                <li>Landscape Design</li>
                                <li>Building Information Modeling</li>
                                <li>Character Modeling</li>
                                <li>3D Model & Product Design</li>
                                <li>T-Shirts & Merchandise</li>
                                <li>Presentation Design</li>
                                <li>Infographic Design</li>
                                <li>Car Wraps</li>
                                <li>Vector Tracing</li>
                                <li>Twitch Store</li>
                                <li>Other</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Fiverr"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Fiverr' class='btn ".$btn." Fiverr' onclick=\"addOrRemove(".$userId.", 'Fiverr')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig ArtVideoFiverrCard">
                        <h1><a href="https://www.fiverr.com/start_selling" target="_blank">Fiverr</a></h1>
                        <h3>Video & Animation</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Whiteboard & Animated Explainers</li>
                                <li>Video Editing</li>
                                <li>Short Video Ads</li>
                                <li>Animated GIFs</li>
                                <li>Logo Animation</li>
                                <li>Intros & Outros</li>
                                <li>App & Website Previews</li>
                                <li>Live Action Explainers</li>
                                <li>Character Animation</li>
                                <li>3D Product Animation</li>
                                <li>Lyric & Music Videos</li>
                                <li>Spokespersons Videos</li>
                                <li>Subtitles & Captions</li>
                                <li>Visual Effects</li>
                                <li>Animation for Kids</li>
                                <li>Product Photography</li>
                                <li>Local Photography</li>
                                <li>Other</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Fiverr"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Fiverr' class='btn ".$btn." Fiverr' onclick=\"addOrRemove(".$userId.", 'Fiverr')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig EtsyCard">
                        <h1><a href="https://www.etsy.com/sell?ref=ftr" target="_blank">Etsy</a></h1>
                        <h3>Crafts & E-commerce</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>E-commerce
                                    <ul>
                                        <li>Jewelry & Accessories</li>
                                        <li>Clothing & Shoes</li>
                                        <li>Home & Living</li>
                                        <li>Wedding & Party</li>
                                        <li>Toys & Entertainment</li>
                                        <li>Art & Collectibles</li>
                                        <li>Craft Supplies</li>
                                        <li>Vintage</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Etsy"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Etsy' class='btn ".$btn." Etsy' onclick=\"addOrRemove(".$userId.", 'Etsy')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="musicCards">
                    <div class="card questionnaire gig BeatStarsCard">
                        <h1><a href="https://www.beatstars.com/pricing" target="_blank">BeatStars</a></h1>
                        <h3>Beat Production</h3>
                        <div class="left">
                            <p>Average Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Beat production</li>
                            </ul>
                            <p>Requirements:</p>
                            <ul>
                                <li>Three subscription options:
                                    <ul>
                                        <li>Free: $0</li>
                                        <li>Marketplace Plan: $9.99/mo</li>
                                        <li>Pro Page Plan: $19.99/mo</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"BeatStars"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='BeatStars' class='btn ".$btn." BeatStars' onclick=\"addOrRemove(".$userId.", 'BeatStars')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig MusicFiverrCard">
                        <h1><a href="https://www.fiverr.com/start_selling" target="_blank">Fiverr</a></h1>
                        <h3>Music & Audio</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Voice Over</li>
                                <li>Mixing & Mastering</li>
                                <li>Producers & Composers</li>
                                <li>Singers & Vocalists</li>
                                <li>Session Musicians</li>
                                <li>Songwriters</li>
                                <li>Podcast Editing</li>
                                <li>Audiobook Production</li>
                                <li>Audio Ads Production</li>
                                <li>DJ Drops & Tags</li>
                                <li>Dialogue Editing</li>
                                <li>Music Transcription</li>
                                <li>Vocal Tuning</li>
                                <li>Jingles & Intros</li>
                                <li>Sound Effects</li>
                                <li>Other</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Fiverr"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Fiverr' class='btn ".$btn." Fiverr' onclick=\"addOrRemove(".$userId.", 'Fiverr')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig GigFinesseCard">
                        <h1><a href="https://www.gigfinesse.com/about/apply/" target="_blank">GigFinesse</a></h1>
                        <h3>Live Music Gigs</h3>
                        <div class="left">
                            <p>Average Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Perform live music at venues</li>
                            </ul>]
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"GigFinesse"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='GigFinesse' class='btn ".$btn." GigFinesse' onclick=\"addOrRemove(".$userId.", 'GigFinesse')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="financeCards">
                    <div class="card questionnaire gig FinanceUpworkCard">
                        <h1><a href="https://www.upwork.com/signup/?dest=job-posting" target="_blank">Upwork</a></h1>
                        <h3>Accounting & Consulting</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Accounting</li>
                                <li>Financial Planning</li>
                                <li>Human Resources</li>
                                <li>Management Consulting</li>
                                <li>Other - Accounting & Consulting</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Upwork"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Upwork' class='btn ".$btn." Upwork' onclick=\"addOrRemove(".$userId.", 'Upwork')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig GraphiteCard">
                        <h1><a href="https://www.graphite.com/professional/signup" target="_blank">Graphite</a></h1>
                        <h3>Finance</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Investment Banking</li>
                                <li>Management Consulting</li>
                                <li>Investment Management (e.g. Private Equity/Hedge Fund)</li>
                                <li>Marketing</li>
                                <li>Venture Capital/Entrepreneurship</li>
                                <li>Corporate Development</li>
                            </ul>
                            <p>Required:</p>
                            <ul>
                                <li>“At least two years of professional work experience in management consulting,
                                investment banking, private equity/venture capital, corporate development, accounting,
                                marketing, IT, data science or a related field”</li>
                                <li>“Prior work experience at large and reputable consulting firms, bulge bracket investment
                                banks, big 4 accounting firms, leading marketing agencies or Fortune 500 companies”</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Graphite"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Graphite' class='btn ".$btn." Graphite' onclick=\"addOrRemove(".$userId.", 'Graphite')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="techCards">
                    <div class="card questionnaire gig WebFreelancerCard">
                        <h1><a href="https://www.freelancer.com/signup" target="_blank">Freelancer</a></h1>
                        <h3>Websites, IT & Software</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Freelancer"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Freelancer' class='btn ".$btn." Freelancer' onclick=\"addOrRemove(".$userId.", 'Freelancer')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig MobileFreelancerCard">
                        <h1><a href="https://www.freelancer.com/signup" target="_blank">Freelancer</a></h1>
                        <h3>Mobile Phones & Computing</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Freelancer"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Freelancer' class='btn ".$btn." Freelancer' onclick=\"addOrRemove(".$userId.", 'Freelancer')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig ITUpworkCard">
                        <h1><a href="https://www.upwork.com/signup/?dest=job-posting" target="_blank">Upwork</a></h1>
                        <h3>IT & Networking</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Database Administration</li>
                                <li>ERP/CRM Software</li>
                                <li>Information Security</li>
                                <li>Network & System Administration</li>
                                <li>Other - IT & Networking</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Upwork"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Upwork' class='btn ".$btn." Upwork' onclick=\"addOrRemove(".$userId.", 'Upwork')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig WebUpworkCard">
                        <h1><a href="https://www.upwork.com/signup/?dest=job-posting" target="_blank">Upwork</a></h1>
                        <h3>Web, Mobile & Software Dev</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Desktop Software Development</li>
                                <li>E-commerce Development</li>
                                <li>Game Development</li>
                                <li>Mobile Development</li>
                                <li>Other - Software Development</li>
                                <li>Product Management</li>
                                <li>QA & Testing</li>
                                <li>Scripts & Utilities</li>
                                <li>Web & Mobile Design</li>
                                <li>Web Development</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Upwork"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Upwork' class='btn ".$btn." Upwork' onclick=\"addOrRemove(".$userId.", 'Upwork')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig DataUpworkCard">
                        <h1><a href="https://www.upwork.com/signup/?dest=job-posting" target="_blank">Upwork</a></h1>
                        <h3>Data Science & Analytics</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>A/B Testing</li>
                                <li>Data Extraction/ETL</li>
                                <li>Data Mining & Management</li>
                                <li>Data Visualization</li>
                                <li>Machine Learning</li>
                                <li>Other - Data Science & Analytics</li>
                                <li>Quantitative Analysis</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Upwork"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Upwork' class='btn ".$btn." Upwork' onclick=\"addOrRemove(".$userId.", 'Upwork')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig TechFiverrCard">
                        <h1><a href="https://www.fiverr.com/start_selling" target="_blank">Fiverr</a></h1>
                        <h3>Programming & Tech</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>WordPress</li>
                                <li>Website Builders & CMS</li>
                                <li>Game Development</li>
                                <li>Web Programming</li>
                                <li>E-Commerce Development</li>
                                <li>Mobile Apps</li>
                                <li>Desktop Applications</li>
                                <li>Support & IT</li>
                                <li>Chatbots</li>
                                <li>Cybersecurity & Data Protection</li>
                                <li>Data Analysis & Reports</li>
                                <li>Convert Files</li>
                                <li>Databases</li>
                                <li>User Testing</li>
                                <li>QA</li>
                                <li>Other</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Fiverr"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Fiverr' class='btn ".$btn." Fiverr' onclick=\"addOrRemove(".$userId.", 'Fiverr')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="engineeringCards">
                    <div class="card questionnaire gig EngineeringFreelancerCard">
                        <h1><a href="https://www.freelancer.com/signup" target="_blank">Freelancer</a></h1>
                        <h3>Engineering & Science</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Freelancer"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Freelancer' class='btn ".$btn." Freelancer' onclick=\"addOrRemove(".$userId.", 'Freelancer')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig EngineeringUpworkCard">
                        <h1><a href="https://www.upwork.com/signup/?dest=job-posting" target="_blank">Upwork</a></h1>
                        <h3>Engineering & Architecture</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>3D Modeling & CAD</li>
                                <li>Architecture</li>
                                <li>Chemical Engineering</li>
                                <li>Civil & Structural Engineering</li>
                                <li>Contract Manufacturing</li>
                                <li>Electrical Engineering</li>
                                <li>Interior Design</li>
                                <li>Mechanical Engineering</li>
                                <li>Other - Engineering & Architecture</li>
                                <li>Product Design</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Upwork"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Upwork' class='btn ".$btn." Upwork' onclick=\"addOrRemove(".$userId.", 'Upwork')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="businessCards">
                    <div class="card questionnaire gig SalesFreelancerCard">
                        <h1><a href="https://www.freelancer.com/signup" target="_blank">Freelancer</a></h1>
                        <h3>Sales & Marketing</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Freelancer"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Freelancer' class='btn ".$btn." Freelancer' onclick=\"addOrRemove(".$userId.", 'Freelancer')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig BusinessFreelancerCard">
                        <h1><a href="https://www.freelancer.com/signup" target="_blank">Freelancer</a></h1>
                        <h3>Business, Accounting, Human Resources & Legal</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Freelancer"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Freelancer' class='btn ".$btn." Freelancer' onclick=\"addOrRemove(".$userId.", 'Freelancer')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig SalesUpworkCard">
                        <h1><a href="https://www.upwork.com/signup/?dest=job-posting" target="_blank">Upwork</a></h1>
                        <h3>Sales & Marketing</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Display Advertising</li>
                                <li>Email & Marketing Automation</li>
                                <li>Lead Generation</li>
                                <li>Market & Customer Research</li>
                                <li>Marketing Strategy</li>
                                <li>Other - Sales & Marketing</li>
                                <li>Public Relations</li>
                                <li>SEM - Search Engine Marketing</li>
                                <li>SEO - Search Engine Optimization</li>
                                <li>SMM - Social Media Marketing</li>
                                <li>Telemarketing & Telesales</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Upwork"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Upwork' class='btn ".$btn." Upwork' onclick=\"addOrRemove(".$userId.", 'Upwork')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>         
                    <div class="card questionnaire gig MarketingFiverrCard">
                        <h1><a href="https://www.fiverr.com/start_selling" target="_blank">Fiverr</a></h1>
                        <h3>Digital Marketing</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:</p>
                            <ul>
                                <li>Social Media Marketing</li>
                                <li>SEO</li>
                                <li>Social Media Advertising</li>
                                <li>Public Relations</li>
                                <li>Content Marketing</li>
                                <li>Podcast Marketing</li>
                                <li>Video Marketing</li>
                                <li>Email Marketing</li>
                                <li>Crowdfunding</li>
                                <li>SEM</li>
                                <li>Marketing Strategy</li>
                                <li>Surveys</li>
                                <li>Web Analytics</li>
                                <li>Influencer Marketing</li>
                                <li>Local SEO</li>
                                <li>Domain Research</li>
                                <li>E-Commerce Marketing</li>
                                <li>Mobile Marketing & Advertising</li>
                                <li>Music Promotion</li>
                                <li>Web Traffic</li>
                                <li>Other</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Fiverr"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Fiverr' class='btn ".$btn." Fiverr' onclick=\"addOrRemove(".$userId.", 'Fiverr')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig BusinessFiverrCard">
                        <h1><a href="https://www.fiverr.com/start_selling" target="_blank">Fiverr</a></h1>
                        <h3>Business</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:
                            <ul>
                                <li>Virtual Assistant</li>
                                <li>Data Entry</li>
                                <li>Market Research</li>
                                <li>Product Research</li>
                                <li>Business Plans</li>
                                <li>Project Management</li>
                                <li>HR Consulting</li>
                                <li>Branding Services</li>
                                <li>Legal Consulting</li>
                                <li>Financial Consulting</li>
                                <li>Business Consulting</li>
                                <li>Presentations</li>
                                <li>Career Advice</li>
                                <li>Flyer Distribution</li>
                                <li>Lead Generation</li>
                                <li>Other</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Fiverr"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Fiverr' class='btn ".$btn." Fiverr' onclick=\"addOrRemove(".$userId.", 'Fiverr')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="legalCards">
                    <div class="card questionnaire gig LegalUpworkCard">
                        <h1><a href="https://www.upwork.com/signup/?dest=job-posting" target="_blank">Upwork</a></h1>
                        <h3>Legal</h3>
                        <div class="left">
                            <p>Hourly Wage: Varies</p>
                            <p>Skills:
                                <ul>
                                    <li>Contract Law</li>
                                    <li>Corporate Law</li>
                                    <li>Criminal Law</li>
                                    <li>Family Law</li>
                                    <li>Intellectual Property Law</li>
                                    <li>Other - Legal</li>
                                    <li>Paralegal Services</li>
                                </ul>
                            </p>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Upwork"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Upwork' class='btn ".$btn." Upwork' onclick=\"addOrRemove(".$userId.", 'Upwork')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
                <div id="rentCards">
                    <div class="card questionnaire gig TuroCard">
                        <h1><a href="https://turo.com/us/en/list-your-car" target="_blank">Turo</a></h1>
                        <h3>Car Rental</h3>
                        <div class="left">
                            <p>Monthly Wage: "On average, owners who list their car on Turo make $720 a month."
                            (<a href="https://studentloanhero.com/featured/turo-review/" target="_blank">Source</a>)</p>
                            <p>Required:</p>
                            <ul>
                                <li>Car</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Turo"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Turo' class='btn ".$btn." Turo' onclick=\"addOrRemove(".$userId.", 'Turo')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig GetaroundCard">
                        <h1><a href="https://www.getaround.com/list" target="_blank">Getaround</a></h1>
                        <h3>Car Rental</h3>
                        <div class="left">
                            <p>Monthly Wage: <a href="https://studentloanhero.com/featured/turo-review/" target="_blank">Calculator</a></p>
                            <p>Required:</p>
                            <ul>
                                <li>Car</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Getaround"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Getaround' class='btn ".$btn." Getaround' onclick=\"addOrRemove(".$userId.", 'Getaround')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                    <div class="card questionnaire gig AirbnbCard">
                        <h1><a href="https://www.airbnb.com/host/homes" target="_blank">Airbnb</a></h1>
                        <h3>House Rental</h3>
                        <div class="left">
                            <p>Monthly Wage: <a href="https://www.airbnb.com/host/homes" target="_blank">Calculator</a></p>
                            <p>Required:</p>
                            <ul>
                                <li>House</li>
                            </ul>
                        </div>
                        <?php
                            if($log && !Database::query("SELECT gig FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>"Airbnb"))) {
                                $btn = "btn-primary";
                                $text = "Add";
                            } else {
                                $btn = "btn-danger";
                                $text = "Remove";
                            }
                            if($log) {
                                echo "<button id='Airbnb' class='btn ".$btn." Airbnb' onclick=\"addOrRemove(".$userId.", 'Airbnb')\">".$text."</button>
                                    <br/>
                                    <br/>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <script>
            $(function() {
                $("#profile").css({"background-color": "#800000", "color": "#fff"});
            });
            $(function() {
                $(".subtopic").css({"background-color": "#fff", "color": "#000"});
                $("#questionnaireButton").css({"background-color": "#d4af37", "color": "#fff"});
            });
        </script>
        <script src="js/mogle.js"></script>
        <script src="js/addOrRemove.js"></script>
        <script src="js/mogle/questionnaire.js"></script>
    </body>
</html>