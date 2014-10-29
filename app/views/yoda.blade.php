@extends('layout')


@section('content')


<div class="center aligned ui grid">
    <img src="{{asset('images/yoda-med.png')}}">
</div>

<h1 class="quote"> "Do.. or Do not. There is no try." <span> - Master Yoda </span> </h1>

<div class="container">
    <div class="ui piled blue segment">
      <h2 class="ui header">
        <i class="icon inverted circular blue comment"></i> Comments
      </h2>
      <div class="ui comments all-comments">


      @foreach($comments as $comment)
        <div class="comment">
          <a class="avatar">
            <img src="http://graph.facebook.com/{{$comment['user']['facebook_id']}}/picture">
          </a>
          <div class="content">
            <a class="author">{{ucfirst($comment['user']['name'])}}</a>
            <div class="metadata">
              <span class="date"></span>
            </div>
            <div class="text">
              {{$comment['comment']}}
            </div>
            <div class="actions">
              <a class="reply reply-trigger">Reply</a>
              <!--
              <span class="comment-like-{{$comment->id}}">{{$comment->likes}}</span>
              <i class="thumbs up icon"></i>
              <span class="comment-like-action-{{$comment->id}}">
                  @if(in_array($comment->id,$votes))
                    <a href="javascript:;" data-url="{{URL::Route('removeLike',array('id'=>$comment->id))}}" data-comment="{{$comment->id}}" class="unlike"> Unlike </a>
                  @else
                    <a href="javascript:;" data-url="{{URL::Route('addLike',array('id'=>$comment->id))}}" data-comment="{{$comment->id}}" class="like"> Like </a>
                  @endif
              </span>
                -->
              <form class="ui reply form reply-form" action="{{URL::Route('addComment')}}" method="POST" style="">
                  <div class="field">
                    <input type="text" name="parent" value="{{$comment['id']}}" style="display:none;">
                    <textarea name="comment"></textarea>
                  </div>
                  <input class="ui fluid blue labeled submit icon button" type="submit" value="Reply">
                  </input>

                </form>
            </div>
          </div>

          <div class="comments repliesOfComment-{{$comment['id']}}">
            @if(isset($replies[$comment['id']]))
                @foreach($replies[$comment['id']] as $reply)
                    <div class="comment">
                    <a class="avatar">
                        <img src="http://graph.facebook.com/{{$reply->user->facebook_id}}/picture">
                      </a>
                      <div class="content">
                        <a class="author">{{ucfirst($reply->user->name)}}</a>
                        <div class="metadata">
                          <span class="date"></span>
                        </div>
                        <div class="text">
                          {{$reply->comment}}
                        </div>
                      </div>
                      </div>
                @endforeach
            @endif
          </div>

        </div>
      @endforeach

        <form class="ui reply form comment-form" name="comment" id="comment" action="{{URL::Route('addComment')}}" method="POST">
          <div class="field">

            <textarea name="comment"></textarea>

          </div>
          <input class="ui fluid blue labeled submit icon button" type="submit" value="Add Comment">
          </input>

        </form>
      </div>
    </div>
  </div>
</div>



@stop

@section('script')

<script>


    $('.reply-form').hide();



    function commentTrigger(){
    $(".comment-form").submit(function(e)
        {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            var comment     = postData['0'].value;
            $(this).hide();
            var generated_comment = "<div class='comment'><a class='avatar'><img src='http://graph.facebook.com/{{Auth::user()->facebook_id}}/picture'></a><div class='content'><a class='author'>{{ucfirst(Auth::user()->name)}}</a><div class='metadata'><span class='date'></span></div><div class='text'>" + comment + "</div></div></div><form class='ui reply form comment-form' name='comment' id='comment' action='{{URL::Route('addComment')}}' method='POST'> <div class='field'> <textarea name='comment'></textarea> </div> <input class='ui fluid blue labeled submit icon button' type='submit' value='Add Comment'> </input> </form>";
            $.ajax(
            {
                url : formURL,
                type: "POST",
                data : postData,
                success:function(data, textStatus, jqXHR)
                {
                    $('.all-comments').append(generated_comment);
                    commentTrigger();
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    //if fails
                }
            });
            e.preventDefault(); //STOP default action
            e.unbind(); //unbind. to stop multiple form submit.

        });
    }

    $(".comment-form").submit(function(e)
    {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        var comment     = postData['0'].value;
        $(this).hide();
        var generated_comment = "<div class='comment'><a class='avatar'><img src='http://graph.facebook.com/{{Auth::user()->facebook_id}}/picture'></a><div class='content'><a class='author'>{{ucfirst(Auth::user()->name)}}</a><div class='metadata'><span class='date'></span></div><div class='text'>" + comment + "</div></div></div><form class='ui reply form comment-form' name='comment' id='comment' action='{{URL::Route('addComment')}}' method='POST'> <div class='field'> <textarea name='comment'></textarea> </div> <input class='ui fluid blue labeled submit icon button' type='submit' value='Add Comment'> </input> </form>";
        $.ajax(
        {
            url : formURL,
            type: "POST",
            data : postData,
            success:function(data, textStatus, jqXHR)
            {
                $('.all-comments').append(generated_comment);
                commentTrigger();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails
            }
        });
        e.preventDefault(); //STOP default action
        e.unbind(); //unbind. to stop multiple form submit.

    });





    $(".reply-form").submit(function(e)
        {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $(this).toggle();
            var parent_id   = postData['0'].value;
            var comment     = postData['1'].value;
            var generated_comment = "<div class='comment'><a class='avatar'><img src='http://graph.facebook.com/{{Auth::user()->facebook_id}}/picture'></a><div class='content'><a class='author'>{{ucfirst(Auth::user()->name)}}</a><div class='metadata'><span class='date'></span></div><div class='text'>" + comment + "</div></div></div>";
            $.ajax(
            {
                url : formURL,
                type: "POST",
                data : postData,
                success:function(data, textStatus, jqXHR)
                {
                    $('.repliesOfComment-'+parent_id).append(generated_comment);
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    //if fails
                }
            });
            e.preventDefault(); //STOP default action
        });

    $(".reply-trigger").on('click',function(){
        $(this).parent().children('.reply-form').toggle();
    });

    $(".like").on('click',function(){
        var comment_id  = $(this).data('comment');
        $.ajax(
        {
            url : $(this).data('url'),
            type: "GET",
            success:function()
            {

            },
            error: function()
            {

            }
        });
    });

</script>



@stop