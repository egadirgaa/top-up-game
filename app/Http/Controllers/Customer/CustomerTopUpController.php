<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\TopUpItem;
use Illuminate\Http\Request;

class CustomerTopUpController extends Controller
{
    public function index() {
        $items = TopUpItem::all();

        return view('topup', compact('items'));
    }
}
