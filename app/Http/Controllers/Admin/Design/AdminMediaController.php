<?php

namespace App\Http\Controllers\Admin\Design;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\URL;

class AdminMediaController extends Controller
{
    public function index(){
        $data['heading_title'] = "Image Manager";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
			'text' => 'Media',
			'href' => URL::to('/admin/media')
		];

        return view('admin.design.media',$data);
    }

    public function uploadFile(Request $request){
         
        $folderPath = public_path('image/products');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        
        if($request->hasFile('files')){
            $files = $request->file('files'); // get files
            
            foreach ($files as $key => $file) {               
                $imageName = $file->getClientOriginalName();
                $imagePath = public_path('image/products/') . $imageName ;
    
                if (!file_exists($imagePath)) {
                    // Move the file to the desired location
                    $file->move(public_path('image/products'), $imageName);
                }
            }
            $array = [
                'error' => 0,
                'message' => 'Files uploaded successfully'
            ];
            return response()->json($array, 200);
        }
        $array = [
            'error' => 1,
            'message' => 'No files found in request'
        ];
        return response()->json($array, 400);
    }

    public function getFiles(){
        $folderPath = public_path('image/products');

        if (!file_exists($folderPath)) {
            return response()->json(['error' => 'Directory does not exist'], 404);
        }

        $directory = scandir($folderPath);
        $directory = array_diff($directory, array('.', '..'));

        $folders = [];
        $files = [];

        foreach ($directory as $file) {
            if(is_file($folderPath .'/'. $file)){
                $filename = URL::to('image/products/'.$file);
                $arr1 = [
                    'href' => $filename,
                    'text' => $file
                ];
                array_push( $files, $arr1);
            }
            if(is_dir($folderPath .'/'. $file)){
                $foldername = URL::to('image/products/'.$file);
                $arr2 = [
                    'href' =>  $foldername,
                    'text' => $file
                ];
                array_push( $folders, $arr2);
            }
        }

        $array = [
            'folders' => $folders,
            'files' => $files,
        ];

        return response()->json(($array));
    }

    public function createFolder(Request $request){
        $folderName = $request->request->get('folder_name');
        $folderPath = public_path('image/products');
        $new_folder = $folderPath .'/'. $folderName;

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        if (!file_exists($folderPath .'/'.$new_folder)) {
            mkdir($new_folder, 0777, true);
        }

        $array = [
            'error' => 0,
            'message' => 'Folder created successfully'
        ];
        return response()->json(($array));
    }

    // delete files
    public function delete(Request $request){
        $folderPath = public_path('image/products');
        $files = $request->input('files', []);
        if (!empty($files)) {
            $fileUrls = explode(',', $files[0]);
            foreach ($fileUrls as $fileUrl) {
                if(is_file($folderPath .'/'.$fileUrl)){
                    unlink($folderPath .'/'.$fileUrl);
                }
                if(is_dir($folderPath .'/'.$fileUrl)){
                    rmdir($folderPath .'/'.$fileUrl);
                }
            }
        } else {
            return response()->json(['error' => 'No files provided'], 400);
        }
        $array = [
            'error' => 0,
            'message' => 'Folder deleted successfully'
        ];
        return response()->json(($array));
    }

    public function openFolder(){
        
    }
}
