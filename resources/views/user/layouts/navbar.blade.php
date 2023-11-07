<header class="header-area header-padding-1 sticky-bar header-res-padding clearfix">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-6 col-4">
                <div class="logo">
                    <a href="{{ route('frontend.index') }}">
                        <!-- <img alt="" src="assets/img/logo/logo.png"> -->
                        <h2>KPOP Merchandise</h2>
                    </a>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 d-none d-lg-block">
                <div class="main-menu">
                    <nav>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">Home</i></a></li>
                            <li><a> Shop <i class="fa fa-angle-down"></i> </a>
                                <ul class="mega-menu">
                                    <li>
                                        <ul>
                                            <li class="mega-menu-title"><a href="#">Kategori</a></li>
                                            @php
                                                $kategori = App\Models\Kategori::orderBy('name', 'asc')->get();
                                            @endphp
                                            @foreach ($kategori as $item)
                                                <li><a
                                                        href="{{ route('frontend.kategori', $item->slug) }}">{{ $item->name }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            </li>
                            <li><a href="#"> Produk </a></li>
                            <li><a href="#"> About </a></li>
                            <li><a href="#"> Kontak</a></li>
                            @auth
                                <li><a href="{{ route('frontend.detailPembayaran') }}">Riwayat Pembelian</a></li>
                            @endauth

                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-8">
                <div class="header-right-wrap">
                    <div class="same-style header-search">
                        <a class="search-active" href="#">
                            <svg style="width: 23px; color: #3c3939;" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </a>
                        <div class="search-content">
                            <form action="#">
                                <input type="text" placeholder="Search" />
                                <button class="button-search">
                                    <svg style="width: 23px; color: #3c3939;" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="same-style account-satting">
                        <a class="account-satting-active" href="#">
                            <svg style="width: 23px; color: #3c3939;" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>

                        </a>
                        <div class="account-dropdown">
                            <ul>
                                @if (Auth::check())
                                    <li>{{ Auth::user()->name }}</li>
                                    <hr>
                                    <li><a href="#">Profil</a></li>
                                    <li><a href="#"
                                            onclick="event.preventDefault(); document.querySelector('#logout').submit();">Logout</a>
                                        <form action="{{ route('logout') }}" method="POST" id="logout">
                                            @csrf
                                        </form>
                                    </li>
                                @else
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                @endif

                            </ul>
                        </div>
                    </div>
                    @auth
                        <div class="same-style cart-wrap">
                            <button class="icon-cart" id="keranjang">
                                <svg style="width: 23px; color: #3c3939;" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                <span class="count-style" id="cartCount">
                                </span>
                            </button>
                        </div>
                    @endauth

                </div>
            </div>
        </div>
    </div>
    <div class="mobile-menu-area">
        <div class="mobile-menu">
            <nav id="mobile-menu-active">
                <ul class="menu-overflow">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="shop.html">Shop</a>
                        <ul>
                            <li><a href="shop.html">standard style</a></li>
                            <li><a href="shop-filter.html">Grid filter style</a></li>
                        </ul>
                    </li>
                    <li><a href="shop.html">Produk</a></li>
                    <li><a href="about.html">About us</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
