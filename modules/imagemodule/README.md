# image module for Craft CMS 3.x

Generates a image with the glide pluin

## Requirements

This module requires Craft CMS 3.0.0-RC1 or later.

This module requires Glide 1.3 or later.

## Installation

To install the module, follow these instructions.

First, you'll need to add the contents of the `app.php` file to your `config/app.php` (or just copy it there if it does not exist). This ensures that your module will get loaded for each request. The file might look something like this:
```
return [
    'modules' => [
        'image-module' => [
            'class' => \modules\imagemodule\ImageModule::class,
        ],
    ],
    'bootstrap' => ['image-module'],
];
```

Paste the `imagemodule` folder in the `modules` folder.

You'll also need to make sure that you add the following to your project's `composer.json` file so that Composer can find your module:

    "autoload": {
        "psr-4": {
          "modules\\imagemodule\\": "modules/imagemodule/src/"
        }
    },
 
    
Now install glide:

    composer require league/glide
   
After you have added this, you will need to do:

    composer dump-autoload
 
 …from the project’s root directory, to rebuild the Composer autoload map. This will happen automatically any time you do a `composer install` or `composer update` as well.
 
 Now make a new assest volume in craft, and use this path:
 
    @root/storage/uploads/singles/
 

## Using image

    http://craft3/img/singles/jorge.png


Brought to you by [Bravoure](https://bravoure.nl)
