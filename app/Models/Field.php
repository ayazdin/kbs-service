<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
  /**
   * Get the product that owns the fields.
   */
  public function products()
  {
      return $this->belongsTo('App\Models\Product', 'prodid');
  }

  /**
   * Get the fields for the product.
   */
  public function field_values()
  {
      return $this->hasMany('App\Models\Field_value', 'fid');
  }

  /**
   * Delete all the field values automatically.
   */
  public static function boot() {
        parent::boot();
        static::deleting(function($field) {
             $field->field_values()->delete();
        });
    }
}
