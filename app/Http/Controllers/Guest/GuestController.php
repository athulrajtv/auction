<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    public function Index()
    {
        $data = DB::table('categories')->get();
        $item = DB::table('products')->get();
        return view('guest.pages.index', compact('data', 'item'));
    }

    
}
