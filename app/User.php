<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    static $users = [];

    public static function getUserArr($userId){

        if(!isset(self::$users[$userId])){
            $user = self::select('name')->find($userId)->toArray();
            if(empty($user)){
                return false;
            }
            self::$users[$userId] = $user['name'];
        }

        return self::$users[$userId];
    }

    public static function getUserNameByUserId($userId){

        $userName = self::getUserArr($userId);

        return !empty($userName)?$userName:'用户不存在';

    }

}
