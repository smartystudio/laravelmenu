<?php

namespace SmartyStudio\LaravelMenu\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    public function __construct(array $attributes = [])
    {
        // parent::construct( $attributes );
        $this->table = config('laravelmenu.table_prefix') . config('laravelmenu.table_name_menus');
    }

    public static function byName($name)
    {
        return self::where('name', '=', $name)->first();
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class, 'menu')->with('child')->where('parent', 0)->orderBy('sort', 'ASC');
    }
    
    public function itemAndChilds()
    {
        return $this->hasMany(MenuItem::class, 'menu')->with('child')->orderBy('sort', 'ASC');
    }
}
