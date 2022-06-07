<?php


namespace App\Helpers\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Class Cart
 * @package App\Helpers\Cart
 *  @method static Cart put(array $value, Model $obj=null)
 *   @method static array has(array $value, Model $obj)
 *   @method static array get($key)
 *  @method static Collection all()
 */

class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}
