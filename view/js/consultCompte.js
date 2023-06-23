let numeroCompte = document.getElementById("numeroCompte");
let soldeCompte = document.getElementById("soldeCompte");
let operationCompte = document.getElementById("operationCompte");

let btnChercher = document.getElementById("btnChercher");
btnChercher.addEventListener("click", function(){
    fetchCompteConsult();
});


function fetchCompteConsult() {
let chercherCompte = document.getElementById("chercherCompte").value;
let data = {
    chercherCompte: chercherCompte,
};
console.log(data);
    fetch("http://localhost/POO_PHP_YACINE/Exercice_Banque_Appli_Complete/controller/distributeur.php?requete=rechercherCompte", {
        // method: "Get", // or 'PUT'
        method: "POST",
        headers: {
        "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.text())
        .then((data) => {
             
        console.log("Success:", data);
        
        if (data == "error") {
            console.log("erreur fonctionnel !");
        }
        data = JSON.parse(data);
        createConsultCompte(data);
        })
        .catch((error) => {
        console.error("Error:", error);
        });
    }

        function createConsultCompte (data) {
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
            operations.forEach((element) => {
                let trElt = document.createElement("tr");
                let tdDescription = document.createElement("td");
                tdDescription.innerHTML = element.description;
                let tdDate = document.createElement("td");
                tdDate.innerHTML = element.date;
                let tdMontant = document.createElement("td");
                tdMontant.innerHTML = element.montant;
                let tdType = document.createElement("td");
                tdType.innerHTML = element.typeOperation;
        
                trElt.appendChild(tdDescription);
                trElt.appendChild(tdDate);
                trElt.appendChild(tdMontant);
                trElt.appendChild(tdType);
                tbodyElt.appendChild(trElt);
            });
            tableElt.appendChild(tbodyElt);
            operationCompte.appendChild(tableElt);
        }
        
