<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Helpers\SettingsHelper;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        $availableLanguages = SettingsHelper::getAvailableLanguages();
        
        $languageNames = [
            'es' => 'Español',
            'en' => 'English', 
            'ca' => 'Català',
            'fr' => 'Français',
            'de' => 'Deutsch',
        ];

        return $schema
            ->components([
                // Campos por idioma
                ...collect($availableLanguages)->flatMap(function ($locale) use ($languageNames) {
                    return [
                        TextInput::make("title_multilang.{$locale}")
                            ->label(__('Título') . " ({$languageNames[$locale]})")
                            ->required($locale === 'es') // Español requerido, otros opcionales
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set, callable $get) use ($locale) {
                                if ($operation === 'create' && $state) {
                                    $slugs = $get('slug_multilang') ?? [];
                                    $slugs[$locale] = Str::slug($state);
                                    $set('slug_multilang', $slugs);
                                }
                            })
                            ->columnSpan(2),
                        
                        TextInput::make("slug_multilang.{$locale}")
                            ->label(__('URL amigable') . " ({$languageNames[$locale]})")
                            ->required($locale === 'es')
                            ->helperText(__('Se genera automáticamente del título'))
                            ->columnSpan(2),
                            
                        Textarea::make("excerpt_multilang.{$locale}")
                            ->label(__('Resumen') . " ({$languageNames[$locale]})")
                            ->rows(2)
                            ->helperText(__('Breve descripción de la publicación (opcional)'))
                            ->columnSpanFull(),
                            
                        RichEditor::make("content_multilang.{$locale}")
                            ->label(__('Contenido') . " ({$languageNames[$locale]})")
                            ->required($locale === 'es')
                            ->helperText(__('Contenido principal de la publicación'))
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull(),
                    ];
                })->toArray(),

                // Separador visual
                Select::make('status')
                    ->label(__('Estado'))
                    ->options([
                        'draft' => __('Borrador'),
                        'published' => __('Publicado'), 
                        'archived' => __('Archivado'),
                    ])
                    ->default('draft')
                    ->required()
                    ->live()
                    ->native(false)
                    ->columnSpan(1),
                    
                DateTimePicker::make('published_at')
                    ->label(__('Fecha de Publicación'))
                    ->helperText(__('Dejar vacío para publicar inmediatamente'))
                    ->visible(fn ($get) => $get('status') === 'published')
                    ->columnSpan(1),
                    
                Toggle::make('is_featured')
                    ->label(__('Publicación Destacada'))
                    ->helperText(__('Aparecerá en destacados'))
                    ->columnSpan(2),

                FileUpload::make('featured_image')
                    ->label(__('Imagen Destacada'))
                    ->image()
                    ->disk('public')
                    ->directory('posts')
                    ->maxSize(2048)
                    ->helperText(__('Tamaño máximo: 2MB. Formatos: JPG, PNG'))
                    ->columnSpanFull(),

                // Campo oculto para el usuario actual si es creación
                Hidden::make('user_id')
                    ->default(Auth::id()),
            ]);
    }
}
