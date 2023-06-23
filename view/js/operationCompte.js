let submitOperation = document.getElementById("submitOperation");
// submitOperation.addEventListener("click", function(){
// console.log("test");
// });


let inputVersementOuRetrait = document.getElementById('inputVersementOuRetrait');
let typeOperationInput = document.getElementById("typeOperationId");



function checkTypeOperation() {
let typeOperation = document.querySelector('input[name=typeOperation]:checked').value;
swtichTypeOperation(typeOperation);

}

function getVersementInput() {
return "<label for='versementInput'>Versement :</label><br><input name='montantOperation' class='input'type='number' id='montantOperationInput' placeholder='+ 200 €'>";
}

function getRetraitInput() {
return "<label for='retraitInput'>Retrait :</label><br><input name='montantOperation' class='input' type='number' id='montantOperationInput' placeholder='- 500 €'>";
}

function swtichTypeOperation(typeOperation) {
if (typeOperation == "versement") {
    inputVersementOuRetrait.innerHTML = getVersementInput();
} else {
  if (typeOperation == "retrait") {
    inputVersementOuRetrait.innerHTML = getRetraitInput();
  } else {
    inputVersementOuRetrait.innerHTML = "";
  }
}
}
submitOperation.addEventListener("click", fetchOperation);
function fetchOperation () {
  let numCompte = document.getElementById("numCompteInput").value;
  let typeOperation = document.querySelector('input[name=typeOperation]:checked').value;
  let montantOperation = document.getElementById("montantOperationInput").value;
  let descriptionOpertion = document.getElementById("description").value;

  let data = {
    numCompte: numCompte,
    typeOperation: typeOperation,
    montantOperation: montantOperation,
    descriptionOpertion: descriptionOpertion,
  };
  console.log(data);
  fetch("http://localhost/POO_PHP_YACINE/Exercice_Banque_Appli_Complete/controller/distributeur.php?requete=operationCompte", {
    method: "POST", // or 'PUT'
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
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}


