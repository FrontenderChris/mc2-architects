# Installation Instructions

1. Run "cp .env.example .env" - Then modify the file with your database details and config
2. Run "composer install"
3. Run "php artisan modulatte:install"
4. Run "php artisan db:seed" (IMPORTANT: this may take a couple of minutes to run)
5. (on development only) Run "npm install"
6. (on development only) Run "gulp --production"

# Frontend Instructions
## Private assets live in the /src folder such as JS, SASS and CSS from vendors/plugins, these CAN be edited manually.
## The outputted files live in /public and in most cases these SHOULD NOT be edited manually

1. Run "gulp watch" before editing files within the /src folder and the output files will be compiled automatically.
2. Alternatively if you edit the files without running gulp watch then just run "gulp" and it will complile your changes for you.
3. You may also run "gulp --production" if you want to compile and minify your assets (this should be done if pushing to a production site).