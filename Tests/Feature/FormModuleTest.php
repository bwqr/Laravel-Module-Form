<?php


namespace App\Modules\Form\Tests\Feature;


use App\Modules\Core\Tests\TestCase;
use App\Modules\Core\User;
use App\Modules\Form\AppliedForm;
use App\Modules\Form\Form;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FormModuleTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([\App\Modules\Core\Http\Middleware\Permission::class]);

        $this->user = factory(User::class)->make();
    }

    public function testRoutes(): void
    {
        $this->assertTrue($this->checkRoute($this->formRoute . 'forms'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'forms/paginate'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'form/{form_id}'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'form/{form_id}/applied-forms'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'form/{form_id}/applied-forms/paginate'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'form', 'post'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'form/{form_id}', 'put'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'form/{form_id}', 'delete'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'applied-forms'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'applied-forms/paginate'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'applied-form/{applied_form_id}'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'applied-form/{applied_form_id}', 'delete'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'applied-form-read/{applied_form_id}'));
        $this->assertTrue($this->checkRoute($this->formRoute . 'applied-form-file/{applied_form_id}/{field_name}'));
    }

    public function testGetForms(): void
    {
        $this->getManyTest(Form::class, $this->formRoute . 'forms', $this->user);
    }

    public function testGetFormsPaginate(): void
    {
        $this->getPaginateTest(Form::class, $this->formRoute . 'forms/paginate', $this->user);
    }

    public function testGetFormAppliedForms(): void
    {
        $form = factory(Form::class)->create();

        $count = 10;

        for ($i = 0; $i < $count; $i++) {
            factory(AppliedForm::class)->create([
                'form_id' => $form->id
            ]);
        }

        $this->getManyTest(AppliedForm::class, $this->formRoute . "form/{$form->id}/applied-forms", $this->user, $count);
    }

    public function testGetFormAppliedFormsPaginate(): void
    {
        $form = factory(Form::class)->create();

        $count = 10;

        for ($i = 0; $i < $count; $i++) {
            factory(AppliedForm::class)->create([
                'form_id' => $form->id
            ]);
        }

        $this->getPaginateTest(AppliedForm::class,  $this->formRoute . "form/{$form->id}/applied-forms/paginate", $this->user);
    }

    public function testGetForm(): void
    {
        $this->getOneTest(Form::class, $this->formRoute . 'form/', 'id', $this->user);
    }

    public function testPostForm(): void
    {
        $this->postTest(Form::class, $this->formRoute . 'form', $this->user);
    }

    public function testPutForm(): void
    {
        $this->putTest(Form::class, $this->formRoute . 'form/', 'id', $this->user, [], ['fields']);
    }

    public function testDeleteForm(): void
    {
        $this->deleteTest(Form::class, $this->formRoute . 'form/', 'id', $this->user);
    }

    public function testGetAppliedForms(): void
    {
        $this->getManyTest(AppliedForm::class, $this->formRoute . 'applied-forms', $this->user);
    }

    public function testGetAppliedFormsPaginate(): void
    {
        $this->getPaginateTest(AppliedForm::class, $this->formRoute . 'applied-forms/paginate', $this->user);
    }

    public function testGetAppliedForm(): void
    {
        $this->getOneTest(AppliedForm::class, $this->formRoute . 'applied-form/', 'id', $this->user);
    }

    public function testDeleteAppliedForm(): void
    {
        $this->deleteTest(AppliedForm::class, $this->formRoute . 'applied-form/', 'id', $this->user);
    }

    public function testSetAppliedFormRead(): void
    {
        $appliedForm = factory(AppliedForm::class)->create([
            'is_read' => 0
        ]);

        $this->actingAs($this->user)->get($this->formRoute . "applied-form-read/{$appliedForm->id}")->assertStatus(200);

        $this->assertDatabaseHas($appliedForm->getTable(), [
            'id' => $appliedForm->id,
            'is_read' => true
        ]);
    }

    public function testCorrectGetAppliedFormFile(): void
    {
        Storage::fake('local');

        $fileName = 'test';

        $fieldName = 'test';

        $appliedForm = factory(AppliedForm::class)->create([
            'values' => [$fieldName => $fileName]
        ]);

        $path = Storage::disk('local')->path("forms/{$appliedForm->id}");

        UploadedFile::fake()->create($fileName, 128)->move($path, $fileName);

        $response =$this->actingAs($this->user)->get($this->formRoute . "applied-form-file/{$appliedForm->id}/{$fieldName}");

        $response->assertStatus(200);
    }

    public function testWrongGetAppliedFormFile(): void
    {
        Storage::fake('local');

        $fileName = 'test';

        $fieldName = 'test';

        $appliedForm = factory(AppliedForm::class)->create([
            'values' => [$fieldName . 'test' => $fileName]
        ]);

        $path = Storage::disk('local')->path("forms/{$appliedForm->id}");

        UploadedFile::fake()->create($fileName, 128)->move($path, $fileName);

        $response =$this->actingAs($this->user)->get($this->formRoute . "applied-form-file/{$appliedForm->id}/{$fieldName}");

        $response->assertStatus(404);
    }
}
