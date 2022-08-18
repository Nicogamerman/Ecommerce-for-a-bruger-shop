<?php

namespace App\Http\Controllers;
class ControladorWebHome extends Controller
{
    public function index()
    {
            return view("web.inicio");
    }
}
