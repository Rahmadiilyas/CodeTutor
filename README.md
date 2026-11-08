# CodeTutor

**Platform Pembelajaran Pemrograman Berbasis Web dengan Integrasi Chatbot AI**

CodeTutor merupakan platform pembelajaran pemrograman berbasis web yang dikembangkan untuk mendukung pembelajaran mata kuliah Dasar-Dasar Pemrograman (DDP). Platform ini mengintegrasikan materi pembelajaran, latihan pemrograman melalui Code Lab, evaluasi, chatbot AI, pemantauan progres belajar, dan sertifikat.

> **URL aplikasi (target deployment):** https://codetutor.my.id  
> Pastikan domain sudah diarahkan ke hosting dan deployment telah selesai sebelum menyatakan aplikasi aktif.

## Informasi Proyek

| Keterangan | Detail |
|---|---|
| Nama Proyek | CodeTutor |
| Mata Kuliah | Proyek Perangkat Lunak |
| Program Studi | Informatika |
| Kelas | B2023 |
| Kelompok | 3 |
| Project Manager | Rahmadi |
| Repository | Isi dengan URL repository GitHub kelompok |

## Tujuan

Mengembangkan platform pembelajaran pemrograman yang membantu pengguna mempelajari materi Dasar-Dasar Pemrograman melalui materi terstruktur, latihan menulis dan menjalankan kode, evaluasi pembelajaran, bantuan chatbot AI, pemantauan progres belajar, serta penerbitan sertifikat sesuai ketentuan sistem.

## Fitur Utama

- **Manajemen pengguna dan hak akses:** pengelolaan akun berdasarkan peran Admin, Instruktur, dan Pelajar.
- **Dashboard:** menampilkan informasi dan aktivitas sesuai hak akses pengguna.
- **Materi pembelajaran:** penyajian serta pengelolaan materi Dasar-Dasar Pemrograman.
- **Code Lab:** fasilitas untuk menulis dan menjalankan latihan kode pemrograman.
- **Evaluasi pembelajaran:** pengelolaan soal dan pengerjaan evaluasi.
- **Chatbot AI:** bantuan penjelasan materi pemrograman melalui integrasi Gemini API.
- **Progres belajar:** informasi perkembangan pembelajaran pengguna.
- **Sertifikat:** penerbitan dan akses sertifikat berdasarkan ketentuan penyelesaian pembelajaran.

## Tim Pengembang

| Nama | Peran |
|---|---|
| Rahmadi | Project Manager |
| Ariqah | System Analyst |
| Fardina | System Designer |
| Rifqah | UI/UX Designer |
| Siti Mariati | Database Designer |
| Rayhan | Developer |
| Silfi Kurnia | Tester/QA |

## Teknologi

- PHP
- Laravel
- MySQL
- HTML
- CSS
- JavaScript
- Tailwind CSS
- Gemini API
- Git dan GitHub

> Versi PHP, Laravel, Node.js, dan paket lainnya harus mengikuti versi yang tercantum pada `composer.json`, `composer.lock`, `package.json`, dan `package-lock.json` proyek. Jangan menaikkan versi secara sepihak karena dapat menimbulkan ketidakcocokan dependensi.

---

# Panduan Pengembangan Lokal

## 1. Persyaratan Awal

Pastikan perangkat pengembang sudah memiliki:

1. PHP dengan versi dan ekstensi yang sesuai dengan kebutuhan Laravel pada proyek.
2. Composer.
3. MySQL atau MariaDB.
4. Node.js dan npm untuk mengelola aset frontend.
5. Git.
6. Editor kode, misalnya Visual Studio Code.

Periksa instalasi melalui terminal:

```bash
php -v
composer -V
node -v
npm -v
git --version
```

## 2. Mengambil Source Code dari GitHub

Buka terminal pada folder tempat proyek akan disimpan, kemudian jalankan:

```bash
git clone https://github.com/USERNAME/REPOSITORY.git
cd REPOSITORY
```

Ganti `USERNAME/REPOSITORY` dengan alamat repository GitHub milik kelompok. Jika source code sudah pernah di-clone, tidak perlu melakukan clone ulang. Masuk ke folder proyek yang sudah ada.

## 3. Memasang Dependensi Laravel

Jalankan perintah berikut dari direktori utama proyek:

```bash
composer install
npm install
```

Jika repository menyediakan `package-lock.json`, gunakan `npm ci` sebagai alternatif yang memasang dependensi sesuai lock file:

```bash
npm ci
```

## 4. Menyiapkan File Environment

Buat file `.env` berdasarkan `.env.example`.

Di Windows Command Prompt:

```bat
copy .env.example .env
```

Di macOS/Linux/Git Bash:

```bash
cp .env.example .env
```

Buka `.env`, kemudian sesuaikan konfigurasi aplikasi dan database. Contoh konfigurasi MySQL:

```env
APP_NAME=CodeTutor
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=codetutor
DB_USERNAME=root
DB_PASSWORD=
```

Buat database bernama `codetutor` melalui MySQL/phpMyAdmin atau alat database yang digunakan.

Jika integrasi chatbot menggunakan Gemini API, masukkan API key pada variabel environment yang memang dipakai oleh konfigurasi proyek. Contoh nama variabel yang umum digunakan:

```env
GEMINI_API_KEY=masukkan_api_key_di_lingkungan_lokal
```

Periksa `config/services.php`, file konfigurasi terkait, atau `.env.example` untuk memastikan nama variabel yang benar. Jangan menaruh API key langsung di source code.

## 5. Membuat Application Key

```bash
php artisan key:generate
```

Perintah ini digunakan untuk membuat `APP_KEY` pada instalasi lokal. Jangan mengganti `APP_KEY` aplikasi produksi yang sudah berjalan karena dapat membuat data terenkripsi atau sesi yang ada tidak dapat dibaca.

## 6. Menyiapkan Database

Jalankan migrasi:

```bash
php artisan migrate
```

Jika proyek memang menyediakan seeder dan data awal dibutuhkan, jalankan:

```bash
php artisan db:seed
```

Atau, untuk menjalankan migrasi beserta seeder sekaligus pada database lokal yang masih kosong:

```bash
php artisan migrate --seed
```

Jangan menjalankan perintah seeding pada database yang berisi data penting tanpa memeriksa isi seeder terlebih dahulu.

## 7. Menyiapkan Storage dan Aset Frontend

Buat symbolic link untuk file publik yang disimpan melalui Laravel:

```bash
php artisan storage:link
```

Bangun aset frontend:

```bash
npm run build
```

Selama pengembangan frontend, jika diperlukan, jalankan Vite dalam terminal terpisah:

```bash
npm run dev
```

## 8. Menjalankan Aplikasi

Jalankan server pengembangan Laravel:

```bash
php artisan serve
```

Buka alamat berikut pada browser:

```text
http://127.0.0.1:8000
```

Untuk menghentikan server pengembangan, tekan `Ctrl + C` pada terminal.

## 9. Menjalankan Pengujian

Jalankan pengujian otomatis yang tersedia pada proyek:

```bash
php artisan test
```

Periksa juga fitur secara manual berdasarkan peran Admin, Instruktur, dan Pelajar, khususnya login, materi, Code Lab, evaluasi, chatbot AI, progres belajar, serta sertifikat.

---

# Panduan Kolaborasi Git dan GitHub

## 1. Aturan Branch

Untuk menjaga branch utama tetap stabil, gunakan pola berikut:

| Branch | Fungsi |
|---|---|
| `main` | Versi stabil yang siap dirilis atau dipasang pada hosting. |
| `develop` | Branch integrasi untuk menggabungkan pekerjaan anggota sebelum dirilis. |
| `feature/*` | Pekerjaan penambahan fitur atau perubahan aplikasi. |
| `fix/*` | Perbaikan bug. |
| `docs/*` | Dokumentasi, SRS, SDD, SPMP, atau README. |
| `test/*` | Skenario dan dokumentasi pengujian. |

Contoh nama branch berdasarkan pekerjaan anggota:

| Anggota | Contoh Branch |
|---|---|
| Rahmadi | `docs/rahmadi-spmp` |
| Ariqah | `docs/ariqah-srs` |
| Fardina | `docs/fardina-sdd` |
| Rifqah | `design/rifqah-ui-ux` |
| Siti Mariati | `database/siti-database` |
| Rayhan | `feature/rayhan-development` |
| Silfi Kurnia | `test/silfi-qa` |

Nama branch di atas merupakan contoh. Buat branch berdasarkan tugas yang benar-benar sedang dikerjakan. Untuk pekerjaan yang berbeda, anggota dapat membuat branch baru.

## 2. Menambahkan Anggota sebagai Collaborator

Pemilik repository atau administrator menambahkan anggota tim agar mereka dapat mengakses repository bersama.

1. Buka repository CodeTutor di GitHub.
2. Masuk ke **Settings**.
3. Pilih **Collaborators** atau **Collaborators and teams** (nama menu dapat berbeda sesuai tampilan GitHub).
4. Klik **Add people**, kemudian cari username atau alamat email GitHub anggota.
5. Kirim undangan dan minta anggota menerima undangan tersebut.
6. Setelah akses aktif, anggota dapat melakukan clone, membuat branch, commit, dan push sesuai izin yang diberikan.

Setiap anggota sebaiknya menggunakan akun GitHub pribadi masing-masing. Jangan menggunakan satu akun bersama karena riwayat kontribusi akan sulit dibedakan.

## 3. Menyiapkan Branch `develop` (oleh Project Manager)

Jika branch `develop` belum tersedia, Project Manager dapat membuatnya dari `main`:

```bash
git switch main
git pull origin main
git switch -c develop
git push -u origin develop
```

Jika `develop` sudah tersedia di GitHub, anggota cukup mengambil pembaruannya:

```bash
git fetch origin
git switch develop
git pull origin develop
```

## 4. Alur Kerja Setiap Anggota

Setiap anggota mengikuti urutan berikut sebelum mulai mengerjakan tugas:

**Langkah 1 — Perbarui branch integrasi**

```bash
git switch develop
git pull origin develop
```

**Langkah 2 — Buat branch pekerjaan sendiri**

Contoh Rayhan mengerjakan fitur tertentu:

```bash
git switch -c feature/rayhan-code-lab
```

Contoh anggota dokumentasi:

```bash
git switch -c docs/ariqah-srs
```

**Langkah 3 — Kerjakan perubahan**

Ubah file sesuai pembagian tugas. Sebelum commit, periksa perubahan:

```bash
git status
git diff
```

**Langkah 4 — Simpan perubahan dengan commit**

```bash
git add .
git commit -m "feat: menambahkan fitur Code Lab"
```

Contoh pesan commit:

```text
feat: menambahkan fitur Code Lab
fix: memperbaiki validasi login
docs: memperbarui dokumen SRS
test: menambahkan skenario pengujian login
refactor: merapikan struktur controller
```

Gunakan awalan pesan commit yang sesuai:

- `feat:` untuk fitur baru.
- `fix:` untuk perbaikan bug.
- `docs:` untuk dokumentasi.
- `test:` untuk pengujian.
- `refactor:` untuk perapian struktur kode tanpa mengubah fungsi utama.
- `chore:` untuk pekerjaan pemeliharaan proyek.

**Langkah 5 — Kirim branch ke GitHub**

```bash
git push -u origin feature/rayhan-code-lab
```

Sesuaikan nama branch dengan branch yang sedang digunakan.

**Langkah 6 — Buat Pull Request (PR)**

1. Buka repository CodeTutor di GitHub.
2. Pilih menu **Pull requests**.
3. Klik **New pull request**.
4. Pilih `base: develop` dan `compare: branch-pekerjaan`.
5. Isi judul dan ringkasan perubahan.
6. Periksa bagian **Files changed**.
7. Minta Project Manager atau anggota yang ditunjuk untuk melakukan review.
8. Setelah disetujui dan tidak ada konflik, gabungkan (merge) PR ke `develop`.

Jangan mengirim pekerjaan langsung ke `main`. Gunakan Pull Request agar perubahan dapat ditinjau sebelum digabungkan.

## 5. Cara Mengambil Pembaruan Terbaru dari Anggota Lain

Lakukan langkah ini secara berkala, terutama sebelum mulai bekerja:

```bash
# 1. Pindah ke branch integrasi
git switch develop

# 2. Ambil pembaruan terbaru dari GitHub
git pull origin develop

# 3. Kembali ke branch pekerjaan sendiri
git switch feature/nama-branch-anda

# 4. Gabungkan pembaruan develop ke branch sendiri
git merge develop

# 5. Jika merge berhasil, kirim pembaruan branch ke GitHub
git push origin feature/nama-branch-anda
```

Ganti `feature/nama-branch-anda` dengan nama branch milik sendiri. Pastikan perubahan lokal sudah di-commit atau disimpan sebelum berpindah branch.

## 6. Jika Terjadi Merge Conflict

Konflik terjadi ketika perubahan pada bagian file yang sama tidak dapat digabungkan otomatis oleh Git.

1. Jalankan `git status` untuk melihat file yang konflik.
2. Buka file yang ditandai konflik.
3. Cari penanda `<<<<<<<`, `=======`, dan `>>>>>>>`.
4. Tentukan perubahan yang benar dan rapikan isi file. Hapus seluruh penanda konflik.
5. Jalankan pengujian yang relevan.
6. Tandai file sebagai selesai diperbaiki dan commit hasilnya:

```bash
git add nama-file-yang-diperbaiki
git commit -m "fix: menyelesaikan merge conflict"
git push
```

Jangan menghapus perubahan anggota lain tanpa berdiskusi terlebih dahulu.

## 7. Aturan Kolaborasi Tim

- Setiap anggota menggunakan akun GitHub masing-masing agar riwayat kontribusi tercatat atas nama kontributor yang benar.
- Setiap anggota hanya mengerjakan bagian yang telah dibagikan atau dikoordinasikan.
- Lakukan `git pull` sebelum mulai bekerja agar menggunakan kode terbaru.
- Gunakan branch pekerjaan; hindari mengubah `main` secara langsung.
- Buat commit dengan pesan yang jelas dan sesuai perubahan.
- Periksa perubahan sebelum membuat Pull Request.
- Beri tahu anggota lain apabila mengubah migration, model, konfigurasi, dependensi, atau file yang digunakan bersama.
- Jangan pernah mengunggah file `.env`, password, token, API key, atau kredensial hosting ke GitHub.

---

# Panduan Deployment ke codetutor.my.id

Panduan berikut adalah alur deployment Laravel secara umum. Langkah dan menu dapat berbeda bergantung pada penyedia hosting, apakah menggunakan cPanel/shared hosting atau VPS. Pastikan versi PHP dan ekstensi pada server sesuai dengan `composer.json` proyek.

## 1. Persiapan Hosting dan Domain

Pastikan tersedia:

- Hosting yang mendukung PHP, Laravel, Composer, dan MySQL.
- Akses ke File Manager atau SSH/Terminal.
- Database MySQL beserta username dan password.
- Domain `codetutor.my.id`.
- Sertifikat SSL untuk HTTPS.
- API key Gemini yang akan disimpan sebagai environment variable di server.

## 2. Arahkan Domain ke Hosting

Pada panel pengelolaan domain/DNS:

1. Atur nameserver sesuai petunjuk penyedia hosting, atau buat record DNS yang diberikan oleh penyedia hosting.
2. Arahkan record `A` untuk domain utama (`@`) ke alamat IP server hosting.
3. Atur `www` sebagai `CNAME` ke `codetutor.my.id` atau sesuai instruksi hosting.
4. Tunggu proses propagasi DNS dan periksa apakah domain sudah mengarah ke server yang benar.

Jangan menebak alamat IP DNS. Gunakan nilai yang diberikan penyedia hosting.

## 3. Siapkan Database Produksi

1. Buka panel database hosting.
2. Buat database MySQL baru.
3. Buat user database dan berikan hak akses yang diperlukan pada database tersebut.
4. Catat nama database, username, password, host, dan port untuk konfigurasi `.env`.
5. Simpan cadangan database sebelum melakukan migrasi pada aplikasi yang sudah memiliki data.

## 4. Unggah Source Code

Ambil source code dari branch `main` yang sudah ditinjau dan disetujui. Source code dapat diunggah melalui Git/SSH atau File Manager hosting.

Struktur yang disarankan:

```text
/home/USERNAME/
├── codetutor/              # Seluruh source code Laravel
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   └── .env
└── public_html/            # Document root hanya jika hosting mengharuskan lokasi ini
```

**PENTING:** Atur document root domain agar menunjuk ke folder `codetutor/public`, bukan ke folder utama proyek Laravel. Jangan membuka folder utama proyek ke internet karena dapat mengekspos file konfigurasi dan data sensitif. Jika hosting tidak mengizinkan pengaturan document root ke folder `public`, minta panduan resmi penyedia hosting sebelum menerapkan konfigurasi alternatif.

## 5. Instalasi Dependensi Produksi

Masuk ke direktori proyek melalui SSH/Terminal:

```bash
cd /home/USERNAME/codetutor
composer install --no-dev --optimize-autoloader
```

Jika aset frontend dibangun pada server dan Node.js tersedia:

```bash
npm ci
npm run build
```

Jika server tidak menyediakan Node.js, bangun aset pada komputer pengembang menggunakan `npm run build`, lalu unggah hasil build yang diperlukan sesuai struktur proyek.

## 6. Konfigurasi `.env` Produksi

Buat `.env` di server. Jangan menggunakan file `.env` lokal secara mentah jika berisi konfigurasi pengembangan.

Contoh nilai yang harus disesuaikan:

```env
APP_NAME=CodeTutor
APP_ENV=production
APP_DEBUG=false
APP_URL=https://codetutor.my.id

DB_CONNECTION=mysql
DB_HOST=HOST_DATABASE_DARI_HOSTING
DB_PORT=3306
DB_DATABASE=NAMA_DATABASE
DB_USERNAME=USERNAME_DATABASE
DB_PASSWORD=PASSWORD_DATABASE

GEMINI_API_KEY=API_KEY_GEMINI_PRODUKSI
```

Nama variabel Gemini harus mengikuti yang digunakan aplikasi. Isi nilai database dan API key berdasarkan informasi milik proyek/hosting. Jangan memasukkan nilai rahasia ke README atau repository.

Pastikan `APP_KEY` sudah terisi dan konsisten dengan aplikasi. Untuk deployment pertama, buat key jika memang belum ada. Untuk deployment pembaruan, pertahankan `APP_KEY` yang sudah digunakan aplikasi.

## 7. Jalankan Perintah Deployment Laravel

Setelah `.env` benar dan dependensi terpasang, jalankan:

```bash
php artisan migrate --force
php artisan storage:link
php artisan optimize
```

`php artisan migrate --force` menjalankan migrasi pada lingkungan produksi. Pastikan database sudah dicadangkan dan migrasi sudah diperiksa sebelum menjalankannya.

Pastikan proses web server memiliki izin tulis pada direktori `storage` dan `bootstrap/cache`. Jangan memberikan izin akses penuh `777` tanpa alasan yang benar.

## 8. Aktifkan SSL/HTTPS

1. Aktifkan sertifikat SSL melalui panel hosting atau penyedia sertifikat.
2. Pastikan sertifikat berlaku untuk `codetutor.my.id` dan, jika digunakan, `www.codetutor.my.id`.
3. Aktifkan pengalihan HTTP ke HTTPS sesuai fitur hosting/web server.
4. Pastikan `APP_URL` menggunakan `https://codetutor.my.id`.
5. Uji akses melalui browser dan pastikan tidak ada peringatan sertifikat.

## 9. Pemeriksaan Setelah Deployment

Lakukan pemeriksaan sekurang-kurangnya pada hal berikut:

- Halaman utama dapat diakses melalui `https://codetutor.my.id`.
- Login dan logout berjalan.
- Hak akses Admin, Instruktur, dan Pelajar sesuai peran.
- Dashboard dan materi pembelajaran dapat dibuka.
- Code Lab dapat digunakan sesuai konfigurasi layanan eksekusi kode.
- Evaluasi dapat dikerjakan dan hasilnya tersimpan.
- Chatbot AI dapat terhubung dengan Gemini API.
- Progres belajar dan sertifikat dapat diakses sesuai ketentuan.
- File gambar/dokumen yang diunggah dapat ditampilkan.
- Tidak ada error kritis pada log aplikasi.

Jika aplikasi memakai queue worker atau scheduler, konfigurasi layanan tersebut sesuai fitur yang benar-benar digunakan oleh proyek dan fasilitas hosting.

## 10. Pembaruan Aplikasi di Hosting

Setiap rilis baru sebaiknya berasal dari branch `main` yang sudah melalui review dan pengujian. Sebelum pembaruan:

1. Cadangkan database dan file penting.
2. Ambil source code versi terbaru dari branch `main`.
3. Pasang dependensi sesuai lock file.
4. Jalankan migrasi yang sudah diperiksa.
5. Bangun ulang aset frontend jika ada perubahan.
6. Jalankan optimasi Laravel.
7. Uji fitur utama setelah deployment.

Contoh jika deployment dilakukan melalui Git pada server:

```bash
git switch main
git pull origin main
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan optimize
```

Jalankan perintah npm hanya apabila Node.js dan npm tersedia pada server. Jika aset dibangun di komputer pengembang, unggah hasil build yang sesuai sebagai bagian dari rilis.

---

# Lisensi

Proyek CodeTutor menggunakan **MIT License**. Lisensi ini mengizinkan penggunaan, penyalinan, modifikasi, penggabungan, penerbitan, distribusi, sublicensing, dan penjualan salinan perangkat lunak, dengan tetap menyertakan pemberitahuan hak cipta dan izin.

Teks lengkap lisensi terdapat pada file [`LICENSE`](LICENSE).

> MIT License sebaiknya digunakan setelah seluruh anggota/pemegang hak proyek menyetujui pemberian izin tersebut. Lisensi proyek tidak menggantikan lisensi komponen pihak ketiga, ketentuan penggunaan Gemini API, maupun hak atas aset/font/gambar eksternal yang digunakan.

---

# Referensi dan Dokumentasi Resmi

1. Laravel Documentation – Installation: https://laravel.com/docs/installation
2. Laravel Documentation – Deployment: https://laravel.com/docs/deployment
3. Laravel Documentation – File Storage: https://laravel.com/docs/filesystem
4. GitHub Docs – About repositories: https://docs.github.com/en/repositories/creating-and-managing-repositories/about-repositories
5. GitHub Docs – About pull requests: https://docs.github.com/en/pull-requests/get-started/about-pull-requests
6. GitHub Docs – Managing branches: https://docs.github.com/en/repositories/configuring-branches-and-merges-in-your-repository/managing-branches-in-your-repository
7. GitHub Docs – Licensing a repository: https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/customizing-your-repository/licensing-a-repository
8. MIT License: https://opensource.org/license/mit

---

## Catatan Kontribusi

Sebelum mengirim perubahan, pastikan kode dapat dijalankan secara lokal, tidak menyertakan file rahasia, dan sudah diuji sesuai bagian yang diubah. Gunakan branch pekerjaan dan Pull Request ke `develop` agar perubahan dapat ditinjau oleh tim sebelum masuk ke branch rilis.
