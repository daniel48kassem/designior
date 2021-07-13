<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageCollection;
use App\Models\User;
use Illuminate\Http\Request;

class DesignerImageController extends Controller
{
    public function index(User $user)
    {
        return new ImageCollection($user->images);
    }
}
