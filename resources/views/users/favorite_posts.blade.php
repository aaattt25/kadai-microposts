@if (count($favorites) > 0)
    <ul class="media-list">
        @foreach($favorites as $favorite)
            <li class="media">
                <img class="media-object rounded" src="{{ Gravatar::src($favorite->user->email, 50) }}" alt="">
                    <div class="media-body ml-3">
                    <div>
                        {{ $favorite->content }}
                    </div>
                    <div>
                        @include('favorite.favorite_button', ['micropost' => $favorite])
                        <p>{!! link_to_route('users.show','View profile', ['id' => $favorite->user->id]) !!}</p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{ $favorites->render('pagination::bootstrap-4') }}
@endif

