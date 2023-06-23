let numeroCompte = document.getElementById("numeroCompte");
let soldeCompte = document.getElementById("soldeCompte");

let descriptionOperation = document.getElementById("descriptionOperation");
let dateOperation = document.getElementById("dateOperation");
let montantOperation = document.getElementById("montantOperation");
let typeOperation = document.getElementById("typeOperation");

function fetchCompte(numeroCompte) {
  fetch(
    'http://localhost/POO_PHP_YACINE/Exercice_Banque_Appli_Complete/controller/distributeur.php?requete=consultationCompte&numero=' + numeroCompte,
    {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      },
    }
  )
    .then((response) => response.text())
    .then((data) => {
      console.log('Success:', data);
      if (data == 'error') {
        console.log('erreur fonctionnel !');
      }

      data = JSON.parse(data);
      createConsultCompte(data);
    })
    .catch((error) => {
      console.error('Error:', error);
    });
}









function createConsultCompte(data) {
    numeroCompte.innerHTML = data[0].numero;
    soldeCompte.innerHTML = data[0].solde;
    let operations = data[0].operationDto;
    
    let tableElt = document.createElement("table");
    tableElt.setAttribute("class", "table table-striped");
    let theadElt = document.createElement("thead");
    let thDescription = document.createElement("th");
    thDescription.innerHTML = "Description";
    let thDate = document.createElement("th");
    thDate.innerHTML = "Date";
    let thMontant = document.createElement("th");
    thMontant.innerHTML = "Montant";
    let thType = document.createElement("th");
    thType.innerHTML = "Type";
    theadElt.appendChild(thDescription);
    theadElt.appendChild(thDate);
    theadElt.appendChild(thMontant);
    theadElt.appendChild(thType);
    tableElt.appendChild(theadElt);
    let tbodyElt = document.createElement("tbody");
    operations.forEach((operation) => {
        let trElt = document.createElement("tr");
        let tdDescription = document.createElement("td");
        tdDescription.innerHTML = operation.description;
        let tdDate = document.createElement("td");
        tdDate.innerHTML = operation.date;
        let tdMontant = document.createElement("td");
        tdMontant.innerHTML = operation.montant;
        let tdType = document.createElement("td");
        tdType.innerHTML = operation.typeOperation;
        trElt.appendChild(tdDescription);
        trElt.appendChild(tdDate);
        trElt.appendChild(tdMontant);
        trElt.appendChild(tdType);
        tbodyElt.appendChild(trElt);
    });
    tableElt.appendChild(tbodyElt);
    operationCompte.appendChild(tableElt);
    }

    function init() {
        console.log("ok !");
        const urlParams = new URLSearchParams(window.location.search);
        const numeroCompte = urlParams.get('numero');
        fetchCompte(numeroCompte);
    }