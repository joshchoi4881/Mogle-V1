"use strict";

module.exports = {
    // Ports
    moglePort: 8000,
    ridesharePort: 8001,
    deliveryPort: 8002,
    plaidPort: 8003,
    anychartPort: 8004,

    // AWS S3
    s3_bucket_screenshots: "mogle-screenshots-before",
    region: "us-east-1",
    access_control_list: "public-read",
  
    /* Puppeteer */
    // 2Captcha
    captcha_api_key: "55f9ce8fff5b245be378bcb412285f40",
    captcha_submit_url: "http://2captcha.com/in.php",
    captcha_retrieval_url: "http://2captcha.com/res.php",
  
    /* Rideshare */
    // Uber
    uber_login_url: "https://auth.uber.com/login/",
    uber_map_url: "https://m.uber.com/looking",
    uber_site_key: "6LdoZSkTAAAAAEyquKnCAeiBngVx1w1DOfML7cix",
    // Lyft
    lyft_fare_url: "https://www.lyft.com/rider",
    
    /* Delivery */
    // Uber Eats
    uber_eats_order_url: "https://www.ubereats.com",
  };  