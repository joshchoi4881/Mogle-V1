"use strict";

// Modules
const dotenv = require("dotenv").config({ path: __dirname + "/../../.env" });
const config = require("../config");
const express = require("express");
const bodyParser = require("body-parser");
const aws = require("aws-sdk");
const multer = require("multer");
const multerS3 = require("multer-s3");
const path = require("path");
const request = require("request-promise");
// const admin = require("firebase-admin");

// AWS S3 variables
const s3 = new aws.S3({
  Bucket: config.s3_bucket_screenshots,
  region: config.region,
  accessKeyId: process.env.AWS_ACCESS_KEY_ID,
  secretAccessKey: process.env.AWS_SECRET_ACCESS_KEY
});

// AWS DynamoDB variables
const AWS = require("aws-sdk");
AWS.config.update({
  region: "us-east-1"
});
const docClient = new AWS.DynamoDB.DocumentClient();

/*
// Firestore variables
const serviceAccount = require("../mogleapp4881-a9172112d9cd.json");
admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
});
const db = admin.firestore();
*/

// Express
const app = express();
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// CORS
app.all("/*", (req, res, next) => {
  res.header("Access-Control-Allow-Origin", "*");
  res.header(
    "Access-Control-Allow-Headers",
    "Content-Type, Authorization, Content-Length, X-Requested-With"
  );
  res.header("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
  next();
});

// Test
app.get("/test", (req, res) => {
  console.log("TEST");
});

app.post("/get_estimates", (req, res) => {
  console.log("/get_estimates");
  const location = req.body.location;
  const platform = req.body.platform;
  console.log(location + platform);
});

/**
 * @route POST /server/mogle/upload_screenshots
 * @desc Upload screenshots
 * @access public
 */
app.post("/upload_screenshots", (req, res) => {
  console.log("/upload_screenshots");
	uploadScreenshots(req, res, (error) => {
		console.log("Files: ", req.files);
		if(error) {
			console.log("Errors: ", error);
			res.json( { error: error } );
		} else {
			// If file not found
			if(req.files === undefined) {
				console.log("Error: No File Selected!");
				res.json("Error: No File Selected");
			} else {
				// If success
				let fileArray = req.files, fileLocation;
				const locationArray = [];
				for(let i = 0; i < fileArray.length; i++) {
					fileLocation = fileArray[i].location;
					console.log("File Location: ", fileLocation);
					locationArray.push(fileLocation);
				}
				// Save the file name into database
				res.json({
					filesArray: fileArray,
					locationArray: locationArray
				});
			}
		}
	});
});

const uploadScreenshots = multer({
	storage: multerS3({
		s3: s3,
		bucket: config.s3_bucket_screenshots,
		acl: config.access_control_list,
		key: function(req, file, cb) {
			cb(null, path.basename(file.originalname, path.extname(file.originalname)) + '-' + Date.now() + path.extname(file.originalname));
		}
	}),
	limits: { fileSize: 50000000 }, // 50 MB
	fileFilter: function(req, file, cb){
		checkFileType(file, cb);
	}
}).array("screenshots", 50);

function checkFileType(file, cb){
	// Allowed ext
	const filetypes = /jpg|jpeg|png/;
	// Check ext
	const extname = filetypes.test(path.extname(file.originalname).toLowerCase());
	// Check mime
	const mimetype = filetypes.test(file.mimetype);
	if(mimetype && extname){
		return cb(null, true);
	} else {
		cb("Error: Images Only!");
	}
}

app.post("/upload_data", (req, res) => {
  console.log("/upload_data");
  const platform = req.body.platform;
  const location = req.body.location;
  if(platform == "DoorDash") {
    const total_earnings = req.body.total_earnings;
    const start_datetime = req.body.start_datetime;
    const end_datetime = req.body.end_datetime;
    const active_time = req.body.active_time;
    const dash_time = req.body.dash_time;
    const deliveries = req.body.deliveries;
    const DPH = (deliveries / dash_time * 60).toFixed(2);
    const TEPH = (total_earnings / dash_time * 60).toFixed(2);
    const id = platform + location + total_earnings + start_datetime + end_datetime + deliveries;
    console.log(id);
    var params = {
      TableName: "DoorDash_earnings",
      Item: {
        "id": id,
        "location": location,
        "total_earnings": total_earnings,
        "start_datetime": start_datetime,
        "end_datetime": end_datetime,
        "deliveries": deliveries,
        "DPH": DPH,
        "TEPH": TEPH
      }
    };
    docClient.put(params, function(err, data) {
      if(err) {
        console.error("Unable to add item. Error JSON: ", JSON.stringify(err, null, 2));
      } else {
        console.log("Added item: ", JSON.stringify(data, null, 2));
      }
    });
    /*
    const DoorDash_earnings = db.collection("DoorDash_earnings");
    DoorDash_earnings.doc(uid).set({
      platform: platform,
      location: location,
      total_earnings: total_earnings,
      start_datetime: start_datetime,
      end_datetime: end_datetime,
      active_time: active_time,
      dash_time: dash_time,
      deliveries: deliveries,
      DPH: DPH,
      TEPH: TEPH
    });
    */
  }
/*
  if(platform === "Uber" || platform === "Lyft" || platform === "HopSkipDrive") {
    const rideshare = db.collection("rideshare_earnings");
    rideshare.doc(uid).set({
      platform: platform,
      location: location,
      datetime: datetime,
      earnings: earnings
    });
  }
  else if(platform === "Uber Eats" || platform === "Postmates" || platform === "DoorDash" || platform === "Caviar" || platform === "Grubhub") {
    const foodDelivery = db.collection("food_delivery_earnings");
    foodDelivery.doc(uid).set({
      platform: platform,
      location: location,
      datetime: datetime,
      earnings: earnings
    });
  }
  else if(platform === "Instacart" || platform === "Shipt") {
    const groceryDelivery = db.collection("grocery_delivery_earnings");
    groceryDelivery.doc(uid).set({
      platform: platform,
      location: location,
      datetime: datetime,
      earnings: earnings
    });
  }
*/
  let message = "Data successfully uploaded";
  return res.send(message);
});

/*
// Add or remove platforms
app.post("/add_or_remove", async (req, res) => {
  console.log("/add_or_remove");
  const USER_ID = req.body.user_id;
  const PLATFORM = req.body.platform;
  console.log(USER_ID, PLATFORM);
  // Retrieve "gigs" collection from Firestore
  const gigs = db.collection("gigs");
  const query = gigs.where("user_id", "==", USER_ID).get()
    .then(snapshot => {
      if(snapshot.empty) {
        gigs.add({
          user_id: USER_ID,
          platforms: [PLATFORM],
        })
      } else {
        let message = "";
        snapshot.forEach(doc => {
          const platforms = doc.platforms;
          // Remove platform
          if(platforms.includes(PLATFORM)) {
            message = "Removed";
            const index = platforms.indexOf(PLATFORM);
            platforms.splice(index, 1);
            doc.set({platforms: platforms});
          } else {
            // Add platform
            message = "Added";
            platforms.push(PLATFORM);
            doc.set({platforms: platforms});
          }
        });
      }
      return res.send(message);
    })
    .catch(err => {
      console.log("Error getting documents", err);
    });
});

class Platform {
  constructor(name, value) {
      this.name = name;
      this.value = value;
  }
  getName() {
      return this.name;
  }
  getValue() {
      return this.value;
  }
}

// Update database with live values
app.post("/live_values", async (req, res) => {
  console.log("/live_values");
  const LOCATION = req.body.location;
  const UBER = new Platform("Uber", req.body.uber);
  const LYFT = new Platform("Lyft", req.body.lyft);
  const dt = new Date();
  const date = (dt.getMonth() + 1) + "-" + dt.getDate() + "-" + dt.getFullYear();
  const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
  const day = days[dt.getDay()];
  const time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
  const hour = dt.getHours();
  // Process each gig
  const platforms = [UBER, LYFT];
  platforms.forEach((platform) => {
    // Firestore
    const live_values = db.collection("live_values");
    const query = gigs.where("user_id", "==", USER_ID).get()
    .then(snapshot => {
      if(snapshot.empty) {
        gigs.add({
          user_id: USER_ID,
          platforms: [PLATFORM],
        })
      } else {
        let message = "";
        snapshot.forEach(doc => {
          const platforms = doc.platforms;
          // Remove platform
          if(platforms.includes(PLATFORM)) {
            message = "Removed";
            const index = platforms.indexOf(PLATFORM);
            platforms.splice(index, 1);
            doc.set({platforms: platforms});
          } else {
            // Add platform
            message = "Added";
            platforms.push(PLATFORM);
            doc.set({platforms: platforms});
          }
        });
      }
  });
});
*/

/**
 * @route POST /server/mogle/upload_screenshot
 * @desc Upload screenshot
 * @access public
 */
/*
app.post("/upload_screenshot", (req, res) => {
  console.log("/upload_screenshot");
	uploadScreenshot(req, res, (error) => {
		console.log("Successful Request", req.file);
		if(error) {
			console.log("Error: ", error);
			res.json({ error: error });
		} else {
			// If file not found
			if(req.file === undefined) {
				console.log("Error: No File Selected!");
				res.json("Error: No File Selected!");
			} else {
				// If success
				const imageName = req.file.key;
				const imageLocation = req.file.location;
        // Save the file name into database into profile model
				res.json({
					image: imageName,
					location: imageLocation
        });
        console.log("Success");
			}
		}
	});
});

/**
 * Upload Screenshot
 */
/*
const uploadScreenshot = multer({
	storage: multerS3({
		s3: s3,
		bucket: config.s3_bucket_screenshots,
		acl: config.access_control_list,
		key: function(req, file, cb) {
			cb(null, path.basename(file.originalname, path.extname(file.originalname)) + '-' + Date.now() + path.extname(file.originalname));
		}
	}),
	limits: { fileSize: 2000000 }, // 2 MB
	fileFilter: function(req, file, cb) {
		checkFileType(file, cb);
	}
}).single("screenshot");
*/

// Export
module.exports = app;