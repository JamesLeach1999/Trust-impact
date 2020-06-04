const express = require("express");
const app = express();
const mysql = require("mysql");

const db = mysql.createConnection({
  host: "DB_HOST",
  user: "DB_USER",
  password: "DB_PASSWORD",
  database: "DB_NAME"
});

db.connect((err) =>{
  if(err) throw err;
  console.log("connected");
});

app.get("/", function(req, res){
  res.sendFile("./index.html", { root: __dirname});
})

app.get("/home", function(req, res, next){
  var context;
  db.query("SELECT * FROM DB_NAME WHERE postcode=tw110an", function(err, result){
    if(err){
      next(err);
      return;
    }
    console.log(result);
    // context.results = result;
    for(var i = 0; i < result.length; i++){
      console.log(result[i].imd);

      res.send(result[i].postcode);
    }
  });
});

app.listen("3000", () =>{
  console.log("server listening");
})