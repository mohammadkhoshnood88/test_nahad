<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use App\Models\UserPanel;
use Illuminate\Support\Facades\DB;


class BaseAdvertiseController extends Controller
{
    protected $model;
    protected $route;
    protected $visit;

    public function getAll($term = null , $ajax = false) :array
    {
        $data = $this->model::query()->where('is_active' , '=' , '1');

        if (isset($term)){
            $data = $data->where('subject', 'LIKE', '%' . $term . '%')
                ->orWhere('description', 'LIKE', '%' . $term . '%')
                ->orWhere('address', 'LIKE', '%' . $term . '%');
        }

        $count = $data->where('is_active' , '=' , 1)->count();

        $all = $data->orderBy('created_at' , 'desc')->paginate(20);

        if ($ajax) {
            return response()->json(['data' => $all]);
        }
        $states = State::all();

        $collect = array(
            'data' => $all,
            'term' => $term,
            'count' => $count,
            'states' => $states
        );

        return $collect;
    }

    public function getItem($id)
    {   
        return $this->model::where('id' , $id)->first();
    }

    public function update(Request $request , $id)
    {
        $item = $this->model::find($id);
        $item->update($request->all());

          /*  if ($request['images'][0] != 'noimage.jpg')
            {
                $item->images()->delete();
                
                foreach ($request['images'] as $image) {
                if($image != null){

                        $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $image);

                        $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
                        $img->fit(300, 300);
                        $img->orientate();
                        $img->insert($watermark, 'bottom-left', 5, 5);

                        $success = $img->save('post_images/related_images_watermark/' . $image);

                        $item->images()->create(['path' => $image]);
                        
                }

            }
            }*/

        return redirect("/admin/advertise/$this->route");

    }
    
    public function destroy(Request $request)
    {
        $item = $this->model::find($request->id);
        $item->delete();
        $item->images()->delete();
        $item->tels()->delete();
        
        return response()->json(['success' => true]);
        
    }

}
