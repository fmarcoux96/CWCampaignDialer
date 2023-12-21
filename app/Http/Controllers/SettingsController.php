<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $this->authorize('edit');

        return view('settings.index');
    }
}
