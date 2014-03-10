<div class="hide" id="message-form-popup">
  {{Form::open(array(
      'route' => "messages.store",
      'method' => 'post',
      'id' => 'message-form'))}}

  {{Form::label('content', "Message: ")}}
  {{Form::textarea('content', '', array(
      'placeholder' => 'Message...(max length: 200 chars)',
      'maxlength' => 200,
      'required' => true,
      'id' => 'content'))}}
  {{Form::submit('Broadcast')}}

  {{Form::close()}}
</div>

<ul id="sidebar">
  <li id="message-form-show">Broadcast Message</li>
  <li>Saved Messages</li>
  <li>
    {{ Form::open(array('route' => 'sessions.destroy', 'method' => 'delete')) }}
    {{ Form::submit('Logout') }}
    {{ Form::close() }}
  </li>
</ul>

<div class="message-overlay">
  <div class="messages">

    @foreach($messages as $message)
      <div class="message">
        {{ HTML::image('user.png')}}
        <div class="message-content">
          {{$message->content}}
          {{$message->created_at}}
        </div>


        @if ($up_vote = DB::table('up_votes')->where('message_id', $message->id)->where('user_id', Auth::user()->id)->first())
        @endif

        @if ($up_vote === NULL)

          {{ Form::open(array(
              'route' => 'up_votes.store',
              'method' => 'post',
              'class' => 'up-vote'
            )) }}
          {{ Form::hidden('message_id', $message->id) }}
          {{ Form::submit('Up Vote') }}
          {{ Form::close() }}

        @else

          {{ Form::open(array('route' => array('up_votes.destroy', $up_vote->id),
                              'method' => 'delete',
                              'class' => 'remove-up-vote')) }}
          {{ Form::hidden('up_vote_id', $up_vote->id) }}
          <!-- here -->
          {{ Form::submit('UP VOTED') }}
          {{ Form::close() }}

        @endif
        <span>  </span>


        @if ($down_vote = DB::table('down_votes')->where('message_id', $message->id)->where('user_id', Auth::user()->id)->first())
        @endif

        @if ($down_vote === NULL)

          {{ Form::open(array(
              'route' => 'down_votes.store',
              'method' => 'post',
              'class' => 'down-vote'
            )) }}
          {{ Form::hidden('message_id', $message->id) }}
          {{ Form::submit('Down Vote') }}
          {{ Form::close() }}

        @else

          {{ Form::open(array('route' => array('down_votes.destroy', $down_vote->id),
                              'method' => 'delete',
                              'class' => 'remove-down-vote')) }}
          {{ Form::hidden('down_vote_id', $down_vote->id) }}
          <!-- here -->
          {{ Form::submit('DOWN VOTED') }}
          {{ Form::close() }}

        @endif
        <span>  </span>


        <span> Save Message </span>
        <span> Add Comment</span>
        <span> Hide Comments</span>

        {{Form::open(array(
            'route' => "comments.store",
            'method' => 'post'))}}

        {{Form::label('content', "Comment: ")}}
        {{Form::textarea('content', '', array(
            'placeholder' => 'Message...(max length: 200 chars)',
            'maxlength' => 200,
            'required' => true))}}
        {{Form::hidden('message_id', $message->id)}}
        {{Form::submit('Comment')}}
        {{ Form::close() }}


      </div>
    @endforeach
  </div>
</div>
