<?php

return [
    // Navegació
    'navigation' => [
        'users' => 'Usuaris',
        'user_management' => 'Gestió d\'Usuaris',
        'my_profile' => 'El Meu Perfil',
        'roles' => 'Rols',
        'permissions' => 'Permisos',
        'settings' => 'Configuració',
        'system' => 'Sistema',
    ],
    
    // Títols de pàgines
    'pages' => [
        'users' => [
            'title' => 'Usuaris',
            'create' => 'Crear Usuari',
            'edit' => 'Editar Usuari',
            'view' => 'Veure Usuari',
        ],
        'roles' => [
            'title' => 'Rols',
            'create' => 'Crear Rol',
            'edit' => 'Editar Rol',
            'view' => 'Veure Rol',
        ],
        'permissions' => [
            'title' => 'Permisos',
            'create' => 'Crear Permís',
            'edit' => 'Editar Permís',
            'view' => 'Veure Permís',
        ],
        'settings' => [
            'title' => 'Configuració',
            'create' => 'Crear Configuració',
            'edit' => 'Editar Configuració',
        ],
    ],
    
    // Camps de configuració
    'settings' => [
        // Informació General
        'app_name' => 'Nom de l\'aplicació',
        'app_description' => 'Descripció de l\'aplicació',
        'app_logo' => 'Logo de l\'aplicació',
        'app_favicon' => 'Favicon',
        
        // Contacte
        'contact_email' => 'Email de contacte',
        'contact_phone' => 'Telèfon de contacte',
        'contact_address' => 'Adreça física',
        
        // Panell Administratiu
        'admin_language' => 'Idioma de l\'Admin',
        
        // Contingut Multiidioma
        'available_languages' => 'Idiomes disponibles',
        'default_timezone' => 'Zona horària',
        'date_format' => 'Format de data',
        
        // Email
        'mail_from_address' => 'Email remitent',
        'mail_from_name' => 'Nom remitent',
        'email_notifications_enabled' => 'Activar notificacions per email',
        
        // Seguretat
        'user_registration_enabled' => 'Permetre registre d\'usuaris',
        'email_verification_required' => 'Verificació d\'email obligatòria',
        
        // Sistema
        'maintenance_mode' => 'Mode manteniment',
        'detailed_logging' => 'Logs detallats',
        
        // Opcions
        'language_options' => [
            'es' => 'Español',
            'ca' => 'Català',
            'en' => 'English',
        ],
        
        'timezone_options' => [
            'Europe/Madrid' => 'Madrid (UTC+1)',
            'Europe/London' => 'Londres (UTC+0)',
            'America/New_York' => 'Nova York (UTC-5)',
            'America/Los_Angeles' => 'Los Angeles (UTC-8)',
            'America/Mexico_City' => 'Ciutat de Mèxic (UTC-6)',
        ],
        
        'date_format_options' => [
            'd/m/Y' => 'dd/mm/aaaa',
            'm/d/Y' => 'mm/dd/aaaa',
            'Y-m-d' => 'aaaa-mm-dd',
            'd-m-Y' => 'dd-mm-aaaa',
        ],
        
        // Textos d\'ajuda
        'helpers' => [
            'app_logo' => 'Mida màxima: 2MB. Suporta la majoria de formats d\'imatge (JPG, PNG, GIF, WEBP, SVG, etc.)',
            'app_favicon' => 'Mida màxima: 512KB. Formats recomanats: ICO, PNG (32x32px)',
            'admin_language' => 'Idioma de tota la interfície administrativa',
            'available_languages' => 'Codis d\'idioma (ex: es, en, ca)',
            'mail_from_address' => 'Email utilitzat per enviar notificacions',
            'mail_from_name' => 'Nom que apareix com a remitent',
            'user_registration_enabled' => 'Els usuaris poden registrar-se automàticament',
            'email_verification_required' => 'Els usuaris han de verificar el seu email',
            'maintenance_mode' => 'Activar per mostrar pàgina de manteniment',
            'detailed_logging' => 'Registrar informació detallada als logs',
        ],
    ],
    
    // Títols de fieldsets
    'fieldsets' => [
        'general_information' => 'Informació General',
        'contact_information' => 'Informació de Contacte',
        'admin_configuration' => 'Configuració del Panell Administratiu',
        'content_configuration' => 'Configuració de Contingut Multiidioma',
        'email_configuration' => 'Configuració d\'Email',
        'security_configuration' => 'Configuració de Seguretat',
        'system_configuration' => 'Configuració del Sistema',
    ],
];