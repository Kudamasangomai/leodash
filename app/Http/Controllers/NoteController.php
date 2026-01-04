<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NoteController extends Controller
{
    public function index()
    {

        return Inertia::render('Notes/notes', [
            'notes' => Note::orderBy('created_at', 'DESC')->get()
        ]);
    }

    public function store(StoreNoteRequest $request)
    {
        Note::create($request->validated());
        return back()->with('success', 'Record created Successful');
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $validated = $request->validated();
        $note->update($validated);
        return back()->with('success', 'Record Updated Successfully');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->back();
    }
}
