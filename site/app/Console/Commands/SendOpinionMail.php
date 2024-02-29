<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Mail\CorreoOpinion;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class SendOpinionMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:opinion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para enviar el día posterior a eventos una url con petición para comentar en la página.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $tomorrow = Carbon::yesterday()->format('Y-m-d');
            $sessios = DB::table('sessios')->whereDate('data', $tomorrow)->get();
            if ($sessios->isEmpty()) {
                Log::info('No hay sesiones de ayer');
                return;
            }
            foreach ($sessios as $sessio) {
                $event = DB::table('esdeveniments')->where('id', $sessio->esdeveniments_id)->first();
                $compras = DB::table('compras')->where('sessios_id', $sessio->id)->get();
                foreach ($compras as $compra) {
                    $url = URL::signedRoute('crearOpinion', ['event-id' => $event->id]);
                    Mail::to($compra->mailComprador)->send(new CorreoOpinion($event, $url));
                }
            }
            Log::info('Mails de petición de opiniones enviadas correctamente.');
        } catch (Exception $e) {
            Log::error('Error al mandar los mails de petición de opiniones. Error: ' . $e->getMessage());
        }
    }
}
