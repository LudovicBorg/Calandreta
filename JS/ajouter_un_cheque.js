function ajouter_un_cheque(){
  var xmlhttp;
  xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      alert("Le cheque a été ajouté et le solde mit à jour");
    }
  }

  xmlhttp.open("POST", "PHP/traitement_ajouter_cheque.php", true);
  xmlhttp.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded');
  xmlhttp.send('date_cheque=' + document.getElementsByName('date_cheque')[0].value + "&numero_cheque=" + (document.getElementsByName("numero_cheque")[0]).value + "&montant_cheque=" + (document.getElementsByName("montant_cheque")[0]).value + "&parents=" + (document.getElementsByName("parents")[0]).value);
}