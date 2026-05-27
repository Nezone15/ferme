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

//Swipe pour mobile
let touchStart = 0;
let touchEnd = 0;
const carrousel = document.getElementById("carrousel-conteneur");
// Enregistrer la position du doigt au moment où il touche l'écran
carrousel.addEventListener(
  "touchstart",
  (e) => {
    touchStart = e.changedTouches[0].screenX;
  },
  { passive: true },
);

// Enregistrer la position du doigt quand il quitte l'écran et calculer le geste
carrousel.addEventListener(
  "touchend",
  (e) => {
    touchEnd = e.changedTouches[0].screenX;
    verifierSwipe();
  },
  { passive: true },
);

// Déterminer la direction du swipe et simuler le clic sur vos boutons
function verifierSwipe() {
  const seuilDistance = 50; // Distance minimale en pixels pour valider le swipe
  const difference = touchStart - touchEnd;

  if (difference > seuilDistance) {
    // Swipe vers la gauche -> Diapo suivante
    btnSuivant.click();
  } else if (difference < -seuilDistance) {
    // Swipe vers la droite -> Diapo précédente
    btnPrecedent.click();
  }
}
