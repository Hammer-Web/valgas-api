<?php

namespace App\Http\Controllers;

use App\Material;
use App\ValoresCarga;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materiais = Material::where('deleted', 0)->get(['id', 'titulo']);

        return response()->json($materiais);
    }

    public function valoresMercadoriasAutonomo()
    {
        $materiais = ValoresCarga::where('deleted', 0)->where('tipo_motorista', 1)->get(['id', 'valor']);

        return response()->json($materiais);
    }

    public function valoresMercadoriasRH()
    {
        $materiais = ValoresCarga::where('deleted', 0)->where('tipo_motorista', 2)->get(['id', 'valor']);

        return response()->json($materiais);
    }

    public function valoresMercadoriasFrota()
    {
        $materiais = ValoresCarga::where('deleted', 0)->where('tipo_motorista', 3)->get(['id', 'valor']);

        return response()->json($materiais);
    }

    public function valoresMercadoriasAgregado()
    {
        $materiais = ValoresCarga::where('deleted', 0)->where('tipo_motorista', 4)->get(['id', 'valor']);

        return response()->json($materiais);
    }
}
