function supprimerenfant(id){
  var xmlhttp;
  xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      document.getElementById(id).remove();
    } else {

    }
  }
  xmlhttp.open("POST", "../PHP/supprimerenfant.php", true);
  xmlhttp.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded');
  xmlhttp.send("id=" + id);
}