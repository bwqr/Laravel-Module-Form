<?php

use App\Modules\Form\AppliedForm;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(AppliedForm::class, function (Faker $faker) {
    return [
        'form_id' => $faker->unique()->numberBetween(0, 1000),
        'is_read' => $faker->boolean,
        'values' => $faker->shuffleArray([random_int(0, 100), random_int(0, 100), random_int(0, 100)])
    ];
});
