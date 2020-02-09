<?php

namespace App\Modules\Form;

use Illuminate\Database\Eloquent\Model;

class FormSectionField extends Model
{
    protected $fillable = [
      'section_id', 'name', 'title', 'placeholder', 'options', 'disabled', 'type'
    ];

    protected $casts = [
        'options' => 'array'
    ];
}