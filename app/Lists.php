<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model {

	protected $table= 'lists';
    protected $fillable = ['name','board_id'];


    public function board()
    {
    	return $this->belongsTo(Board::class);
    }

}