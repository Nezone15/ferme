//menu burger
const burger = document.querySelector(".burger");
const nav = document.querySelector("nav");

burger.addEventListener("click", (event) => {
  event.stopPropagation();
  nav.classList.toggle("actif");
  burger.classList.toggle("inactif");
});

document.addEventListener("click", (event) => {
  // On vérifie si le menu est actuellement ouvert
  if (nav.classList.contains("actif")) {
    // Si le clic N'EST PAS à l'intérieur du menu
    if (!nav.contains(event.target)) {
      nav.classList.toggle("actif");
      burger.classList.toggle("inactif");
    }
  }
});
