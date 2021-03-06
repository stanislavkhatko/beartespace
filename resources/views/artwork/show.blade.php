@extends('layouts.app')

@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <div class="app--wrapper">

        <div class="app-artwork">

            @if(auth()->user() && auth()->user()->id === $artwork->user->id)
                <div class="app-artwork-artist-panel" style="text-align: center;">
                    <a href="/dashboard/artworks/{{ $artwork->id }}/edit"
                       class="el-button el-button--default el-button--mini">Edit</a>
                    {{--<a href="/dashboard/artworks/{{ $artwork->id }}/deactivate" class="el-button el-button--default el-button--mini">Deactivate</a>--}}
                </div>

            @else
                <div class="artist">
                    <div class="artist-info">
                        <img src="/imagecache/fit-75{{ $artwork->user->avatar_url }}" class="artist-avatar" alt="">
                        <a href="{{ $artwork->user->url }}"
                           class="artist-name">{{ $artwork->user->name }}</a>

                        @if($artwork->user->followedBy->count() > 0)
                            <div class="artist-followed">
                                Followed by {{ $artwork->user->followedBy->count() }} people
                            </div>
                        @endif

                        @if(auth()->user())
                            <follow-button
                                    follow_="{{ auth()->user()->followedUsers->contains($artwork->user->id) }}"
                                    user-id_="{{ $artwork->user->id }}">
                                {{ $artwork->user->name }}
                            </follow-button>
                        @endif
                    </div>

                    @if($artwork->user->artworks->count() > 3)
                        <div class="artist-artworks hidden-xs-only">
                            @foreach($artwork->user->artworks->take(3) as $userArtwork)
                                <a href="{{ $userArtwork->url }}" class="artist-artwork">
                                    <img src="/imagecache/fit-75{{ $userArtwork->image_url }}" alt="">
                                </a>
                            @endforeach
                            <a href="{{ $artwork->user->url }}" class="artist-artwork">
                                <span>
                                       <span class="h2" style="display: block;">
                                          {{ $artwork->user->artworks->count() }}
                                    </span><br>
                                Artworks
                                </span>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <div class="artwork">

                <div class="artwork--left">

                    <artwork-show-carousel artwork_="{{ $artwork }}"></artwork-show-carousel>

                    <el-collapse v-model="activeCollapseArtworkShow">
                        @if($artwork->description)
                            <el-collapse-item title="Description" name="description">
                                {{ $artwork->description }}
                            </el-collapse-item>
                        @endif
                        @if($artwork->inspiration)
                            <el-collapse-item title="Inspiration" name="inspiration">

                                {{ $artwork->inspiration }}
                            </el-collapse-item>
                        @endif
                    </el-collapse>

                </div>

                <div class="artwork--right">
                    <el-card class="artwork-description">

                        <div class="artwork-name">{{ $artwork->name }}</div>
                        <div class="artwork-artist"><b>{{ $artwork->made_by ?? $artwork->user->name }}</b></div>

                        <div class="artwork-price">
                            {{ $artwork->formatted_price }}
                        </div>

                        <div class="artwork-shipping">
                            Free shipping @if($artwork->processing_time)
                                within {{ $artwork->processing_time }} @endif
                        </div>

                        <el-form action="{{ route('cart.item.add', $artwork->id) }}" method="POST">
                            {{ csrf_field() }}

                            @if($artwork->status !== 'available')
                                <div class="artwork-status">
                                    {{ trans('artwork-status.' . $artwork->status) }}
                                </div>
                            @else
                                <div class="artwork-status available">
                                    {{ trans('artwork-status.' . $artwork->status) }}
                                </div>

                                @if($artwork->quantity >= 1)
                                    @if(auth()->user() && auth()->user()->id !== $artwork->user->id)
                                        <div class="artwork-qty" style="margin-bottom: 10px;">
                                            Only {{ $artwork->quantity }} available
                                        </div>

                                        <artwork-quantity-input artwork_="{{ $artwork }}"></artwork-quantity-input>
                                    @endif
                                @endif

                            @endif

                            @if($artwork->status === 'available')

                                {{--<buy-now-form artwork_="{{ $artwork }}"></buy-now-form>--}}

                                {{--<a href="{{ route('cart.item.buy-now', $artwork->id) }}"--}}
                                {{--class="el-button el-button--default is-plain ">Buy Now</a>--}}

                                <el-button type="primary" native-type="submit" style="margin-bottom: 20px;"
                                           class="artwork-add"
                                        {{--                                           disabled="{{ auth()->user() && auth()->user()->id !== $artwork->user->id ? 'disabled' : '' }}">--}}
                                >
                                    Add to cart
                                </el-button>

                            @endif
                        </el-form>


                        @if($artwork->favoredUsers()->count() > 1 )
                            <div class="artwork-favored">
                                <i class="el-icon-info"></i> <b>Almost
                                    gone.</b> {{ $artwork->favoredUsers()->count() }} people watch it
                            </div>
                        @endif

                        @include('partials.share')

                    </el-card>

                    <el-card style="margin-bottom: 20px;">

                        <div slot="header">Overview:</div>

                        <div class="artwork-overviews">

                            @if($artwork->height)
                                <div><b>Height:</b> {{ $artwork->height }} cm</div>
                            @endif

                            @if($artwork->width)
                                <div><b>Width:</b> {{ $artwork->width }} cm</div>
                            @endif

                            @if($artwork->depth)
                                <div><b>Depth:</b> {{ $artwork->depth }} cm</div>
                            @endif

                            @if($artwork->weight)
                                <div><b>Weight:</b> {{ $artwork->weight }} g</div>
                            @endif

                        <!-- Optional -->
                            @if($artwork->optional_size)
                                <div class="h5"> With frame/ Base</div>
                            @endif

                            @if($artwork->b_height)
                                <div><b>Total Height:</b> {{ $artwork->b_height }} cm</div>
                            @endif

                            @if($artwork->b_width)
                                <div><b>Total Width:</b> {{ $artwork->b_width }} cm</div>
                            @endif

                            @if($artwork->b_depth)
                                <div><b>Total Depth:</b> {{ $artwork->b_depth }} cm</div>
                            @endif

                            @if($artwork->b_weight)
                                <div><b>Total Weight:</b> {{ $artwork->b_weight }} cm</div>
                            @endif

                            @if($artwork->date_of_completion)
                                <div><b>Completion year:</b> {{ $artwork->date_of_completion->year }}</div>
                            @endif

                            <div class="artwork-category">
                                <b>Category:</b> {{ trans_input('artwork-category.' . $artwork->category) }}
                            </div>

                            @if(count($artwork->medium))
                                <div class="artwork-medium">
                                    <b>Materials:</b> @foreach($artwork->medium as $medium)
                                        {{ trans_input('medium.' . $medium ) }},
                                    @endforeach
                                </div>
                            @endif

                            @if(count($artwork->theme))
                                <div class="artwork-direction">
                                    Art Direction: @foreach($artwork->direction as $direction)
                                        {{ trans_input('direction.' . $direction ) }},
                                    @endforeach
                                </div>
                            @endif

                            @if(count($artwork->theme))
                                <div class="artwork-theme">
                                    Theme: @foreach($artwork->theme as $theme)
                                        {{ trans_input('theme.' . $theme ) }},
                                    @endforeach
                                </div>
                            @endif

                            {{--                                    {{ $artwork->color }}--}}
                            {{--                                    {{ $artwork->shape }}--}}

                        </div>


                    </el-card>

                    <el-card>
                        <div slot="header">Shipping & returns:</div>

                        <div class="artwork-overviews">
                            @if($artwork->processing_time)
                                <div>Ready to ship in <b>{{ $artwork->processing_time }}</b></div>
                            @endif

                            @if($artwork->country)
                                <div class="artwork-country">
                                    Shipping from <b>{{ $artwork->country['country_name'] }}</b>
                                </div>
                            @endif

                            <div class="artwork-country">
                                Free shipping to <b>{{ geoip(request()->ip())->country }}</b>
                            </div>

                            <div>
                                <a href="{{ route('page', 3)}}" class="el-button--text">Shipping</a> |
                                <a href="{{ route('page', 4)}}" class="el-button--text">Rights to Cancellation</a>
                            </div>
                        </div>

                    </el-card>


                </div>

            </div>

        </div>

        <div class="app-artwork-other">
            <artworks-block
                    artworks_="{{ $otherArtworks }}">
                <template slot="header">
                    <div class="h2">Other Artworks</div>
                </template>
                <template slot="footer">
                    <a href="{{ $artwork->user->url }}" class="el-button el-button--default">See more artworks
                        of {{ $artwork->user->name }}</a>
                </template>
            </artworks-block>
        </div>

        <div class="app-artwork-similar">
            <artworks-block artworks_="{{ $similarArtworks }}">
                <template slot="header">
                    <div class="h2">You also might like</div>
                </template>
                <template slot="footer">
                    <a href="/artwork?artwork-category={{$artwork->category}}" class="el-button el-button--default">See
                        more</a>
                </template>
            </artworks-block>
        </div>


    </div>

@endsection