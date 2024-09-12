<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">SICUTI</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'Admin')
            <li class="menu-item {{ Request::is('dashboard/cuti*') ? 'active' : '' }}">
                <a href="{{ route('cuti.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Jenis Cuti</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('dashboard/riwayat-pengajuan*') ? 'active' : '' }}">
                <a href="{{ route('riwayatPengajuan') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-history"></i>
                    <div data-i18n="Analytics">Riwayat Pengajuan</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('dashboard/report*') ? 'active' : '' }}">
                <a href="{{ route('report') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Analytics">Repor Pengajuan</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == 'pegawai')
            <li class="menu-item {{ Request::is('dashboard/pengajuan_cuti*') ? 'active' : '' }}">
                <a href="{{ route('pengajuan_cuti.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-plus"></i>
                    <div data-i18n="Analytics">Pengajuan Cuti</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == 'atasan')
            <li class="menu-item {{ Request::is('dashboard/surat*') ? 'active' : '' }}">
                <a href="{{ route('suratMasuk') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-plus"></i>
                    <div data-i18n="Analytics">Suart Cuti Masuk</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'Admin')
            <li class="menu-item {{ Request::is('dashboard/divisi*') ? 'active' : '' }}">
                <a href="{{ route('divisi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Analytics">Divisi</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('dashboard/divisi-head*') ? 'active' : '' }}">
                <a href="{{ route('divisi-head.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Analytics">Kepala Divisi</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('dashboard/setting*') ? 'active' : '' }}">
                <a href="{{ route('setting.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Analytics">Setting</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
