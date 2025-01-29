<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfile extends Controller
{
  public function index()
  {
    return view('content.user.User-profile');
  }

  public function userProfile()
  {
    return view('content.user.User-profile');
  }
}
