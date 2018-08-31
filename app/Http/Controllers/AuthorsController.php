<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\HelpersProvider;
use App\Models\PanoramaAuthor;

class AuthorsController extends Controller
{
    public function index(HelpersProvider $helpers) {
        $DATA = [];
        $DATA['name'] = 'Tous les auteurs';
        $DATA['breadcrumb'] = [
            'Back-Office' => '/', 
            'Tous les auteurs' => '/authors'];
        $DATA['data'] = PanoramaAuthor::all();
        $DATA['is_ajax'] = false;
        $DATA['is_bulk'] = false;
        $DATA['is_cu'] = ['c' => false, 'u' => false];
        $DATA['filter_criteria'] = [
            ['name' => 'Sexes',
             'db_name' => 'gender',
             'values' => $DATA['data']->pluck('gender', 'gender')
             ]
        ];
        return view('layouts.page__index', compact('DATA'));
    }
}
