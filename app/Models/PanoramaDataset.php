<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 11 May 2018 16:34:27 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PanoramaDataset
 * 
 * @property int $dataset_id
 * @property string $name
 * @property int $stats_type_id_FK
 * @property string $description
 * @property string $comment
 * @property \Carbon\Carbon $date_begin
 * @property \Carbon\Carbon $date_end
 * @property bool $is_highlighted
 *
 * @package App\Models
 */
class PanoramaDataset extends Eloquent
{
	protected $table = 'panorama_dataset';
	protected $primaryKey = 'dataset_id';
	public $timestamps = false;

	protected $casts = [
		'stats_type_id_FK' => 'int',
		'is_highlighted' => 'bool'
	];

	protected $dates = [
		'date_begin',
		'date_end'
	];

	protected $fillable = [
		'name',
		'stats_type_id_FK',
		'description',
		'comment',
		'date_begin',
		'date_end',
		'is_highlighted'
	];

	public function data() {
        return $this->hasMany('\App\Models\PanoramaDatum', 'dataset_id_FK', 'dataset_id');
	}
	
	public function category() {
        return $this->belongsTo('\App\Models\PanoramaStatsType', 'stats_type_id_FK', 'stats_type_id');
    }
}
