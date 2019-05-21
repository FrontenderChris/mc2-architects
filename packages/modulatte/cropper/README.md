# Laravel 5 Image Cropper

This package provides you with a re-usable image cropper, which crops images to an aspect ratio (determined by the specified width/height) and returns the resulting filename.

You will need to do your own backend functionality to save the filename to the item you have added the image for, the filename will be stored in a hidden text field.


## Assumptions

This is designed to work within the BPB CMS, so it is assumed you are using an Image model which saves all images to the database and to the /storage directory.
If you do not have this model, this package will not work.

## Installation

In your project root directory run:

```sh
    composer require modulatte/cropper
```

Then edit config/app.php and add the service provider within the providers array.

```sh
    'providers' => [
        //...
        Modulatte\Cropper\CropperServiceProvider::class,
        //...
    ],
```

### Vendor Publish

To see the files you will need to publish the mandatory files (be sure to add this step to your site readme.md file)

```sh
    php artisan vendor:publish --provider="Modulatte\Cropper\CropperServiceProvider" --tag="mandatory"

    gulp
```


## Usage

### Include Form Input

The form input should be included within the form you are using to add/update your record

```sh
    @include('cropper::_input', [
        'uniqueKey' => 1, // This is used if you have multiple instances on one page (ie. from a foreach loop)
        'width' => 200, // Set the required width
        'height' => 200, // Set the required height
        'image' => null, // Optional - image object
        'label' => 'My Image', // Optional - form input label
        'inputName' => 'image1', // Optional - form input name (where the filename is stored after cropping)
        'required' => false, // Optional - This is only required if you want to display an * on the label
    ])
```

### Include Modal

The modal should be added OUTSIDE OF YOUR FORM. Preferably at the bottom of the page the _input view is included on.
There should be one modal included for every _input field. Ensure the uniqueKeys match.

```sh
    @include('cropper::_modal', [
        'uniqueKey' => 1, // Same as the uniqueKey for the _input include
        'image' => null // Optional - image object (if this is added, user has the option to delete images)
    ])
```

### Example Usage

```sh
    <form>
        <label>Title</label>
        <input name="title" />

        @include('cropper::_input', [
            'uniqueKey' => '1',
            'width' => 160,
            'height' => 160,
            'image' => (!empty($model) ? $model->image : null),
            'label' => 'Image',
            'inputName' => 'image[file]',
            'required' => true,
        ])

        <!-- OR -->

        @foreach ($imageTypes as $key => $imageType)
            @include('cropper::_input', [
                'uniqueKey' => $key, // This is used if you have multiple instances on one page (ie. from a foreach loop)
                'width' => 200, // Set the required width
                'height' => 200, // Set the required height
                'image' => (!empty($model->image) ? $model->image : null), // Optional image object
                'label' => 'My Image', // Optional form input label
                'inputName' => 'image' . $key, // Optional form input name (where the filename is stored after cropping)
            ])
        @endoforeach
    </form>

    @foreach ($imageTypes as $key => $imageType)
        @include('cropper::_modal', ['uniqueKey' => 1])
    @endforeach
```


## Editing View Files

Optionally you can edit the view files if required. To do this just publish the view files to your /views directory and edit them as necessary.

```sh
php artisan vendor:publish --provider="Modulatte\Cropper\CropperServiceProvider" --tag="views"
```

## Adding URL field to the image

You can add a URL field by passing an array with the URL parameters (see below). Note you will need to do your own functionality to save the URL field to the image

```sh
    @include('cropper::_input', [
        'uniqueKey' => \App\Models\Page::IMAGE_TYPE_1,
        'width' => 250,
        'height' => 312,
        'image' => (!empty($model) && $model->image ? $model->image : null),
        'label' => 'Image',
        'inputName' => 'image[' . \App\Models\Page::IMAGE_TYPE_1 . ']',
        'url' => [
            'label' => 'URL',
            'name' => 'url[' . \App\Models\Page::IMAGE_TYPE_1 . ']',
        ],
    ])
```