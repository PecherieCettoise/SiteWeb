let currentIndex1 = 0;
let currentIndex2 = 0;
let currentIndex3 = 0;

const images1 = [
    '../../ressources/images/actualite/bateau.png',
    '../../ressources/images/actualite/joute.png',
    '../../ressources/images/actualite/porter.png'
];

const images2 = [
    '../../ressources/images/actualite/bateau2.png',
    '../../ressources/images/actualite/escale.png',
    '../../ressources/images/actualite/bateau3.png'
];

const images3 = [
    '../../ressources/images/actualite/joueur.png',
    '../../ressources/images/actualite/vueInterieurJoute.png',
    '../../ressources/images/actualite/photoJoute.png'
];

function changeImage(direction, carouselId) {
    if (carouselId === 1) {
        currentIndex1 += direction;
        if (currentIndex1 < 0) {
            currentIndex1 = images1.length - 1;
        } else if (currentIndex1 >= images1.length) {
            currentIndex1 = 0;
        }
        document.getElementById('carousel-image-1').src = images1[currentIndex1];
    } else if (carouselId === 2) {
        currentIndex2 += direction;
        if (currentIndex2 < 0) {
            currentIndex2 = images2.length - 1;
        } else if (currentIndex2 >= images2.length) {
            currentIndex2 = 0;
        }
        document.getElementById('carousel-image-2').src = images2[currentIndex2];
    } else if (carouselId === 3) {
        currentIndex3 += direction;
        if (currentIndex3 < 0) {
            currentIndex3 = images3.length - 1;
        } else if (currentIndex3 >= images3.length) {
            currentIndex3 = 0;
        }
        document.getElementById('carousel-image-3').src = images3[currentIndex3];
    }
}

// Fonction pour ajuster l'opacité en fonction du scroll
function fadeInOnScroll() {
    const image = document.querySelector('.club img'); // Sélectionne l'image
    const debutText = document.querySelector('.debut-actualite p'); // Sélectionne le texte
    const imagePosition = image.getBoundingClientRect().top; // Position de l'image par rapport à la fenêtre
    const windowHeight = window.innerHeight; // Hauteur de la fenêtre

    // Calcul de l'opacité de l'image en fonction du scroll
    const imageOpacity = 1 - (imagePosition / windowHeight);

    // Si l'image est dans la fenêtre de vision, on ajuste son opacité
    if (imagePosition < windowHeight) {
        image.style.opacity = imageOpacity;
    } else {
        image.style.opacity = 0;  // Si l'image est hors de la fenêtre, elle devient invisible
    }

    // Pour le texte, ajustons son opacité également
    const debutTextPosition = debutText.getBoundingClientRect().top; // Position du texte
    const debutTextOpacity = 1 - (debutTextPosition / windowHeight);

    // Applique l'opacité sur le texte également
    if (debutTextPosition < windowHeight) {
        debutText.style.opacity = debutTextOpacity;
    } else {
        debutText.style.opacity = 0;  // Le texte disparaît si on le fait défiler
    }
}

// Écouteur d'événement pour le scroll
window.addEventListener('scroll', fadeInOnScroll);

// Appeler la fonction immédiatement pour ajuster la visibilité dès le chargement de la page
fadeInOnScroll();

