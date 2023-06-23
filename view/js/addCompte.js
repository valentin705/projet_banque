let inputDecouvertOuInteret = document.getElementById('inputDecouvertOuInteret');
let typeCompteInput = document.getElementById("typeCompteId");


function checkTypeCompte() {
let typeCompte = document.querySelector('input[name=typeCompte]:checked').value;
swtichTypeCompte(typeCompte);

}

function getDecouvertInput() {
return "<label for='decouvertInput'>Découvert :</label><br><input name='decouvert' class='input'type='number' id='decouvertInput' placeholder='200 €'>";
}

function getTauxInteretInput() {
return "<label for='tauxInteretInput'>Taux Interêt :</label><br><input name='tauxInteret' class='input' type='' id='tauxInteretInput' placeholder='1.5 %'>";
}

function swtichTypeCompte(typeCompte) {
if (typeCompte == "courant") {
    inputDecouvertOuInteret.innerHTML = getDecouvertInput();
} else {
  if (typeCompte == "epargne") {
    inputDecouvertOuInteret.innerHTML = getTauxInteretInput();
  } else {
    inputDecouvertOuInteret.innerHTML = "";
  }
}
}

// fectch pour ajouter un compte 

let submitId = document.getElementById("SubmitId");
// submitId.addEventListener("click", function(){
// console.log("test");
// });
submitId.addEventListener("click", fetchAdd);

function fetchAdd () {
let numCompte = document.getElementById("numCompteInput").value;
let typeCompte = document.querySelector('input[name=typeCompte]:checked').value;
let decouvertOuInteret;
let solde = document.getElementById("soldeCompteInput").value;

if (typeCompte == "courant") {
        
    decouvertOuInteret = document.getElementById('decouvertInput').value;

} else if (typeCompte == "epargne") {
    
    decouvertOuInteret = document.getElementById('tauxInteretInput').value;
} 

let data = {
  numCompte: numCompte,
  typeCompte: typeCompte,
  decouvertOuInteret: decouvertOuInteret,
  solde: solde,
};

console.log(data);

fetch("http://localhost/POO_PHP_YACINE/Exercice_Banque_Appli_Complete/controller/distributeur.php?requete=createCompte", {
  method: "POST", // or 'PUT'
  headers: {
    "Content-Type": "application/json",
  },
  body: JSON.stringify(data),
})
  .then((response) => response.json())
  .then((data) => {
    console.log("Success:", data);
    if (data == "error") {
      console.log("erreur fonctionnel !");
    }
  })
  .catch((error) => {
    console.error("Error:", error);
  });
}


