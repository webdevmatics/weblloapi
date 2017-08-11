<?php

namespace App\Http\Controllers;

use App\Board;
use App\Lists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($boardId)
    {
        $board=Board::find($boardId);

          if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }
        return response()->json(['lists'=>$board->lists]);
    }

    public function show($boardId,$listId)
    {
        $board=Board::find($boardId);

          if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }

        $list = $board->lists()->find($listId);


        return response()->json(['status'=>'success','list'=>$list]);
    }

    public function store(Request $request, $boardId)
    {
        $this->validate($request,['name'=>'required']);

        $board=Board::find($boardId);

        if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }
        $board->lists()->create([
            'name'    => $request->name,
        ]);

        return response()->json(['message' => 'success'], 200);
    }

    public function update(Request $request, $boardId,$listId)
    {

        $this->validate($request,['name'=>'required']);

        $board = Board::find($boardId);

        if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }

        $board->update($request->all());

        return response()->json(['message' => 'success', 'board' => $board], 200);
    }

    public function destroy($boardId,$listId)
    {
        $board=Board::find($boardId);

        if(Auth::user()->id !== $board->user_id) {
            return response()->json(['status'=>'error','message'=>'unauthorized'],401);
        }
        $list=$board->lists()->find($listId);

        if ($list->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Board Deleted Successfully']);
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong']);

    }
}
