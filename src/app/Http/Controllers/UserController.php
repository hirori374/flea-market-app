<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ExhibitionRequest;

class UserController extends Controller
{
    public function sell()
    {
        $categories = Category::all();

        return view('users.sell', compact('categories'));
    }
    public function store(ExhibitionRequest $request)
    {
        $categories = Category::all();
        $data = $request->only(['name','brand','price','condition','description','seller_id']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image'] = $path;
        }

        $item = Item::create($data);
        $item->categories()->attach($request->category);

        return redirect('/mypage?page=sell');
    }
    public function mypage(Request $request)
    {
        $user = Auth::user();
        $items = Item::all();
        $page = $request->query('page');
        if ($page === 'buy') {
            $items = Auth::user()->purchases()->with('item')->get()->map(function ($purchase) {
                return $purchase->item;
            });
        } elseif ($page === 'sell'){
            $items = Item::where('seller_id',$user->id)->get();
        }
        return view('users.mypage', compact('user','items','page'));
    }
    public function profile()
    {
        $user = Auth::user();

        return view('users.profile', compact('user'));
    }
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->only(['name','post_code','address','building']);
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $data['icon'] = $path;
        } else {
            $data['icon'] = $user->icon;
        }
        $user->update($data);

        return redirect('/mypage');
    }
}
