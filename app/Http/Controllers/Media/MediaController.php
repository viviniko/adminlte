<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Viviniko\Media\Contracts\ImageService;

class MediaController extends Controller
{
    /**
     * @var \Common\Media\Contracts\ImageService
     */
    protected $imageService;

    /**
     * MediaController constructor.
     * @param \Common\Media\Contracts\ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $medias = $this->imageService->search($request)->paginate(15);
        return view('media.index', compact('medias'));
    }

    public function upload(Request $request)
    {
        $dir = $request->get('dir');
        $files = array_wrap(($request->file('files')));
        $pictures = collect($files)->map(function ($file) use ($dir) {
            $picture = $this->imageService->save($file, $dir);
            return $picture;
        });

        if ($request->ajax()) {
            return response()->json($pictures);
        }

        return back()->withSuccess(trans('media.created'));
    }

    public function delete(Request $request)
    {
        $deleted = $this->imageService->delete($request->get('id'));

        if ($request->ajax()) {
            return response()->json(compact('deleted'));
        }

        return back()->withSuccess(trans('media.deleted'));
    }

    public function destroy(Request $request, $media)
    {
        $deleted = $this->imageService->delete($media);

        if ($request->ajax()) {
            return response()->json(compact('deleted'));
        }

        return back()->withSuccess(trans('media.deleted'));
    }
}
