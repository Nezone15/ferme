const rail = document.getElementById("carrousel-conteneur");
const slides = document.querySelectorAll(".carrousel-slide");
const btnPrecedent = document.getElementById("btn-precedent");
const btnSuivant = document.getElementById("btn-suivant");
const totalSlides = slides.length;

// On commence à l'index 1, car l'index 0 est le clone de la dernière image
let index = 1;

function deplacerRail(animation = true) {
  if (animation) {
    rail.style.transition = "transform 0.5s ease-in-out";
  } else {
    rail.style.transition = "none";
  }
  rail.style.transform = `translateX(-${index * 100}%)`;
}

btnPrecedent.addEventListener("click", () => {
  index = (index - 1 + slides.length) % slides.length;
  deplacerRail();
});

btnSuivant.addEventListener("click", () => {
  index = (index + 1) % slides.length;
  deplacerRail();
});

rail.addEventListener("transitionend", () => {
  if (index === totalSlides - 1) {
    index = 1;
    deplacerRail(false);
  }
  if (index === 0) {
    index = totalSlides - 2;
    deplacerRail(false);
  }
});
