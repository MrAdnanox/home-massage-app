# Structure des Custom Post Types (CPT) - Home Massage App

Ce document explique le fonctionnement et la structure des trois types de contenus personnalisés (CPT) principaux utilisés dans le thème WordPress **Home Massage App**.

---

## 1. Service (`service`)

Le CPT **Service** est utilisé pour présenter les différentes prestations proposées (Massages, Soins, etc.).

- **Visibilité** : Public (possède ses propres pages et archives).
- **Slug URL** : `/services/`
- **Fonctionnalités supportées** :
  - Titre
  - Éditeur de contenu (Gutenberg)
  - Image mise en avant (Thumbnail)
  - Extrait (Excerpt)
  - **Mise en avant (Sticky)** : Géré via un post meta personnalisé `_mpe2025_is_sticky`.
- **Utilisation** : Ces posts sont affichés sur le site pour que les clients choisissent une prestation avant de réserver.

---

## 2. Service APP (`service_app`)

Le CPT **Service APP** est une variante du CPT Service, spécifiquement conçue pour l'application mobile ou des services dédiés.

- **Visibilité** : Public.
- **Slug URL** : `/services-app/`
- **Fonctionnalités supportées** : Identiques au CPT `service`.
  - Inclut également la fonctionnalité **Mise en avant (Sticky)** (`_mpe2025_is_sticky`).
- **Icône Admin** : `dashicons-smartphone`.

---

## 3. Masseuse (`masseuse`)

Le CPT **Masseuse** permet de gérer l'équipe de thérapeutes.

- **Visibilité** : Privé (gestion interne uniquement).
- **Fonctionnalités supportées** :
  - Titre (Nom de la masseuse)
  - Éditeur de contenu
  - Image mise en avant (Photo de profil)
  - Champs personnalisés (Custom Fields)
- **Champs spécifiques** :
  - `masseuse_phone` : Numéro de téléphone de la masseuse.
  - `masseuse_gender` : Genre de la masseuse (`female` ou `male`).
- **Rôle** : Servir de base de données pour l'attribution des réservations.

---

## 3. Réservation (`reservation`)

C'est l'élément central du système de réservation. Ce CPT n'est pas créé manuellement par l'admin, mais automatiquement lors de la soumission du formulaire de contact/réservation sur le site.

- **Visibilité** : Privé (uniquement visible dans le tableau de bord).
- **Fonctionnalités supportées** : Titre (généré automatiquement sous la forme `Devis - [Nom] - [Date]`).

### Données de la réservation (Meta Boxes)
Les informations sont stockées dans des méta-données spécifiques :

| Champ | Meta Key | Description |
|-------|----------|-------------|
| **Date** | `_mpe_reservation_date` | Date souhaitée pour la prestation. |
| **Nom** | `_mpe_reservation_name` | Nom du client. |
| **Email** | `_mpe_reservation_email` | Email de contact. |
| **Téléphone** | `_mpe_reservation_phone` | Numéro de téléphone du client. |
| **Objet** | `_mpe_reservation_object` | Le service ou l'excursion concernée. |
| **Message** | `_mpe_reservation_message` | Message complémentaire du client. |
| **Page Source** | `_mpe_reservation_page_url` | URL de la page d'où provient la demande. |

### Gestion et Workflow
L'administrateur peut gérer la réservation via une interface personnalisée dans le "Side" du post :

1. **Statut de la réservation** (`_mpe_reservation_status`) :
   - `pending` : Demande (En attente) - *Par défaut*
   - `confirmed` : Confirmée
   - `completed` : Terminée
   - `cancelled` : Annulée

2. **Assignation** (`_mpe_reservation_masseuse_id`) :
   - Permet de lier une **Masseuse** à cette réservation via une liste déroulante dynamique.

---

## Fonctionnement Technique

1. **Enregistrement** : Les CPT sont enregistrés dans `inc/cpt.php` via l'action `init`.
2. **Formulaire de soumission** : Le fichier `inc/form-handler.php` gère l'envoi AJAX des données. C'est lui qui crée le post de type `reservation` dès qu'un email est envoyé avec succès.
3. **Interface Admin** : Le fichier `inc/admin-reservation.php` personnalise les colonnes de la liste des réservations et ajoute les boîtes de saisie (meta boxes) pour la gestion des statuts et des masseuses.

---

## Guide technique pour Développeur / Agent IA (App Mobile)

Pour connecter une application mobile à ce site, utilisez l'API REST native de WordPress. Les CPTs sont exposés avec des champs personnalisés spécifiques.

### 1. Authentification
L'accès aux `reservations` et aux `masseuses` (CPTs privés) nécessite une authentification.
- **Méthode recommandée** : [Application Passwords](https://developer.wordpress.org/rest-api/using-the-rest-api/authentication/#application-passwords) (natif WP 5.6+) ou un plugin JWT.
- **En-tête** : `Authorization: Basic [BASE64_USER:APP_PASSWORD]`

### 2. Endpoints et Champs REST

#### A. Services (`/wp-json/wp/v2/service`)
Accès public pour lister les prestations.
- **Champs standards** : `id`, `title.rendered`, `content.rendered`, `featured_media`.

#### B. Services APP (`/wp-json/wp/v2/service_app`)
Accès public pour lister les prestations spécifiques à l'application.
- **Champs standards** : Identiques au CPT `service`.

#### C. Masseuses (`/wp-json/wp/v2/masseuse`)
- **Endpoint** : `/wp-json/wp/v2/masseuse`
- **Filtre de recherche spécifique** :
  - `gender_filter` : Permet de filtrer par genre (ex: `?gender_filter=female`).
- **Champs spécifiques REST** :
  - `phone` : Numéro de téléphone (Lecture/Écriture).
  - `gender` : Genre (`female` / `male`) (Lecture/Écriture).

#### C. Réservations (`/wp-json/wp/v2/reservation`)
- **Endpoint** : `/wp-json/wp/v2/reservation`
- **Filtre de recherche spécifique** :
  - `status_filter` : Permet de filtrer par statut (ex: `?status_filter=pending`).
- **Champs spécifiques REST (Mappés)** :
  | Champ REST | Source Meta | Description |
  |------------|-------------|-------------|
  | `client_name` | `_mpe_reservation_name` | Nom du client |
  | `client_email` | `_mpe_reservation_email` | Email |
  | `client_phone` | `_mpe_reservation_phone` | Téléphone |
  | `trip_date` | `_mpe_reservation_date` | Date du RDV |
  | `trip_object` | `_mpe_reservation_object` | Titre du service |
  | `message` | `_mpe_reservation_message` | Message client |
  | `page_url` | `_mpe_reservation_page_url` | URL source |
  | `status` | `_mpe_reservation_status` | Statut (pending, confirmed, etc.) |
  | `masseuse_id` | `_mpe_reservation_masseuse_id` | ID de la masseuse assignée |

### 3. Exemples de requêtes

#### Récupérer les réservations en attente :
`GET /wp-json/wp/v2/reservation?status_filter=pending`

#### Modifier le statut d'une réservation :
`POST /wp-json/wp/v2/reservation/{id}`
```json
{
  "status": "confirmed",
  "masseuse_id": 42
}
```

#### Récupérer les informations d'une masseuse :
`GET /wp-json/wp/v2/masseuse/{id}`
*(Donne accès aux champs `phone` et `gender` mappés en plus des champs standards)*

#### Filtrer les masseuses par genre :
`GET /wp-json/wp/v2/masseuse?gender_filter=female`

