<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ActStatus extends Model
{
    const CANCELED = 12;
    //
    protected $table = 'act_status';
    protected $fillable = ['account_id','status_id', 'status_date', 'act_freq', 'act_other'];

    public function account()
    {
        return $this->belongsToOne('App\Account');
    }

    public function status()
	{
		return $this->belongsTo('App\Status');
	}

    //Accessors
    public function getStatusDateAttribute($value)
    {
        if ($value != '1970-01-01' && $value != '0000-00-00' && strtotime($value) > strtotime('2000/01/01')) {

            return date('m/d/Y', strtotime($value));
        } else {
            return '';

        }
    }
    public function getActFreqAttribute($value)
    {
        $bm = config('lookup_act_status.fq-bm');
        $qt = config('lookup_act_status.fq-qt');
        if ($value < 13 && $value != 0) {

            return ['freq_id' => $value, 'freq_msg'=> $qt[strval($value)] ];
        } elseif($value > 12) {
            return  [ 'freq_id' => $value, 'freq_msg'=> $bm[strval($value)] ];
        }
    }






    //Mutators Not ready to change all dates yet
//    public function setStatusDateAttribute($value)
//    {
//        $this->attributes['status_date'] =date('Y-m-d', strtotime($value));
//    }

}
