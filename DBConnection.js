const mysql = require("mysql");

function getConnection() {
  var con = mysql.createConnection({
    host: "localhost",
    user: "James",
    password: "sexyjosh69",
    database: "trust"
  });
  return con;
};

module.exports.getConnection = getConnection;
