<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'member_id',
        'registration_number',
        'status',
        'personal_info_completed',
        'documents_uploaded',
        'terms_accepted',
        'submitted_at',
        'verified_at',
        'verified_by',
        'verification_notes',
        'approved_at',
        'approved_by',
        'rejection_reason',
    ];
    
    protected $casts = [
        'personal_info_completed' => 'boolean',
        'documents_uploaded' => 'boolean',
        'terms_accepted' => 'boolean',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'status' => 'string',
    ];
    
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
    
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    public function isComplete(): bool
    {
        return $this->personal_info_completed && 
               $this->documents_uploaded && 
               $this->terms_accepted;
    }
    
    public function markAsSubmitted(): void
    {
        $this->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);
    }
    
    public function markAsVerified(int $userId, ?string $notes = null): void
    {
        $this->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => $userId,
            'verification_notes' => $notes,
        ]);
    }
    
    public function markAsApproved(int $userId): void
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $userId,
        ]);
    }
    
    public function reject(string $reason): void
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);
    }
}
