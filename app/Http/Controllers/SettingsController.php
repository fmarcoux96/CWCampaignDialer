<?php

namespace App\Http\Controllers;

class SettingsController extends Controller
{
    public function index()
    {
        $this->authorize('edit');

        return view('settings.index');
    }
}
