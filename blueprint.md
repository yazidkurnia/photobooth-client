
# Blueprint Aplikasi Photobooth

## Ringkasan

Aplikasi web photobooth sederhana yang memungkinkan pengguna untuk mengambil foto secara otomatis setelah memasukkan email mereka. Aplikasi ini akan memiliki antarmuka yang modern, menarik, dan mudah digunakan.

## Desain dan Fitur

### Tampilan Awal:
- **Input Email:** Sebuah field input untuk pengguna memasukkan alamat email.
- **Tombol "Start":** Tombol untuk memulai sesi foto.
- **Desain:**
    - **Latar Belakang:** Latar belakang dengan tekstur dan gradient yang lembut.
    - **Tipografi:** Penggunaan font yang modern dan mudah dibaca.
    - **Warna:** Palet warna yang cerah dan energik.
    - **Ikon:** Penggunaan ikon untuk memperjelas aksi.

### Sesi Foto:
- **Akses Kamera:** Meminta izin pengguna untuk mengakses kamera.
- **Hitung Mundur:** Hitung mundur 5 detik sebelum sesi foto dimulai.
- **Tampilan Kamera:** Menampilkan feed dari kamera pengguna.
- **Timer:** Timer 10 menit untuk sesi foto.
- **Pengambilan Foto Otomatis:** Aplikasi akan mengambil foto secara otomatis setiap 10 detik.
- **Galeri Mini:** Menampilkan thumbnail dari foto yang telah diambil secara real-time.

### Gaya dan Efek Visual:
- **Efek "Glow":** Tombol dan elemen interaktif akan memiliki efek "glow" untuk membuatnya menonjol.
- **Animasi:** Animasi halus untuk transisi antar state (misalnya, dari tampilan awal ke sesi foto).
- **Shadow:** Penggunaan shadow untuk memberikan kedalaman pada elemen UI.

## Rencana Implementasi

1.  **Membuat Route:** Menambahkan route `/photobooth` di `routes/web.php`.
2.  **Membuat Controller:** Membuat `PhotoBoothController` dengan metode `index`.
3.  **Membuat View:** Membuat file `resources/views/photobooth.blade.php`.
4.  **HTML & CSS:** Menulis struktur HTML dan styling untuk halaman photobooth. Menghapus tombol capture manual.
5.  **JavaScript:**
    - Mengimplementasikan validasi email.
    - Mengakses kamera menggunakan `navigator.mediaDevices.getUserMedia`.
    - Membuat fungsi untuk hitung mundur 5 detik.
    - Membuat timer 10 menit.
    - Mengimplementasikan pengambilan foto otomatis setiap 10 detik setelah sesi dimulai.
    - Menghentikan pengambilan foto otomatis saat sesi berakhir.
