<?php

use App\Models\Lookup\Department;
use App\Models\JobPoster;
use App\Models\Lookup\JobTerm;
use App\Models\Lookup\LanguageRequirement;
use App\Models\Manager;
use App\Models\Lookup\Province;
use App\Models\Lookup\SecurityClearance;
use App\Models\Criteria;
use App\Models\JobPosterKeyTask;
use App\Models\JobPosterQuestion;

$faker_fr = Faker\Factory::create('fr');

$factory->define(JobPoster::class, function (Faker\Generator $faker) use ($faker_fr) {
    $closeDate = $faker->dateTimeBetween('now', '1 months')->format('Y-m-d');
    $openDate = $faker->dateTimeBetween('-1 months', 'now')->format('Y-m-d');
    $startDate = $faker->dateTimeBetween('1 months', '2 months')->format('Y-m-d');
    return [
        'job_term_id' => JobTerm::inRandomOrder()->first()->id,
        'term_qty' => $faker->numberBetween(1, 4),
        'open_date_time' => ptDayStartToUtcTime($openDate),
        'close_date_time' => ptDayEndToUtcTime($closeDate),
        'start_date_time' => ptDayStartToUtcTime($startDate),
        'review_requested_at' => $faker->dateTimeBetween('-2 months', '-1 months'),
        'published_at' => null,
        'department_id' => Department::inRandomOrder()->first()->id,
        'province_id' => Province::inRandomOrder()->first()->id,
        'salary_min' => $faker->numberBetween(60000, 80000),
        'salary_max' => $faker->numberBetween(80000, 100000),
        'noc' => $faker->numberBetween(1, 9999),
        'classification' => $faker->regexify('[A-Z]{2}-0[1-5]'),
        'security_clearance_id' => SecurityClearance::inRandomOrder()->first()->id,
        'language_requirement_id' => LanguageRequirement::inRandomOrder()->first()->id,
        'remote_work_allowed' => $faker->boolean(50),
        'manager_id' => function () {
            return factory(Manager::class)->create()->id;
        },
        'published' => false,
        'city:en' => $faker->city,
        'title:en' => $faker->unique()->realText(27, 1),
        'impact:en' => $faker->paragraphs(
            2,
            true
        ),
        'branch:en' => $faker->word,
        'division:en' => $faker->word,
        'education:en' => $faker->sentence(),
        'city:fr' => $faker_fr->city,
        'title:fr' => $faker_fr->unique()->realText(27, 1),
        'impact:fr' => $faker_fr->paragraphs(
            2,
            true
        ),
        'branch:fr' => $faker_fr->word,
        'division:fr' => $faker_fr->word,
        'education:fr' => $faker_fr->sentence(),
    ];
});

$factory->afterCreating(JobPoster::class, function ($jp) : void {
    $jp->criteria()->saveMany(factory(Criteria::class, 5)->make([
        'job_poster_id' => $jp->id
    ]));
    $jp->job_poster_key_tasks()->saveMany(factory(JobPosterKeyTask::class, 5)->make([
        'job_poster_id' => $jp->id
    ]));
    $jp->job_poster_questions()->saveMany(factory(JobPosterQuestion::class, 2)->make([
        'job_poster_id' => $jp->id
    ]));
});

$factory->state(
    JobPoster::class,
    'published',
    function (Faker\Generator $faker) {
        return [
            'published' => true,
            'published_at' => $faker->dateTimeBetween('-1 months', '-3 weeks')
        ];
    }
);

$factory->state(
    JobPoster::class,
    'closed',
    function (Faker\Generator $faker) {
        return [
            'published' => true,
            'published_at' => $faker->dateTimeBetween('-1 months', '-3 weeks'),
            'close_date_time' => ptDayEndToUtcTime($faker->dateTimeBetween('-2 days', '-1 days')->format('Y-m-d')),
        ];
    }
);

$factory->state(
    JobPoster::class,
    'draft',
    function (Faker\Generator $faker) {
        return [
            'published' => false,
            'open_date_time' => ptDayStartToUtcTime($faker->dateTimeBetween('5 days', '10 days')->format('Y-m-d')),
            'close_date_time' => ptDayEndToUtcTime($faker->dateTimeBetween('3 weeks', '5 weeks')->format('Y-m-d')),
            'review_requested_at' => null,
            'published_at' => null,
        ];
    }
);

$factory->state(
    JobPoster::class,
    'review_requested',
    function (Faker\Generator $faker) {
        return [
            'published' => false,
            'open_date_time' => ptDayStartToUtcTime($faker->dateTimeBetween('5 days', '10 days')->format('Y-m-d')),
            'close_date_time' => ptDayEndToUtcTime($faker->dateTimeBetween('3 weeks', '5 weeks')->format('Y-m-d')),
            'review_requested_at' => $faker->dateTimeBetween('-2 days', '-1 days')
        ];
    }
);

$factory->state(JobPoster::class, 'remote', [
    'remote_work_allowed' => true
]);

$factory->state(JobPoster::class, 'local', [
    'remote_work_allowed' => false
]);
