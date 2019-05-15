function ajouterenfant(){
  var xmlhttp;
  xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      if(xmlhttp.responseText == '0'){
        alert("Login ou mot de passe incorrect, veuillez réessayer.");
      }
      if(xmlhttp.responseText == "1")
      {
        location.href = '../accueil.php';
      }
      if(xmlhttp.responseText.match(/Erreur.*/))
      {
        alert(xmlhttp.responseText);
      }
    }
  }

  xmlhttp.open("POST", "../PHP/ajouterenfant.php", true);
  xmlhttp.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded');
  xmlhttp.send('nom=' + document.getElementById('inputNom').value + '&prenom=' + document.getElementById('inputPrenom').value + '&datenaissance=' + document.getElementById('inputDate').value + '&classe=' + document.getElementById('inputClasse').value);
}