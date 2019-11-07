<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Categories;
use Illuminate\Support\Facades\Auth;
use Auth\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Fqsen;
use tests\Mockery\Generator\ClassWithDebugInfo;

class PostController extends Controller
{
    public function getCategories(){

        $cats=Categories::get();
        return view('post.categories')->with(['cats'=>$cats]);
    }
    public  function  newPostCategories(Request $request){
        $this->validate($request,[
            'cat_name'=>'required|unique:categories'

        ]);
        $c=new Categories();
        $c->cat_name=$request['cat_name'];
        $c->save();
        return redirect()->back()->with('info','The new category have been saved');
    }
    public function getDeleteCategory($id){
        //$c=Category::where('id',$id)->firstOrFail();//first();
        $c=Categories::whereId($id)->firstOrFail();//first();
        $c->delete();
        return redirect()->back()->with('info','The selected category have been deleted');
    }

    public function postUpdateCategory(Request $request){
        $cat_id=$request['cat_id'];
        $cats=Categories::whereId($cat_id)->firstOrFail();
        $cats->cat_name=$request['cat_name'];
        $cats->save();
        return redirect()->back()->with('info','The category have been updated');
    }
    public function getSearchPost(Request $request){
        $q=$request['q'];
        $posts=Post::where('item_name',"LIKE","%$q%")
            ->orWhere('price',"LIKE","%$q%")
            ->paginate(1);
        return view('post.posts')->with(['posts'=>$posts]);


    }

    public function getPosts(){
        $posts=Post::OrderBy('id','desc')->paginate("3");
        return view('post.posts')->with(['posts'=>$posts]);
    }
    public function newPost(){
        $cats=Categories::get();
        return view('post.newpost')->with(['cats'=>$cats]);
    }

    public function postNewPost(Request $request){
        $this->validate($request,[
            'item_name'=>'required',
            'price'=>'required|numeric',
            'image'=>'required|mimes:jpg,jpeg,png,gif',
            'category'=>'required',
            'description'=>'required'
        ]);

        $img_name=$request['item_name']."-".date('dmyhis').".".$request->file('image')->getClientOriginalExtension();//getClientOriginalName();
        $img_file=$request->file('image');
        $p=new Post();
        $p->item_name=$request['item_name'];
        $p->price=$request['price'];
        $p->image=$img_name;
        $p->category_id=$request['category'];
        $p->description=$request['description'];
        $p->user_id=Auth::User()->id;//Auth::id();
        $p->save();

        Storage::disk('posts')->put($img_name,File::get($img_file));
        return redirect()->back()->with('info','The new post have been created');
    }
    public  function getImage($file_name){
        $file=Storage::disk('posts')->get($file_name);
        return response($file);//->header("content-type",'*.*');

    }
    public function getDropPost($id){
        $post=Post::whereId($id)->firstOrFail();
        Storage::disk('posts')->delete($post->image);
        $post->delete();
        return redirect()->back()->with('info','The selected post have been created.');

    }
    public function getEditPost($id){
        $cats=Categories::get();
        $posts=Post::whereId($id)->firstOrFail();
        return view('post.edit-post')->with(['posts'=>$posts,'cats'=>$cats]);

    }
    public function getUpdatePost(Request $request){
        $id=$request['id'];
        $post=Post::whereId($id)->firstOrFail();
        $image=$request->file('image');
        if($image){

            Storage::disk('posts')->delete($post->image);
            $img_name=$request['item_name']."-".date('dmyhis').".".$request->file('image')->getClientOriginalExtension();
            $img=$request->file('image');
            Storage::disk('posts')->put($img_name,File::get($img));
            $post->image=$img_name;

        }
        $post->item_name=$request['item_name'];
        $post->price=$request['price'];
        $post->description=$request['description'];
        $post->category_id=$request['category'];
        $post->update();
        return redirect()->route('posts')->with('info','The selected post have been updated');



    }
}
