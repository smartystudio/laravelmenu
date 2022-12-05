<?php

namespace SmartyStudio\LaravelMenu\Helpers;

use SmartyStudio\LaravelMenu\Models\Menu;
use SmartyStudio\LaravelMenu\Models\MenuItem;
use Illuminate\Support\Facades\DB;

class Menu
{
    public function render()
    {
        $menu = new Menu();

        // $menuitems = new MenuItem();

        $menulist = $menu->select(['id', 'name'])->get();
        $menulist = $menulist->pluck('name', 'id')->prepend('Select menu', 0)->all();

        // $roles = Role::all();

        if ((request()->has('action') && empty(request()->input('menu')))|| request()->input('menu') == '0') {
            return view('menu::menu')->with("menulist", $menulist);
        } else {
            $menu = Menu::find(request()->input('menu'));
            $menus = self::get(request()->input('menu'));
            $data = ['menus' => $menus, 'indmenu' => $menu, 'menulist' => $menulist];
            
            if (config('menu.use_roles')) {
                $data['roles'] = DB::table(config('laravelmenu.roles_table'))->select([
                    config('laravelmenu.roles_pk'),
                    config('laravelmenu.roles_title_field')
                ])
                    ->get();
                $data['role_pk'] = config('laravelmenu.roles_pk');
                $data['role_title_field'] = config('laravelmenu.roles_title_field');
            }

            return view('menu::menu', $data);
        }
    }

    public function scripts()
    {
        return view('menu::scripts');
    }

    public function select($name = "menu", $menulist = array(), $attributes = array())
    {
        $attribute_string = "";

        if (count($attributes) > 0) {
            $attribute_string = str_replace(
                "=",
                '="',
                http_build_query($attributes, '', '" ', PHP_QUERY_RFC3986)
            ) . '"';
        }

        $html = '<select name="' . $name . '" ' . $attribute_string . '>';

        foreach ($menulist as $key => $val) {
            $active = '';

            if (request()->input('menu') == $key) {
                $active = 'selected="selected"';
            }        

            $html .= '<option ' . $active . ' value="' . $key . '">' . $val . '</option>';
        }

        $html .= '</select>';
        return $html;
    }

    /**
     * Returns empty array if menu not found now.
     * Thanks @sovichet
     *
     * @param $name
     * @return array
     */
    public static function getByName($name)
    {
        $menu = Menu::byName($name);
        return is_null($menu) ? [] : self::get($menu->id);
    }

    public static function get($menu_id)
    {
        $menuItem = new MenuItem;
        $menu_list = $menuItem->getall($menu_id);

        $roots = $menu_list->where('menu', (int) $menu_id)->where('parent', 0);

        $items = self::tree($roots, $menu_list);
        return $items;
    }

    private static function tree($items, $all_items)
    {
        $data_arr = array();
        $i = 0;

        foreach ($items as $item) {
            $data_arr[$i] = $item->toArray();
            $find = $all_items->where('parent', $item->id);

            $data_arr[$i]['child'] = array();

            if ($find->count()) {
                $data_arr[$i]['child'] = self::tree($find, $all_items);
            }

            $i++;
        }

        return $data_arr;
    }
}
