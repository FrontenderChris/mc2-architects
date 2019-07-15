# Laravel 5 Sections Module

This package gives you CRUD functionality for sections (within pages), also the ability to add custom sections by adding forms into the /forms dir.

The default form is _standard but you may add your own, by using camel casing ie. myCustomForm.blade.php. Copy the _standard file as a template to work off.

This package is designed to be an add on to the modulatte/pages module.

## Assumptions

This is designed to work within the BPB CMS, so it is assumed you are using the Image and SEO modules which are pre-installed.

## Installation

In your project root directory run:

```sh
    composer require modulatte/sections
```

Edit config/app.php and add the service provider within the providers array.

```sh
    'providers' => [
        //...
        Modulatte\Sections\SectionsServiceProvider::class,
        //...
    ],
```

Run the modulatte install command which will publish mandatory files and run the migrations for you (for all modulatte packages).

```sh
    php artisan modulatte:install
```


## Usage

To use this package, after the above steps, the section "form type" should be available when creating new pages.

If you want to see a page into the DB you will just need to set the form field to be _sections.

## Editing View Files

Optionally you can edit the view files if required. To do this just publish the view files to your /views directory and edit them as necessary.

```sh
php artisan vendor:publish --provider="Modulatte\Sections\SectionsServiceProvider" --tag="views"
```