<?php

namespace App\Http\Controllers;

use App\Imports\CompanyImport;
use App\Models\Company;
use Illuminate\Http\Request;
use Excel;
use File;
use Illuminate\Support\Facades\Storage;

class FileMoveController extends Controller
{
    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:csv,txt'
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        $this->validate($request, $rules, $customMessages);

        $oldFileCount = Company::count();
        $oldFile = Company::all();
        if($oldFileCount){
            foreach($oldFile as $file){

                $blog = Company::find($file->id);
                $blog->delete();
            }
        }

        Excel::import(new CompanyImport, $request->file('file'));

        $all = Company::all();

        foreach($all as $single){


            $path = public_path('upload/'.$single->name.'/');

            if(!File::isDirectory($path)){

                File::makeDirectory($path, 0777, true, true);
            }

            if (File::exists(public_path('file/'.$single->number.'.pdf'))) {

                if(File::exists(public_path('upload/'.$single->name.'/'.$single->number.'.pdf'))){
                    unlink(public_path('upload/'.$single->name.'/'.$single->number.'.pdf'));
                }

                File::move(public_path('file/'.$single->number.'.pdf'), public_path('upload/'.$single->name.'/'.$single->number.'.pdf'));
              }
        }
        return redirect()->back()->with('message', 'File move done.Please check public/upload folder in laravel!');
    }
}
