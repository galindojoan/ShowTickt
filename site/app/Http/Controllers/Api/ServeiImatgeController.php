<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServeiImatgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()//GET
    {
        $image = Image::on('imageDB')->get(); 
        return response()->json($image);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)//POST
    {
        $imagen = new Image([
            'urlUnica' => $request->urlUnica,
            'imageMovil' => $request->imageMovil,
            'imageTablet' => $request->imageTablet,
            'imageOrdenador' => $request->imageOrdenador,

        ]);
        $imagen->setConnection('imageDB');
        $imagen->save();
        return response()->json('Añadido correctamente: '.$imagen);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)//GET /{id}
    {
        $imagen = Image::on('imageDB')->where('id', $id)->first();
        return response()->json($imagen);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)//PUT
    {
        $imagen = Image::on('imageDB')->where('id', $id)->update([
            'urlUnica' => $request->urlUnica,
            'imageMovil' => $request->imageMovil,
            'imageTablet' => $request->imageTablet,
            'imageOrdenador' => $request->imageOrdenador,
        ]);
        return response()->json('Actualizado correctamente: '.$imagen);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)//DELETE
    {
        $imagen = Image::on('imageDB')->where('id', $id)->delete(); 
        return response()->json('Eliminado correctamente: '.$imagen);
    }
}
