<?php

namespace App\Modules\Form\Model;

use Illuminate\Database\Eloquent\Model;

class FormSection extends Model
{
    public const CUSTOMER_SECTION = 0b10;
    public const SYSTEM_SECTION = 0b01;

    protected $fillable = [
      'name', 'formable_id', 'formable_type', 'flags'
    ];

    protected $hidden = [

    ];

    public function formable()
    {
        return $this->morphTo();
    }

    public function formFields()
    {
        return $this->hasMany(FormSectionField::class, 'section_id')->orderBy('weight', 'ASC');
    }
}
