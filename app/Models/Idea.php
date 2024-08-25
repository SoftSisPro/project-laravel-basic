<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Idea extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'likes'];

    protected $casts = [
        'created_ad' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeMyIdeas(Builder $query, $filter): void
    {
        if (!empty($filter) && $filter == 'mis-ideas') {
            $query->where('user_id', auth()->user()->id);
        }
    }

    public function scopeTheBest(Builder $query, $filter): void
    {
        if (!empty($filter) && $filter == 'las-mejores') {
            $query->orderBy('likes', 'desc');
        }
    }

}
