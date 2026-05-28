const email = document.querySelector("input[name='email']");
const nom = document.querySelector("input[name='nom']");
const prenom = document.querySelector("input[name='prenom']");
const mdp = document.querySelector("input[name='mdp']");
const mdpConfirme = document.querySelector("input[name='mdpConfirme']");

email.addEventListener("change", function () {
  const emailInvalide = document.getElementById("email-invalide");
  if (email.validity.typeMismatch) {
    console.log("Email invalide");
    emailInvalide.textContent = "Veuillez entrer une adresse e-mail valide.";
  } else {
    emailInvalide.textContent = "";
  }
});

nom.addEventListener("change", function () {
  const nomInvalide = document.getElementById("nom-invalide");
  if (nom.validity.patternMismatch) {
    nomInvalide.textContent = "Le nom doit comporter au moins 2 caractères.";
  } else {
    nomInvalide.textContent = "";
  }
});

prenom.addEventListener("change", function () {
  const prenomInvalide = document.getElementById("prenom-invalide");
  if (prenom.validity.patternMismatch) {
    prenomInvalide.textContent =
      "Le prénom doit comporter au moins 2 caractères.";
  } else {
    prenomInvalide.textContent = "";
  }
});

mdp.addEventListener("change", function () {
  const mdpInvalide = document.getElementById("mdp-invalide");
  if (mdp.validity.patternMismatch) {
    mdpInvalide.textContent =
      "Le mot de passe doit comporter au moins 6 caractères dont une majuscule et un chiffre.";
  } else {
    mdpInvalide.textContent = "";
  }
});

mdpConfirme.addEventListener("change", function () {
  const mdpConfirmeInvalide = document.getElementById("mdpConfirme-invalide");
  if (mdpConfirme.value !== mdp.value) {
    mdpConfirmeInvalide.textContent = "Les mots de passe ne correspondent pas.";
  } else {
    mdpConfirmeInvalide.textContent = "";
  }
});
