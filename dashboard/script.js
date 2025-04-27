// Fonction pour charger les données JSON et afficher dans les cards
function afficherCategories() {
    fetch('index.json') // Charger le fichier JSON
        .then(response => {
            if (!response.ok) {
                throw new Error("Erreur de chargement du fichier JSON");
            }
            return response.json(); // Convertir la réponse en JSON
        })
        .then(data => {
            // On boucle sur les données JSON et on remplit les cards
            for (let i = 0; i < data.length; i++) {
                document.getElementById(`category${i + 1}`).textContent = data[i].nom_categorie;
                document.getElementById(`score${i + 1}`).textContent = `Score : ${data[i].score_total}`;
            }
        })
        .catch(error => {
            console.error("Erreur:", error);
        });
}

// S'assurer que le DOM est complètement chargé avant d'exécuter le script
document.addEventListener('DOMContentLoaded', function() {
    afficherCategories();
});

