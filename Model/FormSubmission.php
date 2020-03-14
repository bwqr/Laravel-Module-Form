<?php

namespace App\Modules\Form\Model;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'field_id', 'formable_id', 'formable_type', 'value'
    ];

    public function formable()
    {
        return $this->morphTo();
    }

    public function formField()
    {
        return $this->hasOne(FormSectionField::class, 'id', 'field_id');
    }
}
