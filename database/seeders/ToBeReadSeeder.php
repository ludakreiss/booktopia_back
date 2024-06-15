<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ToBeReadList;

class ToBeReadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ToBeReadList::factory()->count(10)->create();
    }
}
