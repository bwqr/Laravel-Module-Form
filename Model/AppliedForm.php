<?php

namespace App\Modules\Form\Model;

use Illuminate\Database\Eloquent\Model;

class AppliedForm extends Model
{
    protected $casts = [
        'values' => 'array'
    ];

    protected $fillable = [
        'form_id', 'is_read', 'values'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function values()
    {
        return $this->morphMany(FormSubmission::class, 'formable');
    }
}
