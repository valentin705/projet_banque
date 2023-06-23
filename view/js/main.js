let contentBodyTable = document.getElementById("contentBodyId");
function init(){
console.log("Ok !");
fetchComptes();
}

function fetchComptes(){
    fetch("http://localhost/POO_PHP_YACINE/Exercice_Banque_Appli_Complete/controller/distributeur.php?requete=main", {
    method: "GET", // or 'PUT'
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Success:", data);
      if (data == "error") {
        console.log("erreur fonctionnel !");
      }
    
      createContent(data);
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function createContent(data) {
  data.forEach((element) => {
    let trElt = document.createElement("tr");
    let tdNum = document.createElement("td");
    tdNum.innerHTML = element.numero;
    let tdType = document.createElement("td");
    tdType.innerHTML = element.typeCompte;
    let tdId = document.createElement("td");
    tdId.innerHTML =" ";
    let tdSolde = document.createElement("td");
    tdSolde.innerHTML = element.solde;
    let tdDecouvert = document.createElement("td");
    tdDecouvert.innerHTML = element.decouvert;
    let tdTauxIneret = document.createElement("td");
    tdTauxIneret.innerHTML = element.tauxInteret;
    let tdNbOp = document.createElement("td");
    tdNbOp.innerHTML = element.nbOperation;
    let buttonConsulter = document.createElement("button");
    buttonConsulter.setAttribute("onclick", `consulterCompte("${element.numero}")`);
    buttonConsulter.innerHTML = "Consulter";
    buttonConsulter.addEventListener("click", function(){
      console.log("ok");
    });
    trElt.appendChild(tdNum);
    trElt.appendChild(tdType);
    trElt.appendChild(tdSolde);
    trElt.appendChild(tdDecouvert);
    trElt.appendChild(tdTauxIneret);
    trElt.appendChild(tdNbOp);
    trElt.appendChild(buttonConsulter);
    contentBodyTable.appendChild(trElt);
  })}

function consulterCompte(numeroCompte){
  window.location.href = "http://localhost/POO_PHP_YACINE/Exercice_Banque_Appli_Complete/view/pages/consultCompteDirectBtn.html?requete=consultationCompte&numero=" + numeroCompte;

}


