<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $fillable = ['title', 'description', 'price', 'image_url', 'user_id']; //elementos que se modifican, no poner inf sensible

	// protected $hidden = ['user_id'];

  public function url()
  {
    return $this->id ? 'productos.update' : 'productos.store';
  }

  public function method()
  {
    return $this->id ? 'PUT' : 'POST';
	}

	public function usuario(){
		return $this->belongsTo('App\Usuario');
	}
}
