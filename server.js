require("dotenv").config();

const express = require("express");
const cors = require("cors");
const mysql = require("mysql2");

const app = express();
app.use(cors());

///////////////////// DATABASE ////////////////////////////////
const db = mysql.createConnection({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASS,
  database: process.env.DB_NAME,
});

db.connect((err) => {
  if (err) {
    console.error("Error connecting to database:", err);
    return;
  }
  console.log("Connected to database");
});

///////////////////// API paths////////////////////////////////
app.get("/", (req, res) => {
  res.status(200).send("hello");
});

app.get("/firms/list", (req, res) => {
  const query =
    "select f.name as 'firm',c.main,c.surname,c.name,c.email,c.phone,c.active from contact as c inner join firm as f on firm_id = f.id order by firm, main desc,surname,name;";

  db.query(query, (err, results) => {
    if (err) {
      console.error("Error executing query:", err);
      return res.status(500).json({ success: false, error: "Database error" });
    }
    if (results.length === 0) {
      return res
        .status(404)
        .json({ success: false, message: "firms not found" });
    }
    output = {};
    let contacts = [];
    let last_firm = "";
    let firms = results;

    for (let num in firms) {
      let firm_name = firms[num].firm;

      if (last_firm !== firm_name) {
        if (last_firm) {
          output[last_firm] = contacts;
        }
        contacts = [];
        last_firm = firm_name;
      }

      console.log(firms[num]);
      contacts.push(firms[num]);
    }

    if (last_firm) {
      output[last_firm] = contacts;
    }

    res.status(200).json({ success: true, data: output });
  });
});

app.post("/firms/save", (req, res) => {
  res.status(501).send("not implenented yet");
});

app.patch("/firms/update", (req, res) => {
  res.status(501).send("not implenented yet");
});

app.delete("/firms/remove", (req, res) => {
  res.status(501).send("not implenented yet");
});

///// Contact Routes
app.post("/firms/contact/save", (req, res) => {
  res.status(501).send("not implenented yet");
});

app.patch("/firms/contact/update", (req, res) => {
  res.status(501).send("not implenented yet");
});

app.delete("/firms/contact/remove", (req, res) => {
  res.status(501).send("not implenented yet");
});

///// Card Routes
app.get("/firms/card/get/:firm", (req, res) => {
  res.status(501).send("not implenented yet");
});

app.post("/firms/card/save", (req, res) => {
  res.status(501).send("not implenented yet");
});

app.patch("/firms/card/update", (req, res) => {
  res.status(501).send("not implenented yet");
});

app.delete("/firms/card/delete", (req, res) => {
  res.status(501).send("not implenented yet");
});

///////////////// Start the server//////////////////////////
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
