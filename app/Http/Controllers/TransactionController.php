<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store()
    {
        return response()->json([], 201);
    }
}
