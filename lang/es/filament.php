<?php

return [
    // Navegación
    'navigation' => [
        'users' => 'Usuarios',
        'user_management' => 'Gestión de Usuarios',
        'my_profile' => 'Mi Perfil',
        'roles' => 'Roles',
        'permissions' => 'Permisos',
        'settings' => 'Configuración',
        'system' => 'Sistema',
    ],
    
    // Títulos de páginas
    'pages' => [
        'users' => [
            'title' => 'Usuarios',
            'create' => 'Crear Usuario',
            'edit' => 'Editar Usuario',
            'view' => 'Ver Usuario',
        ],
        'roles' => [
            'title' => 'Roles',
            'create' => 'Crear Rol',
            'edit' => 'Editar Rol',
            'view' => 'Ver Rol',
        ],
        'permissions' => [
            'title' => 'Permisos',
            'create' => 'Crear Permiso',
            'edit' => 'Editar Permiso',
            'view' => 'Ver Permiso',
        ],
        'settings' => [
            'title' => 'Configuración',
            'create' => 'Crear Configuración',
            'edit' => 'Editar Configuración',
        ],
    ],
    
    // Campos de configuración
    'settings' => [
        // Información General
        'app_name' => 'Nombre de la aplicación',
        'app_description' => 'Descripción de la aplicación',
        'app_logo' => 'Logo de la aplicación',
        'app_favicon' => 'Favicon',
        
        // Contacto
        'contact_email' => 'Email de contacto',
        'contact_phone' => 'Teléfono de contacto',
        'contact_address' => 'Dirección física',
        
        // Panel Administrativo
        'admin_language' => 'Idioma del Admin',
        
        // Contenido Multiidioma
        'available_languages' => 'Idiomas disponibles',
        'default_timezone' => 'Zona horaria',
        'date_format' => 'Formato de fecha',
        
        // Email
        'mail_from_address' => 'Email remitente',
        'mail_from_name' => 'Nombre remitente',
        'email_notifications_enabled' => 'Activar notificaciones por email',
        
        // Seguridad
        'user_registration_enabled' => 'Permitir registro de usuarios',
        'email_verification_required' => 'Verificación de email obligatoria',
        
        // Apariencia
        'default_theme' => 'Tema por defecto',
        
        // Sistema
        'maintenance_mode' => 'Modo mantenimiento',
        'detailed_logging' => 'Logs detallados',
        
        // Opciones
        'theme_options' => [
            'light' => 'Claro',
            'dark' => 'Oscuro',
            'auto' => 'Automático',
        ],
        
        'language_options' => [
            'es' => 'Español',
            'ca' => 'Catalá',
            'en' => 'English',
        ],
        
        'timezone_options' => [
            'Europe/Madrid' => 'Madrid (UTC+1)',
            'Europe/London' => 'Londres (UTC+0)',
            'America/New_York' => 'Nueva York (UTC-5)',
            'America/Los_Angeles' => 'Los Ángeles (UTC-8)',
            'America/Mexico_City' => 'Ciudad de México (UTC-6)',
        ],
        
        'date_format_options' => [
            'd/m/Y' => 'dd/mm/aaaa',
            'm/d/Y' => 'mm/dd/aaaa',
            'Y-m-d' => 'aaaa-mm-dd',
            'd-m-Y' => 'dd-mm-aaaa',
        ],
        
        // Textos de ayuda
        'helpers' => [
            'app_logo' => 'Tamaño máximo: 2MB. Soporta la mayoría de formatos de imagen (JPG, PNG, GIF, WEBP, SVG, etc.)',
            'app_favicon' => 'Tamaño máximo: 512KB. Formatos recomendados: ICO, PNG (32x32px)',
            'admin_language' => 'Idioma de toda la interfaz administrativa',
            'available_languages' => 'Códigos de idioma (ej: es, en, ca)',
            'mail_from_address' => 'Email usado para enviar notificaciones',
            'mail_from_name' => 'Nombre que aparece como remitente',
            'user_registration_enabled' => 'Los usuarios pueden registrarse automáticamente',
            'email_verification_required' => 'Los usuarios deben verificar su email',
            'maintenance_mode' => 'Activar para mostrar página de mantenimiento',
            'detailed_logging' => 'Registrar información detallada en logs',
        ],
    ],
];