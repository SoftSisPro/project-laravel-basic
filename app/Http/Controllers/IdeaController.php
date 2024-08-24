<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IdeaController extends Controller
{
    public function index() : View
    {
        // $ideas = DB::table('ideas')->get(); una consulta normal no por eloqueent
        $ideas = Idea::get();
        return view('ideas.index', ['ideas' => $ideas]);
    }

    public function create() : View
    {
        return view('ideas.create_or_edit');
    }

    public function store(Request $request) : RedirectResponse
    {
        // dd($request->all()); # Mostrar variables en pantalla
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:300',
        ]);

        Idea::create([
            'user_id' => auth()->user()->id, # $request->user()->id
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        session()->flash('success', 'Idea creada correctamente');

        return redirect()->route('idea.index');
    }

    public function edit(Idea $idea) : View
    {
        return view('ideas.create_or_edit', ['idea' => $idea]);
    }

    public function update(Request $request, Idea $idea) : RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:300',
        ]);

        $idea->update($validated);

        session()->flash('success', 'Idea actualizada correctamente');

        return redirect()->route('idea.index');
    }

    public function show(Idea $idea) : View
    {
        return view('ideas.show', ['idea' => $idea]);
    }

    public function delete(Idea $idea) : RedirectResponse
    {
        $idea->delete();
        session()->flash('success', 'Idea eliminada correctamente');
        return redirect()->route('idea.index');
    }
}
