document.addEventListener('DOMContentLoaded', () => {
    const accordionHeaders = document.querySelectorAll('.accordion-header');

    accordionHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const accordionItem = header.parentElement;

            // Active/désactive uniquement l'élément actuel
            accordionItem.classList.toggle('active');
        });
    });
});



document.addEventListener("DOMContentLoaded", () => {
    const elementsToAnimate = document.querySelectorAll(".fade-right, .fade-left, .fade-up");

    let observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
            }
        });
    }, { threshold: 0.2 }); // L'animation se déclenche quand 20% de l'élément est visible

    elementsToAnimate.forEach(element => observer.observe(element));
});

