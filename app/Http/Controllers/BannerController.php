<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    //
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);

        $results = Banner::filterSort($request);

        $results = $results->paginate($limit)->appends([
          'limit' => $limit,
        ]);

        return $this->successResponse($results);
    }

    public function store(Request $request)
    {
        try {
            // $validatedData = $request->validated();

            // $photo = $validatedData['photo'];
            // $name_photo = time() . '_' . $validatedData['title'] . '.' . $photo->getClientOriginalExtension();
            // $image = Image::make($photo->getRealPath());
            // $image->resize(750, 750, function ($constraint) {
            //   $constraint->aspectRatio();
            // })->save('images/banner/' . $name_photo);

            $result = Banner::create([
              'photo'       => $request->post('photo'),
              'title'       => $request->post('title'),
              'description' => $request->post('description'),
              'link'        => $request->post('link') ?? null,
            ]);

            return $this->createdResponse($result);
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function show(string $id)
    {
        $result = Banner::where('id', $id)->first();

        if (!empty($result)) {
            return $this->successResponse($result);
        } else {
            return $this->notFoundResponse();
        }
    }

    public function update(BannerRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();

            $photo      = $validatedData['photo'];
            $name_photo = time() . '_' . $validatedData['title'] . '.' . $photo->getClientOriginalExtension();
            $image      = Image::make($photo->getRealPath());
            $image->resize(750, 750, function ($constraint) {
                $constraint->aspectRatio();
            })->save('images/banner/' . $name_photo);

            $result = Banner::where('id', $id)->update([
              'photo'       => $name_photo,
              'title'       => $validatedData['title'],
              'description' => $validatedData['description'],
              'link'        => $validatedData['link'] ?? null,
            ]);

            return $this->createdResponse($result);
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $path   = 'images/banner/';
            File::delete($path . $banner->image);
            $banner->delete();

            return $this->successResponse();
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }
}
