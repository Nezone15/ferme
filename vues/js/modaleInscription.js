document.addEventListener("DOMContentLoaded", () => {
  // 1. Création de la structure HTML de la modale
  const htmlInscription = `
        <dialog id="modaleInscription">
            <form method="dialog">
                <h2>Inscription</h2>
                <input type="text" placeholder="Nom" autofocus required>
                <input type="text" placeholder="Prénom" required>
                <input type="email" placeholder="Email" required>
                <input type="password" placeholder="Mot de passe" required>
                <input type="password" placeholder="Confirmer le mot de passe" required>
                <input type="text" placeholder="Adresse">
                <input type="text" placeholder="Code postal">
                <input type="text" placeholder="Ville">
                <input type="text" placeholder="Pays">
                <input type="text" placeholder="Numéro de téléphone">
                <div class="modale_boutons">
                    <button type="submit">S'inscrire</button>
                    <button type="button" id="fermerModaleInscription">Annuler</button>
                </div>
            </form>
        </dialog>
    `;

  // 2. Insertion dans le DOM
  document.body.insertAdjacentHTML("beforeend", htmlInscription);

  const modaleInscription = document.getElementById("modaleInscription");
  const fermerModaleInscription = document.getElementById(
    "fermerModaleInscription",
  );

  // 3. Fermer la modale avec le bouton "Annuler" ou quand je clique à côté
  fermerModaleInscription.addEventListener("click", () =>
    modaleInscription.close(),
  );
  modaleInscription.addEventListener("click", (event) => {
    if (event.target === modaleInscription) {
      modaleInscription.close();
    }
  });
});

// Fonction globale pour ouvrir la modale depuis n'importe où
function ouvreModaleInscription() {
  const modaleConnexion = document.getElementById("modaleConnexion");
  modaleConnexion.close();
  const modaleInscription = document.getElementById("modaleInscription");
  modaleInscription.showModal();
}
