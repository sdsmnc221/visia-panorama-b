<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 11 May 2018 16:34:27 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PanoramaAuthor
 * 
 * @property int $action_id
 * @property string $details
 * @property string $url
 * @property int $stats_type_id_FK
 *
 * @package App\Models
 */
class PanoramaAction extends Eloquent
{
	protected $table = 'panorama_action';
	protected $primaryKey = 'action_id';
    public $timestamps = false;
    
    protected $casts = [
		'stats_type_id_FK' => 'int'
	];

	protected $fillable = [
		'action_id',
		'details',
        'url',
        'stats_type_id_FK'
    ];
    
    public function statsType() {
        return $this->belongsTo('\App\Models\PanoramaStatsType', 'stats_type_id_FK', 'stats_type_id');
    }
}
