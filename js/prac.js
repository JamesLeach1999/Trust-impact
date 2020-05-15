const input = document.querySelector('input[type="file"]');
input.addEventListener(
  "change",
  function (e) {
    console.log(input.files);
    const reader = new FileReader();
    reader.onload = function () {
      const lines = reader.result.split("\n").map(function (line) {
        return line.split(",");
      });
      console.log(lines);

      var data = e.target.result;
      var workbook = XLSX.read(data, {
        type: "binary",
      });
      console.log("numberwang");

      workbook.SheetNames.forEach(function (sheet) {
        // Here is your object
        var XL_row_object = XLSX.utils.sheet_to_row_object_array(
          workbook.Sheets[sheet]
        );
        var json_object = JSON.stringify(XL_row_object);
        console.log(json_object);
      });
    };

    reader.readAsText(input.files[0]);
  },
  false
);
var ExcelToJSON = function () {
  this.parseExcel = function (input) {
    var reader1 = new FileReader();

    reader1.onload = function (e) {
      var data = e.target.result;
      var workbook = XLSX.read(data, {
        type: "binary",
      });
      console.log("numberwang");

      workbook.SheetNames.forEach(function (input) {
        // Here is your object
        var XL_row_object = XLSX.utils.sheet_to_row_object_array(
          workbook.Sheets[input]
        );
        var json_object = JSON.stringify(XL_row_object);
        console.log(json_object);
      });
    };

    reader1.onerror = function (ex) {
      console.log(ex);
    };

    reader1.readAsBinaryString(file);
  };
};
