const http = require("http");
const fs = require("fs");
const con = require("./DBConnection");
const express = require("express");
const app = express();

const hostname = "127.0.0.1";
const port = "3000";

// use http.createServer to initialise on port 3000
const server = http.createServer((req, res) => {
  // on page load, read index.html and display using pipe(res)
  if(req.method == "GET" && req.url == "/home"){
    res.statusCode == 200;
    res.setHeader("Content-Type", "text/html");
    
    var conn = con.getConnection();
    conn.connect(function (err) {
      if (err) throw err;
      console.log("conc");
    });
    
    conn.query("SELECT * FROM trust", function (err, results, fields) {
      if (err) throw err;
      
      var postcodes = JSON.stringify(results);
      console.log(postcodes);
    });
    
    fs.createReadStream("./index.html").pipe(res);
    conn.end();
    // console.log("numberwang");

    // read in the functions file
  } else if (req.method = "GET" && req.url == "/functions.js"){
    
    res.writeHead(200, {"Content-Type": "text/javascript"});
    fs.createReadStream("./functions.js").pipe(res);

  } else if (req.method == "GET" && req.url == "/home"){
// this is the query, connects to sql via conn and the getConnection function in DBConnection
    res.statusCode == 200;
    res.setHeader("Content-Type", "application/json");

    var conn = con.getConnection();
    console.log(conn);

    conn.connect(function(err){
      if(err) throw err;
      console.log("conc");
    })

    conn.query("SELECT * FROM trust", function (err, results, fields) {
      if (err) throw err;

      var postcodes = JSON.stringify(results);
      console.log(postcodes);

      res.end(postcodes);

    });
    
    conn.end();
  };
});



server.listen(port, hostname, () =>{
  console.log("Server running");
});