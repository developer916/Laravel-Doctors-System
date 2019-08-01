<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model {

	//
    protected $table = 'act_notes';
    protected $fillable = ['notes', 'otherType', 'notes_phone', 'notes_contact', 'notes_email', 'combine'];

    //Accessors
    public function getNotesPhoneAttribute($value)
    {
        if(strlen($value) > 10){
            $rtn = "" . substr($value, 0, 3) . "-" . substr($value, 3, 3) . " - " . substr($value, 6, 4). " Ext " . substr($value, 10);
             $rtn = $value;
        }else if(strlen($value) == 10){
            $rtn = "" . substr($value, 0, 3) . "-" . substr($value, 3, 3) . "-" . substr($value, 6);
        }else{
            $rtn = "";
        }
        return $rtn;
    }

    //Mutators
    public function setNotesPhoneAttribute($value)
    {
        $this->attributes['notes_phone'] = preg_replace("/[^0-9]/", "", $value);
    }
}
