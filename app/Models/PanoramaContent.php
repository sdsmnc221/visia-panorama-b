<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PanoramaDataset
 * 
 * @property int $content_id
 * @property string $name
 * @property string $description
 * @property string $query
 *
 * @package App\Models
 */
class PanoramaContent extends Model
{
    protected $table = 'panorama_content';
	protected $primaryKey = 'content_id';
	public $timestamps = false;

	protected $fillable = [
		'name',
        'description',
        'query'
	];
}
