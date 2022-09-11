<?php

namespace App\Http\Controllers;

use App\Models\Client;
// use App\Models\Project;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getClients()
    {
        return response()->json([
            'message' => 'Data berhasil di load!',
            'data' => Client::all()
        ]);
    }
}
