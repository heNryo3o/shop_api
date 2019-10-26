<?php namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Log;

class AutoRecieve extends Command {

    protected $name = 'auto_recieve';//命令名称

    protected $description = '自动收货'; // 命令描述，没什么用

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        (new Order())->autoRecieve();

    }

}
