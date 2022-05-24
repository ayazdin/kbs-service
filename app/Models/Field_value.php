<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field_value extends Model
{
  public $timestamps = false;

  /**
   * Get the product that owns the fields.
   */
  public function fields()
  {
      return $this->belongsTo('App\Models\Field', 'id');
  }
}
