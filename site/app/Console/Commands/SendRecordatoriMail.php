<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendRecordatoriMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manda emails diarios a todos los compradores de eventos, cuyos sucedan el dia posterior.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('compra');
    }
}
