<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\tmpUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * FILE STORE 
     */

    public function store(Request $request)
    {
        // dd($request->all());
        $tmp = tmpUpload::select('filename')->where('filename', $request->photo)->first();
        // echo $tmp->filename;
        $tmp_path = public_path('storage/tmp/' . $tmp->filename);
        $upload_path = public_path('storage/upload/' . $tmp->filename);
        if (File::exists($tmp_path)) {
            File::move($tmp_path, $upload_path);

            $upload = new FileUpload();
            $upload->photo = $request->photo;
            $upload->save();
            return back();
        }
        return back();
    }




    /**
     * FILEPOND UPLOAD TMP  
     */
    public function upload(Request $request)
    {
        //upload file to filepond api
        if ($request->photo) {

            $extension = $request->photo->extension();
            $img_name = 'Em-' .  uniqid() . '.' . $extension;
            // path
            $path = public_path('storage\tmp');
            if (!File::exists($path)) {
                mkdir($path);
            }

            $request->photo->move($path, $img_name);
            $tmp = new tmpUpload();
            $tmp->filename = $img_name;
            $tmp->save();
            return $img_name;
        }
        return '';
    }
}
