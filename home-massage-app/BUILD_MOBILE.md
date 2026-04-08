# Compilation Mobile - Home Massage App

Ce document explique comment compiler l'application web React/Vite en application mobile native pour Android (APK) et iOS en utilisant **Capacitor**.

## Prérequis communs
Avant de compiler pour mobile, il faut toujours s'assurer d'avoir généré les fichiers web correspondants et les avoir synchronisés.

À la racine de l'application (`home-massage-app`), exécutez toujours ces deux commandes pour mettre à jour la logique web dans le conteneur mobile :

```bash
# 1. Compiler le code source JS / TS (Vite)
npm run build

# 2. Synchroniser les nouveaux fichiers vers Android et iOS
npx cap sync
```

---

## 🤖 Compilation pour Android (Générer l'APK)

### Méthode 1 : Ligne de commande (Linux / Mac / Windows)
Assurez-vous d'avoir installé le SDK Android et Java 21, puis tapez ces commandes :

```bash
cd android
chmod +x gradlew
./gradlew assembleDebug
```
*Le fichier final (`app-debug.apk`) sera généré ici :*
`android/app/build/outputs/apk/debug/app-debug.apk`

*Si vous souhaitez générer une version pour le Play Store (Release) :*
```bash
./gradlew assembleRelease
```
*Le fichier AAB ou APK nécessitera d'être signé numériquement.*

### Méthode 2 : Android Studio
1. Téléchargez et installez **Android Studio**.
2. Ouvrez Android Studio et cliquez sur `Open`.
3. Sélectionnez le dossier `android` situé dans votre projet `home-massage-app`.
4. Attendez la fin de la synchronisation de Gradle (une barre de chargement en bas à droite).
5. Dans le menu en haut, cliquez sur **Build** > **Build Bundle(s) / APK(s)** > **Build APK(s)** pour générer votre APK.

---

## 🍎 Compilation pour iOS

> [!WARNING]
> La compilation pour iOS nécessite obligatoirement un ordinateur Mac et l'installation du logiciel Xcode (disponible gratuitement sur l'App Store d'Apple). Vous ne pouvez pas compiler pour iOS depuis un système Windows ou Linux.

### Instructions (Sur un Mac)

1. Après avoir exécuté `npm run build` et `npx cap sync` à la racine de votre projet, transférez tout le dossier `home-massage-app` sur votre Mac.
2. Assurez-vous d'avoir installé **Xcode** ainsi que **CocoaPods**.
3. Vous pouvez ouvrir le projet directement depuis Capacitor grâce à la commande suivante (à la racine du projet) :
```bash
npx cap open ios
```
*Celle-ci ouvrira le logiciel Xcode automatiquement.*

**Alternative manuelle :**
Ouvrez Xcode, cliquez sur "Open a project or file" et ouvrez le fichier :
`ios/App/App.xcworkspace` (Attention, n'ouvrez pas `.xcodeproj`, mais bien `.xcworkspace`).

### Générer l'application dans Xcode
1. Dans Xcode, sélectionnez l'application "App" à gauche, puis cliquez sur l'onglet **Signing & Capabilities**.
2. Sélectionnez ou ajoutez votre compte Apple Developer (Team).
3. Connectez un iPhone ou sélectionnez un émulateur dans le menu supérieur.
4. Cliquez sur le bouton "Play" en haut à gauche (ou Command + R) pour lancer votre application ou la compiler.
5. Pour publier sur l'App Store, rendez-vous dans **Product** > **Archive**.
