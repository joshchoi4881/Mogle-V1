# Mogle V1 Production
Mogle V1 Production

# AJAX
Contains PHP scripts to allow client to communicate with the MySQL database through AJAX

HTTP -> folder that contains PHP scripts to allow https website to make http requests to Node.js server (workaround; ignore for now, will be fixed)

# PHPMailer-master
Allows automated email functionality

# Classes
Contains PHP classes to allow functionality such as image uploading, connecting to database, etc. These classes are used in the AJAX folder PHP scripts

# CSS
Contains CSS code for design of website

# Graphs
For testing the estimates given by bots; renders bot data into visual graphs

# JS
Contains self-contained JS files that are linked to by the HTML; includes functionality such as displaying the questionnaire results, etc.

# Photos
Contains photos used in the website such as the logo

# Server
Contains Node.js files to create Express servers; this is where you'll find all the API endpoints of the application

anychart -> renders expenses / income financial data from Plaid with pie charts

bots -> contains bot algorithm to estimate earnings for different sectors of the gig economy

mogle -> contains endpoints for anything related to Mogle such as adding/removing gigs from your account, etc. (will be transferring PHP functionality that the AJAX folder currently contains to Node.js in this folder)

plaid -> extracts financial information from user

# homepage.php, profile.php, search.php, schedule.php, income.php, community.php
The six central pages / features of the application
