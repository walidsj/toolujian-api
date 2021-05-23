<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'id',
      'semester_id',
      'name',
      'npm',
      'gender',
      'enter_year',
      'graduate_year',
      'class',
      'number',
   ];

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = [];

   /**
    * Get the semester associated with the user.
    */

   public function semester()
   {
      return $this->belongsTo(Semester::class);
   }

   // use \Znck\Eloquent\Traits\BelongsToThrough;

   // public function prodi()
   // {
   //    return $this->belongsToThrough(Prodi::class, Semester::class);
   // }

   // public function jurusan()
   // {
   //    return $this->belongsToThrough(Jurusan::class, [Prodi::class, Semester::class]);
   // }
}
