# TP Noté E-Commerce ESGI 4IW1

## Setup
- `cd app`
- `docker compose up --build`
- `docker exec -it "app-web-1" bash`
  - `php bin/console d\:s\:c` si nécesaire
  - `php bin/console h\:f\:l`
 
- Port : 8000

## Features
- Entités & relations
- Fixtures
- Auth
  - Login & inscription `/login`
  - Mot de passe oublié
  - Vue de profil `/profile`
- Affichage dynamique (navbar)
- CRUD sécurisé `/admin`
  - Le CRUD pour User permet de bannir/débannir un utilisateur
  - Accès restreint aux utilisateurs bannis

Enjoy
