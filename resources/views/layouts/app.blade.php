<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@section('title') BeArteSpace @show</title>

    {{--<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">--}}

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/icons.css') }}" rel="stylesheet">

    <script>
        window.trans = {!! $translations !!};

        window.status = {!! json_encode(session('status') ?? '') !!};
        window.error = {!! json_encode(session('error') ?? '') !!};

        window.errors = {!! json_encode($errors->all()) !!}

    </script>


</head>
<body class="@if(is_rtl()) rtl @endif">

<div id="app" class="app">

    <el-container>

        <el-header height="auto" class="app-header">

            <div class="app-header--top">

                <div class="app-header--left">

                    @if(Request::segment(1) === 'dashboard')
                        <div class="app-header-logo">
                            <a href="{{ route('home') }}">
                                <img src="/images/logo-100.png" alt="BeArteSpace logo"/>
                            </a>
                        </div>
                    @else

                        <div class="app-header-invites">
                            <a href="{{ route('invite.artist') }}">For Artists</a>|
                            <a href="{{ route('invite.gallery') }}">For Galleries</a>|
                            <a href="{{ route('invite.writer') }}">For Art Writers</a>
                        </div>

                    @endif

                </div>

                <div class="app-header-currencies">
                    <el-dropdown trigger="hover">
                      <span class="el-dropdown-link">
                          {{ session('currency') }}
                          <i class="el-icon-arrow-down el-icon--right"></i>
                      </span>
                        <el-dropdown-menu slot="dropdown">
                            @foreach(currency()->getCurrencies() as $currency)
                                @if($currency['code'] !== session('currency'))
                                    <el-dropdown-item>
                                        <a href="{{ route('switch-currency', $currency['code']) }}">{{ $currency['code'] }}</a>
                                    </el-dropdown-item>
                                @endif
                            @endforeach
                        </el-dropdown-menu>
                    </el-dropdown>
                </div>

                <div class="app-header-languages">
                    <el-dropdown trigger="hover">
                      <span class="el-dropdown-link">
                          {{ currentLanguage()->name ?? 'en' }}
                          <i class="el-icon-arrow-down el-icon--right"></i>
                      </span>
                        <el-dropdown-menu slot="dropdown">
                            @foreach(getLanguages() as $lang)
                                @if($lang->code !== app()->getLocale())
                                    <el-dropdown-item>
                                        <a href="{{ route('switch-language', $lang->code) }}">{{ $lang->name }}</a>
                                    </el-dropdown-item>
                                @endif
                            @endforeach
                        </el-dropdown-menu>
                    </el-dropdown>
                </div>

                <div class="app-header-auth">
                    @if (Auth::guest())
                        <a href="{{ route('login') }}">@lang('portal.login')</a>&nbsp; | &nbsp; <a
                                href="{{ route('register') }}">@lang('portal.signup')</a>&nbsp; |
                    @else
                        <el-dropdown trigger="hover">
                      <span class="el-dropdown-link">
                         {{ auth()->user()->name }}
                          {{--                          <img src="{{auth()->user()->get_gravatar()}}" class="app-header-auth__photo"/>--}}

                          <i class="el-icon-arrow-down el-icon--right"></i>
                      </span>
                            <el-dropdown-menu slot="dropdown">

                                <el-dropdown-item>
                                    <a href="{{route('dashboard')}}" class="el-dropdown-link">Dashboard</a>
                                </el-dropdown-item>

                                <el-dropdown-item>
                                    <a href="{{ route('dashboard.payments') }}" class="el-dropdown-link">Payments</a>
                                </el-dropdown-item>


                                <el-dropdown-item>
                                    <a href="{{route('dashboard.profile')}}" class="el-dropdown-link">Profile</a>
                                </el-dropdown-item>

                                <el-dropdown-item>
                                    <a href="{{route('dashboard.favorites')}}" class="el-dropdown-link">Favorites</a>
                                </el-dropdown-item>

                                @if(!auth()->user()->isUser())

                                    <el-dropdown-item>
                                        <a href="{{route('dashboard.artworks')}}" class="el-dropdown-link">Artworks</a>
                                    </el-dropdown-item>

                                    <el-dropdown-item>
                                        <a href="{{route('dashboard.artwork.create')}}" class="el-dropdown-link">Upload
                                            Artwork</a>
                                    </el-dropdown-item>

                                @endif

                                @if(auth()->user()->isAdmin())

                                    <el-dropdown-item>
                                        <i class="el-icon-message"></i>
                                        <a href="{{route('admin.messages')}}" class="el-dropdown-link">Messages</a>
                                    </el-dropdown-item>

                                    <el-dropdown-item>
                                        <i class="icon-user"></i>
                                        <a href="{{ route('admin.users') }}">Users</a>
                                    </el-dropdown-item>

                                    <el-dropdown-item>
                                        <i class="el-icon-tickets"></i>
                                        <a href="{{ route('admin.translations') }}">Translations</a>
                                    </el-dropdown-item>

                                    <el-dropdown-item>
                                        <i class="el-icon-setting"></i>
                                        <a href="{{ route('admin.languages') }}">Languages</a>
                                    </el-dropdown-item>

                                    <el-dropdown-item>
                                        <i class="el-icon-document"></i>
                                        <a href="{{ route('admin.pages') }}">Pages</a>
                                    </el-dropdown-item>

                                @endif

                                <el-dropdown-item>
                                    <a href="{{route('dashboard.change-password')}}" class="el-dropdown-link">Change
                                        Password</a>
                                </el-dropdown-item>

                                <el-dropdown-item>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="el-dropdown-link">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </el-dropdown-item>

                            </el-dropdown-menu>
                        </el-dropdown>
                    @endif
                </div>

                @if(!Cookie::get('email_subscription'))
                    <div class="app-header-subscribe">
                        <el-popover
                                placement="bottom"
                                width="400"
                                trigger="click">
                            <el-form inline label-position="top" method="POST" action="{{ route('add-lead') }}">
                                {{ csrf_field() }}
                                <el-input name="email" type="email" placeholder="Type your Email and click send"
                                          required>
                                    <el-button slot="append" native-type="submit" type="primary">Send</el-button>
                                </el-input>
                            </el-form>
                            <div slot="reference">Subscribe for Newsletters</div>

                        </el-popover>
                    </div>
                @endif

                @if(session('cart') && session('cart')->totalQuantity > 0)
                    <a href="{{ route('shopping-cart') }}" class="app-header-cart">
                        <i class="el-icon-goods"></i><sup>{{ session('cart')->totalQuantity }}</sup>
                    </a>
                @endif

            </div>

            @if(Request::segment(1) !== 'dashboard')
                <div class="app-header--bottom">

                    <div class="app-header-logo">
                        <a href="{{ route('home') }}">
                            <img src="/images/logo-200.png" title="BeArteSpace" alt="BeArteSpace logo"/>
                        </a>
                    </div>

                    <div class="app-header-links">

                        <a href="{{ route('artists') }}">@lang('portal.artists')</a>
                        <a href="{{ route('artworks') }}">@lang('portal.artworks')</a>
                        <a href="{{ route('auctions') }}">@lang('portal.auction')</a>

                    </div>

                    <div class="app-header-search">
                        <form action="{{ route('search') }}" method="POST">
                            {{ csrf_field() }}

                            <el-input required
                                      placeholder="Search" name="query"
                                      prefix-icon="el-icon-search">
                            </el-input>

                        </form>
                    </div>
                </div>
            @endif


        </el-header>


        <el-container class="app-content">

            @yield('content')

        </el-container>


        <el-footer height="auto" class="app-footer">

            <div class="app-footer--top">


            </div>

            <div class="app-footer--middle">
                <div class="app--wrapper">
                    <div class="app-footer-menu">
                        <div class="app-footer-submenu">

                            <div class="h4">@lang('portal.about-us')</div>

                            <a href="{{ route('page', 'about-beartespace')}}">About BeArteSpace</a>
                            <a href="{{ route('page', 'about-beartegallery')}}">BeArte Gallery</a>
                            <a href="{{ route('page', 'about-beartedesign')}}">BeArte Design</a>
                        </div>
                        <div class="app-footer-submenu">

                            <div class="h4">For Clients</div>

                            <a href="{{ route('artists')}}">@lang('portal.artists')</a>
                            <a href="{{ route('artworks')}}">@lang('portal.artworks')</a>
                            <a href="{{ route('invite.artist') }}">For Artists</a>
                            <a href="{{ route('invite.gallery') }}">For Galleries</a>
                            <a href="{{ route('invite.writer') }}">For Art Writers</a>
                        </div>
                        <div class="app-footer-submenu">
                            <div class="h4">@lang('portal.information')</div>

                            <a href="{{ route('page', 'terms-and-conditions')}}">Terms and Conditions</a>
                            <a href="{{ route('page', 'right-of-cancellation')}}">Rights to Cancellation</a>
                            <a href="{{ route('page', 'warranty')}}">Warranty</a>
                            <a href="{{ route('page', 'taxes')}}">Taxes</a>
                            <a href="{{ route('page', 'freight')}}">Freight</a>
                            <a href="{{ route('page', 'cookies-and-privacy-regulation')}}">Cookies and Privacy
                                Regulation</a>
                            <a href="{{ route('contact-form') }}">@lang('portal.contact')</a>
                        </div>

                        <div class="app-footer-submenu">
                            <div class="h4">@lang('portal.auction')</div>

                            <a href="{{ route('auctions')}}">Go to Online Auction</a>
                        </div>

                        <div class="app-footer-submenu">
                            <div class="h4">@lang('portal.contact')</div>

                            {!! showPage('contacts-in-footer') !!}
                        </div>
                    </div>

                    <div class="app-footer-panel">

                        <div class="app-footer-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i> </a>
                            <a href="#"><i class="fa fa-google-plus"></i> </a>
                            <a href="#"><i class="fa fa-youtube"></i> </a>
                            <a href="#"><i class="fa fa-linkedin"></i> </a>
                            <a href="#"><i class="fa fa-dribbble"></i> </a>
                        </div>

                        @if(!Cookie::get('email_subscription'))
                            <div class="app-footer-subscribe">
                                <el-form inline label-position="top" method="POST" action="{{ route('add-lead') }}">
                                    {{ csrf_field() }}
                                    <el-form-item>
                                        <el-input name="email" type="email"
                                                  placeholder="Sign Up to be informed about new Artworks" required>
                                            <el-button slot="append" native-type="submit" type="primary">Send
                                            </el-button>
                                        </el-input>
                                    </el-form-item>
                                </el-form>
                            </div>
                        @endif

                    </div>

                </div>

            </div>

            <div class="app-footer--bottom">

                <div class="app--wrapper">

                    <div class="app-footer-panel">
                        <div class="app-footer-logo">
                            <a href="{{ route('home') }}">
                                <img src="/images/logo-100.png" title="BeArteSpace" alt="BeArteSpace logo"/>
                            </a>
                        </div>

                        <div class="app-footer-copy">
                            &copy; 2018 Beartespace
                        </div>

                    </div>

                </div>

            </div>

        </el-footer>

    </el-container>

</div>

@yield('script')

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
