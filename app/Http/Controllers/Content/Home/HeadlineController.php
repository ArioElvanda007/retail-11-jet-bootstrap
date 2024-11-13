<?php

namespace App\Http\Controllers\Content\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;
use App\Models\Content\Home\Headline;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class HeadlineController extends Controller
{
    private function can_access()
    {
        return "App\Http\Controllers\Function\GlobalController";
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (app($this->can_access())->access('headlines')->access[0]->modules->is_active == 0 || app($this->can_access())->access('headlines')->access[0]->can_view == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "content.home.headlines.index", 'name' => "Headlines"]
        ];

        $query = Headline::orderBy('seq')->get();
        return view('content.content.home.headlines.index', compact('query'), ['breadcrumbs' => $breadcrumbs]);          
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (app($this->can_access())->access('headlines')->access[0]->modules->is_active == 0 || app($this->can_access())->access('headlines')->access[0]->can_create == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "content.home.headlines.index", 'name' => "Headlines"], ['link' => "content.home.headlines.create", 'name' => "Create Headline"]
        ];

        $seq = Headline::select('seq', 'title')->groupBy('seq', 'title')->orderBy('seq')->get();
        return view('content.content.home.headlines.create', compact('seq'), ['breadcrumbs' => $breadcrumbs]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HttpRequest $request)
    {
        if (app($this->can_access())->access('headlines')->access[0]->modules->is_active == 0 || app($this->can_access())->access('headlines')->access[0]->can_create == 0) {
            return abort(401);
        } 

        // save image *********************************************************************
        $location = config('app.dir_img_headline');
        $files = $request->file('image');
        if (!is_null($files)) {
            $filename = $files->store($location, 'public');
            $image = pathinfo(storage_path($filename), PATHINFO_BASENAME);
        } else {
            $image = null;
        }

        $seq = $request->seq;
        DB::statement("UPDATE content_home_headlines SET seq = seq + 1 WHERE seq >= " . $seq . ";");
        Headline::create([
            'seq' => $seq,
            'image' => $image,
            'title' => Request::get('title'),
            'description' => Request::get('description'),
            'is_active' => Request::get('is_active') ? 1 : 0,
        ]);

        return redirect()->route('content.home.headlines.index');         
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Headline $headline)
    {
        if (app($this->can_access())->access('headlines')->access[0]->modules->is_active == 0 || app($this->can_access())->access('headlines')->access[0]->can_update == 0) {
            return abort(401);
        }

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "content.home.headlines.index", 'name' => "Headlines"], ['link' => "content/home/headlines/edit/$headline->id", 'name' => "Edit Headline"]
        ];

        $query = [
            'id' => $headline->id,
            'image' => $headline->image,
            'seq' => $headline->seq,
            'title' => $headline->title,
            'description' => $headline->description,
            'is_active' => $headline->is_active,
        ];

        $seq = Headline::select('seq', 'title')->groupBy('seq', 'title')->orderBy('seq')->get();
        
        return view('content.content.home.headlines.edit', compact('query', 'seq'), ['breadcrumbs' => $breadcrumbs]);         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Headline $headline, HttpRequest $request)
    {
        if (app($this->can_access())->access('headlines')->access[0]->modules->is_active == 0 || app($this->can_access())->access('headlines')->access[0]->can_update == 0) {
            return abort(401);
        }

        $location = config('app.dir_img_headline');

        // dd($headline->image);
        // delete is remove image have file not null*********************************************************************
        if ($request->is_remove && $headline->image) {
            if (File::exists(public_path("/storage/$location/" . $headline->image))) {
                File::delete(public_path("/storage/$location/" . $headline->image));
            }
        }

        $files = $request->file('image');
        if (!is_null($files)) {
            // delete old image have file not null***************************************************************            
            if ($headline->image) {
                if (File::exists(public_path("/storage/$location/" . $headline->image))) {
                    File::delete(public_path("/storage/$location/" . $headline->image));
                }
            }

            // save image *********************************************************************
            $filename = $files->store($location, 'public');
            $image = pathinfo(storage_path($filename), PATHINFO_BASENAME);
        } else {
            // old image/null *********************************************************************
            $image = $headline->image;
        }

        $seq = $request->seq;
        DB::statement("UPDATE content_home_headlines SET seq = seq + 1 WHERE seq >= " . $seq . ";");
        $headline->update([
            'seq' => $seq,
            'image' => $image,
            'title' => Request::get('title'),
            'description' => Request::get('description'),
            'is_active' => Request::get('is_active') ? 1 : 0,
        ]);

        return redirect()->route('content.home.headlines.index');           
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Headline $headline)
    {
        if (app($this->can_access())->access('headlines')->access[0]->modules->is_active == 0 || app($this->can_access())->access('headlines')->access[0]->can_delete == 0) {
            return abort(401);
        }

        $location = config('app.dir_img_headline');

        // delete not null*********************************************************************
        if ($headline->image) {
            if (File::exists(public_path("/storage/$location/" . $headline->image))) {
                File::delete(public_path("/storage/$location/" . $headline->image));
            }
        }
        
        $headline->delete();
        return redirect()->route('content.home.headlines.index');      
    }
}
