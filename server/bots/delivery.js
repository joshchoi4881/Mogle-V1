"use strict";

// Modules
const express = require("express");
const bodyParser = require("body-parser");
const dotenv = require("dotenv").config({ path: __dirname + "/../../.env" });
const config = require("../config");
const request = require("request-promise");
const puppeteer = require("puppeteer");
const poll = require("promise-poller").default;
const readline = require("readline");

// Local env variables
const SERVER_IP = process.env.SERVER_IP;
const LOCATION_IQ_TOKEN = process.env.LOCATION_IQ_TOKEN;
const USERNAME = process.env.USERNAME;
const PASSWORD = process.env.PASSWORD;

// Puppeteer variables
const chrome_options = {
  executablePath: "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome",
  headless: false,
  slowMo: 10,
  defaultViewport: null,
};

// Readline
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

// Timeout
const timeout = (ms) => new Promise((res) => setTimeout(res, ms));

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

// Run Mogle bot
app.post("/mogle_bot", async (req, res) => {
  console.log("/mogle_bot");
  await timeout(3000);

  // Puppeteer
  const browser = await puppeteer.launch(chrome_options);
  const page = await browser.newPage();

  // Navigate to Mogle homepage
  console.log(`Navigating to ${config.mogle_url}`);
  await page.goto(config.mogle_url, {
    waitUntil: "load",
    timeout: 0,
  });
  await page.click("#rideshare");

  // Addresses to input
  var addresses = [
    "4 E Loudoun Street, Round Hill VA 20141",
    "2012 S goliad st, rockwall TX 75087",
  ];
  console.log("Entering addresses");

  // Continuously enter addresses about every two minutes
  while (true) {
    for (var i = 0; i < addresses.length; i++) {
      await page.evaluate(() => {
        document.getElementById("address").value = "";
      });
      await page.type("#address", addresses[i]);
      await page.click("#eval");
      await page.waitForSelector("#next", {
        waitUntil: "load",
        timeout: 0,
      });
      await timeout(120000);
    }
  }
});

// Get addresses
app.post("/get_addresses", async (req, res) => {
  console.log("/get_addresses");
  const ADDRESS = req.body.address;
  const addresses = [];
  addresses.push(ADDRESS);

  // Calculate latitude and longitude of original address
  const lat_lon = await getLatLon(ADDRESS);
  console.log("lat_lon" + lat_lon);
  const lat = JSON.parse(lat_lon)[0].lat;
  const lon = JSON.parse(lat_lon)[0].lon;
  console.log(lat);
  console.log(lon);
  console.log("\n");

  // Calculate nearby coordinates
  const coordinates = [];
  // North
  const n_lat = parseFloat(lat) + 0.07;
  const n_lon = parseFloat(lon);
  const n = {
    direction: "north",
    lat: n_lat,
    lon: n_lon,
  };
  coordinates.push(n);
  // Northeast
  const ne_lat = parseFloat(lat) + 0.05;
  const ne_lon = parseFloat(lon) + 0.05;
  const ne = {
    direction: "northeast",
    lat: ne_lat,
    lon: ne_lon,
  };
  coordinates.push(ne);
  // East
  const e_lat = parseFloat(lat);
  const e_lon = parseFloat(lon) + 0.07;
  const e = {
    direction: "east",
    lat: e_lat,
    lon: e_lon,
  };
  coordinates.push(e);
  // Southeast
  const se_lat = parseFloat(lat) - 0.05;
  const se_lon = parseFloat(lon) + 0.05;
  const se = {
    direction: "southeast",
    lat: se_lat,
    lon: se_lon,
  };
  coordinates.push(se);
  // South
  const s_lat = parseFloat(lat) - 0.07;
  const s_lon = parseFloat(lon);
  const s = {
    direction: "south",
    lat: s_lat,
    lon: s_lon,
  };
  coordinates.push(s);
  // Southwest
  const sw_lat = parseFloat(lat) - 0.05;
  const sw_lon = parseFloat(lon) - 0.05;
  const sw = {
    direction: "southwest",
    lat: sw_lat,
    lon: sw_lon,
  };
  coordinates.push(sw);
  // West
  const w_lat = parseFloat(lat);
  const w_lon = parseFloat(lon) - 0.07;
  const w = {
    direction: "west",
    lat: w_lat,
    lon: w_lon,
  };
  coordinates.push(w);
  // Northwest
  const nw_lat = parseFloat(lat) + 0.05;
  const nw_lon = parseFloat(lon) - 0.05;
  const nw = {
    direction: "northwest",
    lat: nw_lat,
    lon: nw_lon,
  };
  coordinates.push(nw);

  // Find other addresses based on coordinates
  for (let coordinate of coordinates) {
    console.log("Finding " + coordinate.direction + " address");
    const coordinate_address = await getAddress(
      coordinate.lat.toString(),
      coordinate.lon.toString()
    );
    const address_name = JSON.parse(coordinate_address).display_name;
    addresses.push(address_name);
    console.log(address_name);
    console.log("\n");
    await timeout(750);
  }
  return res.send({ addresses: addresses });
});

// Get lat and lon from address
const getLatLon = async (address) => {
  // Send GET request to LocationIQ
  const address_url = encodeURIComponent(address.trim());
  const url =
    "https://us1.locationiq.com/v1/search.php?key=" +
    LOCATION_IQ_TOKEN +
    "&q=" +
    address_url +
    "&format=json";
  let options = {
    url: url,
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const response = await request(options, (error, response, body) => {
    if (error) {
      console.log("Request failure");
    } else {
      console.log("Response success");
    }
  });
  return response;
};

// Get address from lat and lon
const getAddress = async (lat, lon) => {
  // Send GET request to LocationIQ
  const url =
    "https://us1.locationiq.com/v1/reverse.php?key=" +
    LOCATION_IQ_TOKEN +
    "&lat=" +
    lat +
    "&lon=" +
    lon +
    "&format=json";
  let options = {
    url: url,
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const response = await request(options, (error, response, body) => {
    if (error) {
      console.log("Request failure");
    } else {
      console.log("Response success");
    }
  });
  return response;
};

// Rideshare bots
app.post("/rideshare_bots", async (req, res) => {
  console.log("/rideshare_bots");
  const ADDRESS = req.body.address;
  let addresses = "";
  // Send POST request to '/get_addresses'
  let options = {
    uri: `http://${SERVER_IP}:${config.botsPort}/get_addresses`,
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      address: ADDRESS,
    }),
  };
  const response = await request(options, (error, response, body) => {
    if (error) {
      console.log("Request failure");
    } else {
      console.log("Response success");
    }
  });
  const responseJSON = JSON.parse(response);
  addresses = responseJSON.addresses;
  /* Send addresses to rideshare bots */
  const averages = [];
  // Send POST request to '/uber_bot'
  options = {
    uri: `http://${SERVER_IP}:${config.botsPort}/uber_bot`,
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      addresses: addresses,
    }),
  };
  averages[0] = new Promise((resolve, reject) => {
    request(options, (error, response, body) => {
      if (error) {
        console.log("Request failure");
        reject(error);
      } else {
        console.log("Response success");
        const bodyJSON = JSON.parse(body);
        const uber_average = bodyJSON.average;
        resolve(uber_average);
      }
    });
  });
  // Send POST request to '/lyft_bot'
  options = {
    uri: `http://${SERVER_IP}:${config.botsPort}/lyft_bot`,
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      addresses: addresses,
    }),
  };
  averages[1] = new Promise((resolve, reject) => {
    request(options, (error, response, body) => {
      if (error) {
        console.log("Request failure");
        reject(error);
      } else {
        console.log("Response success");
        const bodyJSON = JSON.parse(body);
        const lyft_average = bodyJSON.average;
        resolve(lyft_average);
      }
    });
  });
  // Send rideshare averages back
  Promise.all([averages[0]]).then((averages) => {
    averages[0] = parseFloat(values[0]).toFixed(2);
    // Send live values to database
    console.log("Sending live values to database");
    var http = require("http");
    var querystring = require("querystring");
    var data = {
      Location: address,
      Uber: values[0],
      Lyft: values[1],
    };
    var qs = querystring.stringify(data);
    var qslength = qs.length;
    var options = {
      hostname: "localhost",
      port: 8080,
      path: "/mogle/AJAX/liveValues.php",
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "Content-Length": qslength,
      },
    };
    var buffer = "";
    var req = http.request(options, function (res) {
      res.on("data", function (chunk) {
        buffer += chunk;
      });
      res.on("end", function () {
        console.log(buffer);
      });
    });
    req.write(qs);
    req.end();
    // Send live values back to client
    console.log("Sending live values to client");
    res.status(200).jsonp({ Uber_Eats: values[0] });
  });
});

// Uber bot
app.post("/uber_bot", async (req, res) => {
  console.log("/uber_bot");
  const ADDRESSES = req.body.addresses;
  // Puppeteer
  const browser = await puppeteer.launch(chrome_options);
  const page = await browser.newPage();
  // Uber login URL
  console.log(`Navigating to ${config.uber_login_url}`);
  await page.goto(config.uber_login_url, {
    waitUntil: "load",
    timeout: 0,
  });
  const username = USERNAME;
  console.log("Typing username");
  await page.type("#useridInput", username);
  await page.click("form button");
  await timeout(2000);
  if ((await page.$("#g-recaptcha-response")) !== null) {
    const request_id = await initiateCaptchaRequest(config.captcha_api_key);
    const response = await pollForRequestResults(
      config.captcha_api_key,
      request_id
    );
    console.log(`Entering recaptcha response ${response}`);
    await page.evaluate(
      `document.getElementById("g-recaptcha-response").innerHTML="${response}";`
    );
    console.log(`Submitting...`);
    await page.click("form button");
    await timeout(2000);
  }
  const password = PASSWORD;
  console.log("Typing password");
  await page.type("#password", password);
  await page.click("form button");
  await timeout(2000);
  if ((await page.$("#verificationCode")) !== null) {
    console.log("SUCCESS");
    var answer;
    rl.question("2FA CODE: ", (ans) => {
      answer = ans;
      outside();
      rl.close();
    });
    const outside = async () => {
      console.log("The user entered: ", answer);
      await page.type("#verificationCode", answer);
      await page.click("form button");
    };
    await timeout(15000);
  }
  // Uber map URL
  const prices = [];
  console.log(`Navigating to ${config.uber_map_url}`);
  await page.goto(config.uber_map_url, {
    waitUntil: "networkidle0",
    timeout: 0,
  });
  await page.type("input", ADDRESSES[0]);
  await page.waitForSelector("div[data-test='search-location-result']", {
    waitUntil: "networkidle0",
    timeout: 0,
  });
  await page.click("div[data-test='search-location-result']");
  for (let i = 1; i < ADDRESSES.length; i++) {
    await page.type("input", ADDRESSES[i]);
    await timeout(2000);
    if ((await page.$("div[data-test='search-location-result']")) !== null) {
      await page.click("div[data-test='search-location-result']");
      await page.waitForSelector("div[data-test='vehicle-view-container'] p", {
        waitUntil: "networkidle0",
        timeout: 0,
      });
      const result = await page.evaluate(() => {
        const price = document.querySelector(
          "div[data-test='vehicle-view-container'] p"
        ).innerText;
        console.log(price);
        return {
          price,
        };
      });
      let price = result["price"];
      price = parseFloat(price.substring(1));
      prices.push(price);
      console.log("Uber: " + price);
      console.log("\n");
      await timeout(1000);
      await page.click("div[data-test='drop-text'] svg");
    } else {
      const button = await page.$("input");
      await button.click();
      await timeout(1000);
      await button.click({ clickCount: 3 });
    }
  }
  // Calculate average
  const average = await calculateAverage(prices);
  console.log("Uber Average: " + average);
  res.send({ average: average });
  browser.close();
});

// Submit request to 2Captcha
async function initiateCaptchaRequest(api_key) {
  const form_data = {
    method: "userrecaptcha",
    pageurl: config.uber_login_url,
    googlekey: config.uber_site_key,
    key: api_key,
    json: 1,
  };
  console.log(
    `Submitting soution request to 2Captcha for ${config.uber_login_url}`
  );
  const response = await request.post(config.captcha_submit_url, {
    form: form_data,
  });
  return JSON.parse(response).request;
}

// Initiate polling
async function pollForRequestResults(
  key,
  id,
  retries = 50,
  interval = 1500,
  delay = 15000
) {
  console.log(`Waiting for ${delay} milliseconds...`);
  await timeout(delay);
  return poll({
    taskFn: requestCaptchaResults(key, id),
    interval,
    retries,
  });
}

// Poll for result
function requestCaptchaResults(api_key, request_id) {
  const url = `${config.captcha_retrieval_url}?key=${api_key}&action=get&id=${request_id}&json=1`;
  return async () => {
    return new Promise(async (resolve, reject) => {
      console.log("Polling for response...");
      const raw_response = await request.get(url);
      const response = JSON.parse(raw_response);
      console.log(response);
      if (response.status === 0) {
        return reject(response.request);
      }
      console.log("Response received.");
      resolve(response.request);
    });
  };
}

// Delivery bots
app.post("/delivery_bots", async (req, res) => {
  console.log("/delivery_bots");
  const ADDRESS = req.body.address;
  /* Send address to delivery bots */
  const averages = [];
  // Send POST request to '/uber_eats_bot'
  options = {
    uri: `http://${SERVER_IP}:${config.botsPort}/uber_eats_bot`,
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      address: ADDRESS,
    }),
  };
  averages[0] = new Promise((resolve, reject) => {
    request(options, (error, response, body) => {
      if (error) {
        console.log("Request failure");
        reject(error);
      } else {
        console.log("Response success");
        const bodyJSON = JSON.parse(body);
        const uber_eats_average = bodyJSON.average;
        resolve(uber_eats_average);
      }
    });
  });
  // Send delivery averages back
  Promise.all([averages[0]]).then((averages) => {
    console.log("Sending delivery averages back");
    console.log(averages[0]);
    res.send({ uber_eats: averages[0] });
  });
});

// Uber Eats bot
app.post("/uber_eats_bot", async (req, res) => {
  console.log("/uber_eats_bot");
  const ADDRESS = req.body.address;
  // Puppeteer
  const browser = await puppeteer.launch(chromeOptions);
  const page = await browser.newPage();
  console.log(`Navigating to ${config.loginURL}`);
  await page.goto(config.loginURL, {
    waitUntil: "load",
    timeout: 0,
  });
  const username = getUsername();
  console.log("Typing username");
  await page.type("#useridInput", username);
  await page.click("form button");
  await timeout(2000);
  if ((await page.$("#g-recaptcha-response")) !== null) {
    const requestId = await initiateCaptchaRequest(config.apiKey);
    const response = await pollForRequestResults(config.apiKey, requestId);
    console.log(`Entering recaptcha response ${response}`);
    await page.evaluate(
      `document.getElementById("g-recaptcha-response").innerHTML="${response}";`
    );
    console.log(`Submitting...`);
    await page.click("form button");
    await timeout(2000);
  }
  const password = getPassword();
  console.log("Typing password");
  await page.type("#password", password);
  await page.click("form button");
  await timeout(3000);
  if ((await page.$("#verificationCode")) !== null) {
    console.log("SUCCESS");
    var answer;
    rl.question("2FA CODE: ", function (ans) {
      answer = ans;
      outside();
      rl.close();
    });
    outside = async function () {
      console.log("The user entered: ", answer);
      await page.type("#verificationCode", answer);
      await page.click("form button");
    };
    await timeout(15000);
  }
  // Uber Eats website
  console.log(`Navigating to ${config.orderURL}`);
  await page.goto(config.orderURL, {
    waitUntil: "networkidle2",
    timeout: 0,
  });
  await page.click("a[rel='nofollow']");
  await timeout(3000);
  await page.type("#location-typeahead-home-input", ADDRESS);
  await timeout(3000);
  await page.click("button.c7.ch.bi");
  await page.waitForSelector("div[role='search']", {
    timeout: 0,
  });
  await page.click("div[role='search']");
  // McDonald's
  await page.type("#search-suggestions-typeahead-input", "McDonald's");
  await page.keyboard.press("Enter");
  // Restaurant
  await page.waitForSelector("img[role='presentation']", {
    timeout: 0,
  });
  const [restaurant] = await page.$x('//div[contains(., "McDonald\'s®")]');
  if (restaurant) {
    await restaurant.click();
    console.log("McDonald's");
  }
  // Meal
  await page.waitForSelector("ul > li > ul > li > a[rel='nofollow']", {
    timeout: 0,
  });
  await page.click("ul > li > ul > li > a[rel='nofollow']");
  console.log("Little Mac");
  // Option
  await page.waitForSelector("ul > li > div > input", {
    timeout: 0,
  });
  const [option] = await page.$x(
    "//html/body/div[1]/div/div[3]/div/div/div[2]/div[4]/ul/li/div[2]/label[3]/div[2]/div/div[1]"
  );
  if (option) {
    await option.click();
    console.log("Option");
  }
  // Add
  await page.waitForXPath(
    "//html/body/div[1]/div/div[3]/div/div/div[2]/div[4]/div[3]/button",
    {
      timeout: 0,
    }
  );
  const [add] = await page.$x(
    "//html/body/div[1]/div/div[3]/div/div/div[2]/div[4]/div[3]/button"
  );
  if (add) {
    await add.click();
    console.log("Add");
  }
  // Checkout
  await page.waitForXPath(
    "//html/body/div[1]/div/header/div/div/div[6]/div[5]/div/div[8]/a",
    {
      timeout: 0,
    }
  );
  const [checkout] = await page.$x(
    "//html/body/div[1]/div/header/div/div/div[6]/div[5]/div/div[8]/a"
  );
  if (checkout) {
    await checkout.click();
    console.log("Checkout");
  }
  // Price
  await page.waitForXPath(
    "//html/body/div[1]/div/div[1]/main/div[2]/div[4]/ul/li[4]/div[2]/span",
    {
      timeout: 0,
    }
  );
  const deliveryFee = await page.$x(
    "//html/body/div[1]/div/div[1]/main/div[2]/div[4]/ul/li[4]/div[2]/span"
  );
  const price = await deliveryFee[0].getProperty("textContent");
  console.log(price["_remoteObject"]["value"].substring(1));
  res.send({ average: price });
  browser.close();
});

// Calculate average
function calculateAverage(prices) {
  let sum = 0;
  let average = 0;
  for (var i in prices) {
    sum += prices[i];
  }
  average = (sum / prices.length).toFixed(2);
  return average;
}

// Export
module.exports = app;