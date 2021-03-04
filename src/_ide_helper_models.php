<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\BadDomain
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|BadDomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BadDomain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BadDomain query()
 * @method static \Illuminate\Database\Eloquent\Builder|BadDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BadDomain whereName($value)
 */
	class BadDomain extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Click
 *
 * @property int $id
 * @property string $ua
 * @property string $ip
 * @property string $ref
 * @property string $param1
 * @property string $param2
 * @property int $error
 * @property int $bad_domain
 * @method static \Illuminate\Database\Eloquent\Builder|Click newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Click newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Click query()
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereBadDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereParam1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereParam2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereUa($value)
 */
	class Click extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

