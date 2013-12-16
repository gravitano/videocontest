@extends('Videocontest::template')

@section('main')

<h3><i class="icon-star"></i> Leaderboard</h3>
	
	@if(count($videos)>0)

		@foreach($videos as $video)
			<li type="1" class="clearfix list-leaderboard">
				<div class="video-embed" id="video{{ $video->id }}">{{ $video->url }}</div>
				
				<script>
                    $(document).ready(function(){
                        $("#video{{ $video->id }}").oembed("{{ $video->url }}",{
                            embedMethod: "fill",                                               
                            maxWidth: {{ Config::get('Videocontest::app.gallery.thumbs.width') }},
                            maxHeight: {{ Config::get('Videocontest::app.gallery.thumbs.height') }}
                        }); 
                    });
                </script>

				<div class="video-detail">
					<a href="{{ Videocontest::uniqueURL($video->id) }}" class="text-caption"> 
						{{ $video->caption }}
					</a>
					<p>
						Posted by
						<a href="#">
						{{ Participant::get($video->participant_id) }}
						</a>
						about
						<span class="muted">
						{{ Videocontest::timeAgoFromDate($video->created_at)}}
						</span>
					</p>
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
			</li>
		@endforeach

	@endif

<pre>
{{-- dd(DB::getQueryLog()) --}}
</pre>

@endsection