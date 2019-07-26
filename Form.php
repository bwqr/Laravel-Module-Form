<?php

namespace App\Modules\Form;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'name', 'slug', 'fields', 'language_id'
    ];

    protected $casts = [
        'fields' => 'array'
    ];

    public function appliedForms()
    {
        return $this->hasMany('App\\Modules\\Form\\AppliedForm');
    }

    public function language()
    {
        return $this->belongsTo('App\\Modules\\Core\\Language');
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
