<?php


namespace App\Modules\Form\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Core\Language;
use App\Modules\Form\Model\AppliedForm;
use App\Modules\Form\Model\Form;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:ownership.form']);
    }

    public function getForms()
    {
        return Form::with('language')->orderBy('slug')->get();
    }

    public function getFormsPaginate()
    {
        return Form::with('language')->orderBy('slug')->paginate(request()->input('per-page') ?? 20);
    }

    public function getForm($formId)
    {
        return Form::with(['language', 'sections.formFields'])->findOrFail($formId);
    }

    public function getFormAppliedForms($form_id)
    {
        return Form::with(['appliedForms' => function ($query) {
            $query->orderBy('created_at', 'DESC');
        }])->findOrFail($form_id)->appliedForms;
    }

    public function getFormAppliedFormsPaginate($form_id)
    {
        return Form::findOrFail($form_id)->appliedForms()->orderBy('created_at', 'DESC')->paginate(request()->input('per-page') ?? 20);
    }

    public function postForm()
    {
        request()->validate([
            'name' => 'required',
            'slug' => 'required',
            'language_id' => 'required'
        ]);

        Form::create(request()->only([
            'name', 'slug', 'language_id'
        ]));

        return response()->json();
    }

    public function postFormSection(Form $form)
    {
        request()->validate([
            'name' => 'required'
        ]);

        $form->sections()->create(request()->only([
            'name'
        ]));

        return response()->json();
    }

    public function putForm(Form $form)
    {
        request()->validate([
            'name' => 'required',
            'slug' => 'required',
            'language_id' => 'required'
        ]);

        $form->update(request()->only(['name', 'slug', 'language_id']));

        return response()->json();
    }

    public function deleteForm(Form $form)
    {
        $form->delete();

        return response()->json([]);
    }

    public function getAppliedForms()
    {
        return AppliedForm::with(['form'])->latest()->get();
    }

    public function getAppliedForm($applied_form_id)
    {
        return AppliedForm::with(['form.formFields', 'values'])->findOrFail($applied_form_id);
    }

    public function getAppliedFormsPaginate()
    {
        return AppliedForm::with('form')->latest()->paginate(request()->input('per-page') ?? 20);
    }

    public function deleteAppliedForm(AppliedForm $appliedForm)
    {
        $appliedForm->delete();

        return response()->json();
    }

    public function setAppliedFormRead($applied_form_id)
    {
        AppliedForm::findOrFail($applied_form_id)->update(['is_read' => 1]);
    }

    public function getAppliedFormFile($applied_form_id, $fieldId)
    {
        $value = AppliedForm::findOrFail($applied_form_id)->values()->where('field_id', $fieldId)->firstOrFail();

        $file_path = Storage::disk('local')->path("forms/{$applied_form_id}/{$value->value}");

        return response()->file($file_path);
    }
}
