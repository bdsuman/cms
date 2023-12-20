<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                'id' => $data->id,
                'slug' => $data->slug,
                'author' => User::find($data->user_id)->firstName,
                'title' => $data->title,
                'content' => $data->content,
                'image' => request()->server("SERVER_NAME").'/'.$data->img_url, 
                'publish_at' => $data->publish_at, 
                'status' => ($data->status==0)?'Inactive':'Active',
                'category'=>$data->categories()->get()
            ];
        })
    ];
       
    }
    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
