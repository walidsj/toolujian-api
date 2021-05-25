<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'mahasiswa_id', 'description'
   ];

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = [];

   /**
    * Get the prodi associated with the user.
    */
   public function mahasiswa()
   {
      return $this->belongsTo(Mahasiswa::class);
   }
}
