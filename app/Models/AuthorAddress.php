<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorAddress extends Model
{
    use HasFactory;

    protected $table = 'author_addresses';

    protected $fillable = [
        'author_id',
        'type',
        'is_default',
        'country',
        'region',
        'city',
        'street',
        'building',
        'apartment',
        'postal_code',
        'contact_name',
        'contact_phone',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the author associated with this address
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
