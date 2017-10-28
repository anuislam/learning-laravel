<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;
use \Auth;
use \DB;
use App\UserModel;
use Hash;

class ChangePassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){
        $cur_user = Auth::user();
        $id = $cur_user->id;
        $user       = new UserModel();
        $user_data  = $user->get_user($id);
        if (Hash::check($value, $cur_user->password, [])) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Current Password Not Match.';
    }
}
