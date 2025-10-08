<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Purchase;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Checkout\Session;

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

        return redirect('/item/'.$id);
    }
    public function purchase($id)
    {
        $item = Item::find($id);
        $user = Auth::user();
        

        return view('items.purchase', compact('item', 'user'));
    }
    public function address($id)
    {
        $item = Item::find($id);
        $user = Auth::user();

        return view('items.address', compact('item', 'user'));
    }
    public function payMethod(Request $request,$id)
    {
        $payMethod = $request->input('pay_method');
        session()->put('pay_method', $payMethod);

        return redirect('/purchase/'.$id);
    }
    public function updateAddress(AddressRequest $request, $id)
    {
        $item = Item::find($id);
        $user = Auth::user();
        session()->put('delivery_post_code',$request->input('delivery_post_code'));
        session()->put('delivery_address',$request->input('delivery_address'));
        session()->put('delivery_building',$request->input('delivery_building'));

        return redirect('/purchase/'. $id);
    }
    public function checkout(PurchaseRequest $request,$id)
    {
        $item = Item::find($id);
        $item_id = $id;
        $user_id = Auth::id();
        $data = $request->only(['delivery_post_code','delivery_address','delivery_building','pay_method']);

        $data['item_id'] = $item_id;
        $data['user_id'] = $user_id;

        $purchase = Purchase::create($data);

        session()->forget(['keyword']);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $user = Auth::user();
        $item = Item::find($id);

        if ($purchase->pay_method === 'カード払い'){
            $payMethod = 'card';
        }else{
            $payMethod = 'konbini';
        }

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => [$payMethod],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['purchase' => $purchase->id]),
            'cancel_url' => route('payment.cancel', ['purchase' => $purchase->id]),
            'customer_email' => $user->email,
        ]);

        return redirect($session->url);
    }
    public function success(Purchase $purchase)
    {
        $purchase->update(['pay_status' => 'paid']);

        return redirect('/item/'.$purchase->item_id);
    }
    public function cancel(Purchase $purchase)
    {
        $purchase->delete();

        return redirect('/item/'.$purchase->item_id);
    }
}
