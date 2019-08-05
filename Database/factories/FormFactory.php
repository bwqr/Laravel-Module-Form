<?php

use App\Modules\Form\Form;
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

$factory->define(Form::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'language_id' => static function() {
            return factory(\App\Modules\Core\Language::class)->create()->id;
        },
        'slug' => $faker->slug,
        'fields' => $faker->shuffleArray([random_int(0, 100), random_int(0, 100), random_int(0, 100)])
    ];
});
