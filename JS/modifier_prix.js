function modifier_prix(){
  var xmlhttp;
  xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      alert("La modification a été effectuée");
    }
  }

  xmlhttp.open("POST", "PHP/traitement_modifier_prix.php", true);
  xmlhttp.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded');
  xmlhttp.send('prix=' + document.getElementsByName('prix')[0].value);
}