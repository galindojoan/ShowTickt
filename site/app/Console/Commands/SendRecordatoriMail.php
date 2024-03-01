<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Sessio;
use Elibyy\TCPDF\TCPDF;
use App\Mail\CorreoRecordatori;
use App\Models\CompraEntrada;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        try {
            $tomorrow = Carbon::tomorrow()->format('Y-m-d');

            $sessios = DB::table('sessios')->whereDate('data', $tomorrow)->get();

            if ($sessios->isEmpty()) {
                Log::info('No hay sesiones programadas para mañana');
                return;
            }

            foreach ($sessios as $sessio) {
                $compras = DB::table('compras')->where('sessios_id', $sessio->id)->get();
                foreach ($compras as $compra) {
                    $evento = DB::table('esdeveniments')->where('id', $sessio->esdeveniments_id)->first();
                    $entrades = CompraEntrada::getEntrades($compra->id);
                    $recinte = Sessio::getRecinteFromSessio($sessio->id);
                    $lloc = $recinte->provincia . ', ' . $recinte->lloc . ', ' . $recinte->codi_postal . ', ' . $recinte->carrer . ', ' . $recinte->numero;

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                    $pdf->SetCreator('ShowTickt');
                    $pdf->SetTitle('Entradas');
                    $image = '<img style="text-align:center;" src="' . public_path('imagen/logo-blanco.png') . '" width="100" alt="logo">';
                    $titol = '<h1 style="font-size: 40px; text-align:center;">ShowTickt</h1>';

                    $pdf->AddPage('L', 'A4');
                    $y = $pdf->getY();
                    $pdf->writeHTMLCell(40, 0, '', $y, $image, 0, 0, 0, true, 'C', true);
                    $pdf->writeHTMLCell(80, 0, '', '', $titol, 0, 1, 0, true, 'C', true);


                    $data = view('pdfs.entradas', ['event' => $evento, 'entrades' => $entrades, 'sessio' => $sessio->data, 'lloc' => $lloc])->render();
                    $pdf->writeHTML($data, true, false, true, false, '');
                    $pdfContent = $pdf->Output('', 'S');

                    Mail::to($compra->mailComprador)->send(new CorreoRecordatori($evento, $pdfContent));
                    Log::info('Mail enviado');
                }
            };
            Log::info('Enviados mails de recordatorio a eventos.');
        } catch (Exception $e) {
            Log::error('Error al enviar los mails recordatorios. Error: ' . $e->getMessage());
        }
    }
}
