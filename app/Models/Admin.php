<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin'; // Define guard for admin authentication
    protected $fillable = ['email', 'password']; // Fillable fields
    protected $hidden = ['password', 'remember_token']; // Hidden fields

    // Add any additional methods or relationships as needed
}
?>
