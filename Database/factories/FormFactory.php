<?php

use App\Modules\Form\Model\Form;
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
        'fields' => [
            [
                'title' => $faker->title,
                'fields' => [
                    [
                        'title' => $faker->title,
                        'placeHolder' => $faker->word,
                        'type' => $faker->word,
                        'required' => $faker->boolean,
                        'name' => $faker->word,
                    ]
                ]
            ]
        ],
    ];
});
