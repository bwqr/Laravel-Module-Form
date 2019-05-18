<?php

namespace App\Modules\Form\Http\Controllers;


use App\Modules\Form\AppliedForm;
use App\Modules\Form\Form;
use App\Http\Controllers\Controller;

class FormsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('admin');
    }

    public function getForms()
    {
        return Form::orderBy('created_at', 'ASC')
            ->paginate(request()->input('per-page') ?? 5);
    }

    public function getFormWithAppliedForms($slug)
    {
        $form = Form::slug($slug)->firstOrFail();

        $appliedForms = $form->appliedForms()
            ->orderBy('created_at', 'DESC')
            ->paginate(request()->input('per-page') ?? 5);

        $form->appliedForms = $appliedForms;
        return $form;
    }

    public function getForm($id)
    {
        return AppliedForm::where('id', $id)->with('form')->firstOrFail();
    }

    public function setFormRead($id)
    {
        AppliedForm::findOrFail($id)->update(['is_read' => 1]);
    }
}
