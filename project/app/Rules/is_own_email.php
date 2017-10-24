<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;
use \Auth;
use \DB;
use App\UserModel;

class is_own_email implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $own_id;
    public function __construct($id = null)
    {
        $this->own_id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){
        $usermodel = new UserModel();
        if (empty($value) === false) {                
               if (is_numeric($this->own_id)) {
                   $userdata = $usermodel->get_user($this->own_id);
                   if ($userdata) {
                       if ($userdata->email == $value) {
                           return true;
                       }else if (filter_var( $value, FILTER_VALIDATE_EMAIL )) {
                          if ($this->email_exists( $value )) {
                            return false;
                          }
                       }                       
                   }
               }
           }   
           return false;
    }


    public function email_exists($email) {
        $email_data = DB::table('users')->select('id')->where('email', $email)->get()->count();
        return ($email_data > 0) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This email already exists.';
    }
}
