// Fonction de validation du formulaire
function validform(event) {
  // Récupérer les valeurs des champs
  var nom = document.getElementById("nom").value;
  var email = document.getElementById("email").value;
  var tel = document.getElementById("tel").value;
  var date_creation = document.getElementById("date_creation").value;
  var etat = document.getElementById("etat").value;
  var type_reclamation = document.getElementById("type_reclamation").value;
  var evenement_concerne = document.getElementById("evenement_concerne").value;
  var description = document.getElementById("description").value;

  // Validation du champ "Nom"
  if (nom.trim() === "") {
      alert("Le champ 'Nom' ne peut pas être vide.");
      event.preventDefault(); // Empêche la soumission du formulaire
      return false;
  }

  // Validation de l'email
  var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  if (!emailPattern.test(email)) {
      alert("Veuillez entrer un e-mail valide.");
      event.preventDefault();
      return false;
  }

  // Validation du téléphone (format numérique, 10 chiffres)
  var phonePattern = /^[0-9]{8}$/;
  if (!phonePattern.test(tel)) {
      alert("Veuillez entrer un numéro de téléphone valide.");
      event.preventDefault();
      return false;
  }

  // Validation de la description
  if (description.trim() === "") {
      alert("La description ne peut pas être vide.");
      event.preventDefault();
      return false;
  }

  // Si tout est valide, le formulaire peut être soumis
  return true;
}
