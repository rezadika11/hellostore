<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <span class="align-middle">Olshop</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Master
            </li>
            <li class="sidebar-item {{ Request::is('admin/dashboard*') ? 'active' : '' }} ">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('admin/kategori*') ? 'active' : '' }} ">
                <a class="sidebar-link" href="{{ route('kategori.index') }}">
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Kategori</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('admin/produk*') ? 'active' : '' }} ">
                <a class="sidebar-link" href="{{ route('produk.index') }}">
                    <i class="align-middle" data-feather="box"></i> <span class="align-middle">Produk</span>
                </a>
            </li>

            <li class="sidebar-item {{ Request::is('admin/slider*') ? 'active' : '' }} ">
                <a class="sidebar-link" href="{{ route('slider.index') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Slider</span>
                </a>
            </li>

            <li class="sidebar-item {{ Request::is('admin/pembayaran*') ? 'active' : '' }} ">
                <a class="sidebar-link" href="{{ route('pembayaran.index') }}">
                    <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Pembayaran</span>
                </a>
            </li>

            <li class="sidebar-item {{ Request::is('admin/laporan*') ? 'active' : '' }} ">
                <a class="sidebar-link" href="{{ route('laporan.index') }}">
                    <i class="align-middle" data-feather="file"></i> <span class="align-middle">Laporan</span>
                </a>
            </li>

        </ul>
    </div>
</nav>
