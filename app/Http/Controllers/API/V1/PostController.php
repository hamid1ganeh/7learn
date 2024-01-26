<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Elastic;
use App\Http\Resources\PostCollection;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $from =0;
        if(is_numeric(request('page')) && request('page')>1)
        {
             $from = (request('page')-1)*100;
        } 
    
        $filter = array();
 
    
        if (isset($_GET['title']))
        {
            $filter['query'] = [ 'match' => ['title' => $_GET['title'] ]];
        }
    
        $params = [
             "from"=> $from,
             "size"=> 100,
             'index' => 'posts',
             'body'  => $filter
        ];
    
        $elastic = new Elastic();
        $posts = $elastic->list($params)->hits->hits;
    
        return response()->json(['posts' => new PostCollection($posts)]);
    }

    public function show(Post $post)
    {
        $post = Post::with('tags.categories')->find($post->id);
        return response()->json(['post' => $post]);
    }
}
