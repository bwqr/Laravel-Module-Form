<?php

namespace App\Modules\Form\Model;

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
        return $this->hasMany(AppliedForm::class);
    }

    public function language()
    {
        return $this->belongsTo(config('modules.namespace') . '\\Core\\Language');
    }

    public function sections()
    {
        return $this->morphMany(FormSection::class, 'formable')->orderBy('weight', 'ASC');
    }

    public function 

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
