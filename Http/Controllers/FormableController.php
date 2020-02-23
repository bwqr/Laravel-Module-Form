<?php


namespace App\Modules\Form\Http\Controllers;


use App\Modules\Core\Traits\Weightable;
use App\Modules\Form\Model\FormSection;
use App\Modules\Form\Model\FormSectionField;
use Illuminate\Support\Facades\DB;

class FormableController
{
    use Weightable;

    public function putSection(FormSection $section)
    {
        request()->validate([
            'name' => 'required',
            'flags' => 'required'
        ]);

        $section->update(request()->only(['name', 'flags']));

        return response()->json();
    }

    public function postSectionField(FormSection $section)
    {
        request()->validate([
            'name' => 'required',
            'title' => 'required',
            'placeholder' => 'required',
            'type' => 'required',
            'options' => 'array'
        ]);

        $section->formFields()->create(request()->only([
            'name', 'title', 'placeholder', 'type', 'options'
        ]));

        return response()->json();
    }

    public function putSectionField(FormSectionField $field)
    {
        request()->validate([
            'title' => 'required',
            'placeholder' => 'required',
        ]);

        $field->update(request()->only([
            'title', 'placeholder', 'disabled'
        ]));

        return response()->json();
    }

    public function putSectionAndFieldWeights()
    {
        request()->validate([
            'sections' => 'array',
            'form_fields' => 'array'
        ]);

        DB::transaction(function () {
            $sections = request()->input('sections');
            $formFields = request()->input('form_fields');

            if (count($sections) > 0) {
                $this->updateWeights(FormSection::getModel()->getTable(), $sections);
            }

            if (count($formFields) > 0) {
                $this->updateWeights(FormSectionField::getModel()->getTable(), $formFields);
            }
        });

        return response()->json();
    }

    public function deleteSection(FormSection $section)
    {
        $section->delete();

        return response()->json();
    }

    public function deleteSectionField(FormSectionField $field)
    {
        $field->delete();

        return response()->json();
    }
}
