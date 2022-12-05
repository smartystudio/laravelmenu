# Drag and Drop menu generator for Laravel

An admin interface for [Laravel](https://laravel.com) to easily add, edit or remove Menus.

## Install

1. In your terminal:

```bash
composer require smartystudio/laravelmenu
```

**_Step 2 & 3 are optional if you are using laravel 5.5_**

2. If your Laravel version does not have package autodiscovery then add the service provider to your config/app.php file:

```php
SmartyStudio\LaravelMenu\MenuServiceProvider::class,
```

3. Add facade in the file config/app.php (optional on laravel 5.5):

```php
'Menu' => SmartyStudio\LaravelMenu\Facades\Menu::class,
```

4. Publish the config file & run the migrations.

```bash
php artisan vendor:publish --provider="SmartyStudio\LaravelMenu\MenuServiceProvider"
```

5. Configure (optional) in `config/laravelmenu.php`:

- **_CUSTOM MIDDLEWARE:_** You can add you own middleware
- **_TABLE PREFIX:_** By default this package will create 2 new tables named "menus" and "menu_items" but you can still add your own table prefix avoiding conflict with existing table
- **_TABLE NAMES_** If you want use specific name of tables you have to modify that and the migrations
- **_Custom routes_** If you want to edit the route path you can edit the field
- **_Role Access_** If you want to enable roles (permissions) on menu items

6. Run the database migrations:

```bash
php artisan migrate
```

DONE!

## Menu Builder Usage Example - displays the builder

On your view blade file

```php
@extends('app')

@section('contents')
    {!! Menu::render() !!}
@endsection
```

**You must have jQuery loaded before menu scripts**

```php
@push('scripts')
    {!! Menu::scripts() !!}
@endpush
```

## Using the Model

Call the model class:

```php
use SmartyStudio\LaravelMenu\Models\Menu;
use SmartyStudio\LaravelMenu\Models\MenuItem;
```

## Menu Usage Example (a)

A basic two-level menu can be displayed in your blade template.

### Using Model class

```php
// Get menu by ID
$menu = Menu::find(1);

// Get menu by Name
$menu = Menu::where('name','Test Menu')->first();

/**
 * Get menu by Name and the Items with eager loading.
 * This is RECOMENDED for better performance and less query calls.
 */
$menu = Menu::where('name','Test Menu')->with('items')->first();

// Get menu by ID
$menu = Menu::where('id', 1)->with('items')->first();

// Access by Model result
$public_menu = $menu->items;

// Convert it to Array
$public_menu = $menu->items->toArray();
```

### Using Helper class
```php
// Using Helper 
$public_menu = Menu::getByName('Public'); // return array
```

## Menu Usage Example (b)

Now inside your blade template file, place the menu using this simple example:

```html
<div class="nav-wrap">
    <div class="btn-menu">
        <span></span>
    </div><!-- // mobile menu button -->
    <nav id="mainnav" class="mainnav">
        @if($public_menu)
            <ul class="menu">
                @foreach($public_menu as $menu)
                    <li class="">
                        <a href="{{ $menu['link'] }}" title="">{{ $menu['label'] }}</a>
                        @if( $menu['child'] )
                        <ul class="sub-menu">
                            @foreach( $menu['child'] as $child )
                                <li class=""><a href="{{ $child['link'] }}" title="">{{ $child['label'] }}</a></li>
                            @endforeach
                        </ul><!-- /.sub-menu -->
                        @endif
                    </li>
                @endforeach
            <!-- empty -->
        @endif
        </ul><!-- /.menu -->
    </nav><!-- /#mainnav -->
 </div><!-- /.nav-wrap -->
```

### HELPERS

### Get Menu Items By Menu ID

```php
use SmartyStudio\LaravelMenu\Facades\Menu;
...
/**
 * Parameter: Menu ID
 * Return:    Array
 */
$menuList = Menu::get(1);
```

### Get Menu Items By Menu Name

In this example, you must have a menu named _Admin_

```php
use SmartyStudio\LaravelMenu\Facades\Menu;
...
/**
 * Parameter: Menu ID
 * Return:    Array
 */
$menuList = Menu::getByName('Admin');
```

### Customization of the menu

You can publish and edit the menu layout in `resources/views/vendor/smartystudio/laravelmenu/menu.blade.php`

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
// TODO
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email us instead of using the issue tracker.

## Credits

- Martin Nestorov - Web Developer @ Smarty Studio.
- All Contributors

## License

The SmartyStudio\LaravelMenu is open-source software licensed under the MIT license.