<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store()
    {
    	if (request()->item_id) {
    		Cart::create(request()->all());
    	}

    	return redirect()->back();
    }

    public function update(Cart $cart)
    {
    	$cart->update(request()->all());

    	return redirect()->back();
    }

    public function destroy(Cart $cart)
    {
    	$cart->delete();

    	return redirect()->back();
    }
}
