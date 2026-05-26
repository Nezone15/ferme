// JS de la page vue admin.

// Permet d'afficher le nom de l'image sélectionnée dans le formulaire de création d'actualité.
document.getElementById("image").addEventListener("change", function () {
  const fileNameSpan = document.getElementById("nom-fichier");

  if (this.files && this.files.length > 0) {
    // Affiche le nom de l'image sélectionnée
    fileNameSpan.textContent = this.files[0].name;
  } else {
    // Remet le texte par défaut si l'utilisateur annule
    fileNameSpan.textContent = "Aucun fichier choisi";
  }
});
