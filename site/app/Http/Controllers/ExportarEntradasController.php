<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sessio;
use App\Models\Compra;
use App\Models\CompraEntrada;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportarEntradasController extends Controller
{
    public function exportarCSV($sessioId)
    {
        $sessio = Sessio::findOrFail($sessioId);
        $compras = Compra::whereHas('sessio', function ($query) use ($sessioId) {
            $query->where('id', $sessioId);
        })->with('compraEntrada.entrada')->get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=entradas_sessio_" . $sessioId . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function () use ($compras) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nom comprador', 'Codi d’entrada', 'Tipus d’entrada']);

            foreach ($compras as $compra) {
                foreach ($compra->compraEntrada as $compraEntrada) {
                    fputcsv($file, [$compraEntrada->nomComprador, $compraEntrada->numeroIdentificador, $compraEntrada->entrada->nom]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
