"use strict";

// Modules
const express = require("express");
const bodyParser = require("body-parser");

// Express
const app = express();
app.use(
  bodyParser.urlencoded({
    limit: "50mb",
    extended: true,
    parameterLimit: 1000000,
  })
);
app.use(bodyParser.json({ limit: "50mb" }));

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

// Parse transactions for expenses and income data
app.post("/get_expenses_income", (req, res) => {
  console.log("/get_expenses_income");
  const TRANSACTIONS = req.body.transactions;
  // Separate transactions into expenses and income
  const categoriesExpenses = {};
  const categoriesIncome = {};
  TRANSACTIONS.forEach((t) => {
    const category = t["category"][0];
    const amount = parseFloat(t["amount"]);
    if (amount > 0) {
      if (!(category in categoriesExpenses)) {
        categoriesExpenses[category] = amount;
      } else {
        categoriesExpenses[category] += amount;
      }
    } else {
      if (!(category in categoriesIncome)) {
        categoriesIncome[category] = Math.abs(amount);
      } else {
        categoriesIncome[category] += Math.abs(amount);
      }
    }
  });
  console.log("Expenses and income data successful");
  return res.send({
    categoriesExpenses: categoriesExpenses,
    categoriesIncome: categoriesIncome,
  });
});

// Export
module.exports = app;