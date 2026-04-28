//Deconnexion avec confirmation
const formDeconnexion = document.getElementById("deconnexion");

if (formDeconnexion) {
  formDeconnexion.addEventListener("submit", function (event) {
    event.preventDefault();
    if (confirm("Êtes-vous sûr de vouloir vous déconnecter ?")) {
      formDeconnexion.submit();
    }
  });
}
