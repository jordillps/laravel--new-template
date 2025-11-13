<?php

namespace App\Filament\Resources\Posts\Schemas;

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
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(__('Título'))
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                        $operation === 'create' ? $set('slug', Str::slug($state)) : null
                    )
                    ->columnSpan(2),
                
                TextInput::make('slug')
                    ->label(__('URL amigable'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText(__('Se genera automáticamente del título'))
                    ->columnSpan(2),
                        
                Textarea::make('excerpt')
                    ->label(__('Resumen'))
                    ->rows(3)
                    ->helperText(__('Breve descripción de la publicación (opcional)'))
                    ->columnSpanFull(),
                        
                RichEditor::make('content')
                    ->label(__('Contenido'))
                    ->required()
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
                    ->native(false),
                    
                DateTimePicker::make('published_at')
                    ->label(__('Fecha de Publicación'))
                    ->helperText(__('Dejar vacío para publicar inmediatamente'))
                    ->visible(fn ($get) => $get('status') === 'published'),
                    
                Toggle::make('is_featured')
                    ->label(__('Publicación Destacada'))
                    ->helperText(__('Aparecerá en destacados')),

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
