<?php

class CommentController extends \BaseController {

	public function add(){

		$comment = new Comment;

		$comment->comment = Input::get('comment');
		$comment->user_id = Auth::user()->id;

		if(Input::has('parent'))
		{
			$comment->parent_id = Input::get('parent');
		}

		if($comment->save())
		{
			return "success";
		}
		else
		{
			return "error";
		}

	}


	public function addLike($id){

		$vote = new vote;
		$vote->comment_id	= $id;
		$vote->user_id		= Auth::user()->id;
		$vote->reputation	= 1;


		$comment = Comment::find($id);

		$comment->likes++;

		$comment->save();



		if($vote->save())
		{
			return "success";
		}
		else
		{
			return "error";
		}

	}

	public function removeLike($id){

		$comment = Comment::find($id);

		$comment->likes--;

		$comment->save();

		Vote::where('comment_id',$id)->where('user_id',Auth::user()->id)->where('reputation',1)->delete();

		return "success";

	}

	public function addDislike($id){

		$vote = new vote;
		$vote->comment_id	= $id;
		$vote->user_id		= Auth::user()->id;
		$vote->reputation	= 0;

		$comment = Comment::find($id);

		$comment->dislikes++;

		$comment->save();

		if($vote->save())
		{
			return "success";
		}
		else
		{
			return "error";
		}

	}

	public function removeDislike($id){

		$comment = Comment::find($id);

		$comment->dislikes--;

		$comment->save();

		Vote::where('comment_id',$id)->where('user_id',Auth::user()->id)->where('reputation',0)->delete();

		return "success";

	}

}