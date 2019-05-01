function verifier_email(){
  var xmlhttp;
  xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      if(xmlhttp.responseText == '0'){
        //Mettre une "croix" rouge
        alert("L'adresse mail renseignée est déjà utilisée.");
        document.getElementById('inputEmail').value = "";
      }
      if(xmlhttp.responseText == '1')
      {
        //Mettre un "validé" vert
      }
    }
  }

  xmlhttp.open("POST", "../PHP/verifier_email.php", true);
  xmlhttp.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded');
  xmlhttp.send('email=' + document.getElementById('inputEmail').value);
}