<?php

return [
    // Navigation
    'navigation' => [
        'users' => 'Users',
        'user_management' => 'User Management',
        'my_profile' => 'My Profile',
        'roles' => 'Roles',
        'permissions' => 'Permissions',
        'settings' => 'Settings',
        'system' => 'System',
    ],
    
    // Page titles
    'pages' => [
        'users' => [
            'title' => 'Users',
            'create' => 'Create User',
            'edit' => 'Edit User',
            'view' => 'View User',
        ],
        'roles' => [
            'title' => 'Roles',
            'create' => 'Create Role',
            'edit' => 'Edit Role',
            'view' => 'View Role',
        ],
        'permissions' => [
            'title' => 'Permissions',
            'create' => 'Create Permission',
            'edit' => 'Edit Permission',
            'view' => 'View Permission',
        ],
        'settings' => [
            'title' => 'Settings',
            'create' => 'Create Setting',
            'edit' => 'Edit Setting',
        ],
    ],
    
    // Settings fields
    'settings' => [
        // General Information
        'app_name' => 'Application Name',
        'app_description' => 'Application Description',
        'app_logo' => 'Application Logo',
        'app_favicon' => 'Favicon',
        
        // Contact
        'contact_email' => 'Contact Email',
        'contact_phone' => 'Contact Phone',
        'contact_address' => 'Physical Address',
        
        // Admin Panel
        'admin_language' => 'Admin Language',
        
        // Multilanguage Content
        'available_languages' => 'Available Languages',
        'default_timezone' => 'Timezone',
        'date_format' => 'Date Format',
        
        // Email
        'mail_from_address' => 'From Email',
        'mail_from_name' => 'From Name',
        'email_notifications_enabled' => 'Enable Email Notifications',
        
        // Security
        'user_registration_enabled' => 'Allow User Registration',
        'email_verification_required' => 'Email Verification Required',
        
        // Appearance
        'default_theme' => 'Default Theme',
        
        // System
        'maintenance_mode' => 'Maintenance Mode',
        'detailed_logging' => 'Detailed Logging',
        
        // Options
        'theme_options' => [
            'light' => 'Light',
            'dark' => 'Dark',
            'auto' => 'Automatic',
        ],
        
        'language_options' => [
            'es' => 'Español',
            'ca' => 'Català',
            'en' => 'English',
        ],
        
        'timezone_options' => [
            'Europe/Madrid' => 'Madrid (UTC+1)',
            'Europe/London' => 'London (UTC+0)',
            'America/New_York' => 'New York (UTC-5)',
            'America/Los_Angeles' => 'Los Angeles (UTC-8)',
            'America/Mexico_City' => 'Mexico City (UTC-6)',
        ],
        
        'date_format_options' => [
            'd/m/Y' => 'dd/mm/yyyy',
            'm/d/Y' => 'mm/dd/yyyy',
            'Y-m-d' => 'yyyy-mm-dd',
            'd-m-Y' => 'dd-mm-yyyy',
        ],
        
        // Helper texts
        'helpers' => [
            'app_logo' => 'Maximum size: 2MB. Supports most image formats (JPG, PNG, GIF, WEBP, SVG, etc.)',
            'app_favicon' => 'Maximum size: 512KB. Recommended formats: ICO, PNG (32x32px)',
            'admin_language' => 'Language for the entire administrative interface',
            'available_languages' => 'Language codes (e.g.: es, en, ca)',
            'mail_from_address' => 'Email used to send notifications',
            'mail_from_name' => 'Name that appears as sender',
            'user_registration_enabled' => 'Users can register automatically',
            'email_verification_required' => 'Users must verify their email',
            'maintenance_mode' => 'Enable to show maintenance page',
            'detailed_logging' => 'Log detailed information',
        ],
    ],
    
    // Fieldset titles
    'fieldsets' => [
        'general_information' => 'General Information',
        'contact_information' => 'Contact Information',
        'admin_configuration' => 'Admin Panel Configuration',
        'content_configuration' => 'Multilanguage Content Configuration',
        'email_configuration' => 'Email Configuration',
        'security_configuration' => 'Security Configuration',
        'appearance_configuration' => 'Appearance Configuration',
        'system_configuration' => 'System Configuration',
    ],
];