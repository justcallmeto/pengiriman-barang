<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>SITracking Tunas Jaya</title>
        <link rel="icon" type="images/png" href="images/tj-logo1.png">

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                        
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/templatemo-topic-listing.css" rel="stylesheet">      
<!--

TemplateMo 590 topic listing

https://templatemo.com/tm-590-topic-listing

-->
    </head>
    
    <body id="top">

        <main>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="index.html">
                        
                        <span>TUNAS JAYA</span>
                    </a>

                    <div class="d-lg-none ms-auto me-4">
                        <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
                    </div>
    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarNav">
                       <ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link click-scroll" href="#section_1">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link click-scroll" href="#section_2">Produk Kami</a>
    </li>
    <li class="nav-item">
        <a class="nav-link click-scroll" href="#section_3">Rumah & Dekat</a>
    </li>
    <li class="nav-item">
        <a class="nav-link click-scroll" href="#section_4">FAQs</a>
    </li>
    <li class="nav-item">
        <a class="nav-link click-scroll" href="#section_5">Hubungi Kami</a>
    </li>
</ul>


                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>

                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                    <li><a class="dropdown-item" href="topics-listing.html">Topics Listing</a></li>

                                    <li><a class="dropdown-item" href="contact.html">Contact Form</a></li>
                                </ul>
                            </li>
                        </ul> -->

                        <!-- <div class="d-none d-lg-block">
                            <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
                        </div> -->
                    </div>
                </div>
            </nav>
            
<!-- Hero Section -->
<section class="hero-section d-flex align-items-center" id="section_1" style="min-height: 100vh; background-color: #CB0404;">
  <div class="container">
    <div class="tracking-wrapper row justify-content-center text-white" id="tracking-wrapper">
      <!-- Tracking Form -->
      <div class="col-lg-6 col-12" id="form-container">
        <h1 class="text-center text-lg-start">Pantau status pesananmu secara real-time</h1>
        <h6 class="text-center text-lg-start text-white text-shadow">Masukkan nomor resimu disini 👇</h6>

        <form id="tracking-form" method="get" class="custom-form mt-3" role="search">
          <div class="input-group input-group-lg">
            <span class="input-group-text bi-search" id="basic-addon1"></span>
            <input name="resi" type="search" class="form-control" id="resi" placeholder="Contoh: TJ-1234567890" aria-label="Search">
            <button type="submit" class="btn btn-light">Search</button>
          </div>
        </form>
      </div>

      <!-- Hasil Tracking -->
<div class="col-lg-6 col-12 mt-5 mt-lg-0" id="tracking-result" style="display: none;">
  <div class="card p-4 shadow-sm mb-3 border-0">
    <h5 class="mb-3 text-danger">📦 Status Terkini</h5>
    <p class="fs-5"><strong id="current-status-text"></strong></p>
    <p id="current-location-text" class="text-muted mb-4"></p>

    <h6 class="text-uppercase fw-bold">Nomor Resi:</h6>
    <p id="resi-text" class="mb-3"></p>

    <h6 class="text-uppercase fw-bold">Barang:</h6>
    <p id="barang-text" class="mb-3 text-danger"></p>

    <h6 class="text-uppercase fw-bold">Kurir:</h6>
    <p id="kurir-text" class="mb-4"></p>

    <!-- Riwayat Perjalanan -->
    <div class="tracking-history-wrapper">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold">Riwayat Perjalanan</h6>
        <button class="btn btn-sm btn-outline-danger" id="toggle-history">Sembunyikan Riwayat</button>
      </div>
      <div id="tracking-history">
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-striped">
            <thead class="table-danger text-center">
              <tr>
                <th>No.</th>
                <th>Status</th>
                <th>Kurir</th>
                <th>Distrik</th>
                <th>Checkpoint</th>
              </tr>
            </thead>
            <tbody id="tracking-table-body">
              <!-- Diisi oleh JS -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- Script -->
<script src="js/script.js"></script>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="explore-section section-padding" id="section_2">
                <div class="container">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="mb-4">Produk Kami</h1>
                        </div>

                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="design-tab" data-bs-toggle="tab" data-bs-target="#design-tab-pane" type="button" role="tab" aria-controls="design-tab-pane" aria-selected="true">Ruang Tamu</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="marketing-tab" data-bs-toggle="tab" data-bs-target="#marketing-tab-pane" type="button" role="tab" aria-controls="marketing-tab-pane" aria-selected="false">Ruang Makan</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance-tab-pane" type="button" role="tab" aria-controls="finance-tab-pane" aria-selected="false">Kamar Tidur</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="music-tab" data-bs-toggle="tab" data-bs-target="#music-tab-pane" type="button" role="tab" aria-controls="music-tab-pane" aria-selected="false">Kantor & Kerja</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education-tab-pane" type="button" role="tab" aria-controls="education-tab-pane" aria-selected="false">Dekorasi & Aksesoris </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="container">
                    <div class="row">

                        <div class="col-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="design-tab-pane" role="tabpanel" aria-labelledby="design-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Sofa</h5>

                                                            <p class="mb-0">Nikmati kenyamanan maksimal saat berkumpul bersama keluarga di sofa pilihan kami.</p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">14</span>
                                                    </div>

                                                    <img src="images/topics/sofa_ruangtamu.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                               
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Meja Tamu</h5>

                                                                <p class="mb-0">Lengkapi momen santai Anda dengan meja tamu elegan yang mempercantik ruangan</p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">75</span>
                                                    </div>

                                                    <img src="images/topics/meja_ruangtamu.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                               
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Kursi Tamu</h5>

                                                                <p class="mb-0">Sambut tamu dengan dudukan yang nyaman dan penuh gaya. <br> <br></p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">100</span>
                                                    </div>

                                                    <img src="images/topics/kursi_ruangtamu.png" class="custom-block-image img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="marketing-tab-pane" role="tabpanel" aria-labelledby="marketing-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                                <div class="custom-block bg-white shadow-lg">
                                                    
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Meja Makan</h5>

                                                                <p class="mb-0">Tempat terbaik untuk berbagi cerita dan cita rasa setiap hari.</div>

                                                            <span class="badge bg-advertising rounded-pill ms-auto">30</span>
                                                        </div>

                                                        <img src="images/topics/mejamakan_ruangmakan.png" class="custom-block-image img-fluid" alt="">
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                                <div class="custom-block bg-white shadow-lg">
                                                   
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Kursi Makan</h5>

                                                                <p class="mb-0">Desain ergonomis untuk kenyamanan saat makan bersama keluarga.</div>

                                                            <span class="badge bg-advertising rounded-pill ms-auto">65</span>
                                                        </div>

                                                        <img src="images/topics/kursimakan_ruangmakan.png" class="custom-block-image img-fluid" alt="">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12">
                                                <div class="custom-block bg-white shadow-lg">
                                                   
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Bufet</h5>

                                                                <p class="mb-0">Simpan peralatan makan dengan rapi dan tampil menawan.</div>

                                                            <span class="badge bg-advertising rounded-pill ms-auto">50</span>
                                                        </div>

                                                        <img src="images/topics/bufet_ruangmakan.png" class="custom-block-image img-fluid" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                  </div>

                                <div class="tab-pane fade" id="finance-tab-pane" role="tabpanel" aria-labelledby="finance-tab" tabindex="0">   <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                               
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Tempat Tidur</h5>

                                                            <p class="mb-0">Tidur lebih nyenyak dengan tempat tidur berkualitas dan desain elegan</div>

                                                        <span class="badge bg-finance rounded-pill ms-auto">30</span>
                                                    </div>

                                                    <img src="images/topics/kasur_kamartidu.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="custom-block custom-block-overlay">
                                               
                                                <div class="d-flex flex-column ">

                                                    <div class="custom-block-overlay-text d-flex">
                                                        <div>
                                                            <h5 class="text-white mb-2">Lemari Pakaian dan Meja Hias</h5>

                                                            <p class="text-white">Simpan semua koleksi pakaian dan kebutuhan Anda dengan gaya dan fungsionalitas.</p>
 
                                                            <div class="d-flex">
                                                            <img src="images/topics/lemaridantatarias.png" class="custom-block-image img-fluid" alt="">
                                               
                                                            </div>
                                                        </div>

                                                        <span class="badge bg-finance rounded-pill ms-auto">25</span>
                                                    </div>

                                                    

                                                    <div class="section-overlay"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="music-tab-pane" role="tabpanel" aria-labelledby="music-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                               
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Meja Kerja</h5>

                                                            <p class="mb-0">Produktivitas meningkat dengan meja kerja yang fungsional dan stylish.</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">45</span>
                                                    </div>

                                                    <img src="images/topics/meja_kantor.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                        
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Kursi Kantor</h5>

                                                            <p class="mb-0">Dukungan maksimal untuk tubuh selama bekerja seharian penuh.</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">45</span>
                                                    </div>

                                                    <img src="images/topics/kursi_kantor.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Rak Buku</h5>

                                                            <p class="mb-0">Tata koleksi buku dan dokumen dengan rapi dan estetis.</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">20</span>
                                                    </div>

                                                    <img src="images/topics/rak_kantor.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="education-tab-pane" role="tabpanel" aria-labelledby="education-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                           
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Cermin</h5>

                                                            <p class="mb-0">Lebih dari sekadar pantulan, cermin juga memperluas dan memperindah ruang.</p>
                                                        </div>

                                                        <span class="badge bg-education rounded-pill ms-auto">80</span>
                                                    </div>

                                                    <img src="images/topics/cermin.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Lampu Hias</h5>

                                                            <p class="mb-0">Ciptakan suasana hangat dan nyaman dengan pencahayaan artistik</p>
                                                        </div>

                                                        <span class="badge bg-education rounded-pill ms-auto">75</span>
                                                    </div>

                                                    <img src="images/topics/lampu.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </section>


            <section class="timeline-section section-padding" id="section_3">
                <div class="section-overlay"></div>

                <div class="container">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="text-white mb-4">Rumah & Dekat</h1>
                        </div>

                        <div class="col-lg-10 col-12 mx-auto">
                            <div class="timeline-container">
                                <ul class="vertical-scrollable-timeline" id="vertical-scrollable-timeline">
                                    <div class="list-progress">
                                        <div class="inner"></div>
                                    </div>

                                    <li>
                                        <h4 class="text-white mb-3">Temukan Furniture Impian</h4>

                                        <p class="text-white">Kami hadir untuk membantu Anda menemukan furniture yang tidak hanya indah dipandang, tetapi juga nyaman digunakan dan cocok untuk mengisi setiap sudut rumah Anda. Mulai dari ruang tamu yang hangat hingga kamar tidur yang menenangkan, kami siap menghadirkan inspirasi untuk menciptakan hunian idaman Anda.</p>

                                        <div class="icon-holder">
                                          <i class="bi-search"></i>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <h4 class="text-white mb-3">Dibuat dengan Cinta</h4>

                                        <p class="text-white">Seluruh produk kami dirancang secara detail dan dikerjakan langsung oleh pengrajin lokal berpengalaman, menggunakan bahan berkualitas yang tahan lama. Dengan sentuhan tangan yang terampil dan dedikasi tinggi, kami memastikan setiap furniture memiliki nilai estetika, fungsionalitas, dan kualitas terbaik yang layak Anda miliki.</p>

                                        <div class="icon-holder">
                                          <i class="bi-bookmark"></i>
                                        </div>
                                    </li>

                                    <li>
                                        <h4 class="text-white mb-3">Antar & Pasang</h4>

                                        <p class="text-white">Setelah proses pemesanan selesai, tim kami akan mengantar furniture pilihan Anda langsung ke rumah dengan aman dan tepat waktu. Kami juga menyediakan layanan pemasangan di tempat, sehingga Anda tidak perlu repot — cukup duduk santai, dan biarkan kami menyulap rumah Anda menjadi lebih nyaman dan elegan.</p>

                                        <div class="icon-holder">
                                          <i class="bi-book"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-5">
                            <p class="text-white">
                                Want to learn more?
                                <a href="#" class="btn custom-btn custom-border-btn ms-3">Check out Youtube</a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>


            <section class="faq-section section-padding" id="section_4">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-12">
                            <h2 class="mb-4">Frequently Asked Questions</h2>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-lg-5 col-12">
                            <img src="images/faq_graphic.jpg" class="img-fluid" alt="FAQs">
                        </div>

                        <div class="col-lg-6 col-12 m-auto">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                         Bagaimana cara melacak pesanan saya?
                                        </button>
                                    </h2>

                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Setelah Anda melakukan pemesanan, Anda akan menerima nomor resi. Masukkan nomor tersebut pada kolom pelacakan di halaman utama untuk melihat status terkini pesanan Anda secara real-time.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Apakah semua produk bisa dilacak melalui sistem ini?
                                    </button>
                                    </h2>

                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Saat ini, hanya produk yang dikirim menggunakan layanan pengantaran resmi Tunas Jaya yang dapat dilacak. Untuk produk yang dibawa sendiri atau dijemput langsung oleh pelanggan, fitur tracking tidak tersedia.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Bagaimana jika saya kehilangan nomor resi?
                                    </button>
                                    </h2>

                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Jangan khawatir. Anda bisa menghubungi tim layanan pelanggan kami dan menyebutkan nama serta tanggal pembelian. Kami akan membantu Anda mendapatkan kembali nomor resi Anda.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="contact-section section-padding section-bg" id="section_5">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center">
                            <h2 class="mb-5">Hubungi Kami</h2>
                        </div>

                        <div class="col-lg-5 col-12 mb-4 mb-lg-0">
                            <iframe class="google-map" <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.747440422776!2d113.21152868885498!3d-8.127175899999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd65d609c412c89%3A0x665c449aaf6ce434!2sTunas%20Jaya!5e0!3m2!1sen!2sid!4v1751478107260!5m2!1sen!2sid" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"</iframe> width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <!-- <div class="col-lg-3 col-md-6 col-12 mb-3 mb-lg- mb-md-0 ms-auto"> -->
                        <div class="col-lg-7 col-md-6 col-12 mb-3 mb-lg-0 mb-md-0 ms-auto">
                            <h4 class="mb-3">Lumajang</h4>

                            <p>Jl. Brigjend Slamet Riyadi No.64, Tompokersan, Kec. Lumajang, Kabupaten Lumajang, Jawa Timur 67312</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <a href="tel: 305-240-9671" class="site-footer-link">
                                    305-240-9671
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:info@company.com" class="site-footer-link">
                                    tunasjaya@example.com
                                </a>
                            </p>
                        </div>

                        <!-- <div class="col-lg-3 col-md-6 col-12 mx-auto">
                            <h4 class="mb-3">Jakarta</h4>

                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur amet quis distinctio ipsum nobis animi </p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <a href="tel: 110-220-3400" class="site-footer-link">
                                    110-220-3400
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:info@company.com" class="site-footer-link">
                                    example@company.com
                                </a>
                            </p>
                        </div> -->

                    </div>
                </div>
            </section>
        </main>

<footer class="site-footer section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-12 mb-4 pb-2">
                        <a class="navbar-brand mb-2" href="index.html">
                          
                            <span>TUNAS JAYA</span>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <h6 class="site-footer-title mb-3">Resources</h6>

                        <ul class="site-footer-links">
                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Home</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">How it works</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">FAQs</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Contact</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
                        <h6 class="site-footer-title mb-3">Information</h6>

                        <p class="text-white d-flex mb-1">
                            <a href="tel: 305-240-9671" class="site-footer-link">
                                305-240-9671
                            </a>
                        </p>

                        <p class="text-white d-flex">
                            <a href="mailto:info@company.com" class="site-footer-link">
                                tunasjaya@example.com
                            </a>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12 mt-4 mt-lg-0 ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            English</button>

                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" type="button">Indonesia</button></li>

                            
                            </ul>
                        </div>

                        <p class="copyright-text mt-lg-5 mt-4">Copyright © 2048 Tunas Jaya. All rights reserved.
                       
                        
                    </div>

                </div>
            </div>
        </footer>


        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/custom.js"></script>

    </body>
</html>
