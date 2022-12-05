<?php

namespace SmartyStudio\LaravelMenu\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SmartyStudio\LaravelMenu\Facades\Menu;
use SmartyStudio\LaravelMenu\Models\Menu as MenuModel;
use SmartyStudio\LaravelMenu\Models\MenuItem;

class MenuController extends Controller
{
    public function createNewMenu(Request $request)
    {
        $menu = new MenuModel();
        $menu->name = $request->input('name');
        $menu->class = $request->input('class', null);
        $menu->save();
        
        return response()->json(['resp' => $menu->id], 200);
    }

    public function destroyMenu(Request $request)
    {
        $menudelete = MenuModel::findOrFail($request->input('id'));
        $menudelete->delete();

        return response()->json(['resp' => 'You delete this item'], 200);
    }

    public function generateMenuControl(Request $request)
    {
        $menu = MenuModel::findOrFail($request->input('idMenu'));
        $menu->name = $request->input('menuName');
        $menu->class = $request->input('class', null);
        $menu->save();

        if (is_array($request->input('data'))) {
            foreach ($request->input('data') as $key => $value) {
                $menuitem = MenuItem::findOrFail($value['id']);
                $menuitem->parent = $value['parent_id'] ?? 0;
                $menuitem->sort = $key;
                $menuitem->depth = $value['depth'] ?? 1;
                
                if (config('laravelmenu.use_roles')) {
                    $menuitem->role_id = $request->input('role_id');
                }

                $menuitem->save();
            }
        }

        return response()->json(['resp' => 1], 200);
    }

    public function createItem(Request $request)
    {
        if ($request->has('data')) {
            foreach ($request->post('data') as $key => $value) {
                $menuitem = new MenuItem();
                $menuitem->label = $value['label'];
                $menuitem->link = $value['url'];
                $menuitem->icon = $value['icon'];

                if (config('laravelmenu.use_roles')) {
                    $menuitem->role_id = $value['role'] ?? 0;
                }

                $menuitem->menu = $value['id'];
                $menuitem->sort = MenuItem::getNextSortRoot($value['id']);
                $menuitem->save();
            }
        }

        return response()->json([
            'resp' => 1
        ], 200);
    }

    public function updateItem(Request $request)
    {
        $dataItem = $request->input('dataItem');

        if (is_array($dataItem)) {
            foreach ($dataItem as $value) {
                $menuitem = MenuItem::findOrFail($value['id']);
                $menuitem->label = $value['label'];
                $menuitem->link = $value['link'];
                $menuitem->class = $value['class'];
                $menuitem->icon = $value['icon'];
                $menuitem->target = $value['target'];

                if (config('laravelmenu.use_roles')) {
                    $menuitem->role_id = $value['role_id'] ? $value['role_id'] : 0;
                }

                $menuitem->save();
            }
        } else {
            $menuitem = MenuItem::findOrFail($request->input('id'));
            $menuitem->label = $request->input('label');
            $menuitem->link = $request->input('url');
            $menuitem->class = $request->input('clases');
            $menuitem->icon = $request->input('icon');
            $menuitem->target = $request->input('target');
            
            if (config('laravelmenu.use_roles')) {
                $menuitem->role_id = $request->input('role_id') ? $request->input('role_id') : 0;
            }

            $menuitem->save();
        }

        return response()->json(['resp' => 1], 200);
    }

    public function destroyItem(Request $request)
    {
        $menuitem = MenuItem::findOrFail($request->input('id'));
        $menuitem->delete();

        return response()->json(['resp' => 1 ], 200);
    }
}
