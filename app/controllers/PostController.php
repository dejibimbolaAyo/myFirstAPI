<?php
use App\User;

class PostController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */


	public function index()
	{
		//
		$posts = Post::all();
		return Response::json([
			'data' => $this->transformCollection($posts)
			], 200);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$post = Post::with(array('User' => function($query)
			{
				$query->select('id', 'email');
			}))->find($id);	
		if(!$post)
		{
			$previous = Post::where('id', '<', $post->id)->max('id');
			$next = Post::where('id', '>', $post->id)->min('id');
			return Response::json([
				'error'=>[
					'message' => 'Post does not Exist'
						]
							], 404);
		}
		return Response::json([
			'previous_post_id' => $previous,
			'next_post_id' => $next,
			'data' => $this->transform($posts)
				], 200);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	private function transformCollection($posts)
	{
		return array_map([$this, 'transform'], $posts->toArray());
	}

	private function transform($post)
	{
	    return [

	           'post_id' => $post['id'],
	           'post' => $post['body'],
	           'submitted_by' => $post['id']['email']
	        ];
	}

}
