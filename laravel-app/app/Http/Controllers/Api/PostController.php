<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Validator;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $data = Post::where('user_id', $user->id)->get();

        if ($data->count() > 0) {
            return $this->successResponse($data);
        } else {
            return $this->errorResponse('No records found',Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse( $validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $user = Auth::user();
        $post = new Post();
        $post->user_id = $user->id;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return $this->successResponse($post, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = Auth::user();
        $data = Post::where('id', $id)
            ->where('user_id', $user->id)
            ->get();

        if ($data->count() > 0) {
            return $this->successResponse($data);
        } else {
            return $this->errorResponse(
                'You Dont have permission to access this record',
                Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse( $validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $user = Auth::user();
        $post = Post::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($post) {
            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();
            return $this->successResponse($post);
        } else {
            return $this->errorResponse(
                'You Dont have permission to access this record',
                Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $post = Post::where('id', $id)
            ->where('user_id', $user->id)
            ->get();

        if ($post->count() > 0) {
            $post->each->delete();
            return $this->successResponse();
        } else {
            return $this->errorResponse(
                'You Dont have permission to access this record',
                Response::HTTP_FORBIDDEN);
        }
    }
    /**
     * this function is not require an authentication.
     * anyone can see the posts for all the user
     * you can filter by search and by user
     * you can order the posts by date aysnc or de
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPostsForAllUsersWithFilters(Request $request)
    {
        $data = Post::join('users', 'posts.user_id','=','users.id');
        $data = $data->select('posts.*', 'users.name');

        if (isset($request->search) && $request->search != '') {
            $data = $data->where('title', 'like', '%' . $request->search . '%');
            $data = $data->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if (isset($request->user_id) && intval($request->user_id) != 0) {
            $data = $data->where('user_id', $request->user_id);
        }

        if (isset($request->order) && intval($request->order) == 2) {
            $data = $data->orderBy('id', 'desc');
        }
        $data = $data->paginate(5);

        return $this->successResponse($data);
    }
}
