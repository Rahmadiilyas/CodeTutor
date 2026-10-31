
# Timeline dan Rencana Operasional Proyek CodeTutor

## 1. Pendahuluan

Dokumen ini berisi timeline dan rencana operasional pengembangan CodeTutor sebagai pedoman bagi Project Manager dan seluruh anggota tim dalam melaksanakan, mengoordinasikan, serta memantau setiap tahapan proyek.

Pengembangan CodeTutor menggunakan model Software Development Life Cycle (SDLC) Waterfall. Model ini memiliki tahapan pengembangan yang terstruktur dan berurutan, dimulai dari Planning, Analysis, Design, Implementation, Testing, Deployment, hingga Maintenance.

Periode pelaksanaan proyek direncanakan berlangsung pada 2 September sampai 15 Desember 2026.

## 2. Tujuan

Timeline dan rencana operasional ini disusun untuk:

1. Menetapkan jadwal pelaksanaan setiap tahapan proyek.
2. Menentukan tanggung jawab anggota tim.
3. Menjelaskan aktivitas dan hasil yang diharapkan.
4. Menjadi pedoman pemantauan perkembangan proyek.
5. Membantu Project Manager mengendalikan waktu, ruang lingkup, dan pelaksanaan pekerjaan.
6. Memastikan setiap tahapan menghasilkan keluaran yang menjadi dasar tahapan berikutnya.

## 3. Jadwal dan Pelaksanaan Proyek

### 3.1 Planning (Perencanaan)

Periode: 2–15 September 2026

Penanggung Jawab:
Rahmadi — Project Manager

Aktivitas:
- Mengidentifikasi permasalahan dan kebutuhan awal proyek.
- Menentukan tujuan dan sasaran pengguna sistem.
- Menetapkan ruang lingkup pengembangan CodeTutor.
- Menyusun struktur dan pembagian tanggung jawab tim.
- Mengidentifikasi kebutuhan sumber daya.
- Menyusun jadwal pelaksanaan proyek.
- Mengidentifikasi risiko awal pengembangan.

Hasil yang Diharapkan:
- Project Charter.
- Tujuan dan ruang lingkup proyek.
- Pembagian peran anggota tim.
- Jadwal dan rencana awal pengembangan.

### 3.2 Analysis (Analisis Kebutuhan)

Periode: 16–29 September 2026

Penanggung Jawab:
Ariqah — System Analyst

Aktivitas:
- Mengumpulkan kebutuhan pengguna Admin, Instruktur, dan Pelajar.
- Mengidentifikasi kebutuhan fungsional sistem.
- Mengidentifikasi kebutuhan nonfungsional sistem.
- Menganalisis hak akses setiap pengguna.
- Menganalisis aturan evaluasi dan pemantauan progres belajar.
- Menganalisis kebutuhan sertifikat pembelajaran.
- Menentukan batas integrasi Gemini dan Code Lab.
- Menyusun spesifikasi kebutuhan sistem.

Hasil yang Diharapkan:
- Dokumen Software Requirements Specification (SRS).
- Daftar kebutuhan fungsional dan nonfungsional.
- Dokumentasi kebutuhan setiap pengguna.

### 3.3 Design (Perancangan Sistem)

Periode: 30 September–27 Oktober 2026

Penanggung Jawab:
- Fardina — System Designer
- Rifqah — UI/UX Designer
- Siti Mariati — Database Designer

Aktivitas:

System Designer:
- Merancang arsitektur sistem.
- Membuat diagram sistem.
- Merancang alur pembelajaran.
- Menyusun rancangan teknis sistem.

UI/UX Designer:
- Merancang antarmuka pengguna.
- Membuat wireframe dan mockup.
- Menyusun prototipe tampilan sistem.
- Menyesuaikan desain dengan kebutuhan pengguna.

Database Designer:
- Merancang struktur basis data.
- Menentukan tabel dan atribut.
- Menyusun relasi antartabel.
- Membuat Entity Relationship Diagram (ERD).
- Menentukan aturan integritas data.

Hasil yang Diharapkan:
- Dokumen Software Design Description (SDD).
- Rancangan arsitektur dan diagram sistem.
- Wireframe dan mockup antarmuka.
- Prototipe sistem.
- Rancangan basis data dan ERD.
- Rancangan API dan kebutuhan teknis implementasi.

### 3.4 Implementation (Implementasi Sistem)

Periode: 28 Oktober–1 Desember 2026

Penanggung Jawab:
Rayhan — Frontend/Backend Developer

Aktivitas:
- Mengimplementasikan proses login dan autentikasi.
- Mengimplementasikan pengaturan hak akses pengguna.
- Mengembangkan pengelolaan akun Instruktur.
- Mengembangkan dashboard sistem.
- Mengimplementasikan pengelolaan bahasa pemrograman.
- Mengembangkan fitur materi dan modul pembelajaran.
- Mengembangkan pengelolaan media pembelajaran.
- Mengimplementasikan fitur evaluasi.
- Mengintegrasikan chatbot AI berbasis Gemini.
- Mengembangkan pengelolaan referensi jawaban chatbot.
- Mengimplementasikan Code Lab.
- Mengembangkan pemantauan progres belajar.
- Mengimplementasikan pencatatan aktivitas sistem.
- Mengembangkan fitur sertifikat pembelajaran.

Hasil yang Diharapkan:
- Fungsi utama CodeTutor berhasil diimplementasikan.
- Integrasi antarmodul dan basis data berjalan.
- Fitur sistem sesuai dengan kebutuhan dan rancangan yang telah ditetapkan.

### 3.5 Testing (Pengujian Sistem)

Periode: 2–11 Desember 2026

Penanggung Jawab:
Silfi Kurnia — Tester/QA

Pihak yang Terlibat:
Rayhan — Developer dan anggota tim terkait.

Aktivitas:
- Menyusun skenario pengujian.
- Melakukan pengujian integrasi sistem.
- Menguji alur pembelajaran pengguna.
- Menguji integrasi chatbot AI dan Code Lab.
- Memeriksa hak akses setiap pengguna.
- Menguji hasil evaluasi dan pemantauan progres.
- Menguji penerbitan dan akses sertifikat.
- Mencatat kesalahan atau bug yang ditemukan.
- Mengoordinasikan perbaikan kesalahan bersama developer.
- Melakukan pengujian ulang.
- Melaksanakan User Acceptance Testing (UAT) bersama perwakilan pengguna.

Catatan:
Pengujian fungsi juga dilakukan secara berkala selama implementasi untuk menemukan kesalahan lebih awal.

Hasil yang Diharapkan:
- Dokumentasi hasil pengujian.
- Daftar kesalahan dan perbaikan.
- Hasil pengujian ulang.
- Hasil User Acceptance Testing.
- Sistem teruji dan siap memasuki tahap deployment.

### 3.6 Deployment (Penerapan Sistem)

Tanggal: 12 Desember 2026

Koordinator:
Rahmadi — Project Manager

Pelaksana:
Tim pengembang sesuai tanggung jawab teknis.

Aktivitas:
- Memasang aplikasi CodeTutor pada hosting.
- Melakukan konfigurasi lingkungan produksi.
- Memeriksa koneksi aplikasi dan basis data.
- Memeriksa fungsi utama setelah pemasangan.
- Memastikan aplikasi dapat diakses melalui lingkungan produksi.

Hasil yang Diharapkan:
Aplikasi CodeTutor berhasil dipasang dan tersedia pada lingkungan produksi.

### 3.7 Maintenance (Pemeliharaan)

Tanggal: 13 Desember 2026

Koordinator:
Rahmadi — Project Manager

Pelaksana:
Tim pengembang dan anggota terkait.

Aktivitas:
- Melakukan pemantauan awal setelah deployment.
- Mengidentifikasi masalah pascapemasangan.
- Memperbaiki masalah apabila ditemukan.
- Melakukan pengujian ulang terhadap fungsi yang diperbaiki.
- Memastikan sistem berada dalam kondisi siap digunakan.

Hasil yang Diharapkan:
Aplikasi CodeTutor berada dalam kondisi siap digunakan setelah deployment.

### 3.8 Documentation (Dokumentasi Proyek)

Periode: 2 September–14 Desember 2026

Koordinator:
Rahmadi — Project Manager

Pihak yang Terlibat:
Seluruh anggota tim sesuai tanggung jawab masing-masing.

Aktivitas:
- Menyusun dan memperbarui dokumentasi kebutuhan sistem.
- Menyusun dokumen SRS dan SDD.
- Mendokumentasikan perkembangan implementasi.
- Mencatat hasil pengujian dan perbaikan sistem.
- Memperbarui catatan perkembangan proyek.
- Mengelola dokumentasi melalui repositori GitHub.

Hasil yang Diharapkan:
Dokumentasi proyek tersedia, tersusun, dan diperbarui sesuai perkembangan pekerjaan.

Catatan:
Dokumentasi merupakan aktivitas yang berjalan secara berkala selama pengembangan proyek, bukan hanya dilakukan pada tahap akhir.

### 3.9 Finalisasi dan Penyerahan Proyek

Tanggal: 15 Desember 2026

Penanggung Jawab:
Rahmadi — Project Manager

Pihak yang Terlibat:
Seluruh anggota tim.

Aktivitas:
- Memfinalisasi laporan proyek.
- Menyusun panduan penggunaan sistem.
- Menyusun panduan pemasangan sistem.
- Memeriksa kelengkapan dokumentasi.
- Mempersiapkan presentasi proyek.
- Mengoordinasikan penyerahan hasil pengembangan.

Hasil yang Diharapkan:
- Aplikasi CodeTutor selesai dikembangkan.
- Laporan akhir proyek tersedia.
- Panduan penggunaan dan pemasangan tersedia.
- Seluruh hasil proyek siap diserahkan.

## 4. Mekanisme Pemantauan oleh Project Manager

Project Manager melakukan pemantauan terhadap pelaksanaan proyek melalui beberapa kegiatan berikut:

1. Memeriksa kesesuaian pekerjaan dengan jadwal yang telah ditetapkan.
2. Memantau perkembangan tugas setiap anggota.
3. Memastikan setiap anggota menjalankan tanggung jawabnya.
4. Mencatat kendala dan risiko selama pengembangan.
5. Mengoordinasikan penyelesaian kendala bersama anggota terkait.
6. Memeriksa hasil pekerjaan sebelum dilanjutkan ke tahapan berikutnya.
7. Memastikan dokumentasi proyek diperbarui secara berkala.

## 5. Pengendalian Perubahan dan Kendala

Apabila terdapat perubahan kebutuhan, keterlambatan pekerjaan, atau kendala teknis, Project Manager melakukan langkah berikut:

1. Mengidentifikasi permasalahan yang terjadi.
2. Mencatat dampak permasalahan terhadap pekerjaan dan jadwal.
3. Berkoordinasi dengan anggota yang bertanggung jawab.
4. Menentukan tindakan perbaikan bersama tim.
5. Memperbarui dokumentasi dan status pekerjaan apabila terdapat perubahan yang disepakati.

Setiap perubahan terhadap ruang lingkup dan jadwal proyek perlu dikomunikasikan serta disepakati oleh tim.

## 6. Ketentuan Pembaruan Status

Status setiap tahapan diperbarui berdasarkan kondisi pekerjaan yang sebenarnya.

Status yang digunakan:

- Belum Dimulai
- Sedang Dikerjakan
- Dalam Peninjauan
- Selesai
- Tertunda

Project Manager bertanggung jawab memastikan informasi perkembangan proyek tetap sesuai dengan kondisi aktual.

## 7. Penutup

Timeline dan rencana operasional ini menjadi pedoman pelaksanaan serta pengendalian pengembangan CodeTutor.

Seluruh anggota tim diharapkan menjalankan tanggung jawab sesuai pembagian peran, memperhatikan jadwal yang telah ditetapkan, dan melaporkan perkembangan pekerjaan kepada Project Manager.

Melalui perencanaan dan pemantauan yang terstruktur, pengembangan CodeTutor diharapkan dapat diselesaikan sesuai ruang lingkup, jadwal, dan tujuan proyek.
