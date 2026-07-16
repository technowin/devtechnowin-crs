<?php

namespace App\Http\Controllers;

use App\Models\CustomersModel;
use Illuminate\Http\Request;
use App\Models\FileUplodedModel;
use App\Models\CategoryMasterModel;

class FileUplodedController extends Controller
{
    public function index()
    {
        $fileuploded = FileUplodedModel::all();
        return view('fileuploaded.index', compact('fileuploded'));
    }

//    public function create()
//    {
//        $category = CustomersModel::all()->pluck('customername', 'customercode');
//        return view('fileuploaded.create', compact('category'));
//    }

    public function edit($id)
    {

        $model = FileUplodedModel::where('id', $id)->get()->first();
        return view('fileuploaded.edit', compact('model', 'id', 'product'));
    }

    public function update(Request $request, $id)
    {  $model = FileUplodedModel::find($request['hdid']);
        $model->tenderno = $request['tenderno'];
        $file = $request->file('gallery');
        if ($file != null) {
            $string = $file->getClientOriginalName();
            $fileName = str_replace(' ', '-', $string);
            $fileExtension = $file->getClientMimeType();
            $filesize = $file->getClientSize();
            $model->filename = $fileName;
            $model->fileextesion = $fileExtension;
            $model->filesize = $filesize;
            $destinationPath = '/uploads';
            $filesource = $file->move($destinationPath, $fileName);
            $model->fileurl = $filesource;

//            $folderpath  = 'uploads'.'/';
//            $file->move($folderpath , $fileName);
//            $model->fileurl = $folderpath;
        }
        $model->save();
        return redirect()->back();

    }

}
