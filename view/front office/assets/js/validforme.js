// Fonction pour valider le formulaire
function validateForm(event) {
  // Récupérer les valeurs des champs
  var nom = document.getElementById("nom").value;
  var email = document.getElementById("email").value;
  var tel = document.getElementById("tel").value;
  var date_creation = document.getElementById("date_creation").value;
  var etat = document.getElementById("etat").value;
  var type_reclamation = document.getElementById("type_reclamation").value;
  var evenement_concerne = document.getElementById("evenement_concerne").value;
  var description = document.getElementById("description").value;

  // Validation du champ "Nom" (ne doit pas être vide)
  if (nom === "") {
    alert("Le champ 'Nom' ne peut pas être vide.");
    event.preventDefault(); // Empêcher l'envoi du formulaire
    return false;
  }

  // Validation de l'email
  var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  if (!emailPattern.test(email)) {
    alert("Veuillez entrer un e-mail valide.");
    event.preventDefault();
    return false;
  }

  // Validation du téléphone (doit être un nombre)
  var phonePattern = /^[0-9]{8}$/; // Exemple de validation pour un numéro à 10 chiffres
  if (!phonePattern.test(tel)) {
    alert("Veuillez entrer un numéro de téléphone valide.");
    event.preventDefault();
    return false;
  }

  // Validation de la description
  if (description === "") {
    alert("La description de la réclamation ne peut pas être vide.");
    event.preventDefault();
    return false;
  }

  return true;
}
