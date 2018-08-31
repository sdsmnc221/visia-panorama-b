<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\BNFServiceProvider;
use App\Models\PanoramaAuthor;
use App\Models\PanoramaAction;
use App\Models\PanoramaContent;
use App\Models\PanoramaDataset;
use App\Models\PanoramaDatum;
use App\Models\PanoramaStatsType;

class APIController extends Controller
{
    public function datasetsFeatured() {
        $datasets = PanoramaDataset::all()->where('is_highlighted', true);
        $DATA = collect($datasets)->transform(function ($d, $k) {
            $data = $d->data->count();
            $stats_type = PanoramaStatsType::find($d->stats_type_id_FK);
            $cat = $stats_type->category;
            $type = $stats_type->name;
            return collect($d)->put('data', $data)->put('cat', $cat)->put('type', $type);
        })->values();
        return response()->json($DATA);
    }

    public function datasetsIndex() {
        $datasets = PanoramaDataset::all();
        $DATA = collect($datasets)->transform(function ($d, $k) {
            $data = $d->data->count();
            $stats_type = PanoramaStatsType::find($d->stats_type_id_FK);
            $cat = $stats_type->category;
            $type = $stats_type->name;
            return collect($d)->put('data', $data)->put('cat', $cat)->put('type', $type);
        });
        return response()->json($DATA);
    }

    public function datasetsOne($dataset_id) {
        $dataset = PanoramaDataset::find($dataset_id);
        $data = $dataset->data;
        $category = $dataset->category;
        $actions = PanoramaStatsType::find($dataset->stats_type_id_FK)->actions;
        $authors = $data->map(function($d, $k) { return collect($d->author)->put('data_id', $d->data_id); });
        $authorsF = $authors->filter(function($a, $k) { return $a->get('gender') === 'F'; });
        $authorsM = $authors->filter(function($a, $k) { return $a->get('gender') === 'M'; });
        $DATA = collect($dataset);
        $DATA->put('data', $data);
        $DATA->put('actions', $actions);
        $DATA->put('category', $category);
        $DATA->put('authors', $authors);
        $DATA->put('authorsM', $authorsM);
        $DATA->put('authorsF', $authorsF);
        return response()->json($DATA);
    }

    public function authorsIndex() {
        $DATA = ['all' => PanoramaAuthor::where('gender', 'F')->get()];
        return response()->json($DATA);
    }

    public function authorsOne($author_id) {
        $author = PanoramaAuthor::find($author_id);
        // $works = BNFServiceProvider::search_works_by_author(['pseudonym' => $author->pseudonym]);
        // if (!$author->img) {
        //     $img = BNFServiceProvider::search_author_img(['pseudonym' => $author->pseudonym]);
        //     $author->img = $img;
        // }
        $works = ['all' => []];
        $img = [];
        $datasets = PanoramaDataset::findMany(PanoramaDatum::where('author_id_FK', $author->id_author)->get()->unique('dataset_id_FK')->pluck('dataset_id_FK')->toArray());
        $datasets = collect($datasets)->transform(function ($d, $k) {
            $data = $d->data->count();
            $stats_type = PanoramaStatsType::find($d->stats_type_id_FK);
            $cat = $stats_type->category;
            $type = $stats_type->name;
            return collect($d)->put('data', $data)->put('cat', $cat)->put('type', $type);
        });
        $DATA = collect($author);
        $DATA->put('works', $works);
        $DATA->put('img', $img);
        $DATA->put('datasets', $datasets);
        
        return response()->json($DATA);
    }

    public function authorsImg($author_id) {
        $author = PanoramaAuthor::find($author_id);
        if (!$author->img) {
            $img = BNFServiceProvider::search_author_img(['pseudonym' => $author->pseudonym]);
            $author->img = $img;
        }
        return response()->json($author->img);
    }

    public function authorsWorks($author_id) {
        $author = PanoramaAuthor::find($author_id);
        $works = BNFServiceProvider::search_works_by_author(['pseudonym' => $author->pseudonym]);
        return response()->json($works);
    }

    public function content($query) {
        $query = explode('+', $query);
        $content = PanoramaContent::where(function ($q) use ($query) {
            $q->where(function ($q) use ($query) {
                foreach ($query as $q_) {
                    $q->orWhere('query', $q_);
                }
            });
        })->get();
        $response = [];
        foreach ($query as $q) {
            array_push($response, $content->firstWhere('query', $q));
        }
        return response()->json($response);
    }
}
