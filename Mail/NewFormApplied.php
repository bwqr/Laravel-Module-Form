<?php


namespace App\Modules\Form\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;


class NewFormApplied extends Mailable
{
    use Queueable, SerializesModels;

    public $values;

    public $formFields;

    public $formName;

    public function __construct($values, $formFields, $formName)
    {
        $this->values = $values;
        $this->formFields = $formFields;
        $this->formName = $formName;
    }

    public function build()
    {
        return $this->view('emails.form-created')->with([
            'values' => $this->values,
            'formFields' => $this->formFields,
            'title' => Lang::get('form.email', ['formName' => $this->formName])
        ]);
    }
}
