<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 11 May 2018 16:34:27 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PanoramaStatsType
 * 
 * @property int $stats_type_id
 * @property string $name
 * @property string $category
 * @property string $img
 *
 * @package App\Models
 */
class PanoramaStatsType extends Eloquent
{
	protected $table = 'panorama_stats_type';
	protected $primaryKey = 'stats_type_id';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'category',
		'img'
	];

	public function actions() {
        return $this->hasMany('\App\Models\PanoramaAction', 'stats_type_id_FK', 'stats_type_id');
	}
}
