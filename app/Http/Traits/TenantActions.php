<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Tenant;

trait TenantActions
{
    /**
     * Creates a new tenant 
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return Tenant
     */
    public function createTenant(Request $request)
    {
        $validatedData = $this->validateTenantsRequest($request);

        // Conditions to check if image or file was passed or even both
        if ($request->hasFile('image') && !($request->hasFile('file'))) {
            // Image Only
            $tenant = Tenant::create(array_merge(
                $validatedData,
                ['image' => $this->storeTenantImage($request)]
            ));
        } elseif ($request->hasFile('file') && !($request->hasFile('image'))) {
            // File Only
            $tenant = Tenant::create(array_merge(
                $validatedData,
                ['file' => $this->storeTenantFile($request)]
            ));
        } else if ($request->hasFile('image') && $request->hasFile('file')) {
            // Image and File
            $tenant = Tenant::create(array_merge(
                $validatedData,
                ['image' => $this->storeTenantImage($request)],
                ['file' => $this->storeTenantFile($request)]
            ));
        } else {
            // Image and File not provided
            $tenant = Tenant::create($validatedData);
        }

        return $tenant;
    }

    /**
     * Stores a Tenant's image
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return Intervention\Image\Facades\Image $img_filePath
     */
    public function storeTenantImage(Request $request)
    {
        $img_filePath = $request->file('image')->store('uploads/tenants_img', 'public');

        //resize uploaded tenant image
        $image = Image::make(public_path("storage/{$img_filePath}"))->fit(200, 200);
        $image->save();

        return $img_filePath;
    }

    /**
     * Stores tenant's agreement document
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return string $fileNameToStore
     */
    public function storeTenantFile(Request $request)
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
     *  Validates Tenant Request Details
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return array
     */
    public function validateTenantsRequest(Request $request)
    {
        return $request->validate([
            'surname' => 'required',
            'other_names' => 'required',
            'gender' => 'required',
            'national_id' => 'required|unique:tenants',
            'phone_no' => 'required|max:12|unique:tenants',
            'email' => 'required|email|unique:tenants',
            'image' => 'image|mimes:jpeg,png,jpg|max:1999',
            'file' => 'file|nullable|max:1999',
        ]);
    }

    /**
     *  Validates Updated Tenant Request Details
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return array
     */
    public function validateUpdatedTenantsRequest(Request $request)
    {
        return $request->validate([
            'surname' => 'required',
            'other_names' => 'required',
            'gender' => 'required',
            'national_id' => 'required',
            'phone_no' => 'required|max:12',
            'email' => 'required|email',
            'image' => 'image|mimes:jpeg,png,jpg|max:1999',
            'file' => 'file|nullable|max:1999',
        ]);
    }
}
