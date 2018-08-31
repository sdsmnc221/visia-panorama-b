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
 * @property int $id_author
 * @property int $id_bnf
 * @property string $id_wikidata
 * @property string $gender
 * @property string $pseudonym
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property string $date_of_death
 * @property string $img
 * @property string $img_src
 *
 * @package App\Models
 */
class PanoramaAuthor extends Eloquent
{
	protected $table = 'panorama_author';
	protected $primaryKey = 'id_author';
	public $timestamps = false;

	protected $casts = [
		'id_bnf' => 'int'
	];

	protected $fillable = [
		'id_bnf',
		'id_wikidata',
		'gender',
		'pseudonym',
		'first_name',
		'last_name',
		'date_of_birth',
		'date_of_death',
		'img',
		'img_src'
	];
}
