"use strict";

// Modules
const express = require("express");
const bodyParser = require("body-parser");
const dotenv = require("dotenv").config({ path: __dirname + "/../../.env" });
const config = require("../config");
const plaid = require("plaid");
const request = require("request-promise");
const admin = require("firebase-admin");

// Local env variables
const SERVER_IP = process.env.SERVER_IP;
const client = new plaid.Client(
  process.env.PLAID_CLIENT_ID,
  process.env.PLAID_SECRET_SANDBOX,
  process.env.PLAID_PUBLIC_KEY,
  plaid.environments.sandbox
);

// Plaid variables
// We store the access_token in memory - in production, store it in
// a secure persistent data store.
var PUBLIC_TOKEN = null;
var ACCESS_TOKEN = null;

// Firestore variables
const serviceAccount = require("../mogleapp4881-a9172112d9cd.json");
admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
});
const db = admin.firestore();

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

// Accept the public_token sent from Link
app.post("/get_access_token", (req, res) => {
  console.log("/get_access_token");
  PUBLIC_TOKEN = req.body.public_token;
  // Exchange public token for access token
  client.exchangePublicToken(PUBLIC_TOKEN, (err, token_response) => {
    // Handle err
    if (err != null) {
      console.log("Could not exchange public_token!" + "\n" + err);
      return res.send(err);
    } else {
      ACCESS_TOKEN = token_response.access_token;
      return res.send({ access_token: ACCESS_TOKEN });
    }
  });
});

// Get item, accounts and save to Firestore
app.post("/firestore", async (req, res) => {
  console.log("/firestore");
  const UID = req.body.uid;
  PUBLIC_TOKEN = req.body.public_token;
  // Send POST request to '/get_access_token'
  let options = {
    uri: `http://${SERVER_IP}:${config.plaidPort}/get_access_token`,
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      public_token: PUBLIC_TOKEN,
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
  ACCESS_TOKEN = responseJSON.access_token;
  // Pull the accounts associated with the Item
  client.getAccounts(ACCESS_TOKEN, (err, result) => {
    // Handle err
    if (err != null) {
      console.log("Could not get accounts!" + "\n" + err);
      return res.send(err);
    } else {
      const { item, accounts } = result;
      // Save to Firestore
      db.collection("plaid_item")
        .add({
          user_id: UID,
          available_products: item.available_products,
          billed_products: item.billed_products,
          institution_id: item.institution_id,
          item_id: item.item_id,
          webhook: item.webhook,
        })
        .then((plaid_item_id) => {
          accounts.map((account) => {
            db.collection("plaid_account").add({
              plaid_item_id: plaid_item_id.id,
              account_id: account.account_id,
              balances: account.balances,
              mask: account.mask,
              name: account.name,
              official_name: account.official_name,
              subtype: account.subtype,
              type: account.type,
            });
          });
        })
        .then(() => {
          console.log("Firestore successful");
          return res.send("Success");
        });
    }
  });
});

// Pull transactions for a date range
app.post("/get_transactions", async (req, res) => {
  console.log("/get_transactions");
  PUBLIC_TOKEN = req.body.public_token;
  const START_DATE = req.body.start_date;
  const END_DATE = req.body.end_date;
  // Send POST request to '/get_access_token'
  let options = {
    uri: `http://${SERVER_IP}:${config.plaidPort}/get_access_token`,
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      public_token: PUBLIC_TOKEN,
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
  ACCESS_TOKEN = responseJSON.access_token;
  // Get transactions
  client.getTransactions(
    ACCESS_TOKEN,
    START_DATE,
    END_DATE,
    {
      count: 250,
      offset: 0,
    },
    (err, result) => {
      // Handle err
      if (err != null) {
        console.log("Could not get transactions");
        return res.send(err);
      } else {
        const transactions = result.transactions;
        console.log("Transactions successful");
        return res.send({ transactions: transactions });
      }
    }
  );
});

// Export
module.exports = app;