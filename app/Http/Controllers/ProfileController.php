<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'imageUpload' => 'required|file|image|max:200'
        ]);

        if ($request->imageUpload) {

            $requestImage = $request->file('imageUpload');
            $img = Image::make($requestImage);
            
            $img->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
            });
            
            $name = $requestImage->hashName();
            $path = config('filesystems.disks.public.root') . '/images/' . $name;
            $img->save($path);
            $path = "images/".$name;
            Profile::updateOrCreate(
                ['user_id' => Auth::id()],
                ['imageUpload' => $path]
            );
            return back()->with('success', "Your image has been uploaded.");
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        return view("profile/edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
