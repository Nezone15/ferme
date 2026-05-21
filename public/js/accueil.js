const slide_actuel = document.getElementById("slide-actuel");
const btn_suivant = document.getElementById("btn-suivant");
const btn_precedent = document.getElementById("btn-precedent");
const carrousel = document.getElementById("carrousel-slides");
const slides = document.querySelectorAll(".carrousel-slide");
// Initialisation
let index = 0;
slide_actuel.textContent = `${index}/3`;

/**
 * Faire glisser à la diapo correspondante à l'index donné et met à jour le compteur
 * @param {*} n L'index de la diapo à afficher (1, 2 ou 3)
 */
function updateSlide() {
  carrousel.style.transform = `translateX(-${index} * 100%))`;
  slides.forEach((slide, i) => {
    if (i === index) {
      slide.setAttribute("aria-hidden", "false");
    } else {
      slide.setAttribute("aria-hidden", "true");
    }
  });
  slide_actuel.textContent = `${index}/3`;
}

btn_suivant.addEventListener("click", () => {
  index++;
  if (index > 3) {
    index = 1;
  }
  updateSlide();
});

btn_precedent.addEventListener("click", () => {
  index--;
  if (index < 1) {
    index = 3;
  }
  updateSlide();
});
