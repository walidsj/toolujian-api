<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'name', 'code'
   ];

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = [];

   // protected $with = [
   //    'jurusan'
   // ];

   // /**
   //  * Get the jurusan associated with the user.
   //  */
   // public function jurusan()
   // {
   //    return $this->belongsTo(Jurusan::class);
   // }
}
