<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'member_id',
        'type',
        'file_name',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'verified',
        'verification_notes',
    ];
    
    protected $casts = [
        'verified' => 'boolean',
        'file_size' => 'integer',
    ];
    
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
    
    public function getFullPathAttribute(): string
    {
        return storage_path('app/' . $this->file_path);
    }
}
