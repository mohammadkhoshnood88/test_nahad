<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use App\Models\Rent;
use App\Models\RentImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Morilog\Jalali\CalendarUtils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminRentController extends Controller
{
    public function index(Request $request)
    {

        // $rents = Post::all()->where('is_rent' , '=' , 1);

        $rents = Post::where('is_rent', '=', '1')
        ->orderBy('is_delete' , 'asc')
        ->orderBy('is_active' , 'asc')
        ->orderBy('created_at' , 'desc')
        ->paginate(8);
        
        if ($request->ajax()) {
            return response()->json(['data' => $rents]);
        }        
        
        return view('admin.rents.index' , compact('rents'));
    }

    public function edit($id)
    {
        if (!Gate::any(['isAdmin', 'isOwner' , 'isIssuer'])) {
            return abort(403 , 'شما به این بخش دسترسی ندارید');
        }
        $rents = Post::find($id);
        $images = Image::where('post_id', $id)->get();
        $expire_time =Carbon::now()->addMonth()->timestamp;
//        return $expire_time;

        $data = array(
            'rents' => $rents,
            'images' => $images,
            'expire_time' => $expire_time,
            'image_size' => sizeof($images)
        );

        return view('admin.rents.edit', $data);
    }

    public function update(Request $request, $id)
    {

        if (!Gate::any(['isAdmin', 'isOwner' , 'isIssuer'])) {
            return abort(403 , 'شما به این بخش دسترسی ندارید');
        }

        $this->validate(
            $request,
            ['description' => 'required',
                'subject' => 'required',
                'phone_number' => 'required',
                ],

            ['description.required' => 'موضوع آگهی الزامی می باشد.',
                'subject.required' => 'عنوان آگهی الزامی می باشد.',
                'phone_number.required' => 'شماره تلفن الزامی می باشد.',
               ]


        );

        $rents = Post::find($id);
        $last_active = $rents->is_active;
        


        // // Handle File Upload
        // if($request->hasFile('img-upload-0')){
        //     // Get filename with extension
        //     $filenameWithExt = $request->file('img-upload-0')->getClientOriginalName();
        //     // Get just filename
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get just ext
        //     $extension = $request->file('img-upload-0')->getClientOriginalExtension();
        //     // Filename to store
        //     $fileNameToStore = $filename.'_'.time().'.'.$extension;
        //     // Upload Image
        //     $path = $request->file('img-upload-0')->storeAs('public/cover_images', $fileNameToStore);
        //     $rents->image_path = $fileNameToStore;
        // }


        // Update Posts


        $rents->subject = $request->input('subject');
        $rents->is_rent = 1;
        $rents->phone_number = $request->input('phone_number');
        $rents->email = $request->input('email');
        $rents->description = $request->input('description');
        $rents->admin_response = $request->input('admin_response');
        $rents->driver_status = $request->input('driver_status');
        $rents->visit_count = $rents->visit_count;
        $rents->is_pending = $request->has('is_pending');
        $rents->image_path = $request['img_base64_one'];


        $confirm = Carbon::parse($this->convertDate($request->confirm_at));
        $expire = Carbon::parse($this->convertDate($request->expire_at));

        if($expire->lt($confirm)){
            return back()->with(['error' => "تاریخ انقضا نامعتبر است"]);
        }

        $rents->is_active =  $request->has('is_active');
        $rents->confirm_at = $this->convertDate($request->confirm_at);

        if ($request->expire_at_status) {
            $expiree = $this->convertDate($request->expire_at);
            $rents->expire_at = $expiree;
        } else {
            $expiree = Carbon::parse($confirm)->addMonth();
            $rents->expire_at = $expiree;
        }
        
                ////////////////////////////// short link /////////////////////////////
        if($rents->shortlink == null){
        
        $links = DB::select('
            select shortlink
            from posts
            ');

        $l = [];
        foreach ($links as $link){
            $l[] = $link->shortlink;
        }

        $sl = Str::random(8);
        $flag = 0;
        $i = 0;

        while (!$flag){

            if (!in_array($sl , $l)){
                $flag = 1;
            }
            else{
                $sl = Str::random(8);
            }
            $i++;
        }
        $rents->shortlink = $sl;            
            
            
        }
        
        // return $sl;
        // $rents->save();
        
        ////////////////////////////////////////////////////////////////////////
        
        

        $rents->save();
        
                        $images = Image::all()->where('post_id', '=', $id);
        foreach ($images as $img){
            $img->delete();
        }

        if (isset($request['img_base64_one']) && $request['img_base64_one'] != "noimage.jpg"){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_one']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(600, 600);
            $img->insert($watermark, 'bottom-left', 10, 10);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_one']);

            $image = new Image;
            $image->post_id = $rents->id;
            $image->path = $request['img_base64_one'];
            $image->save();

        }else{
            $image = new Image;
            $image->post_id = $rents->id;
            $image->path = "noimage.jpg";
            $image->save();
        }

        if ($request['img_base64_two'] != "") {
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_two']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(600, 600);
            $img->insert($watermark, 'bottom-left', 10, 10);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_two']);

            $image = new Image;
            $image->post_id = $rents->id;
            $image->path = $request['img_base64_two'];
            $image->save();
        }

        if ($request['img_base64_three'] != ""){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_three']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(600, 600);
            $img->insert($watermark, 'bottom-left', 10, 10);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_three']);

            $image = new Image;
            $image->post_id = $rents->id;
            $image->path = $request['img_base64_three'];
            $image->save();
            
        }

        if ($request['img_base64_four'] != ""){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_four']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(600, 600);
            $img->insert($watermark, 'bottom-left', 10, 10);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_four']);

            $image = new Image;
            $image->post_id = $rents->id;
            $image->path = $request['img_base64_four'];
            $image->save();

        }
        
        /////////////////////////////////   sms  ///////////////////////////////

    

        if($last_active == "0" && $rents->is_active == 1){
            
            $message = urlencode("کاربر گرامی\nآگهی شما با موفقیت در سامانه 18 چرخ تایید گردید.");
            
            $sms = new Sms();
            $sms->submit($rents->phone_number , $message);
            
        }        

        

        return redirect('/admin/rent_ads_manage')->with ('success', 'آگهی مورد نظر با موفقیت ویرایش گردید');

    }

    protected function convertDate($date)
    {
        $aa = CalendarUtils::convertNumbers($date, true);

        $year = substr($aa, '0', '4');
        $month = substr($aa, '5', '2');
        $day = substr($aa, '8', '2');

        $result = CalendarUtils::toGregorian($year, $month, $day);
        $re = $result[0] . '-' . $result[1] . '-' . $result[2] . ' ' . "00:00:00";
        return $re;
    }


    public function uploadFile(Request $request){

        if (!Gate::any(['isAdmin', 'isOwner' , 'isIssuer'])) {
            return abort(403 , 'شما به این بخش دسترسی ندارید');
        }

        $imageId = $request["imageId"];
        $rentId = $request["rentId"];
        $image_path = "";

        if($request->hasFile('image')){
            // Get filename with extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/related_images', $fileNameToStore);
            $image_path = $fileNameToStore;
        }


        $image = RentImage::find($imageId);
        if($imageId == -1 && $image_path != ""){
            $image = new RentImage;
            $image->rent_id = $rentId;
            $image->path = $image_path;
            $image->save();
        }else if($image_path != ""){
            $image->rent_id = $rentId;
            $image->path = $image_path;
            $image->save();
        }

        return response()->json(array('success' => true,"imageId"=>$image->id), 200);

    }

    public function deleteFile(Request $request){

        if (!Gate::any(['isAdmin', 'isOwner' , 'isIssuer'])) {
            return abort(403 , 'شما به این بخش دسترسی ندارید');
        }

        $imageId = $request["imageId"];
        $rentId = $request["rentId"];

        RentImage::where('id',$imageId)->where('rent_id',$rentId)->delete();

        return response()->json(array('success' => true), 200);

    }

}
