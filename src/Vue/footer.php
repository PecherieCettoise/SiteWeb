<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer avec Mini Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

</head>
<body>
<footer>
    <div class="footerNom">
        <!-- Section Contact -->
        <div class="contact-container">
            <h3>Contact</h3>
            <div>
                <img src="../../ressources/images/acceuil/calendrier.png" alt="Logo calendrier">
                <p>Du Lundi au Vendredi - 6h/12h - 14h/17h</p>

            </div>

            <div>
                <img src="../../ressources/images/acceuil/appel-telephonique.png" alt="Logo téléphone">
                <p>04 67 51 88 51</p>
            </div>

            <div>
                <a href="https://www.facebook.com/p/P%C3%AAcherie-Cettoise-100064808943708/" class="btn-image">
                    <img src="../../ressources/images/acceuil/icone-facebook-ronde.png" alt="Bouton Accueil">
                </a>

                <a href="https://www.instagram.com/pecheriecettoise/?hl=fr" class="btn-image">
                    <img src="../../ressources/images/acceuil/logo-instagram-rond.png">
                </a>
            </div>
        </div>

        <!-- Section Plan du Site -->
        <div class="footer-bouton">
            <h3>Plan du site</h3>
            <p>
                <a href="controleurFrontal.php?controleur=page&action=afficherAccueil">-> Accueil</a><br>
                <a href="controleurFrontal.php?controleur=page&action=afficherPecherieCettoise">-> Pêcherie Cettoise</a><br>
                <a href="controleurFrontal.php?controleur=page&action=afficherProduits">-> Nos Produits</a><br>
                <a href="controleurFrontal.php?controleur=page&action=afficherEngagements">-> Nos Engagements</a><br>
                <a href="controleurFrontal.php?controleur=page&action=afficherActualites">-> Actualités</a><br>
                <a href="controleurFrontal.php?controleur=page&action=afficherCandidatures">-> Candidatures</a><br>
                <a href="controleurFrontal.php?controleur=page&action=afficherContact">-> Contact</a>
            </p>
        </div>

        <!-- Section Carte -->
        <div class="map-container">
            <h3>Nous situer</h3>
            <div id="map"></div>
        </div>
    </div>

    <div class="mention">
        <p>La Pêcherie Cettoise © 2025 - <a href="controleurFrontal.php?controleur=page&action=afficherMentionsLegales">Mentions Légales</a>
        </p>
    </div>

</footer>

<!-- Script pour Leaflet (OpenStreetMap) -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var map = L.map('map').setView([43.4024, 3.7008], 13); // Coordonnées pour Sète, France

        // Ajout des tuiles OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Ajout d'un marqueur sur la carte
        L.marker([43.4024, 3.7008]).addTo(map)
            .bindPopup('<b>La Pêcherie Cettoise</b><br>239 rue phare de roquerols<br>34200 Sète, France')
            .openPopup();

        // Ajuster la taille de la carte lors du redimensionnement
        window.addEventListener("resize", function () {
            map.invalidateSize();
        });
    });
</script>

</body>
</html>
