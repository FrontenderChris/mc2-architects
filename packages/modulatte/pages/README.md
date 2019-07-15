# Laravel 5 Pages Module

This package gives you CRUD functionality for pages, also the ability to add custom pages by adding forms into the /forms dir.

The default form is _standard but you may add your own, by using camel casing ie. myCustomForm.blade.php. Copy the _standard file as a template to work off.

This package also works with Sections (modulatte/sections) if you wanted to have sections/modules within pages.

## Assumptions

This is designed to work within the BPB CMS, so it is assumed you are using the Image and SEO modules which are pre-installed.

## Installation

In your project root directory run:

```sh
    composer require modulatte/pages
```

Edit config/app.php and add the service provider within the providers array.

```sh
    'providers' => [
        //...
        Modulatte\Pages\PagesServiceProvider::class,
        //...
    ],
```

Run the modulatte install command which will publish mandatory files and run the migrations for you (for all modulatte packages).

```sh
    php artisan modulatte:install
```


## Usage

To use the pages package, you will need to add the "admin.pages.index" route to your nav and check the config file for settings.

## Editing View Files

Optionally you can edit the view files if required. To do this just publish the view files to your /views directory and edit them as necessary.

```sh
php artisan vendor:publish --provider="Modulatte\Pages\PagesServiceProvider" --tag="views"
```