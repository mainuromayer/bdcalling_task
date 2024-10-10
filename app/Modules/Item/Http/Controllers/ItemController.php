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

class ItemController extends Controller
{

    public function list( Request $request ) {
        try {
            if ( $request->ajax() && $request->isMethod( 'post' ) ) {
                $list = Item::with('user')->select( 'id', 'title', 'description', 'status', 'user_id', 'updated_at', 'updated_by' )
                    ->orderBy( 'id' )
                    ->get();
                return Datatables::of( $list )
                    ->editColumn( 'id', function ( $list ) {
                        return $list->id;
                    } )
                    ->editColumn( 'title', function ( $list ) {
                        return $list->title;
                    } )
                    ->editColumn( 'description', function ( $list ) {
                        return $list->description;
                    } )
                    ->editColumn( 'status', function ( $list ) {
                        return $list->status;
                    } )
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->updated_by->user_id ?? '';
                    })
                    ->addColumn( 'action', function ( $list ) {
                        return '<a href="' . URL::to('item/edit/' . $list->id) . '" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></a> ';
                    } )
                    ->rawColumns( array( 'status', 'action' ) )
                    ->make( true );
            }
            return view( "Item::list" );
        } catch ( Exception $e ) {
            Log::error( "Error occurred in ItemController@list ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data load [Item-101]" );
            return response()->json( array( 'error' => $e->getMessage() ), Response::HTTP_INTERNAL_SERVER_ERROR );
        }

    }

    public function create(): View | RedirectResponse {
        $data['status_list'] = ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'];
        return view( 'Item::create', $data );
    }

    public function store( StoreItemRequest $request ) {

        try {
            if ( $request->get( 'id' ) ) {
                $item = Item::findOrFail( $request->get( 'id' ) );
            } else {
                $item = new Item();
            }
            $item->title = $request->get('title');
            $item->description = $request->get('description');
            $item->user_id = Auth::id();
            $item->status = $request->get('status');
            $item->save();
            Session::flash( 'success', 'Data save successfully!' );
            return redirect()->route( 'item.list' );
        } catch (Exception $e) {
            Log::error( "Error occurred in ItemController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data store [Item-103]" );
            return Redirect::back()->withInput();
        }
    }

    public function edit( $id ): View | RedirectResponse {
        try {
            $data['data'] = Item::findOrFail( $id );
            $data['status_list'] = ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'];
            return view( 'Employee::edit', $data );
        } catch ( Exception $e ) {
            Log::error( "Error occurred in ItemController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data edit [Item-104]" );
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->delete();

            return response()->json(['success' => true, 'message' => 'Item deleted successfully.']);
        } catch (Exception $e) {
            Log::error("Error in ItemController@destroy ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return response()->json(['success' => false, 'message' => 'Something went wrong.']);
        }
    }

}
