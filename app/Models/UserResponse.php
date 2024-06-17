<?php

namespace App\Models;

/**
 * Reponse model with user data.
 */
class UserResponse {
    /**
     * User's name
     * @var string
     */
    public $name;

    /**
     * User's email address
     */
    public $email;

       /**
     * User's id 
     */
    public $id;
    /**
     * @param User $user
     */
    public function __construct($user)
    {   
        $this->id=$user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->profile_picture = $user->profile_picture;
        
    }
}
