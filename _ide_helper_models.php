<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Genre
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Record[] $records
 * @property-read int|null $records_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Genre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Genre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Genre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Genre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Genre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Genre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Genre whereUpdatedAt($value)
 */
	class Genre extends \Eloquent {}
}

namespace App{
/**
 * App\Order
 *
 * @property int $id
 * @property int $user_id
 * @property float $totalPrice
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderline[] $orderlines
 * @property-read int|null $orderlines_count
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 */
	class Order extends \Eloquent {}
}

namespace App{
/**
 * App\Orderline
 *
 * @property int $id
 * @property int $order_id
 * @property string $artist
 * @property string $title
 * @property string|null $cover
 * @property float $totalPrice
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline whereArtist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderline whereUpdatedAt($value)
 */
	class Orderline extends \Eloquent {}
}

namespace App{
/**
 * App\Record
 *
 * @property int $id
 * @property int $genre_id
 * @property string $artist
 * @property string|null $artist_mbid
 * @property string $title
 * @property string|null $title_mbid
 * @property string|null $cover
 * @property float $price
 * @property int $stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Genre $genre
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereArtist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereArtistMbid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereGenreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereTitleMbid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereUpdatedAt($value)
 */
	class Record extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $active
 * @property int $admin
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

