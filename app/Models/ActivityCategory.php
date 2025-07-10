<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityCategory extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'color',
    ];
    
    /**
     * Get the activities for this category.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class, 'category_id');
    }
}
