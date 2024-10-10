<?php

namespace App\Modules\User\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Modules\User\Http\Requests\StoreUserRequest;
use App\Modules\User\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use yajra\Datatables\Datatables;

class UserController {

    public function list( Request $request ) {

        try {
            if ( $request->ajax() && $request->isMethod( 'post' ) ) {
                $list = User::select( 'id', 'name', 'email', 'updated_at', 'updated_by' )
                    ->with('updated_by')
                    ->orderBy( 'id' )
                    ->get();

                return Datatables::of( $list )
                    ->editColumn( 'name', function ( $list ) {
                        return $list->name ?? '';
                    } )
                    ->editColumn( 'email', function ( $list ) {
                        return $list->email;
                    })
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->updated_by->id ?? '';
                    })
                    ->addColumn('action', function ($list) {

                            return '<a href="' . URL::to('user/edit/' . $list->id) .
                                '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a> ';

                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }
            return view( "User::list" );
        } catch ( Exception $e ) {
            Log::error( "Error occurred in UserController@list ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data load [User-101]" );
            return response()->json( array( 'error' => $e->getMessage() ), Response::HTTP_INTERNAL_SERVER_ERROR );
        }

    }

    public function create(): View | RedirectResponse {

        try {
            $data['roles'] = ['user' => 'User', 'admin' => 'Admin'];
            return view( 'User::create', $data );

        } catch ( Exception $e ) {
            Log::error( "Error occurred in User@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data create [User-102]" );
            return redirect()->back();
        }
    }

    public function store(StoreUserRequest $request) {
        try {
            if ($request->get( 'id' ) ) {
                $user = User::findOrFail( $request->get( 'id' ) );
            } else {
                $user = new User();
            }
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->role = $request->get('role');
            $user->save();

            Session::flash('success', 'Data saved successfully!');
            return redirect()->route('user.list');
        } catch (Exception $e) {
            Log::error("Error occurred in UserController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [UC-103]");
            return Redirect::back()->withInput();
        }
    }


    public function edit($id): View | RedirectResponse {
        try {
            $data['data'] = User::findOrFail( $id );
            $data['roles'] = ['user' => 'User', 'admin' => 'Admin'];

            return view( 'User::edit', $data );
        } catch ( Exception $e ) {
            Log::error( "Error occurred in User@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data edit [User-103]" );
            return redirect()->back();
        }
    }

}
