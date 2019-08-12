<?php


namespace App\Modules\Form\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Core\Language;
use App\Modules\Form\AppliedForm;
use App\Modules\Form\Form;
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

    public function getForm($form_id)
    {
        return Form::with('language')->findOrFail($form_id);
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
        request()->validate([
            'name' => 'required',
            'slug' => 'required',
            'language_id' => 'required'
        ]);

        $form = Form::findOrFail($form_id);

        $language = Language::findOrFail(request()->input('language_id'));

        $form->update(request()->only(['name', 'slug', 'language_id']));

        return response()->json();
    }

    public function deleteForm($form_id)
    {
        Form::findOrFail($form_id)->delete();

        return response()->json([]);
    }

    public function getAppliedForms()
    {
        return AppliedForm::with('form')->latest()->get();
    }

    public function getAppliedForm($id)
    {
        return AppliedForm::with('form')->findOrFail($id);
    }

    public function getAppliedFormsPaginate()
    {
        return AppliedForm::with('form')->latest()->paginate(request()->input('per-page') ?? 20);
    }

    public function deleteAppliedForm($applied_form_id)
    {
        AppliedForm::findOrFail($applied_form_id)->delete();

        return response()->json();
    }

    public function setFormRead($applied_form_id)
    {
        AppliedForm::findOrFail($applied_form_id)->update(['is_read' => 1]);
    }

    public function getAppliedFormFile($applied_form_id, $field_name)
    {
        $applied_form = AppliedForm::findOrFail($applied_form_id);

        if (!array_key_exists($field_name, $applied_form->values)) {
            abort(404);
        }

        $file_path = Storage::disk('local')->path("forms/{$applied_form->id}/{$applied_form->values[$field_name]}");

        return response()->file($file_path);
    }
}
