<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'full_name',
        'nik',
        'birth_place',
        'birth_date',
        'gender',
        'phone',
        'address',
        'city',
        'occupation',
        'job_title',
        'division_id',
        'position_id',
        'registration_number',
        'status',
    ];
    
    // Define status enum values
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    protected $casts = [
        'birth_date' => 'date',
        'status' => 'string',
        'card_generated_at' => 'datetime',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
    
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
    
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
    
    public function registration(): HasOne
    {
        return $this->hasOne(Registration::class);
    }

    /**
     * Get all comments by this member.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    
    /**
     * Get all comment replies by this member.
     */
    public function commentReplies(): HasMany
    {
        return $this->hasMany(CommentReply::class);
    }
    
    /**
     * Get all likes by this member.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
    
    /**
     * Get the member's photo document.
     *
     * @return \App\Models\Document|null
     */
    public function getPhotoDocument()
    {
        return $this->documents()->where('type', 'photo')->first();
    }
    
    /**
     * Get the member's KTP document.
     *
     * @return \App\Models\Document|null
     */
    public function getKtpDocument()
    {
        return $this->documents()->where('type', 'ktp')->first();
    }
    
    /**
     * Generate registration number for a new member.
     *
     * @return string
     */
    public function generateRegistrationNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        
        // Count members registered this month and add 1
        $count = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count() + 1;
        
        // Format: MMS-YYYYMM-XXXX (e.g., MMS-202504-0001)
        return 'MMS-' . $year . $month . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Activate this member
     */
    public function activate()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->save();
        return $this;
    }
    
    /**
     * Deactivate this member
     */
    public function deactivate()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->save();
        return $this;
    }
}
