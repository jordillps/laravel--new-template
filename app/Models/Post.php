<?php

namespace App\Models;

use App\Helpers\SettingsHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'title_multilang',
        'slug_multilang',
        'excerpt_multilang',
        'content_multilang',
        'featured_image',
        'status',
        'is_featured',
        'user_id',
        'published_at',
        'meta_data',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'meta_data' => 'array',
        'title_multilang' => 'array',
        'slug_multilang' => 'array',
        'excerpt_multilang' => 'array',
        'content_multilang' => 'array',
    ];

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Mutadores
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Obtener título en idioma específico o por defecto
     */
    public function getTitleInLanguage($locale = null): string
    {
        if (!$locale) {
            $locale = app()->getLocale();
        }
        
        if ($this->title_multilang && isset($this->title_multilang[$locale])) {
            return $this->title_multilang[$locale];
        }
        
        return $this->title ?? '';
    }

    /**
     * Obtener slug en idioma específico o por defecto
     */
    public function getSlugInLanguage($locale = null): string
    {
        if (!$locale) {
            $locale = app()->getLocale();
        }
        
        if ($this->slug_multilang && isset($this->slug_multilang[$locale])) {
            return $this->slug_multilang[$locale];
        }
        
        return $this->slug ?? '';
    }

    /**
     * Obtener excerpt en idioma específico o por defecto
     */
    public function getExcerptInLanguage($locale = null): string
    {
        if (!$locale) {
            $locale = app()->getLocale();
        }
        
        if ($this->excerpt_multilang && isset($this->excerpt_multilang[$locale])) {
            return $this->excerpt_multilang[$locale];
        }
        
        return $this->excerpt ?? '';
    }

    /**
     * Obtener contenido en idioma específico o por defecto
     */
    public function getContentInLanguage($locale = null): string
    {
        if (!$locale) {
            $locale = app()->getLocale();
        }
        
        if ($this->content_multilang && isset($this->content_multilang[$locale])) {
            return $this->content_multilang[$locale];
        }
        
        return $this->content ?? '';
    }

    /**
     * Obtener idiomas disponibles para el contenido
     */
    public function getAvailableLanguages(): array
    {
        return SettingsHelper::getAvailableLanguages();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'draft' => 'warning',
            'published' => 'success',
            'archived' => 'secondary',
            default => 'primary',
        };
    }
}
