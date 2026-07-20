<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $page = $request->page ?? 'sell';
        if ($page === 'buy') {
            $items = $user->purchases->pluck('item');
        } else {
            $items = $user->items()->with('purchases')->get();
        }
        return view('mypage.index', compact('user', 'page', 'items'));
    }
    public function edit()
    {
        $user = auth()->user();
        return view('mypage.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        $data = $request->only(['name', 'postal_code', 'address', 'building']);
        if ($request->hasFile('img_url')) {
            $data['img_url'] = $request->file('img_url')->store('profiles', 'public');
        }
        $user->update($data);
        return redirect('/');
    }
}
