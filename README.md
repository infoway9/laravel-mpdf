# Laravel mPDF: mPDF wrapper for Laravel 5+

> Generate PDF documents from raw HTML or laravel blade file using the laravel

## Installation

Require this package in your `composer.json` or install it by running:

```
composer require infoway9/laravel-mpdf
```

> Note: This package supports auto-discovery features of Laravel 5.4+, You only need to manually add the service provider and alias if working on Laravel version lower then 5.5

To start using Laravel, add the Service Provider and the Facade to your `config/app.php`:

```php
'providers' => [
	// ...
	Infoway\mPdf\mPdfServiceProvider::class
]
```

```php
'aliases' => [
	// ...
	'PDF' => Infoway\mPdf\Facades\Pdf::class
]
```

Now, you should publish package's config file to your config directory by using following command:

```
php artisan vendor:publish --tag=laravel-mpdf
```

## Basic Usage
This is the basic usage of this package.

```php
<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use PDF;

class HomeController extends Controller {

    public function index() {
        $data = [
    		'foo' => 'bar'
    	];
        PDF::loadView('pdf',$data)->download('abc.pdf');
    }

}

```

## Other methods

All available methods of `pdf` object are:

`output()`: Outputs the PDF as a string.  
`save($filename)`: Save the PDF to a file  
`download($filename)`: Make the PDF and download it.
`stream($filename)`: Return a response with the PDF to show in the browser.
## License

Laravel PDF is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)