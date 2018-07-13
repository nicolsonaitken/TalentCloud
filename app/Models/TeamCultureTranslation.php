<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 12 Jul 2018 22:39:28 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TeamCultureTranslation
 * 
 * @property int $id
 * @property int $team_culture_id
 * @property string $locale
 * @property string $narrative_text
 * @property string $operating_context
 * @property string $what_we_value
 * @property string $how_we_work
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\TeamCulture $team_culture
 */
class TeamCultureTranslation extends Eloquent
{
	protected $casts = [
		'team_culture_id' => 'int'
	];

	protected $fillable = [
		'narrative_text',
		'operating_context',
		'what_we_value',
		'how_we_work'
	];

	public function team_culture()
	{
		return $this->belongsTo(\App\Models\TeamCulture::class);
	}
}
