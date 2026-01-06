<a href="/purchasing/dashboard" class="nav-link {{ request()->is('purchasing/dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> Dashboard
</a>

<a href="/purchasing/pesanan_masuk" class="nav-link {{ request()->is('purchasing/pesanan_masuk') ? 'active' : '' }}">
    <i class="bi bi-bag-check"></i> Pesanan Masuk
</a>

<a href="/purchasing/cari_kurir" class="nav-link {{ request()->is('purchasing/cari_kurir') ? 'active' : '' }}">
    <i class="bi bi-truck"></i> Cari Kurir
</a>

<a href="/purchasing/konfirmasi_pembayaran" class="nav-link {{ request()->is('purchasing/konfirmasi_pembayaran') ? 'active' : '' }}">
    <i class="bi bi-cash-coin"></i> Konfirmasi Pembayaran
</a>

<a href="/purchasing/pesanan_berjalan" class="nav-link {{ request()->is('purchasing/pesanan_berjalan') ? 'active' : '' }}">
    <i class="bi bi-hourglass-split"></i> Pesanan Berjalan
</a>

<a href="/purchasing/kelola_ongkir" class="nav-link {{ request()->is('purchasing/kelola_ongkir') ? 'active' : '' }}">
    <i class="bi bi-geo-alt"></i> Kelola Ongkir & Daerah
</a>

<a href="/purchasing/riwayat_pesanan" class="nav-link {{ request()->is('purchasing/riwayat_pesanan') ? 'active' : '' }}">
    <i class="bi bi-clock-history"></i> Riwayat Pesanan
</a>

<form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="nav-link bg-transparent border-0 w-100 text-start" style="color: inherit;">
        <i class="bi bi-box-arrow-right"></i> Logout
    </button>
</form>
