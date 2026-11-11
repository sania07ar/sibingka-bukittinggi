/**
 * SiMonDa Bukittinggi - Master Table Catalogs & Title Resolver
 * BPS Kota Bukittinggi
 * Sinkron 100% dengan Katalog Resmi Daerah Dalam Angka (OPD & Instansi Vertikal)
 */

const opdTablesCatalog = {
    '01': [
        { code: '1.1.6', title: 'Nama Sungai/Batang, Lebar dan Kecamatan yang Dilalui di Kota Bukittinggi', titleEn: 'Name of River, Width and Subdistrict Passed Through in Bukittinggi Municipality' },
        { code: '8.1.1', title: 'Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi', titleEn: 'Length of Roads by Level of Government Authority in Bukittinggi Municipality' },
        { code: '8.1.2', title: 'Panjang Jalan Menurut Jenis Permukaan Jalan di Kota Bukittinggi (km)', titleEn: 'Length of Roads by Type of Road Surface in Bukittinggi Municipality (km)' },
        { code: '8.1.3', title: 'Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km)', titleEn: 'Length of Roads by Road Condition in Bukittinggi Municipality (km)' },
        { code: '8.1.4', title: 'Banyak dan Panjang Jembatan, Panjang Trotoar Kota Bukittinggi', titleEn: 'Number and Length of Bridge, Length of Sidewalk in Bukittinggi' },
        { code: '8.1.5', title: 'Panjang Gorong-Gorong dan Panjang Drainase di Kota Bukittinggi', titleEn: 'Length of Culverts and Length of Drainage in Bukittinggi Municipality' }
    ],
    '02': [
        { code: '1.1.10', title: 'Jumlah IMB/PBG yang Dikeluarkan Dinas Penanaman Modal PTSP Kota Bukittinggi Menurut Klasifikasinya di Kota Bukittinggi', titleEn: 'Number of Building Approvals (IMB/PBG) Issued by Investment and One-Stop Integrated Services of Bukittinggi Municipality by Classification' },
        { code: '11.2', title: 'Jumlah Nomor Induk Berusaha (NIB) yang Dikeluarkan Menurut Sektor di Kota Bukittinggi', titleEn: 'Number of Business Identification Numbers (NIB) Issued by Sector in Bukittinggi Municipality' },
        { code: '11.3', title: 'Jumlah Nomor Izin Berusaha (NIB) yang Dikeluarkan per Bulan di Kota Bukittinggiin Bukittinggi Municipality', titleEn: 'Number of Business Identification Numbers (NIB) Issued by Month in Bukittinggi Municipality' },
        { code: '11.4', title: 'Jumlah Nomor Induk Berusaha (NIB) yang Dikeluarkan Menurut Sektor di Kota Bukittinggi', titleEn: 'Number of Business Identification Numbers (NIB) Issued by Sector in Bukittinggi Municipality' }
    ],
    '03': [
        { code: '2.2.5', title: 'Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi', titleEn: 'Decrees and Results of Regional House of Representatives Working Meetings in Bukittinggi Municipality' }
    ],
    '04': [
        { code: '2.3.1', title: 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Jabatan, Jenis ASN, dan Jenis Kelamin (orang)', titleEn: 'Number of State Civil Apparatus (ASN) of Bukittinggi Municipal Government by Occupation, Type of ASN, and Sex' },
        { code: '2.3.2', title: 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Tingkat Pendidikan, Jenis ASN, dan Jenis Kelamin (orang)', titleEn: 'Number of Civil Servant of Bukittinggi Municipal Government by Educational Level, Type of ASN, and Sex (people)' },
        { code: '2.3.3', title: 'Jumlah Pegawai Negeri Sipil Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang)', titleEn: 'Number of Bukittinggi Municipality Government’s Civil Servants by Hierarchy and Sex (people)' },
        { code: '2.3.4', title: 'Jumlah Pegawai Pemerintah dengan Perjanjian Kerja Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang)', titleEn: 'Number of Bukittinggi Municipal Government’s Civil servants with employment agreements by Hierarchy and Sex (people)' },
        { code: '2.3.5', title: 'Banyak Aparatur Sipil Negara di Lingkungan Pemerintah Kota Bukittinggi Menurut Unit Kerja di Kota Bukittinggi', titleEn: 'Number of Civil Servants in Local Government of Bukittinggi Municipality' }
    ],
    '05': [
        { code: '2.4.1', title: 'Realisasi Pendapatan Pemerintah Kota Bukittinggi Menurut Jenis Pendapatan (Juta rupiah)', titleEn: 'Actual Bukittinggi Municipal Government Revenues by Kind of Revenues (thousand rupiahs)' },
        { code: '2.4.2', title: 'Realisasi Belanja Pemerintah Kota Bukittinggi Menurut Jenis Belanja (Juta rupiah)', titleEn: 'Actual Bukittinggi Municipal Government Expenditures by Kind of Expenditures (million rupiah)' },
        { code: '2.4.3', title: 'Realisasi Pembiayaan Pemerintah Daerah Kota Bukittinggi', titleEn: 'Realization of Bukittinggi Local Government Cost Budgeting' },
        { code: '2.4.4', title: 'Perkembangan Pendapatan Asli Daerah di Kota Bukittinggi', titleEn: 'Regional Real Receipt Budget in Bukittinggi' },
        { code: '2.4.5', title: 'Realisasi Pembiayaan Pemerintah Daerah Kota Bukittinggi', titleEn: 'Realization of Bukittinggi Local Government Cost Budgeting' }             
    ],
    '06': [
        { code: '3.1.1', title: 'Jumlah Penduduk, Laju Pertumbuhan Penduduk, Distribusi Persentase Penduduk, Kepadatan Penduduk, Rasio Jenis Kelamin Penduduk Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Population, Population Growth Rate, Percentage Distribution of Population, Population Density, and Population Sex Ratio by District in Bukittinggi Municipality' },
        { code: '3.1.2', title: 'Penduduk Menurut Golongan Umur dan Jenis Kelamin di Kota Bukittinggi', titleEn: 'Population by Age Group and Sex in Bukittinggi Municipality' },
        { code: '3.1.8', title: 'Jumlah Penduduk Wajib KTP (Kartu Tanda Penduduk) dan yang Telah Memiliki KTP dirinci Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Population Owner Identity Card and Be Possessed Identity Card Already by District in Bukittinggi Municipality' },
        { code: '4.3.1', title: 'Jumlah Penduduk Menurut Agama yang Dianut di Kota Bukittinggi', titleEn: 'Number of Population by Religion in Bukittinggi' }
    ],
    '07': [
        { code: '3.2.8', title: 'Jumlah Pencari Kerja yang Terdaftar Menurut Tingkat Pendidikan yang Ditamatkan di Kota Bukittinggi', titleEn: 'Number of Job Seeker Registered by Educational Attainment in Bukittinggi Municipality' },
        { code: '9.1', title: 'Jumlah Koperasi Aktif Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Active Cooperative in Bukittinggi Municipality' },
        { code: '9.2', title: 'Jumlah Koperasi Menurut Jenis Koperasi dan Kecamatan di Kota Bukittinggi', titleEn: 'Number of Cooperative by Kind of Cooperative and Subdistrict in Bukittinggi Municipality' },
        { code: '9.3', title: 'Perkembangan Koperasi Dirinci Menurut Anggota, Simpanan dan Volume Usaha di Kota Bukittinggi', titleEn: 'Growth of Cooperative by Member, Deposite and Omset in Bukittinggi' },
        { code: '9.4', title: 'Jumlah Koperasi Menurut Jenisnya per Kecamatan di Kota Bukittinggi', titleEn: 'Number of Cooperation by Kind in District in Bukittinggi' }
    ],
    '08': [
        { code: '4.1.1', title: 'Jumlah Sekolah, Guru, dan Murid Taman Kanak–Kanak (TK) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Kindergarten Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality' },
        { code: '4.1.3', title: 'Jumlah Sekolah, Guru, dan Murid Sekolah Dasar (SD) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Primary Schools Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality' },
        { code: '4.1.4', title: 'Jumlah Sekolah, Guru, dan Murid Madrasah Ibtidaiyah (MI) Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Madrasah Ibtidaiyah (MI) by District in Bukittinggi Municipality' },
        { code: '4.1.5', title: 'Jumlah Sekolah, Guru, dan Murid Sekolah Menengah Pertama (SMP) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Junior High Schools Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality' },
        { code: '4.1.15', title: 'Jumlah Sekolah, Guru, dan Murid Kelompok Bermain (KB) di Bawah Kementerian Pendidikan dan Kebudayaan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Playgroup Under The Ministry of Education, Culture, Research, and Technology by Subistrict in Bukittinggi Municipality' },
        { code: '4.1.16', title: 'Jumlah Sekolah, Guru, dan Murid Taman Penitipan Anak (TPA) di Bawah Kementerian Pendidikan dan Kebudayaan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Day Care Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality' },
        { code: '4.1.17', title: 'Jumlah Sekolah, Guru, dan Murid Satuan PAUD Sejenis (SPS) di Bawah Kementerian Pendidikan dan Kebudayaan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Satuan PAUD Sejenis (SPS) Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality' }
    ],
    '09': [
        { code: '4.3.4', title: 'Jumlah Kejadian Bencana Alam di Kota Bukittinggi Menurut Kecamatan', titleEn: 'Number of Natural Disasters in Bukittinggi Municipality by District' }
    ],
    '10': [
        { code: '4.1.20', title: 'Jumlah Klub/Persatuan Olahraga di Kota Bukittinggi', titleEn: 'Number of Sport Club in Bukittinggi' }
    ],
    '11': [
        { code: '4.1.24', title: 'Jumlah Lembaga Perpustakaan, Koleksi, dan Pengunjung Perpustakaan di Kota Bukittinggi', titleEn: 'Number of Library Institutions, Collections, and Library Visitors in the City of Bukittinggi' }
    ],
    '12': [
        { code: '4.2.2', title: 'Jumlah Tenaga Kesehatan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Health Human Resources by District in Bukittinggi Municipality' },
        { code: '4.2.3', title: 'Jumlah Rumah Sakit Umum, Rumah Sakit Khusus, dan Puskesmas Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of General Hospital, Specialized Hospital, dan Public Health Center by District in Bukittinggi' },
        { code: '4.2.4', title: 'Jumlah Tempat Tidur Pada Rumah Sakit Pemerintah dan Swasta di Kota Bukittinggi', titleEn: 'Number of Beds at Government and Private Hospital in Bukittinggi' },
        { code: '4.2.5', title: 'Jumlah Pengunjung Pada Rumah Sakit Pemerintah dan Swasta di Kota Bukittinggi', titleEn: 'Number of Visitor at Hospital Government and Private in Bukittinggi' },
        { code: '4.2.6', title: 'Jumlah Kasus Penyakit Terbanyak di Kota Bukittinggi', titleEn: 'Number of Most Desease Case in Bukittinggi' },
        { code: '4.2.7', title: 'Banyak Lahir Hidup, lahir Mati, dan Kematian Ibu Sewaktu Melahirkan di Kota Bukittinggi', titleEn: 'Number of Abortion and Maternal Deaths at Child Birth in Bukittinggi' },
        { code: '4.2.9', title: 'Jumlah Dokter Praktek Menurut Keahlian di Kota Bukittinggi', titleEn: 'Number of Physicians by Profession in Bukittinggi' },
        { code: '4.2.10', title: 'Jumlah Kunjungan dan Rata–rata Kunjungan per Hari pada Puskesmas Kota Bukittinggi di Kota Bukittinggi', titleEn: 'Number of Attendence and Average Daily Attendence to puskesmas in Bukittinggi Municipality in Bukittinggi' }
    ],
    '13': [
        { code: '4.2.12', title: 'Perkiraan Rata–rata Timbunan Sampah dan Volume Sampah yang Terangkut per Hari Setiap Bulan di Kota Bukittinggi', titleEn: 'Number of Rubbish Heap and Volume of Rubbish Carry Out by Day Every Month in Bukittinggi' },
        { code: '4.2.13', title: 'Persentase Komposisi Sampah di Kota Bukittinggi', titleEn: 'Number of Rubish Composition in Bukittinggi' },
        { code: '4.2.14', title: 'Rata–rata Timbunan Sampah yang Terangkut menurut Sumbernya di Kota Bukittinggi', titleEn: 'Rubbish Which is Carried by Source of Rubbish in Bukittinggi' },
        { code: '4.2.15', title: 'Jumlah Personil dan Sarana Kebersihan dan Pertamanan di Kota Bukittinggi', titleEn: 'Number of Personal, Tools and Equipment Cleanners in Bukittinggi' },              
        { code: '4.2.16', title: 'Jumlah Timbunan dan Volume Sampah yang Diangkut di Kota Bukittinggi', titleEn: 'Rubbish Which is Carried by Source of Rubbish in Bukittinggi' }
    ],
    '14': [
        { code: '4.2.17', title: 'Jumlah Akseptor Aktif Keluarga Berencana Menurut Alat Kontrasepsi di Kota Bukittinggi', titleEn: 'Number of Family Planning Acceptors by Contraception in Bukittinggi' },
        { code: '4.2.18', title: 'Jumlah PPKBD, Kelompok UPPKS, PLKB dan CU Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of PPKBD, UPPKS Society, PLKB and CU by District in Bukittinggi' },
        { code: '4.2.19', title: 'Jumlah Klinik dan Tenaga Medis Keluarga Berencana di Kota Bukittinggi', titleEn: 'Number of Clinics and Medical Personal of Family Planning in Bukittinggi' },
        { code: '4.2.20', title: 'Target dan Realisasi Keluarga Berencana di Kota Bukittinggi', titleEn: 'Target and Realization of Family Planning in Bukittinggi' }
    ],
    '15': [
        { code: '4.3.5', title: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Bulan', titleEn: 'Number of Fire Incident in Bukittinggi Municipality by Month' },
        { code: '4.3.6', title: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Tempat Kejadian', titleEn: 'Number of Fire Incident in Bukittinggi Municipality by incident Scene' },
        { code: '4.3.7', title: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Penyebab Kebakaran', titleEn: 'Number of Fire Incident in Bukittinggi Municipality by Fire Cause' },
        { code: '4.3.8', title: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Nilai Kerugian Akibat Kebakaran', titleEn: 'Number of Fire Incident in Bukittinggi Municipality by Value of Losses Due to Fire' }
    ],
    '16': [
        { code: '4.3.13', title: 'Jumlah Pekerja Sosial Masyarakat, Karang Taruna, Tenaga Kerja Sosial dan Organisasi Sosial di Kota Bukittinggi', titleEn: 'Number of Public Social Officers, Youth Club, Social Workers and Social Organization in Bukittinggi' },
        { code: '4.3.14', title: 'Jumlah Penyandang Disabilitas, Anak Terlantar dan Lanjut Usia Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Disable People, Homeless Child, and Old Age Person by District in Bukittinggi' },   
        { code: '4.3.15', title: 'Jumlah Orang terlantar, Bekas Narapidana, Penyandang Disabilitas dan Penghuni Panti Asuhan yang Dibantu di Kota Bukittinggi', titleEn: 'Number of Homeless People, Ex Prisoner, Disable People, Refective Person in Bukittinggi' }
    ],
    '17': [
        { code: '5.1.15', title: 'Luas Areal Sawah Menurut jenis Pengairan per Kecamatan di Kota Bukittinggi', titleEn: 'Plantation Area by Type of irigation by District in Bukittinggi' },
        { code: '5.1.16', title: 'Target dan realisasi Intensifikasi Palawija per Kecamatan di Kota Bukittinggi', titleEn: 'Target and Realization of Intensification Food Crops by District in Bukittinggi' },
        { code: '5.1.17', title: 'Target dan realisasi Intensifikasi Sayur–Sayuran per Kecamatan di Kota Bukittinggi', titleEn: 'Target and Realization of Intensification vegetables by District in Bukittinggi' },
        { code: '5.1.18', title: 'Realisasi Pupuk di Kota Bukittinggi', titleEn: 'Realization of Fertilizer in Bukittinggi' },
        { code: '5.1.19', title: 'Jumlah Pengadaan Peralatan Pemberantasan Hama Penyakit Tanaman Menurut Jenisnya per Kecamatan di Kota Bukittinggi', titleEn: 'Number of Pest Control Machinery Procurement by District in Bukittinggi' },
        { code: '5.2.1', title: 'Luas Areal Tanaman Perkebunan Menurut Kecamatan dan Jenis Tanaman di Kota Bukittinggi (ha)', titleEn: 'Planted Area of Estate Crops by District and Types of Crops in Bukittinggi Municipality (ha)' },
        { code: '5.2.2', title: 'Produksi Perkebunan Menurut Kecamatan dan Jenis Tanaman di Kota Bukittinggi (Ribu ton)', titleEn: 'Production of Estate Crops by District and Types of Crops in Bukittinggi Municipality (Thousands ton)' },
        { code: '5.2.3', title: 'Luas Areal Tanaman Perkebunan Rakyat Menurut Jenis Tanaman di Kota Bukittinggi (ha)', titleEn: 'Area of Smallholder by Types of Crops in Bukittinggi Municipality (ha)' },
        { code: '5.2.4', title: 'Produksi Tanaman Perkebunan Rakyat Menurut Jenis Tanaman di Kota Bukittinggi (ton)', titleEn: 'Production of Smallholder by Types of Crops in Bukittinggi Municipality (ton)' },
        { code: '5.3.1', title: 'Jumlah Ternak dan Unggas Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Livestock and Poultry by District in Bukittinggi' },
        { code: '5.3.2', title: 'Jumlah Pemotongan Ternak Menurut Jenis Ternak di Kota Bukittinggi', titleEn: 'Number of Registered Slughtered Livestock by District in Bukittinggi' },
        { code: '5.3.3', title: 'Jumlah Produksi Daging Menurut Jenis Ternak di Kota Bukittinggi (Ton)', titleEn: 'Number Production of Livestock by Kind (Ton) in Bukittinggi' },
        { code: '5.3.4', title: 'Jumlah Produksi Daging Unggas di Kota Bukittinggi (Ton)', titleEn: 'Number Production of Poultry (Ton) in Bukittinggi' },
        { code: '5.3.5', title: 'Jumlah Vaksinasi Ternak di Kota Bukittinggi', titleEn: 'Number of Cattle Vaccination in Bukittinggi' },
        { code: '5.3.6', title: 'Produksi Susu Sapi di Kota Bukittinggi (Liter)', titleEn: 'Production of Cow Milk (litre) in Bukittinggi' },
        { code: '5.3.7', title: 'Jumlah Produksi Telur Menurut Kecamatan di Kota Bukittinggi (Kg)', titleEn: 'Production of poultry Egg by District (Kg) in Bukittinggi Municipality' },
        { code: '5.4.1', title: 'Jumlah Ikan yang Diperdagangkan Menurut Kecamatan di Kota Bukittinggi (Ton)', titleEn: 'Number of Fish Trading by District (Ton) in Bukittinggi Municipality' },
        { code: '5.4.2', title: 'Jumlah Petani Ikan Darat Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Fresh Water Fish Farmers by District in Bukittinggi Municipality' },
        { code: '5.4.3', title: 'Luas Areal Pemeliharaan Ikan Darat per Kecamatan di Kota Bukittinggi (Ha)', titleEn: 'Fresh Water Fishery Area by District (Ha) in Bukittinggi Municipality' },
        { code: '5.4.4', title: 'Produksi Ikan Darat per Kecamatan di Kota Bukittinggi (Ha)', titleEn: 'Production of Fresh Water Fish (Ton) in Bukittinggi Municipality' },
        { code: '9.11', title: 'Harga Komoditi Perkebunan di Pasar Bukittinggi', titleEn: 'Market Prices in Bukittinggi' }
    ],
    '18': [
        { code: '6.5', title: 'Jumlah Perusahaan dan Tenaga Kerja yang Terdaftar pada Industri Kecil Makanan dan Minuman di Kota Bukittinggi', titleEn: 'Number of Companies and Man Power at Small Scale Industrial of Food and Beverages in Bukittinggi' },
        { code: '6.6', title: 'Jumlah Perusahaan dan tenaga Kerja yang Terdaftar pada Industri Kecil Sandang dan Kulit di Kota Bukittinggi', titleEn: 'Number of Companies and Man Power at Small Scale Industrial of Food and Beverages in Bukittinggi' },
        { code: '6.7', title: 'Jumlah Perusahaan dan tenaga Kerja yang Terdaftar pada Industri Kecil Lainnya di Kota Bukittinggi', titleEn: 'Number of Companies and Man Power at Small Scale Industrial of Other in Bukittinggi' },
        { code: '6.8', title: 'Jumlah Perusahaan dan tenaga Kerja yang Terdaftar pada Industri Kecil Lainnya di Kota Bukittinggi', titleEn: 'Number of Companies and Man Power at Small Scale Industrial of Metals, Chemical Products and Other Crafts in Bukittinggi' },
        { code: '11.1', title: 'Jumlah Sarana Perdagangan Menurut Jenisnya di Kota Bukittinggi', titleEn: 'Number of Trading Facilities by Type of Facility in Bukittinggi Municipality' }
    ],
    '19': [
        { code: '7.1', title: 'Jumlah Rumah Makan, Restoran dan Cafe di Kota Bukittinggi', titleEn: 'Number of Restaurants and Cafe in Bukittinggi Municipality' },
        { code: '7.3', title: 'Jumlah Pengunjung & Hasil Penjualan Karcis Taman Margasatwa dan Budaya Kinantan di Kota Bukittinggi', titleEn: 'Number of Visitor and Result of Ticket Sold of Taman Margasatwa dan Budaya Kinantan in Bukittinggi' },
        { code: '7.4', title: 'Jumlah Pengunjung & Hasil Penjualan Karcis Taman Panorama Lobang Jepang di Kota Bukittinggi', titleEn: 'Number of Visitor and Result of Ticket Sold of Taman Panorama Lobang Jepang in Bukittinggi' },
        { code: '7.5', title: 'Jumlah Wisatawan Asing Berkunjung ke Bukittinggi Menurut Kebangsaan di Kota Bukittinggi', titleEn: 'Number of Foreign Tourist Visiting to Bukittinggi by Nationality in Bukittinggi' }
    ],
    '20': [
        { code: '8.1.6', title: 'Jumlah Mobil Penumpang Menurut Jenisnya di Kota Bukittinggi', titleEn: 'Number of Passenger’s Car by Kind of Vehicles in Bukittinggi' },
        { code: '8.1.7', title: 'Jumlah Kendaraan Wajib Uji Dalam Daerah Kota Bukittinggi', titleEn: 'Number of Vehicles Compulsory Test in Bukittinggi Municipality' },
        { code: '8.1.8', title: 'Jumlah Kendaraan Tidak Bermotor di Kota Bukittinggi', titleEn: 'Number of Non Engine Vehicles in Bukittinggi' },
        { code: '8.1.9', title: 'Jumlah Terminal/Pangkalan, Luas dan Daya Tampung Terminal di Kota Bukittinggi', titleEn: 'Number of Terminal, Wide and Capacity in Bukittinggi' }
    ]
};

const instansiTablesCatalog = {
    '01': [
        { code: '1.1.8', title: 'Jumlah Pembuatan Sertifikat Menurut Jenis Kepemilikan di Kota Bukittinggi', titleEn: 'Number Of Certificate by type of ownersip in Bukittinggi' },
        { code: '1.1.9', title: 'Jumlah Pencatatan Peralihan Hak Menurut Jenis Kepemilikan di Kota Bukittinggi', titleEn: 'Number of changes Right Note by Owner in Bukittinggi' }
    ],
    '02': [
        { code: '2.2.1', title: 'Jumlah Anggota Dewan Perwakilan Rakyat Menurut Partai Politik dan Jenis Kelamin di Kota Bukittinggi (orang)', titleEn: 'Number of Regional House of Representative’s Member by Political and Sex in Bukittinggi Municipality (people)' },
        { code: '2.2.2', title: 'Jumlah Anggota Dewan Perwakilan Rakyat Menurut Partai Politik dan Tingkat Pendidikan di Kota Bukittinggi', titleEn: 'Number of Regional House of Representative’s Member by Political and Education in Bukittinggi Municipality' },
        { code: '2.2.3', title: 'Jumlah Anggota Dewan Perwakilan Rakyat Menurut Partai Politik dan Agama di Kota Bukittinggi', titleEn: 'Number of Regional House of Representative’s Member by Political and Religion in Bukittinggi Municipality' }
    ],
    '03': [
        { code: '4.1.2', title: 'Jumlah Sekolah, Guru, dan Murid Raudatul Athfal (RA) di Bawah Kementerian Agama Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Kindergarten Under The Ministry of Religious Affairs by District in Bukittinggi Municipality' },
        { code: '4.1.4', title: 'Jumlah Sekolah, Guru, dan Murid Madrasah Ibtidaiyah (MI) di Bawah Kementerian Agama Menurut Kecamatan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Madrasah Ibtidaiyah (MI) Under The Ministry of Religious Affairs by District in Bukittinggi Municipality' },
        { code: '4.1.6', title: 'Jumlah Sekolah, Guru, dan Murid Madrasah Tsanawiyah (MTs) di Bawah Kementerian Agama Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Madrasah Tsanawiyah (MTs) Under The Ministry of Religious Affairs by Sub District in Bukittinggi Municipality' },
        { code: '4.1.9', title: 'Jumlah Sekolah, Guru, dan Murid Madrasah Aliyah (MA) di Bawah Kementerian Agama Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Madrasah Aliyah (MA) Under the Ministry of Religious Affairs by District in Bukittinggi Municipality' },
        { code: '4.1.10', title: 'Jumlah Sekolah, Guru, dan Murid Pondok Pesantren Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Islamic Boarding School by Subdistrict in Bukittinggi Municipality' },
        { code: '4.3.2', title: 'Jumlah Tempat Peribadatan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Prayer Houses by Religion of District in Bukittinggi Municipality' },
        { code: '4.3.9', title: 'Jumlah Nikah Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Marriage by District in Bukittinggi Municipality' },
        { code: '4.3.10', title: 'Jumlah Jemaah Haji Menurut Jenis Pekerjaan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Moeslem Pilgrims by Occupation of District in Bukittinggi' },
        { code: '4.3.11', title: 'Jumlah Jemaah Haji Menurut Jenis Pendidikan per Kecamatan di Kota Bukittinggi', titleEn: 'Number of Moeslem Pilgrims by Education Atteinment of District in Bukittinggi' },               
        { code: '4.3.12', title: 'Jumlah Jemaah Haji Menurut Golongan Umur dan Jenis Kelamin per Kecamatan di Kota Bukittinggi', titleEn: 'Number of Moeslem Pilgrims by Age Group and Sex of District in Bukittinggi' }
    ],
    '04': [
        { code: '4.1.7', title: 'Jumlah Sekolah, Guru, dan Murid Sekolah Menengah Atas (SMA) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Senior High Schools Under The Ministry of Education, Culture, Research, and Technology by Sub District in Bukittinggi Municipality' },
        { code: '4.1.8', title: 'Jumlah Sekolah, Guru, dan Murid Sekolah Menengah Kejuruan (SMK) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Teachers, and Pupils in Vocational High Schools Under The Ministry of Education, Culture, Research, and Technology by Sub District in Bukittinggi Municipality' }
    ],
    '05': [
        { code: '4.1.18', title: 'Jumlah Dosen di Fakultas PGSD UNP Belakang Balok', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas PGSD UNP Belakang Balok', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '06': [
        { code: '4.1.18', title: 'Jumlah Dosen di Fakultas Psikologi UNP Belakang Balok', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Psikologi UNP Belakang Balok', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '07': [
        { code: '4.1.18', title: 'Jumlah Dosen di Fakultas Kedokteran UNP Belakang Balok', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Kedokteran UNP Belakang Balok', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '08': [
        { code: '4.1.18', title: 'Jumlah Dosen di POLTEKES Depkes Prodi Akbid Belakang Balok', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan POLTEKES Depkes Prodi Akbid Belakang Balok', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '09': [
        { code: '4.1.18', title: 'Jumlah Dosen di POLTEKES Depkes Jurusan Keperawatan Gigi', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan POLTEKES Depkes Jurusan Keperawatan Gigi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '10': [
        { code: '4.1.18', title: 'Jumlah Dosen di STKIP Ahlussunah', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan STKIP Ahlussunah', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '11': [
        { code: '4.1.18', title: 'Jumlah Dosen di STIT Ahlussunah', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan STIT Ahlussunah', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '12': [
        { code: '4.1.18', title: 'Jumlah Dosen di Universitas Perintis Indonesia', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Universitas Perintis Indonesia', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '13': [
        { code: '4.1.18', title: 'Jumlah Dosen di Universitas Prima Nusantara', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan STIKES Prima Nusantara', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '14': [
        { code: '4.1.18', title: 'Jumlah Dosen di Univ Moh. Nasir Yarsi Bukittinggi', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Univ Moh. Nasir Yarsi Bukittinggi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '15': [
        { code: '4.1.18', title: 'Jumlah Dosen di STIE, STBA, Akuntansi, Pertanian Agus Salim', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan STIE, STBA, Akuntansi, Pertanian Agus Salim', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '16': [
        { code: '4.1.18', title: 'Jumlah Dosen Fakultas Teknik Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Teknik Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '17': [
        { code: '4.1.18', title: 'Jumlah Dosen Fakultas Hukum Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Hukum Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '18': [
        { code: '4.1.18', title: 'Jumlah Dosen Fakultas Pariwisata Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Pariwisata Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '19': [
        { code: '4.1.18', title: 'Jumlah Dosen Fakultas Kesehatan Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Kesehatan Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '20': [
        { code: '4.1.18', title: 'Jumlah Dosen di Akademi Farmasi Imam Bonjol', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Akademi Farmasi Imam Bonjol', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '21': [
        { code: '4.1.18', title: 'Jumlah Dosen di Universitas Ford de Kock', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Universitas Ford de Kock', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '22': [
        { code: '4.1.18', title: 'Jumlah Dosen di Akademi Farmasi Dwi Farma', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Akademi Farmasi Dwi Farma', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '23': [
        { code: '4.1.18', title: 'Jumlah Dosen di Akademi Pariwisata PARAMITA', titleEn: 'Number of Lecturer in Bukittinggi' },
        { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Akademi Pariwisata PARAMITA', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
    ],
    '24': [
        { code: '4.1.21', title: 'Jumlah Pengunjung Pada UPT Perpustakaan Proklamator Bung Hatta Menurut Tingkat Pendidikan di Kota Bukittinggi', titleEn: 'Number of Visitor at UPT Perpustakaan Proklamator Bung Hatta by Education Level in Bukittinggi' },
        { code: '4.1.22', title: 'Jumlah Peminjam Buku Pada UPT Perpustakaan Proklamator Bung Hatta Menurut Pekerjaan di Kota Bukittinggi', titleEn: 'Number of Book Borrowed at Mhd. Hatta Library by Employment Status in Bukittinggi' },
        { code: '4.1.23', title: 'Jumlah Buku yang Dipinjamkan UPT Perpustakaan Proklamator Bung Hatta Menurut Penggolongan Koleksi Buku di Kota Bukittinggi', titleEn: 'Number of Books Which is Lended by UPT Perpustakaan Proklamator Bung Hatta by Book Collection in Bukittinggi' }
    ],
    '25': [
        { code: '4.2.11', title: 'Jumlah Donatur Darah Menurut Golongan Darah yang Terdaftar pada PMI Kota Bukittinggi', titleEn: 'Number of Donor by Classification of Blood that Registered in Bukittinggi' }
    ],
    '26': [
        { code: '4.2.21', title: 'Jumlah Peserta Aktif BPJS Kesehatan per Puskesmas di Kota Bukittinggi di Kota Bukittinggi', titleEn: 'Number of Members Health Insurances by Civil Health Centre in Bukittinggi' },
        { code: '4.2.22', title: 'Jumlah Peserta Aktif BPJS Kesehatan Menurut jenis Kepesertaan di Kota Bukittinggi', titleEn: 'Number of Participant Health Insurance by Kind of Participant in Bukittinggi' }
    ],
    '27': [
        { code: '4.5.1', title: 'Jumlah Perkara yang Diterima dan Diputuskan oleh Pengadilan Negeri Bukittinggi di Kota Bukittinggi', titleEn: 'Number of Cases Which Reported and Cleared by Law Court in Bukittinggi' }
    ],
    '28': [
        { code: '4.5.2', title: 'Jumlah Perkara yang Masuk pada Kejaksaan Negeri Bukittinggi per Bulan di Kota Bukittinggi', titleEn: 'Number of Cases Which is Reported by Public by Month in Bukittinggi' },
        { code: '4.5.4', title: 'Jumlah Perkara yang Diselesaikan oleh Kejaksaan Negeri Bukittinggi per Bulan di Kota Bukittinggi', titleEn: 'Number of Cases Whics is Cleared by Public Count by Month in Bukittinggi' }
    ],
    '29': [
        { code: '4.5.5', title: 'Jumlah Perkara yang Diterima dan Diputuskan Pengadilan Agama Bukittinggi per Bulan di Kota Bukittinggi', titleEn: 'Number of Cases Which is Decided by Religion Count by Month in Bukittinggi' },
        { code: '4.5.3', title: 'Jenis Perkara Sisa Tahun Lalu yang Diterima dan Diputuskan Pengadilan Agama di Kota Bukittinggi', titleEn: 'Number of Cases Which is Decided by Religion Court in Bukittinggi' }
    ],
    '30': [
        { code: '4.5.6', title: 'Jumlah Kriminal Menurut Jenis Kejadian di Kota Bukittinggi', titleEn: 'Number of Crimes by Type of Crimes in Bukittinggi' },
        { code: '8.1.10', title: 'Banyaknya Tabrakan / Kecelakaan Lalu Lintas di Kota Bukittinggi', titleEn: 'Number of Traffic Accidents in Bukittinggi' }
    ],
    '31': [
        { code: '6.1', title: 'Daya Terpasang, Produksi, Listrik Terjual, dan Pelanggan di PLN Kota Bukittinggi (Ha)', titleEn: 'Installed Electricity Power, Production, and Electricity Sold at PLN Branch in Bukittinggi Municipality' },
        { code: '6.2', title: 'Jumlah Pelanggan Listrik di Kota Bukittinggi', titleEn: 'Number of Electricity Costumer in Bukittinggi Municipality' },
        { code: '6.3', title: 'Tenaga Listrik yang Dijual / Didistribusikan PLN Cabang Bukittinggi di Kota Bukittinggi', titleEn: 'Electric Power Which is Distributed by Branch Electric Enterprise Bukittinggi in Bukittinggi' }
    ],
    '32': [
        { code: '6.4', title: 'Jumlah Pelanggan dan Air yang Disalurkan oleh Perusahaan Umum Daerah Air Minum Tirta Jam Gadang Kota Bukittinggi', titleEn: 'Number of Customers and Distributed Water by Water Works Establishment Bukittinggi Municipality' }
    ],
    '33': [
        { code: '8.1.11', title: 'Jumlah Kendaraan Bermotor yang Mendaftar Ulang dan Balik Nama pada UPTD Pelayanan Pendapatan Provinsi di Kota Bukittinggi', titleEn: 'Number of Vehicles with Registered and Name Return on UPTD Provincial Incomes Service in Bukittinggi Municipality' }
    ],
    '34': [
        { code: '8.2.1', title: 'Jumlah Kantor Pos Pembantu Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Auxiliary Post Office by Subdistrict in Bukittinggi' },
        { code: '8.2.4', title: 'Jumlah Kiriman Surat dan Paket Yang Diterima dan Dikirim Kantor Pos Kota Bukittinggi', titleEn: 'Number of Letters and Packages Received and Sent by the Post Office of Bukittinggi Municipality' },
        { code: '8.2.5', title: 'Jumlah Wesel Pos yang Diterima / Dikirim di Kota Bukittinggi', titleEn: 'Number of Money Orders Sent Received / Send in Bukittinggi' },
        { code: '8.2.6', title: 'Jumlah Penerimaan dan Pengeluaran Giro dan Cek Pos di Kota Bukittinggi', titleEn: 'Number of Received and Paid of Giro and Postal Cheque in Bukittinggi' }
    ],
    '35': [
        { code: '8.2.7', title: 'Acara Siaran LPP RRI Bukittinggi', titleEn: 'Programmes of Radios Indonesian Republic in Bukittinggi' }
    ],
    '36': [
        { code: '9.5', title: 'Jumlah Data Peserta Aktif Taspen Kota Bukittinggi', titleEn: 'Number of Data Taspens Member Active for Bukittinggi Municipality' },
        { code: '9.6', title: 'Jumlah Data Peserta Pensiun di Taspen Kota Bukittinggi', titleEn: 'Number of Data Taspens Member Inactive for Bukittinggi Municipality' }
    ],
    '37': [
        { code: '11.5', title: 'Penerimaan dan Penyaluran Beras Bulog dalam Daerah Kota Bukittinggi (kg)', titleEn: 'Inflow and Distribution of Rice Through Burreu of Logistic (Kg) in Bukittinggi Municipality' }
    ]
};

const bpsTablesCatalog = {
    '01': [], // PODES
    '02': [], // PENDUDUK
    '03': [], // SUSENAS
    '04': [], // SAKERNAS
    '05': [], // HORTI
    '06': [], // IMK
    '07': [], // HOTEL
    '08': [], // IHK & INFLASI
    '09': [], // PDRB LAPUS
    '10': []  // PDRB PENGELUARAN
};

/**
 * Ambil daftar semua tabel untuk suatu instansi/OPD/BPS
 */
function getAgencyTables(opdCode, type) {
    const cleanOpd = opdCode ? opdCode.toString().padStart(2, '0') : '01';
    let currentType = type;
    if (!currentType && typeof window !== 'undefined' && window.location) {
        try {
            const urlParams = new URLSearchParams(window.location.search);
            currentType = urlParams.get('type') || 'opd';
        } catch (e) {}
    }

    let catalog = opdTablesCatalog;
    let storagePrefix = 'simonda_custom_opd_tables_';
    if (currentType === 'bps') {
        catalog = bpsTablesCatalog;
        storagePrefix = 'simonda_custom_bps_tables_';
    } else if (currentType === 'instansi') {
        catalog = instansiTablesCatalog;
        storagePrefix = 'simonda_custom_instansi_tables_';
    }

    let list = (catalog && catalog[cleanOpd]) ? [...catalog[cleanOpd]] : [];

    // Gabungkan tabel kustom dari localStorage jika ada
    if (typeof window !== 'undefined' && window.localStorage) {
        try {
            const storageKey = storagePrefix + cleanOpd;
            const stored = JSON.parse(window.localStorage.getItem(storageKey) || '[]');
            if (Array.isArray(stored)) {
                stored.forEach(st => {
                    if (!list.some(t => t.code.trim() === st.code.trim())) {
                        list.push({ ...st, isCustom: true });
                    }
                });
            }
        } catch(e) {}
    }

    // Gabungkan dari window.serverDbCustomTables jika di-inject oleh backend
    if (typeof window !== 'undefined' && window.serverDbCustomTables && Array.isArray(window.serverDbCustomTables)) {
        window.serverDbCustomTables.forEach(st => {
            if (!list.some(t => t.code.toString().trim() === st.code.toString().trim())) {
                list.push({
                    code: st.code,
                    title: st.title,
                    titleEn: st.titleEn || st.title,
                    isCustom: true
                });
            }
        });
    }

    return list;
}

/**
 * Cari informasi judul resmi tabel dari katalog OPD / Instansi / BPS
 */
function getCatalogTableInfo(code, opdCode, type) {
    if (!code) return null;
    const cleanCode = code.toString().trim().replace(/\.+$/, '');
    const cleanOpd = opdCode ? opdCode.toString().padStart(2, '0') : null;
    let currentType = type;
    if (!currentType && typeof window !== 'undefined' && window.location) {
        try {
            const urlParams = new URLSearchParams(window.location.search);
            currentType = urlParams.get('type') || 'opd';
        } catch (e) {}
    }

    // 1. Prioritaskan pencarian di katalog resmi OPD / Instansi / BPS berdasarkan kode tabel!
    // 1a. Jika tipe BPS, prioritaskan bpsTablesCatalog
    if (currentType === 'bps' && typeof bpsTablesCatalog !== 'undefined') {
        if (cleanOpd && bpsTablesCatalog[cleanOpd]) {
            const found = bpsTablesCatalog[cleanOpd].find(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode);
            if (found) return { title: found.title, titleEn: found.titleEn || '' };
        }
        for (const k in bpsTablesCatalog) {
            const found = bpsTablesCatalog[k].find(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode);
            if (found) return { title: found.title, titleEn: found.titleEn || '' };
        }
    }

    // 1b. Jika tipe instansi, prioritaskan instansiTablesCatalog
    if (currentType === 'instansi' && typeof instansiTablesCatalog !== 'undefined') {
        if (cleanOpd && instansiTablesCatalog[cleanOpd]) {
            const found = instansiTablesCatalog[cleanOpd].find(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode);
            if (found) return { title: found.title, titleEn: found.titleEn || '' };
        }
        for (const k in instansiTablesCatalog) {
            if (['4.1.18', '4.1.19'].includes(cleanCode)) continue; // Jangan pinjam judul kampus lain untuk 4.1.18 & 4.1.19!
            const found = instansiTablesCatalog[k].find(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode);
            if (found) return { title: found.title, titleEn: found.titleEn || '' };
        }
    }

    // 1c. Cari di opdTablesCatalog
    if (typeof opdTablesCatalog !== 'undefined') {
        if (cleanOpd && opdTablesCatalog[cleanOpd]) {
            const found = opdTablesCatalog[cleanOpd].find(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode);
            if (found) return { title: found.title, titleEn: found.titleEn || '' };
        }
        for (const k in opdTablesCatalog) {
            const found = opdTablesCatalog[k].find(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode);
            if (found) return { title: found.title, titleEn: found.titleEn || '' };
        }
    }

    // 1d. Fallback ke instansi / BPS jika belum ketemu
    if (typeof instansiTablesCatalog !== 'undefined') {
        for (const k in instansiTablesCatalog) {
            if (['4.1.18', '4.1.19'].includes(cleanCode)) continue; // Jangan salah pasang judul kampus
            const found = instansiTablesCatalog[k].find(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode);
            if (found) return { title: found.title, titleEn: found.titleEn || '' };
        }
    }
    if (typeof bpsTablesCatalog !== 'undefined') {
        for (const k in bpsTablesCatalog) {
            const found = bpsTablesCatalog[k].find(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode);
            if (found) return { title: found.title, titleEn: found.titleEn || '' };
        }
    }

    // 1e. Cek dari daftar custom agency tables
    try {
        if (typeof getAgencyTables === 'function') {
            const agencyList = getAgencyTables(cleanOpd || '01', currentType);
            const customFound = agencyList.find(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode);
            if (customFound) {
                return { title: customFound.title, titleEn: customFound.titleEn || customFound.title };
            }
        }
    } catch (e) {}

    // 2. Terakhir, jika tidak ada di katalog resmi, baru periksa query parameter URL
    // (HANYA jika kode pada URL cocok dengan kode yang dicari!)
    try {
        if (typeof window !== 'undefined' && window.location) {
            const urlParams = new URLSearchParams(window.location.search);
            const urlCode = (urlParams.get('code') || urlParams.get('table') || '').toString().trim().replace(/\.+$/, '');
            if (urlCode === cleanCode) {
                const urlTitle = urlParams.get('title');
                const urlTitleEn = urlParams.get('title_en') || urlParams.get('titleEn');
                if (urlTitle && urlTitle.trim()) {
                    return { title: urlTitle.trim(), titleEn: (urlTitleEn || '').trim() };
                }
            }
        }
    } catch (e) {}

    return null;
}

/**
 * Cari kode OPD/Instansi dan Tipenya berdasarkan kode tabel
 */
function getAgencyInfoForTable(tableCode, defaultOpd = '01', defaultType = 'opd') {
    if (!tableCode) return { opdCode: defaultOpd, type: defaultType };
    const cleanCode = tableCode.toString().trim().replace(/\.+$/, '');
    
    // JIKA dipanggil dari Data BPS, TETAP DI BPS (JANGAN PERNAH dialihkan ke OPD atau Instansi)
    if (defaultType === 'bps') {
        if (typeof bpsTablesCatalog !== 'undefined') {
            const cleanDefaultOpd = defaultOpd ? defaultOpd.toString().padStart(2, '0') : null;
            if (cleanDefaultOpd && bpsTablesCatalog[cleanDefaultOpd]) {
                if (bpsTablesCatalog[cleanDefaultOpd].some(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode)) {
                    return { opdCode: cleanDefaultOpd, type: 'bps' };
                }
            }
            for (const b in bpsTablesCatalog) {
                if (bpsTablesCatalog[b].some(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode)) {
                    return { opdCode: b, type: 'bps' };
                }
            }
        }
        return { opdCode: defaultOpd, type: 'bps' };
    }

    // JIKA dipanggil dari Instansi Vertikal, TETAP DI INSTANSI (JANGAN PERNAH dialihkan ke OPD)
    if (defaultType === 'instansi') {
        if (typeof instansiTablesCatalog !== 'undefined') {
            const cleanDefaultOpd = defaultOpd ? defaultOpd.toString().padStart(2, '0') : null;
            if (cleanDefaultOpd && instansiTablesCatalog[cleanDefaultOpd]) {
                if (instansiTablesCatalog[cleanDefaultOpd].some(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode)) {
                    return { opdCode: cleanDefaultOpd, type: 'instansi' };
                }
            }
            // Khusus tabel kampus 4.1.18 & 4.1.19: jika instansi vertikal 05 s.d. 23 sedang aktif, TETAP PERTAHANKAN OPD INI!
            if (['4.1.18', '4.1.19'].includes(cleanCode) && cleanDefaultOpd) {
                const opdNum = parseInt(cleanDefaultOpd, 10);
                if (opdNum >= 5 && opdNum <= 23) {
                    return { opdCode: cleanDefaultOpd, type: 'instansi' };
                }
            }
            for (const inst in instansiTablesCatalog) {
                if (['4.1.18', '4.1.19'].includes(cleanCode)) continue; // JANGAN switch kampus 05-23 ke kampus pertama!
                if (instansiTablesCatalog[inst].some(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode)) {
                    return { opdCode: inst, type: 'instansi' };
                }
            }
        }
        return { opdCode: defaultOpd, type: 'instansi' };
    }

    // Pemetaan khusus tabel yang memiliki instansi definitif (Hanya untuk OPD)
    if (cleanCode.startsWith('5.') || cleanCode === '9.11') return { opdCode: '17', type: 'opd' }; // 17. Dinas Pertanian dan Pangan
    if (cleanCode.startsWith('7.')) return { opdCode: '19', type: 'opd' }; // 19. Dinas Pariwisata, Pemuda dan Olahraga
    if (cleanCode.startsWith('2.2.')) return { opdCode: '03', type: 'opd' }; // 03. Sekretariat DPRD
    if (cleanCode.startsWith('2.3.')) return { opdCode: '04', type: 'opd' }; // 04. BKPSDM
    if (cleanCode.startsWith('2.4.')) return { opdCode: '05', type: 'opd' }; // 05. Badan Keuangan Daerah
    if (cleanCode.startsWith('9.')) return { opdCode: '07', type: 'opd' }; // 07. Diskop & Tenaga Kerja
    if (cleanCode === '11.1') return { opdCode: '18', type: 'opd' }; // 18. Dinas Perdagangan
    if (cleanCode === '11.2') return { opdCode: '02', type: 'opd' }; // 02. DPM-PTSP
    if (cleanCode === '4.1.24') return { opdCode: '11', type: 'opd' }; // 11. Dinas Perpustakaan dan Kearsipan
    if (cleanCode === '4.1.20') return { opdCode: '10', type: 'opd' }; // 10. Dinas Pemuda dan Olahraga
    if (cleanCode === '4.3.4')  return { opdCode: '09', type: 'opd' }; // 09. BPBD
    if (cleanCode === '4.3.5' || cleanCode === '4.3.6' || cleanCode === '4.3.7' || cleanCode === '4.3.8') return { opdCode: '15', type: 'opd' }; // 15. Dinas Pemadam Kebakaran dan Penyelamatan
    if (cleanCode === '8.1.6' || cleanCode === '8.1.7' || cleanCode === '8.1.8' || cleanCode === '8.1.9') return { opdCode: '20', type: 'opd' }; // 20. Dinas Perhubungan
    if (cleanCode === '1.1.6' || ['8.1.1', '8.1.2', '8.1.3', '8.1.4', '8.1.5'].includes(cleanCode) || cleanCode.startsWith('8.2.')) return { opdCode: '01', type: 'opd' }; // 01. PUPR

    // 1. Cari di katalog OPD terlebih dahulu
    if (typeof opdTablesCatalog !== 'undefined') {
        // Cek jika ada di defaultOpd
        const cleanDefaultOpd = defaultOpd ? defaultOpd.toString().padStart(2, '0') : null;
        if (cleanDefaultOpd && opdTablesCatalog[cleanDefaultOpd]) {
            if (opdTablesCatalog[cleanDefaultOpd].some(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode)) {
                return { opdCode: cleanDefaultOpd, type: 'opd' };
            }
        }
        for (const opd in opdTablesCatalog) {
            if (opdTablesCatalog[opd].some(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode)) {
                return { opdCode: opd, type: 'opd' };
            }
        }
    }

    // 2. Cari di katalog Instansi Vertikal
    if (typeof instansiTablesCatalog !== 'undefined') {
        for (const inst in instansiTablesCatalog) {
            if (['4.1.18', '4.1.19'].includes(cleanCode)) continue; // Jangan auto-redirect ke 05 untuk tabel kampus
            if (instansiTablesCatalog[inst].some(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode)) {
                return { opdCode: inst, type: 'instansi' };
            }
        }
    }

    // 3. Cari di katalog BPS
    if (typeof bpsTablesCatalog !== 'undefined') {
        for (const b in bpsTablesCatalog) {
            if (bpsTablesCatalog[b].some(t => t.code.toString().trim().replace(/\.+$/, '') === cleanCode)) {
                return { opdCode: b, type: 'bps' };
            }
        }
    }

    return { opdCode: defaultOpd, type: defaultType };
}

// Bersihkan riwayat salah tempat jika tabel 4.1.24 pernah tersimpan di bawah OPD 10 pada localStorage
try {
    if (typeof window !== 'undefined' && window.localStorage) {
        const k10 = 'simonda_custom_opd_tables_10';
        const raw10 = localStorage.getItem(k10);
        if (raw10) {
            const list10 = JSON.parse(raw10);
            if (Array.isArray(list10) && list10.some(t => t.code === '4.1.24')) {
                localStorage.setItem(k10, JSON.stringify(list10.filter(t => t.code !== '4.1.24')));
            }
        }
    }
} catch(e) {}

// Export for Browser window and global runtime
if (typeof window !== 'undefined') {
    window.opdTablesCatalog = opdTablesCatalog;
    window.instansiTablesCatalog = instansiTablesCatalog;
    window.bpsTablesCatalog = bpsTablesCatalog;
    window.getAgencyTables = getAgencyTables;
    window.getCatalogTableInfo = getCatalogTableInfo;
    window.getAgencyInfoForTable = getAgencyInfoForTable;
}
if (typeof globalThis !== 'undefined') {
    globalThis.opdTablesCatalog = opdTablesCatalog;
    globalThis.instansiTablesCatalog = instansiTablesCatalog;
    globalThis.bpsTablesCatalog = bpsTablesCatalog;
    globalThis.getAgencyTables = getAgencyTables;
    globalThis.getCatalogTableInfo = getCatalogTableInfo;
    globalThis.getAgencyInfoForTable = getAgencyInfoForTable;
}

// Export for Node/CommonJS if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { opdTablesCatalog, instansiTablesCatalog, bpsTablesCatalog, getAgencyTables, getCatalogTableInfo, getAgencyInfoForTable };
}
