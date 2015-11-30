<?php

namespace App;

use App\Question;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract

{
    use Authenticatable, Authorizable, CanResetPassword;

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
    protected $fillable = ['email', 'password','confirmation_code', 'active', 'is_admin'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public static function create(array $attributes = Array(), $confirmation=true ){                  
        $attributes["confirmation_code"]= \Uuid::generate()->string;
        
        $user = parent::create( $attributes );
        
        if( $confirmation ){
            self::sendComfirmationMail($user);
        }
                    
        
        return $user;
    }

    public static function sendComfirmationMail($user){

        $json   = json_encode(["email"=>$user->email,"confirmation_code"=>$user->confirmation_code]);            
        $data   = base64_encode($json);
        
        \Mail::send('emails.confirmation', ['data' => $data], function($message) use ($user)
        {
            $message->from('panic@polls.rs', "Polls");
            $message->to($user->email)->subject('Email confirmation');
        });
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}