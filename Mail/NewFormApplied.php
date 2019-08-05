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

    public $sections;

    public $formName;

    public function __construct($values, $sections, $formName)
    {
        $this->values = $values;
        $this->sections = $sections;
        $this->formName = $formName;
    }

    public function build()
    {
        return $this->view('emails.form-created')->with([
            'values' => $this->values,
            'sections' => $this->sections,
            'title' => Lang::get('form.email', ['formName' => $this->formName])
        ]);
    }
}
