<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\CrawlerController;
class Stock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock';

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
     * @return int
     */
    public function handle()
    {
        $strat = '2021-06-02';
        for ($i=0; $i < 100; $i++) { 
            $date = date('Ymd',strtotime($strat." -{$i} days"));
            $info = CrawlerController::stockOHLCV($date);
            $this->info($info);
        }
        
        
    }
}
