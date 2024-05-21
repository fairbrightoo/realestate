<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Auth;

class PropertyTypeController extends Controller
{
    public function AllType(){

        $types = PropertyType::latest()->get();
        return view('backend.type.all_type', compact('types'));

    } // end method

    public function AddType(){

        return view('backend.type.add_type');

    } // end method

    public function StoreType(Request $request){

       //validation
       $request->validate([
        'type_name' => 'required|unique:property_types|max:200',
        'type_icon' => 'required'
    ]);

    PropertyType::insert([
        'type_name' => $request->type_name,
        'type_icon' => $request->type_icon,
    ]);
    $notification = array(
        'message' => 'Property Type Created Successfully!',
        'alert-type' => 'success'
    );
   
        return redirect()->route('all.type')->with($notification);

    } // end method

    public function EditType($id){

        $types = PropertyType::findorfail($id);
        return view('backend.type.edit_type', compact('types'));

    } // end method

    public function UpdateType(Request $request){

        $pid = $request->id;


        PropertyType::findorfail($pid)->update([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);
        $notification = array(
            'message' => 'Property Type Created Successfully!',
            'alert-type' => 'success'
        );
    
            return redirect()->route('all.type')->with($notification);

        } // end method

        public function DeleteType($id){

            PropertyType::findorfail($id)->delete();

            $notification = array(
                'message' => 'Property Type Deleted Successfully!',
                'alert-type' => 'success'
            );
        
                return redirect()->back()->with($notification);


        } // end method
}
