WePlan(t) Platform Overview
===========================

Mission
-------
WePlan(t) menyediakan platform digital ekosistem kelapa sawit yang
menghubungkan tamu, petani, mitra pemasok, dan admin untuk transaksi
produk serta pengelolaan rantai pasok.

Peran Pengguna
--------------
- Guest: jelajah katalog, checkout sebagai tamu atau membuat akun.
- Petani: autentikasi, kelola profil kebun, belanja produk mitra
  (pupuk, bibit, alat), lacak pesanan.
- Mitra: daftar sebagai pemasok, unggah/kelola produk, kelola stok,
  monitor status approval serta pesanan.
- Admin: kelola pengguna, kategori, produk mitra, persetujuan supply,
  pemrosesan order serta laporan.

Modul Fungsional
----------------
- Authentication & Authorization: multi-role guard berbasis `users` +
  `roles` + `permissions`.
- Catalog & Search: daftar produk tersegmentasi kategori (pupuk,
  bibit, alat, layanan).
- Order Lifecycle: keranjang, checkout, pembayaran (placeholder),
  tracking status.
- Supply Pipeline: mitra mengirim listing → admin review → produk aktif
  ditampilkan ke toko.
- Farmer Services: paket rekomendasi, riwayat pembelian, notifikasi.
- Admin Backoffice: dashboard approval, manajemen konten, laporan KPI.

Struktur Basis Data Awal
------------------------
- `users`: data akun umum (nama, email, password), kolom `role_id`.
- `roles`: `guest` (virtual), `farmer`, `partner`, `admin`.
- `partner_profiles`: data perusahaan mitra & status verifikasi.
- `farmer_profiles`: informasi kebun, lokasi, luas lahan.
- `products`: dimiliki `partner_id`, status `draft|pending|approved|rejected|archived`.
- `product_categories`: hierarki jenis produk.
- `product_media`: gambar atau dokumen pendukung.
- `supplies`: log pengajuan produk (audit trail approval admin).
- `orders`: header order (guest/petani), enumerasi status.
- `order_items`: detail produk & kuantitas.
- `inventory_movements`: tracking stok per mitra.
- `payments` (placeholder): tipe pembayaran & status.

Rencana Routing
---------------
- Web shop (`routes/web.php`):
  - `/` landing + katalog,
  - `/product/{slug}`,
  - `/cart`, `/checkout`, `/orders`.
- Portal petani (`/farmer/*`): dashboard, pesanan, rekomendasi.
- Portal mitra (`/partner/*`): produk, stok, supply request.
- Portal admin (`/admin/*`): approval, master data, laporan.
- API (opsional, `routes/api.php`): integrasi mobile / headless.

Langkah Implementasi Berikutnya
-------------------------------
1. Konfigurasi autentikasi multi-role (seed user admin awal).
2. Buat migrasi + model + relasi untuk tabel inti di atas.
3. Skeleton UI:
   - Landing & katalog dasar (Blade + Tailwind),
   - Dashboard petani/mitra/admin dengan layout turunan.
4. Implementasi alur supply mitra → approval admin → publikasi produk.
5. Implementasikan keranjang & order untuk guest/petani.
6. Tambahkan pengujian feature untuk alur penting + policy/permission.

Catatan Teknis
--------------
- Gunakan Laravel Breeze atau Fortify untuk auth dasar sebelum kustom.
- Simpan media via `public` disk, siapkan abstraksi untuk S3 jika dibutuhkan.
- Pertimbangkan job queue untuk notifikasi & approval email.
- Gunakan policy/gate untuk kontrol akses granular.



