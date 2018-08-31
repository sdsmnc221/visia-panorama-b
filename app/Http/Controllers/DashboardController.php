<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PanoramaAuthor;
use App\Models\PanoramaDataset;
use App\Models\PanoramaDatum;
use App\Models\PanoramaStatsType;


class DashboardController extends Controller
{
    public function index() {
        $stats_type_ids = [
            'edu' => PanoramaStatsType::all()->where('category', 'Éducation')->pluck('stats_type_id')->toArray(),
            'edi' => PanoramaStatsType::all()->where('category', 'Édition')->pluck('stats_type_id')->toArray()
        ];
        $DATA = [];
        $DATA['name'] = 'Dashboard';
        $DATA['breadcrumb'] = [
            'Back-Office' => '/', 
            'Dashboard' => '/dashboard'];
        $DATA['overview'] = [
            [
                'name' => 'Auteurs',
                'alias' => 'authors',
                'icon' => 'users',
                'count' => PanoramaAuthor::all()->count(),
                'labels' => [
                    ['icon' => 'venus',
                    'desc' => 'Femmes',
                    'count' => PanoramaAuthor::where('gender', 'F')->count()],
                    ['icon' => 'mars',
                    'desc' => 'Hommes',
                    'count' => PanoramaAuthor::where('gender', 'M')->count()],
                    ['icon' => 'question',
                    'desc' => 'ONSP',
                    'count' => PanoramaAuthor::where('gender', '-')->count()]
                ]
            ],
            [
                'name' => 'Jeux de données',
                'alias' => 'datasets',
                'icon' => 'database',
                'count' => PanoramaDataset::all()->count(),
                'labels' => [
                    ['icon' => 'briefcase',
                    'desc' => 'Éducation',
                    'count' => PanoramaDataset::all()->whereIn('stats_type_id_FK', $stats_type_ids['edu'])->count()],
                    ['icon' => 'book',
                    'desc' => 'Édition',
                    'count' => PanoramaDataset::all()->whereIn('stats_type_id_FK', $stats_type_ids['edi'])->count()]
                ]
            ],
            [
                'name' => 'Catégories de jeux de données',
                'alias' => 'categories',
                'icon' => 'database',
                'count' => PanoramaStatsType::all()->count(),
                'labels' => [
                    ['icon' => 'briefcase',
                    'desc' => 'Éducation',
                    'count' => PanoramaStatsType::where('category', 'Éducation')->count()],
                    ['icon' => 'book',
                    'desc' => 'Édition',
                    'count' => PanoramaStatsType::where('category', 'Édition')->count()]
                ]
            ] 
        ];
        return view('layouts.page__dashboard', compact('DATA'));
    }
}
