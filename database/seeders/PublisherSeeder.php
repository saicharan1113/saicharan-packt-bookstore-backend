<?php

namespace Database\Seeders;

use App\Models\Publisher;
use App\Traits\GeneralHelperTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    use GeneralHelperTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publishers = Publisher::PUBLISHERS;
        foreach ($publishers as $publisher) {
            Publisher::updateOrCreate(
                ['name' => $publisher],
                ['uniquePublisherId' => $this->generateUniqueId()]
            );
        }
    }
}
