@extends('Videocontest::template')

@section('meta')
<meta property="og:title" content="{{ $video->caption }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ URL::full() }}" />
<meta property="og:caption" content="{{ $video->caption }}" />  
<meta property="og:description" content="{{ $video->desc }}" />  
@endsection

@section('main')

<h3>
{{ $video->caption }}
</h3>

 <div class="video-embed" id="video{{ $video->id }}">{{ $video->url }}</div>

<script>
    $(document).ready(function(){
        $("#video{{ $video->id }}").oembed("{{ $video->url }}",{
            embedMethod: "fill",                                               
            maxWidth: {{ Config::get('Videocontest::app.gallery.single.width') }},
            maxHeight: {{ Config::get('Videocontest::app.gallery.single.height') }}
        }); 
    });
</script>

<div class="video-detail">
	<p>
		{{ e($video->desc) }}
	</p>
</div>
<div class="video-panel">
	{{
		Form::open(
			array(
				'url' 		=> 'vote/'. $video->id,
				'class' 	=>'pull-left form-vote',
				'data-id'	=>	$video->id
			)
		)
	}}
	<button type="submit" class="btn btn-vote" data-id="{{ $video->id }}">
		Vote
		<span class="vote-count{{ $video->id }}">{{ Vote::getCount($video->id) }}</span>
	</button>
	{{ Form::close() }}

	<a href="#" class="btn btn-primary pull-left btn-facebook-share"
		data-video-url="{{ Videocontest::uniqueURL($video->id) }}"
		data-video-caption="{{ e($video->caption) }}"
		data-video-desc="{{ e($video->desc) }}">  						
		Share
	</a>

	{{
		Form::open(
			array(
				'url' => 'twitter/share/'.$video->id,
				'class'=>'pull-left'
			)
		)
	}}
	<button type="submit" class="btn btn-info">Tweet</button>
	{{ Form::close() }}
</div>
@endsection