<?php

namespace App\Http\Controllers\Admin;

use App\Models\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;

class PhotoController extends Controller
{
    protected array $statuses = ['published', 'draft'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $status = request('status');
        $statuses = $this->statuses;

        $photos = Photo::when($search, function ($query) use ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        })->paginate(10)->withQueryString();

        return view('admins.photos.index', [
            'photos' => $photos,
            'statuses' => $statuses,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = $this->statuses;

        return view('admins.photos.create', [
            'statuses' => $statuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhotoRequest $request)
    {
        $validated = $request->validated();

        $photo = Photo::create($validated);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension(); // Generate a unique filename
            $file->storeAs('media/photo', $filename); // Store file with the unique name
            $photo->photo = $filename; // Store only the unique file name in the database
            $photo->save();
        }

        return redirect()
            ->route('admins.photos.index')
            ->with('success', __('Berhasil menambahkan foto ' . $photo->title));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        $statuses = $this->statuses;

        return view('admins.photos.edit', [
            'photo' => $photo,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhotoRequest $request, Photo $photo)
    {
        $photo->update($request->except('photo'));

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($photo->photo && Storage::exists('media/photo/' . $photo->photo)) {
                Storage::delete('media/articles/' . $photo->photo);
            }

            // Store new photo with a unique name
            $file = $request->file('photo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension(); // Generate a unique filename
            $file->storeAs('media/photo', $filename); // Store file with the unique name
            $photo->photo = $filename; // Store only the unique file name in the database
            $photo->save();
        }
        return redirect()
            ->route('admins.photos.index')
            ->with('success', __('Berhasil mengupdate foto ' . $photo->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        // Delete the file if it exists
        if ($photo->photo && Storage::exists($photo->photo)) {
            Storage::delete($photo->photo);
        }

        $photo->delete();

        return redirect()
            ->route('admins.photos.index')
            ->with('success', __('Berhasil menghapus foto ' . $photo->title));
    }
}
