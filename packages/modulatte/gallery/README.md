# Laravel 5 Gallery Module

This package gives you CRUD functionality for a gallery within pages or any other CRUD type module.

See installation instructions below, by default this package will be installed into the homepage section of modulatte/pages for a working example.

## Assumptions

This is designed to work within the BPB CMS, so it is assumed you are using the Image and SEO modules which are pre-installed.

## Installation

In your project root directory run:

```sh
    composer require modulatte/gallery
```

Edit config/app.php and add the service provider within the providers array.

```sh
    'providers' => [
        //...
        Modulatte\Gallery\GalleryServiceProvider::class,
        //...
    ],
```

Run the modulatte install command which will publish mandatory files and run the migrations for you (for all modulatte packages).

```sh
    php artisan modulatte:install
```


## Usage

To use this package, after the above steps, you will need to include the _index file wherever you need it (again see homepage in pages module for working example).

```sh
    @include('gallery::partials._index', [
        'parent' => $page, // This is the parent model ie. Page or Blog
        'width' => 2880, // Image width
        'height' => 1030 // Image height
    ])
```

You will normally want to include this as a tabbed view, so you will need to add the navigation item to your menu. The request()->has stuff will make the tab
active when being redirected back to this page from the gallery form.

```sh
<li class="{{ request()->has('gallery') ? 'active' : '' }}"><a href="#" class="{{ (empty($model) ? 'disabled-tab' : 'do-show-content') }}" data-show=".tab-gallery">Gallery</a></li>
```

Then you will need to add a tab to be displayed when clicking on the nav item. You will also need to add an if statement to your main (default) tab so it is not displayed if
the below tab is set as active ie. style="{{ !request()->has('gallery') ? 'display:block;' : '' }}"

```sh
@if (!empty($model))
    <div class="tab-content tab-gallery" style="{{ request()->has('gallery') ? 'display: block;' : '' }}">
        @include('gallery::partials._index', [
            'parent' => $model,
            'width' => 2880,
            'height' => 1030
        ])
    </div>
@endif
```

## Editing View Files

Optionally you can edit the view files if required. To do this just publish the view files to your /views directory and edit them as necessary.

```sh
php artisan vendor:publish --provider="Modulatte\Gallery\GalleryServiceProvider" --tag="views"
```