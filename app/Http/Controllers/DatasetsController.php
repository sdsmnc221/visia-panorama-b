<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\HelpersProvider;
use App\Models\PanoramaDataset;
use App\Models\PanoramaStatsType;

class DatasetsController extends Controller
{
    public function index(HelpersProvider $helpers) {
        $DATA = [];
        $DATA['name'] = 'Tous les jeux de données';
        $DATA['breadcrumb'] = [
            'Back-Office' => '/', 
            'Tous les jeux de données' => 'datasets/'];
        $DATA['data'] = PanoramaDataset::all();
        $DATA['is_ajax'] = false;
        $DATA['is_bulk'] = true;
        $DATA['is_cu'] = ['c' => true, 'u' => true];
        $categories = PanoramaStatsType::all();
        $is_highlighted_values = $helpers->collection_get_values_from_key($DATA['data'], 'is_highlighted');
        $DATA['filter_criteria'] = [
            ['name' => 'Catégories',
             'db_name' => 'stats_type_id_FK',
             'values' => $categories->pluck('stats_type_id', 'name')
             ],
             ['name' => 'Mis en avant',
             'db_name' => 'is_highlighted',
             'values' => array_combine(
                array_map(function($el) { return $el === false ? 'Non' : 'Oui'; }, $is_highlighted_values),
                array_map(function($el) { return $el === false ? '0' : '1'; }, $is_highlighted_values)
                )
             ],
        ];
        return view('layouts.page__index', compact('DATA'));
    }

    public function one($dataset_id, HelpersProvider $helpers) {
        $dataset = PanoramaDataset::find($dataset_id);
        $DATA = [];
        $DATA['name'] = $dataset->name;
        $DATA['breadcrumb'] = [
            'BO' => '/', 
            'Tous les jeux de données' => '/datasets', 
            $DATA['name'] => sprintf('/datasets/%d', $dataset->dataset_id)];
        $DATA['data'] = $dataset->data;
        $DATA['is_ajax'] = false;
        $DATA['is_bulk'] = true;
        $DATA['is_cu'] = ['c' => false, 'u' => true];
        $DATA['filter_criteria'] = [
            ['name' => 'Année',
             'db_name' => 'year',
             'values' => $DATA['data']->pluck('year', 'year')
             ]
        ];
        return view('layouts.page__index', compact('DATA'));
    }

    public function cu(string $mode, HelpersProvider $helpers) {
        if ($mode === 'create' || $mode === 'update') {
            $DATA = [];
            $DATA['active_tab'] = $mode;
            $DATA['breadcrumb'] = [
                'BO' => '/',
                'Tous les jeux de données' => '/datasets', 
                'Ajouter - Mettre à jour' => sprintf('/datasets/%s', $mode)];

            switch ($mode) {
                case 'create':
                    $category = PanoramaDataset::find(1);
                    $DATA['name'] = 'Ajouter un jeu de données';
                    $DATA['model'] = $helpers->collection_get_model_name($category, true);
                    $DATA['data'] = $helpers->model_get_keys($category, false);
                    break;
                case 'update':
                    $category = PanoramaDataset::all();
                    $DATA['name'] = 'Modifier un jeu de données';
                    $DATA['model'] = $helpers->collection_get_model_name($category, false);
                    $DATA['data'] = $helpers->model_get_keys($category->first(), true);
                    $DATA['values'] = $category->toArray();
                    break;
                default:
                    break;
            } 

            return view('layouts.page__cu', compact('DATA'));

        } else {
            return false;
        }
    }

}
