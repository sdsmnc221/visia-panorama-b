<?php

namespace App\Providers\ComponentProviders;

use App\Providers\HelpersProvider;
use App\Models\PanoramaStatsType;
 
class Form{
    protected $helpers;
    public $what;
    public $what_model;
    public $type;
    public $fields_nb;
    public $fields_data;
    public $fields_values;

    public function __construct($DATA) {
        $this->helpers = new HelpersProvider();
        $this->what = $this->helpers->string_trim_till(request()->path(), '/', false);
        $this->what_model = $DATA['model'];
        $this->type = $DATA['active_tab'];
        $this->fields_nb = $this->helpers->number_to_word(sizeof($DATA['data']));
        $this->fields_data = $DATA['data'];
        $this->fields_values = array_key_exists('values', $DATA) ? $DATA['values'] : null;
        // dd($this);
    }

    public function render_field($field) {
        if ($this->type === 'create') return $this->helpers->blade_render($this->prepare_template($field['field']), $field);
        if ($this->type === 'update') return $this->helpers->blade_render($this->prepare_template($field['field'], $field['is_PK'], $field['value']), $field);
    }

    public function prepare_template($field, $is_PK = false, $value = null) {
        $html = '';

        switch($this->type) {

            case 'create':
                if (str_contains($this->what, 'categories')) {
                    if ($field === 'category') {
                            $values = $this->helpers->collection_get_values_from_key(PanoramaStatsType::all(), 'category');
                            foreach ($values as $v) {
                                $html .= sprintf('<div class="item" data-value="%s">%s</div>', $v, $v);
                            }
                            $html = sprintf('<div class="field">
                                                <label>{{$field}}</label>
                                                <div class="ui selection dropdown">
                                                    <input type="hidden" name="{{$field}}" required>
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text">{{$field}}</div>
                                                    <div class="menu">
                                                        %s
                                                    </div>
                                                </div>
                                            </div>', $html);
                            
                        } else {
                            $html = '<div class="field">
                                                <label>{{$field}}</label>
                                                <input type="text" name="{{$field}}" required min="1">
                                            </div>';
                        }
                    }
                break;

            case 'update':
                if (str_contains($this->what, 'categories')) {
                    if ($field === 'category') {
                        $values = $this->helpers->collection_get_values_from_key(PanoramaStatsType::all(), 'category');
                        foreach ($values as $v) {
                            $html .= sprintf('<div class="item" data-value="%s">%s</div>', $v, $v);
                        }
                        $html = sprintf('<div class="field">
                                            <label>{{$field}}</label>
                                            <div class="ui selection dropdown">
                                                <input type="hidden" name="{{$field}}" value="%s" required>
                                                <i class="dropdown icon"></i>
                                                <div class="default text">{{$field}}</div>
                                                <div class="menu">
                                                    %s
                                                </div>
                                            </div>
                                        </div>', $value, $html);
                        
                    } else {
                        $html = $is_PK 
                                ? 
                                sprintf('<div class="disabled two wide field"> 
                                            <label>{{$field}}</label>
                                            <input type="text" value="%s" name="{{$field}}" min="1" disabled="" tabindex="-1" required>
                                        </div>', $value) 
                                :  
                                sprintf('<div class="field"> 
                                            <label>{{$field}}</label>
                                            <input type="text" value="%s" name="{{$field}}" required min="1">
                                        </div>', $value);
                    }
                }
                break;

            default:
                break;
        }
        
        return $html;
    }

}

?>