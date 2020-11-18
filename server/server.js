"use strict";

// Local files
const dotenv = require("dotenv").config({ path: __dirname + "/../.env" });
const config = require("./config");
const mogle = require("./mogle/mogle");
const rideshare = require("./bots/rideshare");
const delivery = require("./bots/delivery");
const plaid = require("./plaid/plaid");
const anychart = require("./anychart/anychart");

// Local env variables
const SERVER_IP = process.env.SERVER_IP;

// Port configurations
mogle.listen(config.moglePort, () => {
  console.log(`Mogle API REST running in http://${SERVER_IP}:${config.moglePort}`);
});
rideshare.listen(config.ridesharePort, () => {
  console.log(`Rideshare API REST running in http://${SERVER_IP}:${config.ridesharePort}`);
});
delivery.listen(config.deliveryPort, () => {
  console.log(`Delivery API REST running in http://${SERVER_IP}:${config.deliveryPort}`);
});
plaid.listen(config.plaidPort, () => {
  console.log(`Plaid API REST running in http://${SERVER_IP}:${config.plaidPort}`);
});
anychart.listen(config.anychartPort, () => {
  console.log(
    `AnyChart API REST running in http://${SERVER_IP}:${config.anychartPort}`
  );
});