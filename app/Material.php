<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model {

    protected $table = 'materials';
	protected $fillable = ['id', 'code', 'name', 'primary', 'secondary', 'units', 'other', 'cost'];

    public function inventory()
    {
        return $this->hasMany('App\Invantory', 'mat_id', 'id');
    }

    public static function searchByKeyword( $keyword )
	{
		return self::where('code', 'like', '%' . $keyword . '%')
			->orWhere('name', 'like', '%' . $keyword . '%')
			->select('id', 'code', 'name', 'units')
			->get();
	}
}