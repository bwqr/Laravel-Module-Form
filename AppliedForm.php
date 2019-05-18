<?php

namespace App\Modules\Form;

use Illuminate\Database\Eloquent\Model;

class AppliedForm extends Model
{
    protected $fillable = [
        'form_id', 'submission', 'is_read'
    ];

    protected $casts = [
        'submission' => 'array'
    ];

    public function form() {
        return $this->belongsTo('App\\Modules\\Form\\Form');
    }
}
