<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductsCollection extends ResourceCollection
{
  /**
   * Transform the resource collection into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    // los parametros que se pasan se obtienen en $this.collection
    //el metodo transform, transforma la estuctura de presentar los datos
    return [
      'data' => $this->collection->transform(function ($element) {
        return [
					"username" => $element->name,
					"products" => $element->products,
          // "description" => $element->description,
          // "humanPrice" => "$" . ($element->price / 100), // se divide porque el precio por defecto viene en centavos
          // "numberPrice" => $element->price,
          // "image" => $element->image_url,

        ];
      })
    ];
  }
}
