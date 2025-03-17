<form action="controleurFrontal.php?action=importerFichiers&controleur=fichierCSV" method="post" enctype="multipart/form-data">
    <label for="fileClient">Fichier Clients (CSV):</label>
    <input type="file" name="fileClient" id="fileClient" accept=".csv">

    <label for="fileProduit">Fichier Produits (CSV):</label>
    <input type="file" name="fileProduit" id="fileProduit" accept=".csv">

    <input type="submit" value="Importer">
</form>