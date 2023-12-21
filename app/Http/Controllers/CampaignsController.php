<?php

namespace App\Http\Controllers;

use App\Exports\SampleUploadFile;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class CampaignsController extends Controller
{
    public function index()
    {
        return view('campaigns.index');
    }

    public function downloadSample()
    {
        return \Excel::download(new SampleUploadFile(), 'sample-campaign.csv');
    }

    public function show(Campaign $campaign, Request $request)
    {
        return view('campaigns.show', [
            'campaign' => $campaign,
        ]);
    }
}
