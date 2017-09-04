<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Viviniko\Media\Contracts\FileService;
use Viviniko\Media\Rules\FileNameValidationRule;
use Viviniko\Media\Rules\FolderNameValidationRule;

class FileController extends Controller
{
    protected $fileService;
    /**
     * FileController constructor.
     * @param $files
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $path = $request->get('folder');
        $data = $this->fileService->dirInfo($path);
        $data['folder'] = $path;
        return view('media.file', $data);
    }

    public function upload(Request $request)
    {
        $path = $request->get('folder');
        $this->fileService->upload($request->file('files'), $path);
        return response()->json(['message' => 'OK']);
    }

    public function mkdir(Request $request)
    {
        $this->validate($request, [
            'new_folder' => [
                'required',
                new FolderNameValidationRule()
            ]
        ]);
        $this->fileService->mkdir($request->get('new_folder'), $request->get('folder'));
        return response()->json(['message' => 'OK']);
    }

    public function rmdir(Request $request)
    {
        $folder = $request->get('folder');
        if (in_array(trim($folder), ['/', ''])) {
            throw new \InvalidargumentException;
        }
        $this->fileService->rmdir($folder);
        return back()->withSuccess(trans('media.folder_deleted'));
    }

    public function delete(Request $request)
    {
        $file = $request->get('file');
        $this->fileService->delete($file);
        return back()->withSuccess(trans('media.file_deleted'));
    }

    public function rename(Request $request)
    {
        $this->validate($request, [
            'old_file' => 'required',
            'new_file_name' => [
                'required',
                new FileNameValidationRule()
            ]
        ]);
        $folder = $request->get('folder');
        $old_file = $request->get('old_file');
        $fileInfo = pathinfo($old_file);
        $new_file_name = $request->get('new_file_name') . '.' . $fileInfo['extension'];
        $result = $this->fileService->rename($old_file, $new_file_name, $folder);
        if ($result) {
            $request->session()->flash('success', trans('media.file_renamed'));
        } else {
            $request->session()->flash('errors', collect([trans('media.rename_failed')]));
        }
        return response()->json(['message' => 'OK']);
    }
}
