<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Providers\HelpersProvider;
use \ParseCsv\Csv;
use App\Providers\ComponentProviders\Table;
use App\Providers\ComponentProviders\Toolbar;

class AJAXController extends Controller
{
    public function filter(HelpersProvider $helpers) {
        if (request()->ajax()) {
            $DATA = collect(request('data'));
            $DATA['is_ajax'] = true;
            // $DATA['filter_criteria'] = $helpers->collection_make_filter_criteria($DATA['filter_criteria']);
            $DATA['data'] = $helpers->collection_filter($DATA['model'], $helpers->collection_make_filter_criteria($DATA['filter_criteria']));
            $html = view('layouts.components.table', compact('DATA'))->renderSections();

            return response()->json(array_merge($html, $DATA));
        }
        
    }

    public function cu(HelpersProvider $helpers) {
        $DATA = collect(request()->all());
        $RES = [];
        
        switch ($DATA['type']) {
            case 'create':
                $RES['stored_items'] = $helpers->model_store_many($DATA['what_model'], $DATA['data']);
                $RES['what'] = $DATA['what'];
                $RES['type'] = $DATA['type'];
                // $RES['status'] = sizeof($RES['stored_items']) > 0 ? 'success' : 'error';
                break;
            case 'update':
                $RES['updated_items'] = $helpers->model_update_many($DATA['what_model'], $DATA['data']);
                $RES['what'] = $DATA['what'];
                $RES['type'] = $DATA['type'];
                break;
            default:
                break;
        }

        return response()->json($RES);
    }

    public function csv(HelpersProvider $helpers) {
        $DATA = [];
        $DATA['is_ajax'] = false;
        $DATA['is_bulk'] = true;
        $DATA['not_eloquent'] = false;
        $DATA['data'] = request()->input('string');
        $DATA['data'] = $helpers->format_CSV($DATA['data']);
        $DATA['data'] = $helpers->update_CSV_data($DATA['data']);
        $DATA['filter_criteria'] = [];
        $table = new Table($DATA);
        $html = view('layouts.components.table', compact('DATA'))->renderSections();
    
        return response()->json($html);
    }

}
