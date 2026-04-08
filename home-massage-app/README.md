# Home Massage App - Client React pour WordPress

Une application moderne et performante de réservation de massages à domicile, conçue avec React 19 et intégrée à une instance WordPress comme Backend (Headless CMS).

## 🚀 Fonctionnalités

- **Exploration des Services** : Visualisation des types de massages disponibles stockés dans des Custom Post Types WordPress (`service_app`).
- **Détails des Services** : Descriptions détaillées, bienfaits et images pour chaque soin.
- **Flux de Réservation (Booking)** : Processus interactif pour choisir une date, une heure, un masseur/masseuse et saisir les informations de contact.
- **Interface Premium** : Design responsive et épuré utilisant Tailwind CSS 4, agrémenté d'animations fluides avec Framer Motion.
- **Synchronisation en Temps Réel** : Les réservations sont envoyées directement dans le back-office WordPress pour une gestion centralisée.

## 🛠️ Stack Technique

- **Framework** : [React 19](https://react.dev/)
- **Build Tool** : [Vite 6](https://vitejs.dev/)
- **Styling** : [Tailwind CSS 4](https://tailwindcss.com/)
- **State Management & Routing** : [React Router 7](https://reactrouter.com/)
- **Animations** : [Framer Motion](https://www.framer.com/motion/)
- **Icônes** : [Lucide React](https://lucide.dev/)
- **Lien Backend** : WordPress REST API avec Basic Auth.

## 📁 Structure du Projet

```text
src/
├── components/   # Composants réutilisables (Layout, etc.)
├── pages/        # Vues principales (Home, Details, Booking Flow)
├── lib/          # Logique API et utilitaires
├── types.ts      # Définitions TypeScript pour les données WordPress
├── App.tsx       # Configuration des routes
└── main.tsx      # Point d'entrée de l'application
```

## ⚙️ Configuration

### Pré-requis
- Node.js (version 18+)
- Un serveur WordPress avec le thème `homemassageapp` installé.

### Installation
1. Accédez au répertoire de l'application :
   ```bash
   cd wp-content/themes/homemassageapp/home-massage-app
   ```
2. Installez les dépendances :
   ```bash
   npm install
   ```

### Variables d'Environnement
Créez un fichier `.env` à la racine de ce dossier (ou basez-vous sur `.env.example`) :
```env
VITE_WP_API_URL=https://votre-site.com/wp-json/wp/v2
VITE_WP_USERNAME=votre_utilisateur
VITE_WP_APP_PASSWORD=votre_mot_de_passe_application_wordpress
```

## ⌨️ Développement et Production

- **Démarrer en mode développement** :
  ```bash
  npm run dev
  ```
  L'application sera disponible sur `http://localhost:3000`.

- **Générer le build de production** :
  ```bash
  npm run build
  ```
  Les fichiers optimisés seront générés dans le dossier `dist/`.

## 🔄 Intégration WordPress Backend

L'application communique avec trois Custom Post Types personnalisés dans WordPress :
1. `service_app` : Les services de massage proposés.
2. `masseuse` : Les profils des prestataires.
3. `reservation` : Les demandes envoyées par le frontend.

L'authentification est sécurisée via les **Application Passwords** de WordPress pour permettre l'écriture (POST) dans la base de données sans exposer les identifiants d'administration classiques.

---
*Ce projet fait partie intégrante du thème WordPress `homemassageapp`.*
