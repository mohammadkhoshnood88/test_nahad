<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Cmodel;
use App\Models\MarkPost;
use App\Models\MarkLux;
use App\Models\MarkInsurance;
use App\Models\MarkAccessory;
use App\Models\ReportProblem;
use App\Models\Post;
use Carbon\Carbon;
use App\Models\UserPanel;
use App\Models\VehicleMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class MetaController extends Controller
{
    public function getCity(Request $request)
    {
        $stateId = $request->input('stateId');

        $cities = City::where('state_id', $stateId)->get();

        return response()->json(["data" => $cities]);

    }

    public function getModel(Request $request)
    {
        
        $cbrandId = $request->input('cbrandId');
        $cmodels = Cmodel::where('cbrand_id', $cbrandId);
        
        
        if($request->has('intro')){
            
            $aa = [];
            // return response()->json(["data" => $cmodels->get()[1]->intro]);
            foreach($cmodels->get() as $model){
                if($model->intro == null)
                    array_push($aa , $model);
            }
            $cmodels = $aa;
        }
        else{
            $cmodels = $cmodels->orderBy('name')->get();
        }
        
        return response()->json(["data" => $cmodels]);
    }

    public function get_meta(Request $request)
    {
        $meta = VehicleMeta::all()->where('type_id', '=', $request->type);
        switch ($request->type) {
            case("5"):
                $val = "تعداد چرخ";
                break;
            case("4"):
                $val = "تناژ";
                break;
            default :
                $val = "گزینه";
        }

        return response()->json(['meta' => $meta, 'val' => $val]);
    }

    public function getPosts(Request $request)
    {
        $input = $request->all();

    
        $posts = Post::where([['is_active', '=', "1"], ['is_delete', '=', '0'], ['is_rent', '=', $input["is_rent"]]]);

        if (isset($input["states"]) && $input["states"][0] != null)
            $posts = $posts->whereIn('state_id', $input["states"]);
        if (isset($input["brands"]) && $input["brands"][0] != null)
            $posts = $posts->whereIn('cbrand_id', $input["brands"]);
        if (isset($input["models"]) && $input["models"][0] != null)
            $posts = $posts->whereIn('cmodel_id', $input["models"]);
        if (isset($input["years"]) && $input["years"][0] != null)
            $posts = $posts->whereIn('year_id', $input["years"]);
        if (isset($input["gearboxes"]) && $input["gearboxes"][0] != null)
            $posts = $posts->whereIn('gearbox_id', $input["gearboxes"]);
        // if (isset($input["bodies"]) && $input["bodies"][0] != null)
        //     $posts = $posts->whereIn('cbody_id', $input["bodies"]);
        if (isset($input["colors"]) && $input["colors"][0] != null)
            $posts = $posts->whereIn('color_id', $input["colors"]);
        if (isset($input["types"]))
            $posts = $posts->where('type', $input["types"]);
        if (isset($input["status"]))
            $posts = $posts->where('driver_status', $input["status"]);
        if (isset($input["price"]))
            $posts = $posts->where('price', '>=', $input["price"]);

        if (isset($input["term"])){
            $a = $input["term"];
                $posts = $posts->where(function ($query) use ($a) {
                        $query->where('subject', 'LIKE', '%' . $a . '%')
                        ->orWhere('description', 'LIKE', '%' . $a . '%');
        });
        
        }
        
    
        $count = $posts->count();
        $posts = $posts->orderByDesc('sort_id')->paginate(20);


        return response()->json(['data' => $posts , 'count' => $count]);
    }


    public function mark_post(Request $request)
    {
        $phone = session()->get('phone_number', '0');

        if (!$phone) {
            return response()->json(["auth" => false]);
        }

        $user = UserPanel::all()->where('phone_num', '=', $phone)->first();
        $user_id = $user->id;
        $mark = MarkPost::all()->where('post_id', '=', $request->post_id)->where('user_id', '=', $user_id);

        if (count($mark) == 0) {
            $markpost = new MarkPost;
            $markpost->post_id = $request->post_id;
            $markpost->user_id = $user_id;
            $markpost->save();
            return response()->json('mark');


        } else {
            $markk = $mark->first();
            $markk->delete();
            return response()->json('unmark');
        }

        return response()->json("another");
    }

    public function mark_cookie(Request $request)
    {
        $id = $request->id;

        $marks = unserialize($request->cookie('marks'));


        if (!$marks)
            $marks = [];

        if (in_array($id, $marks)) {
            $marks = array_diff($marks, [$id]);
            $mark = 0;
        } else {
            array_push($marks, $id);
            $mark = 1;
        }

        return response()->json(['success' => true, 'marks' => $marks, 'mark' => $mark])->withCookie(cookie()->forever("marks", serialize($marks)));

    }

    public function delete_mark(Request $request)
    {
        $login = session()->get('login');
        if ($login){
            
            $model = MarkPost::class;
            
            if($request->type == 1)
                $model = MarkLux::class;
            if($request->type == 2)
                $model = MarkInsurance::class;
            if($request->type == 3)
                $model = MarkAccessory::class;                
            
            $mark = $model::all()->where('id', '=', $request->id)->first()->delete();
                
            return response()->json(['success' => 1]);
        }
        else{
            $marks = unserialize($request->cookie('marks'));
            $marks = array_diff($marks, [$request->id]);
            return response()->json(['success' => 1])->withCookie(cookie()->forever("marks", serialize($marks)));
        }

    }
    
    
        ////////////////////////     UPLOAD IMAGE      //////////////////////////////////

    public function upload(Request $request)
    {
        $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
        
            $imageName = "image" . time() . '.' . 'jpg';

            $source = file_put_contents('post_images/related_images/' . $imageName, $file);
            
        
        if ($source)
            return response()->json(['image_name' => $imageName , 'code' => 200]);
        else
            return response()->json(['code' => 400]);
    }
    
        public function RA($link)
    {
        return "aaaa";
        $bind = [
            "shortlink" => $link
        ];
        $posts = DB::select("
            select id , phone_number
            from posts
            where shortlink = :shortlink
        " , $bind);

        if(count($posts) == 0){
            return redirect('/');
        }

        $l = $posts[0]->id;
        $p = $posts[0]->phone_number;

        \session()->put('login', true);
        \session()->put('phone_number', $p);

        return redirect("/userpanel/post/$l/upgrade");
    }
    
   
   
    public function report_problem(Request $request){
        
        $phone = session()->get('phone_number', '0');

        if (!$phone) {
            return response()->json(['success' => false, "auth" => false]);
        }
        
        $user = UserPanel::where('phone_num', '=', $phone)->get();
        $user_id = $user[0]->id;
        
        $reports = ReportProblem::where('user_id' , $user_id)->latest()->first();

        if(isset($reports)){
            
            $last_sent = $reports->created_at;
            
            $now = Carbon::now();
            
            $diff = $now->diffInHours($last_sent);
            
            if($diff < 6){
                return response()->json(['success' => false, 'auth' => true , 'message' => 'شما مجاز به ثبت گزارش نیستید']);
            }
        }
        
        if($request->content == null){
                return response()->json(['success' => false, 'auth' => true , 'message' => 'محتوای گزارش را وارد کنید']);            
        }
        
        $report = new ReportProblem();
        $report->post_id = $request->post_id;
        $report->user_id = $user_id;
        $report->type = $request->type;
        $report->content = $request->content;
        
        if($report->save()){
            return response()->json(['success' => true, 'auth' => true , 'message' => 'گزارش شما ثبت شد']);
        }
        

    }
    
    public function download_app(){
        
        // return response()->download(storage_path('app/18charkh.apk'));
        
        return response()->file(storage_path('app/18charkh.apk') ,[
                    'Content-Type'=>'application/vnd.android.package-archive',
                    'Content-Disposition'=> 'attachment; filename="18charkh.apk"',
            ]) ;
        
        
    }
    
    


}
