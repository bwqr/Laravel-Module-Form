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

    public function putFormSectionField(FormSectionField $field)
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
            $this->updateWeights(FormSection::getModel()->getTable(), request()->input('sections'));
            $this->updateWeights(FormSectionField::getModel()->getTable(), request()->input('form_fields'));
        });

        return response()->json();
    }

    public function deleteSection(FormSection $section)
    {
        $section->delete();

        return response()->json();
    }

    public function deleteFormSectionField(FormSectionField $field)
    {
        $field->delete();

        return response()->json();
    }
}
