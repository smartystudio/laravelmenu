<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | You can add your own middleware here.
    |
    */

    'middleware' => [],

    /*
    |--------------------------------------------------------------------------
    | DB Table Prefix
    |--------------------------------------------------------------------------
    |
    | You can set your own database table prefix here.
    |
    */

    'table_prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | DB Table Names
    |--------------------------------------------------------------------------
    |
    | You can set your own database tables names.
    |
    */

    'table_name_menus' => 'menus',
    'table_name_items' => 'menu_items',

    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | You can set your own route path.
    |
    */

    'route_prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | User Roles
    |--------------------------------------------------------------------------
    |
    | You can make menu items to be visible to specific roles.
    |
    */

    'use_roles' => false,

    /*
    |--------------------------------------------------------------------------
    | Roles DB Tables
    |--------------------------------------------------------------------------
    |
    | If 'use_roles' is set to TRUE, then you must to set the table name, 
    | primary key and title field to get roles details.
    |
    */

    'roles_table'       => 'roles',
    'roles_pk'          => 'id',    // primary key of the roles table
    'roles_title_field' => 'name',  // display name (field) of the roles table
];
