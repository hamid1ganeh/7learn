<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
 
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($item){
            return [
                'id' => $item->_id,
                'title'=> $item->_source->title,
                'content'=> $item->_source->content,
                'publishDateTime'=> $item->_source->publishDateTime,
                'status'=> $item->_source->status
            ];
        });
    }
}
