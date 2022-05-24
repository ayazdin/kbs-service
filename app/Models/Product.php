<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

  /**
   * Get the fields for the product.
   */
  public function fields()
  {
      return $this->hasMany('App\Models\Field', 'prodid');
  }


}
