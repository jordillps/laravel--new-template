# Sistema de Logo y Favicon Dinámico - Documentación

## 🎯 Funcionalidad Implementada

Hemos implementado un sistema completo de gestión de logo y favicon dinámicos que permite:

### ✅ Características Principales

1. **Gestión de Archivos Automática**
   - Subida de logo y favicon a través del panel de administración
   - Eliminación automática de archivos anteriores al subir nuevos
   - Almacenamiento en directorio dedicado `storage/app/public/media/logos/`

2. **Integración con Filament**
   - Logo dinámico en el panel de administración
   - Favicon dinámico en todas las páginas
   - Fallback a assets por defecto si no hay archivos personalizados

3. **Cache Optimizado**
   - Los settings se cachean automáticamente
   - El cache se limpia cuando se actualizan los valores
   - Rendimiento optimizado para acceso frecuente

4. **Acceso Global**
   - Variables disponibles en todas las vistas: `$appName`, `$appLogo`, `$appFavicon`
   - Helper methods para acceso programático
   - Integración completa con el sistema de settings

## 📁 Archivos Modificados/Creados

### Modelos y Helpers
- `app/Models/Setting.php` - Lógica de eliminación automática de archivos
- `app/Helpers/SettingsHelper.php` - Métodos para obtener logo y favicon
- `app/Observers/SettingObserver.php` - Observer existente para cache

### Proveedores
- `app/Providers/AppServiceProvider.php` - Registro del View Composer
- `app/Providers/Filament/AdminPanelProvider.php` - Logo/favicon dinámico en panel

### Vistas y Composers
- `app/View/Composers/SettingsComposer.php` - Composer para variables globales

### Formularios Filament
- `app/Filament/Resources/Settings/Schemas/SettingForm.php` - Campos de upload

### Configuración
- `config/filesystems.php` - Disk 'logos' configurado
- Directorio `storage/app/public/media/logos/` creado

### Testing
- `app/Console/Commands/TestLogoSystem.php` - Comando de prueba

## 🔧 Configuración Técnica

### Disk de Almacenamiento
```php
'logos' => [
    'driver' => 'local',
    'root' => storage_path('app/public/media/logos'),
    'url' => env('APP_URL').'/storage/media/logos',
    'visibility' => 'public',
],
```

### Campos de Upload
```php
FileUpload::make('app_logo')
    ->label('Logo de la aplicación')
    ->disk('logos')
    ->visibility('public')
    ->maxSize(2048)
    ->image() // Validación básica de imagen, acepta todos los formatos comunes
    ->helperText('Tamaño máximo: 2MB. Soporta la mayoría de formatos de imagen')

FileUpload::make('app_favicon')
    ->label('Favicon')
    ->disk('logos')
    ->visibility('public')
    ->maxSize(512)
    ->image() // Validación básica de imagen
    ->helperText('Tamaño máximo: 512KB. Formatos recomendados: ICO, PNG (32x32px)')
```

## 🔧 Solución de Problemas

### Error de Tipo de Archivo
Si aparece un error como "El campo logo de la aplicación debe ser un archivo de tipo: image/jpeg, image/png, image/webp", significa que:

1. **Validación simplificada**: Hemos removido las restricciones específicas de MIME types
2. **Usa `.image()`**: Ahora acepta cualquier formato de imagen común
3. **Formatos soportados**: JPG, JPEG, PNG, GIF, WEBP, SVG, BMP, TIFF, ICO
4. **Cache**: Ejecuta `php artisan cache:clear` después de cambios

## 🚀 Uso

### En el Panel Admin
1. Ir a **Settings**
2. Subir archivo en **Logo de la Aplicación**
3. Subir archivo en **Favicon**
4. Guardar cambios

### Acceso Programático
```php
// Obtener URLs
$logoUrl = SettingsHelper::getAppLogo();
$faviconUrl = SettingsHelper::getAppFavicon();

// En vistas (variables globales disponibles)
{{ $appLogo }} // URL del logo o null
{{ $appFavicon }} // URL del favicon o null
{{ $appName }} // Nombre de la aplicación
```

### Comando de Testing
```bash
php artisan test:logo-system
```

## ⚡ Funciones de Limpieza Automática

Cuando se actualiza o elimina un setting de logo/favicon:

1. **Al actualizar**: Se elimina el archivo anterior automáticamente
2. **Al eliminar setting**: Se elimina el archivo asociado
3. **Cache**: Se limpia automáticamente el cache de settings

## 🔗 URLs de Ejemplo

- Logo: `http://tu-app.com/storage/media/logos/logo-123456789.png`
- Favicon: `http://tu-app.com/storage/media/logos/favicon-987654321.ico`

## 💡 Beneficios

1. **Sin Intervención Manual**: Los archivos viejos se eliminan automáticamente
2. **Rendimiento**: Cache optimizado para acceso rápido
3. **Flexibilidad**: Fallback a assets por defecto
4. **Integración**: Funciona perfectamente con Filament y Laravel
5. **Global**: Disponible en todas las vistas sin configuración adicional

El sistema está completamente operativo y listo para usar en producción.