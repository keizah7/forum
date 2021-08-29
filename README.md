![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)
[![Chat](https://img.shields.io/discord/620935790867906561?label=chat)](https://discord.gg/YeJBQrTUT9)
![HitCount](https://views.whatilearened.today/views/github/keizah7/forum.svg)
![Forks](https://img.shields.io/github/forks/keizah7/forum?style=social)
![Stars](https://img.shields.io/github/stars/keizah7/forum?style=social)
![Watchers](https://img.shields.io/github/watchers/keizah7/forum?style=social)
![Contributors](https://img.shields.io/github/contributors/keizah7/forum)

# Let's Build A Forum with Laravel and TDD

### Forum:
This project is for educational porpuses only. Pull request are welcome! Thank you for your cooperation!

## Installation
`.env`
```
RECAPTCHA_SECRET=(v2 checkbox)
ALGOLIA_APP_ID=
ALGOLIA_KEY=
ALGOLIA_SECRET=
```
Commands
```
git clone https://github.com/keizah7/forum.git forum
cd forum
composer install
vagrant up
vagrant ssh
php74
cd forum
npm install && npm run dev
php artisan migrate:fresh --seed
php artisan scout:import 'App\Thread'
```

### Authors
[Artūras](https://github.com/keizah7) ![Followers](https://img.shields.io/github/followers/keizah7?style=social)
