const prestasi = {
    "id_prestasi": 1,
    "ekstrakurikuler_id": 1,
    "ketua_id": 1,
    "nama_siswa": ["Siswa 1", "Siswa 2", "Siswa 3"],
    "tahun_ajaran": "2023/2024",
    "berkas": "path/to/berkas.pdf",
    "status": "aktif",
    "created_at": "2023-07-17 12:00:00",
    "updated_at": "2023-07-17 12:00:00"
};

// Akses data
console.log(prestasi);
// Menampilkan daftar nama siswa dengan nomor urut
console.log('Nama Siswa:');
prestasi.nama_siswa.forEach((nama, index) => {
    console.log(`${index + 1}. ${nama}`);
})
