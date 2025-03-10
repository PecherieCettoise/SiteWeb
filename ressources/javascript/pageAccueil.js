let image = document.querySelector('.image-container img');
let currentIndex = 0;
let images = [
    { src: '../../ressources/images/acceuil/camion.jpg', alt: 'Camion' },
    { src: '../../ressources/images/acceuil/arrivage.jpg', alt: 'Arrivage' },
    { src: '../../ressources/images/acceuil/photoMer.jpg', alt: 'Mer' }
]; // Tableau d'objets contenant 'src' et 'alt'


function changeImage() {
    // Après 5 secondes, changer l'image et réinitialiser l'agrandissement
    setTimeout(() => {
        currentIndex = (currentIndex + 1) % images.length; // Passer à l'image suivante
        image.src = images[currentIndex].src; // Changer l'image
        image.alt = images[currentIndex].alt; // Mettre à jour le texte alternatif
        image.classList.remove('enlarge'); // Réinitialiser l'agrandissement
    }, 5000); // 5 secondes (durée de l'animation)
}

// Initialiser l'animation toutes les 5 secondes
setInterval(changeImage, 5000);

// Lancer immédiatement la première animation au chargement de la page
changeImage();



// Sélection des éléments
document.addEventListener("DOMContentLoaded", function () {
    const images = [
        "../ressources/images/acceuil/photoMer.jpg",
        "../ressources/images/acceuil/coquillageBleu.png",
        "../ressources/images/acceuil/logo.png"
    ];

    let index = 0; // Index de l'image actuelle
    const imageElement = document.getElementById("imagePromo");

    // Fonction pour changer l'image
    function changeImage(direction) {
        index += direction; // Incrémente ou décrémente l'index

        if (index < 0) {
            index = images.length - 1; // Retourne à la dernière image
        } else if (index >= images.length) {
            index = 0; // Retourne à la première image
        }

        imageElement.src = images[index]; // Change l'image affichée
    }

    // Attacher les événements aux boutons flèche
    document.querySelector(".prev").addEventListener("click", function () {
        changeImage(-1);
    });

    document.querySelector(".next").addEventListener("click", function () {
        changeImage(1);
    });
});

// Sélectionner l'iframe de la vidéo
const video = document.getElementById('video');

// Créer un observer d'intersection
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Si la vidéo entre dans la vue, on lance la lecture
            video.src = "https://www.youtube.com/embed/vePFbTBcju0?autoplay=1&mute=1";
        } else {
            // Si la vidéo sort de la vue, on met en pause (optionnel)
            video.src = "https://www.youtube.com/embed/vePFbTBcju0?autoplay=0&mute=1";
        }
    });
}, { threshold: 0.5 });  // Déclenche l'action lorsque 50% de la vidéo est visible

// Observer l'iframe
observer.observe(video);





let lastScrollTop = window.scrollY;
window.addEventListener("scroll", () => {
    let currentScroll = window.scrollY;
    let separator = document.querySelector(".separator").forEach(separator => {
        separator.style.transform = "scaleX(1.2)";
    });

    if (currentScroll > lastScrollTop) {
        // Scroll vers le bas → droite à gauche
        separator.style.transform = "translateX(-100px)";
    } else {
        // Scroll vers le haut → gauche à droite
        separator.style.transform = "translateX(200px)";
    }

    lastScrollTop = currentScroll;
});





document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll(".counter");
    let observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let target = parseInt(entry.target.getAttribute("data-target"));
                let count = 0;
                let step = target / 100; // Vitesse de l'animation

                let updateCounter = () => {
                    count += step;
                    if (count < target) {
                        entry.target.innerText = Math.floor(count);
                        requestAnimationFrame(updateCounter);
                    } else {
                        entry.target.innerText = target.toLocaleString(); // Format avec séparateurs
                    }
                };

                updateCounter();
                observer.unobserve(entry.target); // Arrête l'animation après la première fois
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => observer.observe(counter));
});









document.addEventListener("DOMContentLoaded", () => {
    const elementsToAnimate = document.querySelectorAll(".fade-right, .fade-left");

    let observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
            }
        });
    }, { threshold: 0.2 });

    elementsToAnimate.forEach(element => observer.observe(element));
});
