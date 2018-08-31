<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\HelpersProvider;
use App\Models\PanoramaStatsType;

class CategoriesController extends Controller
{
    public function index(HelpersProvider $helpers) {
        $DATA = [];
        $DATA['name'] = 'Toutes les catégories';
        $DATA['breadcrumb'] = [
            'Back-Office' => '/', 
            'Toutes les catégories' => '/categories'];
        $DATA['data'] = PanoramaStatsType::all();
        $DATA['is_ajax'] = false;
        $DATA['is_bulk'] = true;
        $DATA['is_cu'] = ['c' => true, 'u' => true];
        $DATA['filter_criteria'] = [
            ['name' => 'Thématiques',
             'db_name' => 'category',
             'values' => $DATA['data']->pluck('category', 'category')
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
                'Toutes les catégories' => '/categories', 
                'Ajouter - Mettre à jour' => sprintf('/cagetories/%s', $mode)];

            switch ($mode) {
                case 'create':
                    $category = PanoramaStatsType::find(1);
                    $DATA['name'] = 'Ajouter une (des) catégorie(s)';
                    $DATA['model'] = $helpers->collection_get_model_name($category, true);
                    $DATA['data'] = $helpers->model_get_keys($category, false);
                    break;
                case 'update':
                    $category = PanoramaStatsType::all();
                    $DATA['name'] = 'Modifier une (des) catégorie(s)';
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
