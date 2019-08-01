<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Salesman extends Model {

	//
    protected $table = 'salesmen';
    protected $fillable = ['id','abvr','name'];
}