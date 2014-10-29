<?php

class YodaController extends \BaseController {

	public function view(){


		$comments = Comment::where('parent_id',NULL)->with('user')->get();

		$comment_ids = [];

		foreach($comments as $comment)
		{
			array_push($comment_ids,$comment->id);

		}

		if($comment_ids!=[])
		{
			$comment_replies = Comment::whereIn('parent_id',$comment_ids)->with('user')->orderBy('parent_id')->get();
			$votes 			=	Vote::whereIn('comment_id',$comment_ids)->where('reputation',1)->where('user_id',Auth::user()->id)->get();
			if(!$votes->count())
			{
				$votes = [];
			}else{
				$votes_process = [];
				foreach($votes as $vote)
				{
					array_push($votes_process,$vote->id);
				}
				$votes = $votes_process;
			}

		}
		else
		{
			$comment_replies = [];
			$votes = [];
		}





		$replies = [];


		foreach($comment_replies as $reply)
		{
			foreach($comments as $comment)
			{
				if($reply->parent_id == $comment['id'])
				{
					$id = $comment['id'];
					$replies[$id][] = $reply;
				}
			}
		}





		return View::Make('yoda')->with('comments',$comments)->with('replies',$replies)->with('votes',$votes);

	}

}