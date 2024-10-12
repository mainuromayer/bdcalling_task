<?php

namespace App\Modules\Item\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Modules\Item\Http\Requests\StoreItemRequest;
use App\Modules\Item\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\RedirectResponse;

class ItemApiController extends Controller
{
    // Read all of their own items
    public function list(Request $request)
    {
        try {
            $items = Item::where('user_id', Auth::id())
                ->orderBy('id')
                ->get();

            return response()->json($items);
        } catch (Exception $e) {
            Log::error("Error in ItemApiController@list ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return response()->json(['error' => 'Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Create a new item
    public function store(StoreItemRequest $request)
    {
        try {
            $item = new Item();
            $item->title = $request->get('title');
            $item->description = $request->get('description');
            $item->user_id = Auth::id();
            $item->status = $request->get('status');
            $item->save();

            return response()->json(['success' => true, 'message' => 'Item created successfully!', 'item' => $item], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error("Error in ItemApiController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return response()->json(['error' => 'Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Update their own items
    public function update(StoreItemRequest $request, $id)
    {
        try {
            $item = Item::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
            $item->title = $request->get('title');
            $item->description = $request->get('description');
            $item->status = $request->get('status');
            $item->save();

            return response()->json(['success' => true, 'message' => 'Item updated successfully!', 'item' => $item]);
        } catch (Exception $e) {
            Log::error("Error in ItemApiController@update ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return response()->json(['error' => 'Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Delete their own items
    public function destroy($id)
    {
        try {
            $item = Item::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
            $item->delete();

            return response()->json(['success' => true, 'message' => 'Item deleted successfully.']);
        } catch (Exception $e) {
            Log::error("Error in ItemApiController@destroy ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return response()->json(['error' => 'Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

