// connexion.js
document.addEventListener("DOMContentLoaded", () => {
  // 1. Création de la structure HTML de la modale
  const htmlConnexion = `
        <dialog id="modaleConnexion">
            <form method="dialog">
                <h2>Connexion</h2>
                <input type="text" placeholder="Email" autofocus required>
                <input type="password" placeholder="Mot de passe" required>
                <div class="modale_boutons">
                    <button type="submit">Se connecter</button>
                    <button type="button" onclick="ouvreModaleInscription()">S'inscrire</button>
                    <button type="button" id="fermerModaleConnexion">Annuler</button>
                </div>
            </form>
        </dialog>
    `;

  // 2. Insertion dans le DOM
  document.body.insertAdjacentHTML("beforeend", htmlConnexion);

  const modaleConnexion = document.getElementById("modaleConnexion");
  const fermerModaleConnexion = document.getElementById(
    "fermerModaleConnexion",
  );

  // 3. Fermer la modale avec le bouton "Annuler", lorsque l'utilisateur clique en dehors de la modale
  fermerModaleConnexion.addEventListener("click", () =>
    modaleConnexion.close(),
  );
  modaleConnexion.addEventListener("click", (event) => {
    if (event.target === modaleConnexion) {
      modaleConnexion.close();
    }
  });
});

// Fonction globale pour ouvrir la modale depuis n'importe où
function ouvreModaleConnexion() {
  const modaleConnexion = document.getElementById("modaleConnexion");
  modaleConnexion.showModal();
}
