<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'cover_image',
        'price',
        'rating',
        'released_at',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'rating' => 'float',
            'released_at' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class)->orderBy('name');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Covers live under public/images/games, so the URL never depends on a
     * storage symlink existing on the machine running the app.
     */
    public function coverUrl(): string
    {
        return asset('images/games/'.$this->cover_image);
    }

    public function priceLabel(): string
    {
        return $this->price === 0
            ? 'Gratis'
            : 'Rp '.number_format($this->price, 0, ',', '.');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when($term, fn (Builder $q) => $q->where('title', 'like', '%'.$term.'%'));
    }

    public function scopeInCategory(Builder $query, ?string $slug): Builder
    {
        return $query->when($slug, fn (Builder $q) => $q->whereHas(
            'category',
            fn (Builder $c) => $c->where('slug', $slug)
        ));
    }

    public function scopeOnPlatform(Builder $query, ?string $slug): Builder
    {
        return $query->when($slug, fn (Builder $q) => $q->whereHas(
            'platforms',
            fn (Builder $p) => $p->where('slug', $slug)
        ));
    }
}
