<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\HouseAdvert;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class HouseAdvertsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = HouseAdvert::count();
        $houseadverts = HouseAdvert::latest()->paginate($perPage);
        return view('admin.house-adverts.index', compact('houseadverts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $houseadvert = new HouseAdvert();
        return view('admin.house-adverts.create', compact('houseadvert'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // validate request from form
        $validatedData = $this->validateRequest($request);

        // check if the image files have been uploaded
        if ($request->hasFile('images') && !($request->hasFile('file'))) {
            // Images only
            HouseAdvert::create(array_merge(
                $validatedData,
                ['images' => $this->store_imgData($request)]
            ));
        } elseif ($request->hasFile('file') && !($request->hasFile('images'))) {
            // File Only
            HouseAdvert::create(array_merge(
                $validatedData,
                ['file' => $this->store_file($request)]
            ));
        } else if ($request->hasFile('images') && $request->hasFile('file')) {
            // Image and File
            HouseAdvert::create(array_merge(
                $validatedData,
                ['images' => $this->store_imgData($request)],
                ['file' => $this->store_file($request)]
            ));
        } else {
            HouseAdvert::create($validatedData);
        }

        return redirect('admin/house-adverts')->with('flash_message', 'House Advert added!');
    }

    // function returns the imgData to be saved in the db
    public function store_imgData(Request $request)
    {
        $img_data = '';
        $data = array();

        foreach ($request->images as $image) {
            // store image in file path
            $img_filePath = $image->store('uploads/houseAdvert_img', 'public');

            // add image file path to data array
            array_push($data, $img_filePath);

            // resize uploaded tenant image
            // $image = Image::make(public_path("storage/{$img_filePath}"))->fit(500, 500);
            // $image->save();
        }

        // separate the image file path with commas
        $img_data = implode(", ", $data);

        return $img_data;
    }

    // stores House Advert agreement document
    public function store_file(Request $request)
    {
        // get name of Agreement doc. file
        $fileNameWithExt = $request->file('file')->getClientOriginalName();
        // file name
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        // extension of file
        $extension = $request->file('file')->getClientOriginalExtension();
        // file name to store
        $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
        // Upload File
        $file_path = $request->file('file')->storeAs('public/uploads/agreement_docs', $fileNameToStore);

        return $fileNameToStore;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $houseadvert = HouseAdvert::findOrFail($id);

        $images = $houseadvert->images;
        $images = explode(', ', $images);

        return view('admin.house-adverts.show', compact('houseadvert', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $houseadvert = HouseAdvert::findOrFail($id);

        return view('admin.house-adverts.edit', compact('houseadvert'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $validatedData = $this->validateRequest($request);
        $houseadvert = HouseAdvert::findOrFail($id);

        // check if the image files have been uploaded
        if ($request->hasFile('images') && !($request->hasFile('file'))) {
            // Image Only
            $houseadvert->update(array_merge(
                $validatedData,
                ['images' => $this->store_imgData($request)]
            ));
        } elseif ($request->hasFile('file') && !($request->hasFile('images'))) {
            // File Only
            $houseadvert->update(array_merge(
                $validatedData,
                ['file' => $this->store_file($request)]
            ));
        } else if ($request->hasFile('images') && $request->hasFile('file')) {
            // Image and File
            $houseadvert->update(array_merge(
                $validatedData,
                ['images' => $this->store_imgData($request)],
                ['file' => $this->store_file($request)]
            ));
        } else {
            $houseadvert->update($validatedData);
        }

        return redirect('admin/house-adverts')->with('flash_message', 'House Advert updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        HouseAdvert::destroy($id);

        return redirect('admin/house-adverts')->with('flash_message', 'HouseAdvert deleted!');
    }

    // validate data from form
    public function validateRequest(Request $request)
    {
        return $request->validate([
            'house' => 'required',
            'location' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048', // validates the image files themselves
            'details' => 'required',
            'description' => 'required',
            'rent' => 'required',
            'booking_status' => 'required',
            'file' => 'file|nullable|max:1999'
        ]);
    }

    // View Agreement Document in Browser
    public function view_doc($id)
    {
        $houseadvert = HouseAdvert::findOrFail($id);
        $filename = $houseadvert->file;
        $pathToFile = public_path('/storage/uploads/agreement_docs/' . $filename);

        // headers for pdf file
        $headers =  [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Content-Transfer-Encoding' => 'binary',
            'Accept-Ranges' => 'bytes'
        ];

        if ($filename != null) {
            return response()->file($pathToFile, $headers);
        } else {
            return "The Agreement Document does not exist in the Database. Please add one";
        }
    }
}
