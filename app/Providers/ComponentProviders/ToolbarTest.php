<?php

namespace App\Providers\ComponentProviders;
 
class ToolbarTest{
    public $table;
    public $m_pagination;
    public $m_filter;
    public $m_search;

    public function __construct(Table $table, array $filter_criteria) {
        $this->table = $table;
        $this->init_menu($filter_criteria);
    }

    public function init_menu($filter_criteria, $col_w = 200) {
        $this->m_pagination = [
            'pages' => sizeof($this->table->pages)
        ];

        $this->m_filter = [
            'criteria_nb' => sizeof($filter_criteria),
            'criteria' => $filter_criteria,
            'col_w' => $col_w,
            'col_nb_lt' => ''
        ];
        switch ($this->m_filter['criteria_nb']) {
            case 1:
                $this->m_filter['col_nb_lt'] = 'one';
                break;
            case 2:
                $this->m_filter['col_nb_lt'] = 'two';
                break;
            case 3:
                $this->m_filter['col_nb_lt'] = 'three';
                break;
            case 4:
                $this->m_filter['col_nb_lt'] = 'four';
                break;
            case 5:
                $this->m_filter['col_nb_lt'] = 'five';
                break;
            default:
                break;
        }
    }

}

?>