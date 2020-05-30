<?php

namespace App\Modules\Form\Model;

use Illuminate\Database\Eloquent\Model;

class FormSectionField extends Model
{
    protected $fillable = [
      'section_id', 'name', 'title', 'placeholder', 'options', 'disabled', 'type', 'required'
    ];

    protected $casts = [
        'options' => 'array'
    ];
}
