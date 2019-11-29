<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportRegionsCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:regions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $country_dump = File::get(base_path().'/database/migrations/country.sql');
        $region_dump = File::get(base_path().'/database/migrations/region.sql');
        DB::connection()->getPdo()->exec($country_dump);
        DB::connection()->getPdo()->exec($region_dump);

    }
}
