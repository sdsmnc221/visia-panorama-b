<?php

namespace App\Providers;

use Illuminate\Support\Str;
use \Terbilang;
use App\Providers\CustomBladeCompiler;
use App\Models\PanoramaAuthor;
 
class HelpersProvider{

    public function __construct() {
    }

    public function format_CSV(string $csv) {
        //parse CSV string to array
        $data = [];
        $lines = explode(PHP_EOL, $csv);
        foreach ($lines as $line) {
            $data[] = str_getcsv($line);
        }

        //get keys
        $keys = $data[0];
        unset($data[0]); //remove keys line
        $data = array_values($data); //reindex array (array starts at 0)

        //reformat CSV array by keys
        $data = array_map(function($line) use ($keys) {
                    return array_combine($keys, $line);
                }, $data);
        
        return $data;
    }

    public function update_CSV_data(array $data) {
        if (sizeof($data) > 0) {
            $_data = [];
            $p = ['id_author', 'id_isni', 'id_bnf', 'id_wikidata', 'pseudonym'];

            foreach ($data as $d) {
                $d['status'] = [
                    'is_updated' => false,
                    'updated_w' => '',
                    'pikachu' => '',
                    'before' => ''
                ];

                if ($d[$p[0]] !== '') {
                    $author = PanoramaAuthor::find($d[$p[0]]);
                    //If author not found, break
                    if (!is_null($author)) {
                        $d = $this->update_CSV_data_helper($d, $author, $p[0]);
                        array_push($_data, collect($d));
                        continue;
                    }
                }

                if ($d[$p[1]] !== '') {
                    continue;
                }

                if ($d[$p[2]] !== '') {
                    $author = PanoramaAuthor::where($p[2], $d[$p[2]])->first();
                    if (!is_null($author)) {
                        $d = $this->update_CSV_data_helper($d, $author, $p[2]);
                        array_push($_data, collect($d));
                        continue;
                    }
                }

                if ($d[$p[3]] !== '') {
                    $author = PanoramaAuthor::where($p[3], $d[$p[3]])->first();
                    if (!is_null($author)) {
                        $d = $this->update_CSV_data_helper($d, $author, $p[3]);
                        array_push($_data, collect($d));
                        continue;
                    }
                }

                if ($d[$p[4]] !== '') {
                    $author = PanoramaAuthor::where($p[4], $d[$p[4]])->first();
                    if (!is_null($author)) {
                        $d = $this->update_CSV_data_helper($d, $author, $p[4]);
                        array_push($_data, collect($d));
                        continue;
                    }
                }

                if (!$d['status']['is_updated'] && $d['pseudonym'] !== '') {
                        $author = BNFServiceProvider::search_author(['pseudonym' => $d['pseudonym']]);
                        if (!is_null($author)) {
                            $d = $this->update_CSV_data_helper($d, $author, 'api');
                            array_push($_data, collect($d));
                            continue;
                        }
                }

                //Not passing any condition
                array_push($_data, collect($d));
            }
        }
        return collect($_data);
    }

    public function update_CSV_data_helper($d, $author, $case) {
            $a_keys = $this->model_get_keys(PanoramaAuthor::first(), $include_PK = true);
            $author = $author->toArray();
            if ($author['pseudonym'] === $d['pseudonym']) {
                $d['status']['is_updated'] = true;
                $d['status']['updated_w'] = $case;
                $d['status']['before'] = $d;
                foreach ($a_keys as $k) {
                    // $d['id_author'] = $author['id_author'];
                    // $d[$k] = array_key_exists($k, $author) ? $author[$k] : isset($d[$k]) ? '$d[$k]' : '';
                    if (array_key_exists($k, $author)) $d[$k] = $author[$k];
                    else $d[$k] = 't';
                }
            } else {
                //do something if wrong author...
            }
        return $d;
    }

    public function array_except($array, $keys) {
        return array_diff_key($array, array_flip((array) $keys));   
    } 

    public function number_to_word($number, $lang = "fr") {
        return Terbilang::make($number);
    }

    public function string_trim_till($string, $character, $include = true) {
        return substr($string, 0, strrpos($string, $character) + ($include ? 1 : 0));
    }

    public function collection_get_PK($collection) {
        return $collection->pluck($collection->first()->getKeyName())->toArray();
    }

    public function collection_get_model_name($collection, $is_singular = false) {
        return !$is_singular
            ? Str::studly(Str::singular($collection->first()->getTable()))
            : Str::studly(Str::singular($collection->getTable()));;
    }

    public function collection_get_values_from_key($collection, $key) {
        return $collection->pluck($key)->unique()->toArray();
    }

    public function model_create($model_name) {
        switch ($model_name) {
            case 'PanoramaAuthor':
                $model = new PanoramaAuthor;
                break;
            case 'PanoramaDataset':
                $model = new PanoramaDataset;
                break;
            case 'PanoramaDatum':
                $model = new PanoramaDatum;
                break;
            case 'PanoramaStatsType':
                $model = new PanoramaStatsType;
                break;
            default:
                break;
        }
        return $model;
    }

    public function model_store($model_name, $data) {
        return sprintf('\App\Models\%s', $model_name)::create($data);
    }

    public function model_store_many($model_name, $data) {
        $elements = [];
        foreach ($data as $datum) {
            array_push($elements, $this->model_store($model_name, $datum));
        }
        return $elements;
    }

    public function model_update($model_name, $data) {
        $PK = sprintf('\App\Models\%s', $model_name)::first()->getKeyName();
        return sprintf('\App\Models\%s', $model_name)::where($PK, $data[$PK])->update($this->array_except($data, [$PK]));
    }

    public function model_update_many($model_name, $data) {
        $elements = [];
        foreach ($data as $datum) {
            array_push($elements, $this->model_update($model_name, $datum));
        }
        return $elements;
    }

    public function model_get_keys($instance, $include_PK = true) {
        $keys = array_keys($instance->getAttributes());
        $keys = $include_PK ? $keys : array_filter($keys, function($el) use ($instance) {
            return $el !== $instance->getKeyName();
        }); 
        return array_values($keys);
    }

    public function collection_make_filter_criteria($criteria) {
        $filter_criteria = [];
        foreach ($criteria as $criterion) {
            if (array_key_exists('values', $criterion)) {
                $filter_criteria[$criterion['db_name']] = array_flatten($criterion['values']);
            }
        }
        return $filter_criteria;
    }

    public function collection_filter($collection_name, $filter_criteria) {
        $collection = sprintf('\App\Models\%s', $collection_name)::all();
        return $collection->filter(function($el) use ($filter_criteria) {
            $satisfied = true;
            foreach ($filter_criteria as $criterion=>$values) {
                foreach ($values as $value) {
                    $satisfied = $el->$criterion == $value ? true : false;
                    if ($satisfied) break;
                }
                if ($satisfied) break;
            }
            return $satisfied;
        });
    }

    public function blade_render($template, $data) {
        return CustomBladeCompiler::render($template, $data);
    }

}

?>