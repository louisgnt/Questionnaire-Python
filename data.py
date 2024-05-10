import matplotlib.pyplot as plt
import numpy as np
import requests

# Télécharger le contenu du lien
url = "https://nsigp04.alwaysdata.net/results.txt"  # Remplacez ceci par le lien réel
response = requests.get(url)
data = response.text

results = []

# Parcourir les lignes du contenu téléchargé
for line in data.split('\n')[1:]:
    if line.strip():
        data = line.strip().split(',')
        results.append(int(data[1].split('/')[0]))

score_counts = [results.count(i) for i in range(11)]


plt.figure(figsize=(10, 6))
plt.bar(range(11), score_counts, color='blue')
plt.xlabel('Résultat sur 10')
plt.ylabel('Nombre de personnes')
plt.title('Répartition des résultats du quiz')
plt.xticks(np.arange(11))
plt.yticks(np.arange(max(score_counts)+1))
plt.grid(axis='y', linestyle='--', alpha=0.7)
plt.tight_layout()
plt.show()