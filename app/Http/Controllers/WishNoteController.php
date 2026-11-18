<?php

namespace App\Http\Controllers;

use App\Models\WishNote;
use Illuminate\Http\Request;

class WishNoteController extends Controller
{
    public function index(Request $request)
    {
        $boards = WishNote::where('users_id', $request->user()->id)->withCount('messages')->latest()->get();

        return view('boards', compact('boards'));
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'judul' => 'required|string|max:100',
            'deskripsi_singkat' => 'required|string|max:255',
            'tipe_wadah' => 'required|in:tree,mading,mailbox',
            'privasi' => 'required|in:public,private',
        ]);
        $board = WishNote::create($fields + ['users_id' => $request->user()->id]);

        return to_route('boards.show', $board);
    }

    public function show(Request $request, WishNote $board)
    {
        $this->checkAccess($request, $board);

        return view('board', ['board' => $board, 'messages' => $board->messages()->oldest('id')->get()]);
    }

    public function message(Request $request, WishNote $board)
    {
        $this->checkAccess($request, $board);
        $rules = ['body' => 'required|string|max:1000', 'display_name' => 'nullable|string|max:60'];
        if ($board->tipe_wadah === 'tree') {
            $rules += ['ornament' => 'required|in:Bola,CandyCane,Kado,KaosKaki,Lolipop', 'x' => 'required|numeric|between:0,100', 'y' => 'required|numeric|between:0,100'];
        }
        $board->messages()->create($request->validate($rules) + ['user_id' => $request->user()?->id]);

        return to_route('boards.show', $board)->with('status', 'Pesan tersimpan.');
    }

    public function destroy(Request $request, WishNote $board)
    {
        abort_unless($request->user()->id === $board->users_id, 403);
        $board->delete();

        return to_route('dashboard')->with('status', 'Papan dihapus.');
    }

    private function checkAccess(Request $request, WishNote $board): void
    {
        abort_unless($board->privasi === 'public' || ($request->user() && $request->user()->id === $board->users_id), 403);
    }
}
