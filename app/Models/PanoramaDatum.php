<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 11 May 2018 16:34:27 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PanoramaDatum
 * 
 * @property int $data_id
 * @property int $dataset_id_FK
 * @property int $author_id_FK
 * @property string $year
 * @property string $details
 * @property string $src
 *
 * @package App\Models
 */
class PanoramaDatum extends Eloquent
{
	protected $primaryKey = 'data_id';
	public $timestamps = false;

	protected $casts = [
		'dataset_id_FK' => 'int',
		'author_id_FK' => 'int'
	];

	protected $fillable = [
		'dataset_id_FK',
		'author_id_FK',
		'year',
		'details',
		'src'
	];

	public function dataset() {
        return $this->belongsTo('\App\Models\PanoramaDataset', 'dataset_id_FK', 'dataset_id');
	}
	
	public function author() {
        return $this->hasOne('\App\Models\PanoramaAuthor', 'id_author', 'author_id_FK');
	}

}
