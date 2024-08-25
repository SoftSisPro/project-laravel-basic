<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IdeaController extends Controller
{
    private array $roules = [
        'title' => 'required|string|max:100',
        'description' => 'required|string|max:300',
    ];

    private array $errorMessages = [
        'title.required' => 'El título es obligatorio',
        'title.string' => 'El título debe ser un texto',
        'title.max' => 'El título no debe superar los 100 caracteres',
        'description.required' => 'La descripción es obligatoria',
        'description.string' => 'La descripción debe ser un texto',
        'description.max' => 'La descripción no debe superar los 300 caracteres',
    ];

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
        $validated = $request->validate($this->roules, $this->errorMessages);

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
        $this->authorize('update', $idea);
        return view('ideas.create_or_edit', ['idea' => $idea]);
    }

    public function update(Request $request, Idea $idea) : RedirectResponse
    {
        $this->authorize('update', $idea);
        //- Validamos los datos
        $validated = $request->validate($this->roules, $this->errorMessages);
        //- Actualizamos la idea
        $idea->update($validated);
        //- Mostramos un mensaje de éxito
        session()->flash('success', 'Idea actualizada correctamente');
        //- Redireccionamos a la vista de ideas
        return redirect()->route('idea.index');
    }

    public function show(Idea $idea) : View
    {
        return view('ideas.show', ['idea' => $idea]);
    }

    public function delete(Idea $idea) : RedirectResponse
    {
        $this->authorize('delete', $idea);
        $idea->delete();
        session()->flash('success', 'Idea eliminada correctamente');
        return redirect()->route('idea.index');
    }

    public function voteLikes(Request $request, Idea $idea) : RedirectResponse
    {
        //- toggle() agrega o quita un registro de la tabla pivote
        $request->user()->ideasLiked()->toggle([$idea->id]);
        //- Contamos los like
        $like = $idea->users()->count();
        //- Actualizamos el campo likes de la idea
        $idea->update(['likes' => $like]);

        //- Redireccionamos a la vista ver idea
        return redirect()->route('idea.show', $idea);
    }
}
