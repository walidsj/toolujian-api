<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'prodi_id', 'name', 'number'
   ];

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = [];

   // protected $with = [
   //    'prodi'
   // ];

   /**
    * Get the prodi associated with the user.
    */
   // public function prodi()
   // {
   //    return $this->belongsTo(Prodi::class);
   // }
}
