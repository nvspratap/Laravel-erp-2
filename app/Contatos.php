<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Telefones;
use App\Atendimento;

class Contatos extends Model
{
    protected $table = 'contatos';

    public function telefones()
    {
        return $this->hasMany('App\Telefones');
    }
    
    public function atendimento()
    {
      return $this->hasMany('App\Atendimento');
    }

    public function from()
    {
      return $this->belongsToMany('App\Contatos', 'contatos_pivot', 'from_id', 'to_id')->withPivot('from_text', 'to_text', 'id');
    }

    public function to()
    {
      return $this->belongsToMany('App\Contatos', 'contatos_pivot', 'to_id', 'from_id')->withPivot('to_text', 'from_text', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

}
