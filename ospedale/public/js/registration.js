window.onload=function() {
  document.getElementById("dipendente").style.display="none";
  var radios = document.forms[0].elements["ruolo"];
  for (var i = [0]; i < radios.length; i++)
  radios[i].onclick=radioClicked;
}

function radioClicked() {
  if (this.value == "paziente") {
    document.getElementById("dipendente").style.display="none";
    document.getElementById("paziente").style.display="block";
   } else {
    document.getElementById("dipendente").style.display="block";
    document.getElementById("paziente").style.display="none";
   }
}