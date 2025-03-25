# Maison des Ligues  

[Lien vers le site ](https://exemple.com)

Ce projet consiste à développer une **plateforme Intranet** pour une société en pleine expansion.  
L'objectif est de **faciliter et encourager** les relations entre collaborateurs via une interface accessible en interne.  

En tant que **développeur Front-End**, vous êtes responsable de la création de la partie frontale de cette plateforme, initialement sous forme de prototype graphique.  

---

## 🎯 Fonctionnalités principales  

### 👤 Utilisateur Standard  

1. **Connexion**  
   - Les collaborateurs peuvent se connecter via leur **login et mot de passe**.  
   - Une fois connectés, ils sont redirigés vers une **page d'accueil** présentant un collaborateur au hasard.  
   - Un bouton **"Dire bonjour à quelqu'un d'autre"** permet d'afficher un autre collaborateur au hasard.  

2. **Liste des Collaborateurs**  
   - Accès à une **page listant tous les collaborateurs** de la société.  
   - Affichage des collaborateurs sous forme de **fiches** avec leurs caractéristiques.  
   - **Filtres** disponibles par **nom, localisation et catégorie**.  
   - La liste se **rafraîchit instantanément**.  

3. **Modification des Informations Personnelles**  
   - Accès à une **page de modification des informations personnelles** (y compris login/mot de passe) en cliquant sur l'image de profil dans le header.  

4. **Déconnexion**  
   - Possibilité de **se déconnecter**.  
   - Après déconnexion, les pages précédentes (**home, liste**) ne sont plus accessibles.  

---

### 🔧 Administrateur  

L'administrateur dispose de **privilèges supplémentaires** :  

1. **Gestion des Collaborateurs**  
   - **Ajouter** un nouveau collaborateur via un formulaire.  
   - **Modifier** les informations d'un collaborateur existant.  
   - **Supprimer** un collaborateur existant.  
   - **Assigner** le rôle d'administrateur à un collaborateur.  

2. **Interface Administrateur**  
   - Accès à un lien **"Ajouter"** un nouveau collaborateur dans la barre de menu.  
   - Boutons **"Éditer"** et **"Supprimer"** sur les fiches des collaborateurs.  

---

## 📂 Structure du Répertoire  
Root/
├── Index  
├── .gitignore  
├── readme.md  
├── views        # Composants de page  
├── model        # Base de données  
├── asset        # Images, icônes  
├── css          # Styles: reset et thème  
└── favicon      # Icônes onglets  