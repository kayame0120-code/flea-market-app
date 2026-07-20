<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $tab     = $request->tab;

        if ($tab === 'mylist' && !auth()->check()) {
            $items = collect();
        } else {
            $items = Item::when(auth()->check(), function ($q) {
                $q->where('user_id', '!=', auth()->id());
            })
                ->when($keyword, function ($q, $keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                })
                ->when($tab === 'mylist' && auth()->check(), function ($q) {
                    $q->whereHas('likes', function ($q) {
                        $q->where('user_id', auth()->id());
                    });
                })
                ->with('purchases')
                ->get();
        }

        return view('item.index', compact('keyword', 'tab', 'items'));
    }
    public function show($item_id)
    {
        $item = Item::with(['categories', 'comments.user', 'likes'])
            ->findOrFail($item_id);

        return view('item.show', compact('item'));
    }
    public function like($item_id)
    {
        $item = Item::findOrFail($item_id);
        $item->likes()->create(['user_id' => auth()->id()]);
        return redirect('/item/' . $item_id);
    }

    public function unlike($item_id)
    {
        $item = Item::findOrFail($item_id);
        $item->likes()->where('user_id', auth()->id())->delete();
        return redirect('/item/' . $item_id);
    }
    public function comment(CommentRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        $item->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect('/item/' . $item_id);
    }
    public function create()
    {
        $categories = Category::all();
        $conditions = Item::CONDITIONS;

        return view('item.create', compact('categories', 'conditions'));
    }
    public function store(ExhibitionRequest $request)
    {
        $img_url = $request->file('img_url')->store('items', 'public');

        $item = Item::create([
            'user_id'     => auth()->id(),
            'name'        => $request->name,
            'brand'       => $request->brand,
            'description' => $request->description,
            'price'       => $request->price,
            'condition'   => $request->condition,
            'img_url'     => $img_url,
        ]);

        $item->categories()->sync($request->category_id);

        return redirect('/');
    }
}
