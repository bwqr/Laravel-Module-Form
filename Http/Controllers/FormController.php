<?php


namespace App\Modules\Form\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Form\AppliedForm;
use App\Modules\Form\Form;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:ownership.form']);
    }

    public function getForms()
    {
        return Form::with('language')->orderBy('slug')->all();
    }

    public function getFormsPaginate()
    {
        return Form::with('language')->orderBy('slug')->paginate(request()->input('per-page') ?? 20);
    }

    public function getForm($form_id)
    {
        return Form::with('language')->findOrFail($form_id);
    }

    public function getFormAppliedForms($form_id)
    {
        return Form::with('appliedForms')->findOrFail($form_id)->applied_forms;
    }

    public function getFormAppliedFormsPaginate($form_id)
    {
        return Form::findOrFail($form_id)->applied_forms()->paginate(request()->input('per-page') ?? 20);
    }

    public function postForm()
    {
        request()->validate([
            'name' => 'required',
            'slug' => 'required',
            'fields' => 'array',
            'language_id' => 'required'
        ]);

        Form::create(request()->only([
            'name', 'slug', 'fields', 'language_id'
        ]));

        return response()->json([]);
    }

    public function putForm($form_id)
    {

    }

    public function deleteForm($form_id)
    {
        Form::findOrFail($form_id)->delete();

        return response()->json([]);
    }

    public function getAppliedForms()
    {
        return AppliedForm::with('form')->all();
    }

    public function getAppliedForm($id)
    {
        return AppliedForm::with('form')->findOrFail($id);
    }

    public function getAppliedFormsPaginate()
    {
        return AppliedForm::with('form')->paginate(request()->input('per-page') ?? 20);
    }

    public function deleteAppliedForm($applied_form_id)
    {
        AppliedForm::findOrFail($applied_form_id)->delete();

        return response()->json([]);
    }

    public function setFormRead($id)
    {
        AppliedForm::findOrFail($id)->update(['is_read' => 1]);
    }

    public function getAppliedFormFile($applied_form_id, $field_name)
    {
        $applied_form = AppliedForm::findOrFail($applied_form_id);

        if (!array_key_exists($field_name, $applied_form->values)) {
            abort(404);
        }

        $file_path = "app/forms/{$applied_form->id}/{$applied_form->values[$field_name]}";

        return response()->file(storage_path($file_path));
    }
}
