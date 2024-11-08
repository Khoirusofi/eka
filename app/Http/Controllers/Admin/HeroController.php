<?php

namespace App\Http\Controllers\Admin;

use App\Models\Hero;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHeroRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateHeroRequest;

class HeroController extends Controller
{
    public function index()
{
    $search = request('search');

    $heroes = Hero::when($search, function ($query) use ($search) {
        return $query->where('title', 'like', '%' . $search . '%');
    })->paginate(10)->withQueryString();

    return view('admins.heroes.index', [
        'heroes' => $heroes,
        'search' => $search,
    ]);
}


    public function create()
    {
        return view('admins.heroes.create');
    }

    public function store(StoreHeroRequest $request)
    {
        $validated = $request->validated();

        $hero = Hero::create($validated);

        if ($request->hasFile('background_hero')) {
            $file = $request->file('background_hero');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension(); // Generate a unique filename
            $file->storeAs('media/hero', $filename); // Store file with the unique name
            $hero->background_hero = $filename; // Store only the unique file name in the database
            $hero->save();
        }

        return redirect()
            ->route('admins.heroes.index')
            ->with('success', __('Berhasil menambahkan foto: ' . $hero->title));
    }

    public function update(UpdateHeroRequest $request, Hero $hero)
    {
        $validated = $request->validated();
        $hero->update($validated);

        if ($request->hasFile('background_hero')) {
            // Delete old photo if exists
            if ($hero->background_hero && Storage::exists('media/hero/' . $hero->background_hero)) {
                Storage::delete('media/hero/' . $hero->background_hero);
            }

            // Store new photo with a unique name
            $file = $request->file('background_hero');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension(); // Generate a unique filename
            $file->storeAs('media/hero', $filename); // Store file with the unique name
            $hero->background_hero = $filename; // Store only the unique file name in the database
            $hero->save();
        }

        return redirect()
            ->route('admins.heroes.index')
            ->with('success', __('Berhasil mengupdate hero: ' . $hero->title));
    }

    public function edit(Hero $hero)
    {
        return view('admins.heroes.edit', compact('hero'));
    }


    public function destroy(Hero $hero)
    {
        if ($hero->background_hero) {
            Storage::disk('public')->delete($hero->background_hero);
        }

        $hero->delete();
        return redirect()->route('admins.heroes.index')->with('success', 'Hero section deleted successfully.');
    }
}
