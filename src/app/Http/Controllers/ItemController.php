<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check() && ! Auth::user()->hasVerifiedEmail()) {
            return redirect('/email/verify');
        }
        
        session()->forget(['delivery_post_code','delivery_address','delivery_building','pay_method']);

        $tab = $request->query('tab');
        $keyword = $request->input('keyword', session('keyword'));
        session(['keyword' => $keyword]);

        $query = Item::query();
        
        if (Auth::check()) {
            $query->where('seller_id', '!=', Auth::id())->orWhereNull('seller_id');;
        }

        if ($tab === 'mylist') {
            $query = Item::whereHas('favoritesUsers', function ($query) {
                $query->where('user_id', Auth::id());
            });
        }

        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        $items = $query->get();

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    public function detail($id)
    {
        $categories = Category::all();
        $item = Item::find($id);
        $comments = Comment::with(['user', 'item'])->where('item_id', $id)->get();
        $favoritesCount = $item->favoritesUsers()->count();
        $commentsCount = $comments->count();
        $favoritesItem = $item->favoritesUsers()->where('user_id', Auth::id())->first();

        return view('items.detail', compact('item','categories','comments', 'favoritesCount', 'commentsCount','favoritesItem'));
    }
    public function favorite($id)
    {
        $item = Item::find($id);
        $item_id = $id;
        $user_id = Auth::id();
        $item->favoritesUsers()->attach($user_id);

        return redirect('/item/'.$id);
    }
    public function favoriteDestroy($id)
    {
        $item = Item::find($id);
        $item_id = $id;
        $user_id = Auth::id();
        $item->favoritesUsers()->detach($user_id);

        return redirect('/item/'.$id);
    }
    public function comment(CommentRequest $request, $id)
    {
        $item = Item::find($id);
        $item_id = $id;
        $user_id = Auth::id();
        Comment::create([
            'item_id' => $item_id,
            'user_id' => $user_id,
            'content' => $request->input('content')
        ]);

        return redirect(route('items.detail', ['itemId' => $id]));
    }
}
