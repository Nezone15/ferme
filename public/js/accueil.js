const slide_actuel = document.getElementById("slide-actuel");
const btn_suivant = document.getElementById("btn-suivant");
const btn_precedent = document.getElementById("btn-precedent");
const carrousel = document.getElementById("carrousel-slides");
const slides = document.querySelectorAll(".carrousel-slide");
// Initialisation
let index = 1;
slide_actuel.textContent = `${index}/3`;

/**
 * Faire glisser à la diapo correspondante à l'index donné et met à jour le compteur
 * @param {*} n L'index de la diapo à afficher (1, 2 ou 3)
 */
function afficherSlide(n) {
  const deplacement = (n - 1) * -100; // Calcul du déplacement en pourcentage
  const carrousel = document.querySelector(".carrousel");
  carrousel.style.transform = `translateX(${deplacement}%)`; // Appliquer la transformation CSS
  slides.forEach((slide, i) => {
    if (i === n - 1) {
      slide.classList.add("affiche");
      slide.classList.remove("cache");
      slide.setAttribute("aria-hidden", "false");
    } else {
      slide.classList.remove("affiche");
      slide.classList.add("cache");
      slide.setAttribute("aria-hidden", "true");
    }
  });

  slide_actuel.textContent = `${n}/3`;
}

btn_suivant.addEventListener("click", () => {
  index = index === 3 ? 1 : index + 1;
  afficherSlide(index);
});

btn_precedent.addEventListener("click", () => {
  index = index === 1 ? 3 : index - 1;
  afficherSlide(index);
});
