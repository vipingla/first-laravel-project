<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Userdata;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Http\Traits\PostTrait;
use App\Repositories\PostRepositoryInterface;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    use PostTrait;    
}
