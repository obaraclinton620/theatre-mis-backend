<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Production;
use Illuminate\Http\Request;


class AdminProductionController extends Controller
{
    public function index()
    {
        // list all productions
    }

    public function store()
    {
        // create production
    }

    public function suspend(Production $production)
    {
        $production->active = false;
        $production->save();

        return response()->json([
            'message' => 'Production suspended',
            'production' => $production
        ]);
    }

}

