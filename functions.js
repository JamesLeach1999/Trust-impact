
function loadPostcodes(){
    var xhttp = new XMLHttpRequest();


    var pCode = form.postcode.value;


    var results = [];
    xhttp.open("GET", "/home", true);

    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var result = this.responseText;

            results = JSON.parse(result);

            console.log(results);

            results.forEach((results)=>{

                var node = document.createElement("div");
                var pos = document.createElement("H5");

                pos.className = "res";

                imd = document.createTextNode(results.imd);
                
                pos.appendChild(imd);
                
                
                node.appendChild(pos);
                document.getElementById("post").appendChild(pos);
            })
            
        }
    }
    console.log(results);

    xhttp.send();
    console.log("success");
}

function test(){
    console.log("numberwang");
}