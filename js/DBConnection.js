const mysql = require("mysql");

function getConnection() {
  var con = mysql.createConnection({
    host: "DB_HOST",
    user: "DB_USER",
    password: "DB_PASSWORD",
    database: "DB_NAME"
  });
  return con;
};

module.exports.getConnection = getConnection;
