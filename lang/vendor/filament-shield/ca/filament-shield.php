<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */
    //Traducir al catalan
    'column.name' => 'Nom',
    'column.guard_name' => 'Guard',
    'column.roles' => 'Rols',
    'column.permissions' => 'Permisos',
    'column.updated_at' => 'Actualitzat el',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field.name' => 'Nom',
    'field.guard_name' => 'Guard',
    'field.permissions' => 'Permisos',
    'field.select_all.name' => 'Seleccionar tots',
    'field.select_all.message' => 'Habilitar tots els permisos actualment <span class="text-primary font-medium">habilitats</span> per a aquest rol',

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav.group' => 'Gestió d\'Usuaris',
    'nav.role.label' => 'Rols',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'Rol',
    'resource.label.roles' => 'Rols',

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */

    'section' => 'Entitats',
    'resources' => 'Recursos',
    'widgets' => 'Widgets',
    'pages' => 'Págines',
    'custom' => 'Permisos personalitzats',

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'forbidden' => 'Usted no té permiso d\'accés',

    /*
    |--------------------------------------------------------------------------
    | Resource Permissions' Labels
    |--------------------------------------------------------------------------
    */

    'resource_permission_prefixes_labels' => [
        'view' => 'Ver un registre en particular',
        'view_any' => 'Ver el llistat de registres',
        'create' => 'Crear',
        'update' => 'Actualizar',
        'delete' => 'Eliminar un registre en particular',
        'delete_any' => 'Eliminar diversos registres a la vegada',
        'force_delete' => 'Forçar elminació de un registre en particular',
        'force_delete_any' => 'Forçar eliminació de diversos registres',
        'restore' => 'Restaurar un registre en particular',
        'reorder' => 'Reordenar',
        'restore_any' => 'Restaurar diversos registres',
        'replicate' => 'Replicar',
    ],
];
