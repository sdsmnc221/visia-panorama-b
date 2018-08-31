<?php

namespace App\Providers\ComponentProviders;

use App\Providers\HelpersProvider;
use View;
 
class Table{
    public $has_data;
    public $cols_nb;
    public $thead;
    public $pagination;
    public $pages;
    public $pages_nb;
    public $bulk_enable;
    public $ajax_data;
    public $is_csv;

    public function __construct($DATA, $pagination = 25) {
        $helpers = new HelpersProvider();
        $this->has_data = $DATA['data']->isNotEmpty();
        $this->thead = $this->has_data ? array_key_exists('not_eloquent', $DATA) ? $DATA['data']->first()->keys()->diff('status') : $helpers->model_get_keys($DATA['data']->first()) : [];
        $this->cols_nb = $DATA['is_bulk'] ? sizeof($this->thead)+1 : sizeof($this->thead);
        $this->pagination = $pagination;
        $this->pages = $DATA['data']->chunk($pagination);
        $this->pages_nb = sizeof($this->pages);
        $this->bulk_enable = $DATA['is_bulk'];
        $this->ajax_data = array_key_exists('not_eloquent', $DATA) ? $DATA : array_merge((array) $DATA, ['model' => !$this->has_data ? '' : $helpers->collection_get_model_name($DATA['data'])]);
        $this->ajax_data['data'] = [];
        $this->is_csv = array_key_exists('not_eloquent', $DATA) ? true : false;

        //reindex (for csv table)
        foreach($this->pages as $page) {
            $page = array_values($page->toArray());
        }

        // dd(view('datasets.index', compact('DATA'))->renderSections());
    }

}

?>