<?php

namespace App\Modules\Form;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $casts = [
        'fields' => 'array', 'name' => 'array'
    ];

    public function appliedForms() {
        return $this->hasMany('App\\Modules\\Form\\AppliedForm');
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
