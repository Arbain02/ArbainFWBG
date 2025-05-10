**tabel users**.

---

## <p align="center" style="margin-top: 0;">SISTEM ADMINISTRASI SURAT DESA</p>

<p align="center">
  <img src="/public/LogoUnsulbar.png" width="300" alt="LogoUnsulbar" />
</p>

### <p align="center">ARB**AIN**</p>

### <p align="center">D0222041</p></br>

### <p align="center">MANAJEMEN BASIS DATA</p>

### <p align="center">2025</p>



## 🧑‍🤝‍🧑 Role dan Hak Akses

| Role          | Akses                                                                       |
| ------------- | --------------------------------------------------------------------------- |
| *Admin*       | Mengelola data pengguna, surat masuk, surat keluar, log aktivitas           |
| *Kepala Desa* | Melihat dan menandatangani surat keluar, memberi disposisi surat masuk      |
| *Staf Desa*   | Menambahkan surat masuk & keluar, mengunggah file, memperbarui status surat |



## 🗃 Struktur Database

### 1. Tabel `users`

| Field       | Tipe Data        | Keterangan                                            |
| ----------- | ---------------- | ----------------------------------------------------- |
| id          | bigint (PK)      | ID unik                                               |
| nama        | varchar          | Nama lengkap pengguna                                 |
| username    | varchar (unique) | Nama pengguna (login)                                 |
| password    | varchar          | Password terenkripsi                                  |
| role        | enum             | admin, kepala\_desa, staf\_desa (default: staf\_desa) |
| created\_at | timestamp        | Tanggal dibuat                                        |
| updated\_at | timestamp        | Tanggal update                                        |

### 2. Tabel `surat_masuk`

| Field           | Tipe Data   | Keterangan                            |
| --------------- | ----------- | ------------------------------------- |
| id              | bigint (PK) | ID surat masuk                        |
| nomor\_surat    | varchar     | Nomor surat dari pengirim             |
| tanggal\_surat  | date        | Tanggal surat dibuat oleh pengirim    |
| tanggal\_terima | date        | Tanggal diterima kantor desa          |
| pengirim        | varchar     | Asal instansi atau orang              |
| perihal         | varchar     | Ringkasan isi surat                   |
| file            | varchar     | Nama file PDF atau dokumen            |
| status          | varchar     | Status (baru, ditindaklanjuti, arsip) |
| disposisi       | text        | Arahan atau disposisi kepala desa     |
| created\_at     | timestamp   | Tanggal dibuat                        |
| updated\_at     | timestamp   | Tanggal update                        |

### 3. Tabel `surat_keluar`

| Field             | Tipe Data   | Keterangan                     |
| ----------------- | ----------- | ------------------------------ |
| id                | bigint (PK) | ID surat keluar                |
| nomor\_surat      | varchar     | Nomor surat yang dikeluarkan   |
| tanggal\_surat    | date        | Tanggal surat diterbitkan      |
| tujuan            | varchar     | Tujuan surat                   |
| perihal           | varchar     | Topik utama surat              |
| isi               | text        | Isi surat                      |
| file              | varchar     | File surat (PDF, DOCX, dll)    |
| status            | varchar     | draft, dikirim, ditandatangani |
| penandatangan\_id | bigint (FK) | User yang menandatangani surat |
| created\_at       | timestamp   | Tanggal dibuat                 |
| updated\_at       | timestamp   | Tanggal update                 |

### 4. Tabel `log_aktivitas`

| Field       | Tipe Data   | Keterangan                                |
| ----------- | ----------- | ----------------------------------------- |
| id          | bigint (PK) | ID log                                    |
| user\_id    | bigint (FK) | Relasi ke users                           |
| aktivitas   | varchar     | Deskripsi aktivitas (misal: upload surat) |
| tipe\_surat | varchar     | masuk / keluar                            |
| surat\_id   | bigint      | ID surat terkait (bisa masuk/keluar)      |
| created\_at | timestamp   | Tanggal log dibuat                        |
| updated\_at | timestamp   | Tanggal log diupdate                      |

---

## 🔗 Relasi Antar Tabel

| Tabel Asal     | Tabel Tujuan                 | Relasi        | Penjelasan                                     |
| -------------- | ---------------------------- | ------------- | ---------------------------------------------- |
| users          | surat\_keluar                | many-to-one   | Banyak surat keluar ditandatangani oleh 1 user |
| users          | log\_aktivitas               | one-to-many   | 1 user bisa melakukan banyak aktivitas         |
| log\_aktivitas | surat\_masuk / surat\_keluar | manual lookup | surat\_id bisa menunjuk ke dua jenis surat     |


