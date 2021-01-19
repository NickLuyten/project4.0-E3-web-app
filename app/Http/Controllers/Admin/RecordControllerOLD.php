<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordControllerOLD extends Controller
{
    public function index()
    {
        $records = [
            'Queen - Greatest Hits',
            'The Rolling Stones - Sticky Fingers',
            'The Beatles - Abbey Road',
            'The Who - Tommy'
        ];

        return view('admin.records.index', [
            'records' => $records
        ]);
    }
}
