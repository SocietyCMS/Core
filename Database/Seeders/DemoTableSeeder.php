<?php

namespace Modules\Core\Database\Seeders;

use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\Factory\useFactories;

class DemoTableSeeder extends Seeder
{
    use useFactories;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('core__media')->delete();
        DB::table('core__activities')->delete();

        $this->clearStoredMedia();
    }

    private function clearStoredMedia()
    {
        return File::deleteDirectory(public_path('media'), true);
    }
}
