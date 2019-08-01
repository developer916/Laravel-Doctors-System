<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Invantory extends Model {

    //
    protected $table = 'invantories';
	protected $fillable = ['id','office_id', 'mat_id', 'begin_amount', 'end_amount', 'purchased_amount', 'cost','trans','month'];

     public function materialInv(){
        return $this->belongsTo('App\Material');
    }

	public function invMaterial()
    {
        return $this->hasOne('App\Material', 'id', 'mat_id');
         
    }

	public function invOffice()
    {
        return $this->hasOne('App\Office', 'id', 'office_id');
    }

	/**
	 * @param $officeId
	 * @return mixed
	 */
    public static function getByOfficeGroupByMonth( $officeId )
	{
		return self::where('office_id', $officeId)
			->groupBy('month')
			->orderBy('month', 'DESC')
			->get(['id', 'month']);
	}

	/**
	 * @param $officeId
	 * @param $date
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public static function getByOfficeAndMonth( $officeId, $date )
	{
		return self::with(['invMaterial', 'invOffice'])
			->where('office_id', $officeId)
			->where('month', 'like', $date.'%')
			->get();
	}
}