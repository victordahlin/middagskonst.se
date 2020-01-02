<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $fillable = ['title', 'dinners', 'persons', 'longText', 'summaryText', 'addonsText', 'text', 'img', 'price', 'discount', 'type', 'reference'];
    public $timestamps = false;

    /**
     * Get all standard bags
     * @return mixed
     */
    public static function getDinners()
    {
        return Products::orderBy('title')->having('type', '=', 'bags')->get();
    }

    /**
     * Get all alternative bags
     * @return mixed
     */
    public static function getAlternativeBags()
    {
        return Products::where('type', '=', 'alternativeBags')->get();
    }

    /**
     * Get all extra products
     * @return mixed
     */
    public static function getExtra()
    {
        return Products::where('type', '=', 'extra')->get();
    }

    /**
     * Get specific product
     * @param $id
     * @return mixed
     */
    public static function getProduct($id)
    {
        return Products::where('id', '=', $id)->first();
    }

    /**
     * Merge all extra products to single string
     * @param $u
     * @param $extraProudctsInput
     * @return string
     */
    public static function addExtra($u, $extraProductsInput)
    {
        $extraProductsDB = \App\Products::getExtra();
        $user = \App\User::find($u->id);
        $size = sizeof($extraProductsDB);
        $totalExtraProduct = $extraProductsInput;

        // Merge extra products if any
        if (!empty($user->extraProductCurrent)) {
            $currentExtraDB = explode(', ', $user->extraProductCurrent);
            for ($i = 0; $i < $size; $i++) {
                $totalExtraProduct[$i] += $currentExtraDB[$i];
            }
        }
        return implode(', ', $totalExtraProduct);
    }
}
