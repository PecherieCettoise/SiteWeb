<?php if (isset($produit)): ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Formulaire d'affichage du produit et d'ajout au panier -->
                <form method="POST" action="controleurFrontal.php?action=ajouterAuPanier&controleur=produit" class="p-4 border rounded shadow-sm">
                    <h1 class="text-center mb-4"><?= htmlspecialchars($produit->getDesignation()) ?></h1>
                    <!-- Image du produit -->
                    <div class="text-center mb-4">
                        <img src="path/to/your/image.jpg" alt="Image du produit" class="img-fluid rounded shadow-lg" style="max-height: 300px; object-fit: cover;">
                    </div>

                    <!-- Informations produit -->
                    <div class="product-info mb-4">
                        <p><strong>Prix:</strong> <?= number_format($produit->getPrixVente(), 2, ',', ' ') ?> €</p>
                        <p><strong>Poids Net:</strong> <?= htmlspecialchars($produit->getPoidsNet()) ?> kg</p>
                    </div>

                    <!-- Quantité -->
                    <div class="form-group mb-3">
                        <label for="quantite" class="font-weight-bold">Quantité:</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary" id="decrease">-</button>
                            <input type="number" name="quantite" id="quantite" class="form-control text-center" value="1" min="1" required>
                            <button type="button" class="btn btn-outline-secondary" id="increase">+</button>
                        </div>
                    </div>

                    <!-- Bouton Ajouter au panier -->
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">Ajouter au panier</button>
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="text-center mt-5">
        <p class="alert alert-danger">Produit non trouvé.</p>
    </div>
<?php endif; ?>

<script>
    // Gestion des boutons + et -
    document.getElementById("increase").addEventListener("click", function() {
        var quantityField = document.getElementById("quantite");
        quantityField.value = parseInt(quantityField.value) + 1;
    });
    document.getElementById("decrease").addEventListener("click", function() {
        var quantityField = document.getElementById("quantite");
        if (parseInt(quantityField.value) > 1) {
            quantityField.value = parseInt(quantityField.value) - 1;
        }
    });
</script>

<!-- Style CSS -->
<style>
    .container {
        max-width: 900px;
        padding: 20px;
    }

    .product-info p {
        font-size: 1.1rem;
        color: #555;
    }

    .btn-outline-secondary {
        font-size: 1.5rem;
        width: 45px;
        height: 45px;
        padding: 0;
        border-radius: 5px;
    }

    .btn-outline-secondary:hover {
        background-color: #f0f0f0;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        font-size: 1.2rem;
        padding: 12px;
        border-radius: 5px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .input-group {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-control {
        text-align: center;
        font-size: 1.2rem;
        padding: 0.5rem;
        border-radius: 5px;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }
        .product-info p {
            font-size: 1rem;
        }
    }
</style>
