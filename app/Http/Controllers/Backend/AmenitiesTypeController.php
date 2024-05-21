<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;

class AmenitiesTypeController extends Controller
{
    public function AllAmenity(){
        $amenities = Amenities::latest()->get();
        return view('backend.amenities.all_amenities', compact('amenities'));
    } // end method

    public function AddAmenity(){

        return view('backend.amenities.add_amenities');

    } // end method

    public function StoreAmenity(Request $request){

        //validation
        $request->validate([
         'amenities_name' => 'required|unique:amenities|max:200',
     ]);
 
     Amenities::insert([
         'amenities_name' => $request->amenities_name,
     ]);
     $notification = array(
         'message' => 'Property Type Created Successfully!',
         'alert-type' => 'success'
     );
    
         return redirect()->route('all.amenity')->with($notification);
 
     } // end method

     public function EditAmenity($id){

        $amenities = Amenities::findorfail($id);
        return view('backend.amenities.edit_amenities', compact('amenities'));

    } // end method

    public function DeleteAmenity($id){

        Amenities::findorfail($id)->delete();

        $notification = array(
            'message' => 'Amenity Deleted Successfully!',
            'alert-type' => 'success'
        );
    
            return redirect()->back()->with($notification);


    } // end method

    public function UpdateAmenity(Request $request){

        $pid = $request->id;


        Amenities::findorfail($pid)->update([
            'amenities_name' => $request->amenities_name,
        ]);
        $notification = array(
            'message' => 'Amenity Updated Successfully!',
            'alert-type' => 'success'
        );
    
            return redirect()->route('all.amenity')->with($notification);

        } // end method

        public function SiteLayout(){
            return view('backend.site_layout.site_layout');
        }
}
