function update_week(){
  var xmlhttp;
  xmlhttp = new XMLHttpRequest();
  id = document.getElementById("id_enfant").value;


console.log(1);
  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      res = JSON.parse(xmlhttp.response);
      if(res[1] == "OUI"){
        document.getElementById('lundi').checked=true;
      } else{
        document.getElementById('lundi').checked=false;
      }
      if(res[2] == "OUI"){
        document.getElementById('mardi').checked=true;
      } else{
        document.getElementById('mardi').checked=false;
      }
      if(res[3] == "OUI"){
        document.getElementById('jeudi').checked=true;
      } else{
        document.getElementById('jeudi').checked=false;
      }
      if(res[4] == "OUI"){
        document.getElementById('vendredi').checked=true;
      } else{
        document.getElementById('vendredi').checked=false;
      }

    }
  }

  xmlhttp.open("POST", "PHP/semaine_type.php", true);
  xmlhttp.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded');
  xmlhttp.send('id=' + id);
}