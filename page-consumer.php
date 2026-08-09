<?php
/**
 * Template Name: Consumer Page
 * 
 * Description: The dedicated B2C Consumer portal layout, styled with Snap Stitch.
 */

get_header(); ?>

<style>
/* Custom full-width hero styles */
.consumer-hero-video {
    height: 90vh;
    min-height: 600px;
}
</style>

<main id="primary" class="site-main bg-white">
    <!-- FULL WIDTH HERO VIDEO -->
    <section class="relative w-full mb-16 consumer-hero-video overflow-hidden bg-slate-900" id="hero-section">
        
        <!-- The Video (Autoplaying Background) -->
        <video id="hero-video" class="absolute inset-0 w-full h-full object-cover z-0" playsinline loop muted autoplay>
            <source src="//consumer.bluestarindia.com/cdn/shop/videos/c/vp/5ac5f4a698694d8395279f50f91b30c6/5ac5f4a698694d8395279f50f91b30c6.HD-1080p-7.2Mbps-34891684.mp4?v=0" type="video/mp4">
        </video>

        <!-- Dark Overlay for Readability -->
        <div class="absolute inset-0 bg-black/30 pointer-events-none z-10"></div>
        
        <!-- Content & Controls (Bottom Left) -->
        <div class="absolute bottom-12 left-8 md:left-12 z-20 text-left pointer-events-none max-w-3xl">
            <h1 class="text-3xl md:text-5xl lg:text-[54px] leading-tight font-black text-white mb-6 uppercase tracking-tight">EXPERIENCE THE POWER OF HEAVY DUTY ACs.</h1>
            
            <div class="pointer-events-auto">
                <!-- CTA Button -->
                <a href="/product-category/room-air-conditioners/" class="inline-flex items-center justify-center text-white border border-white rounded-none px-8 py-3 text-sm font-bold tracking-wide hover:bg-[#1A56DB] hover:border-[#1A56DB] transition-colors mb-6">
                    Discover Now
                </a>
                
                <!-- Video Controls -->
                <div class="flex items-center gap-4">
                    <!-- Play/Pause Button -->
                    <button id="hero-play-pause-btn" class="w-12 h-12 rounded-none bg-[#FBBF24] text-black flex items-center justify-center hover:bg-yellow-500 transition-colors" aria-label="Play/Pause">
                        <span class="material-symbols-outlined text-[24px]" id="hero-play-icon">pause</span>
                    </button>
                    <!-- Mute/Unmute Button -->
                    <button id="hero-mute-btn" class="w-12 h-12 rounded-none bg-[#1c1c1c] text-white flex items-center justify-center hover:bg-black transition-colors border border-white/20" aria-label="Mute/Unmute">
                        <span class="material-symbols-outlined text-[20px]" id="hero-mute-icon">volume_off</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- CATEGORY BANNERS -->
    <section class="w-full bg-white py-24 px-4 sm:px-8 lg:px-20 overflow-x-hidden">
        <div class="max-w-screen-xl mx-auto">
            <!-- Section Header (matches front-page pattern) -->
            <div class="flex flex-col gap-4 mb-12">
                <span class="inline-block bg-[#FBBF24] text-black font-black text-xs px-4 py-1.5 uppercase tracking-widest w-fit">Shop by Category</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight text-[#0A0A0A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">Explore Our Product Range</h2>
            </div>

            <!-- Category Grid: 4 columns, large images -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- AC -->
                <a href="/product-category/room-air-conditioners/" class="group block overflow-hidden bg-white" style="box-shadow: none;">
                    <div class="relative overflow-hidden bg-[#f0f5fa] flex items-center justify-center p-8" style="aspect-ratio: 1/1;">
                        <img src="https://cdn.shopify.com/s/files/1/0888/8297/0937/files/GalleryImages01_96164da9-aea8-41e8-8d41-1a856cb0595f.png?v=1767784754" class="w-full h-full object-contain transition-transform duration-500 ease-out group-hover:scale-110" alt="Air Conditioners" loading="lazy">
                    </div>
                    <div class="flex items-center justify-between py-4">
                        <h3 class="font-black text-[#0A0A0A] text-base uppercase tracking-widest group-hover:text-[#1A56DB] transition-colors" style="font-family: 'Plus Jakarta Sans', sans-serif;">Air Conditioners</h3>
                        <span class="material-symbols-outlined text-[#0A0A0A] text-lg group-hover:text-[#1A56DB] group-hover:translate-x-1 transition-all">arrow_forward</span>
                    </div>
                </a>

                <!-- Air Coolers -->
                <a href="/product-category/air-coolers/" class="group block overflow-hidden bg-white" style="box-shadow: none;">
                    <div class="relative overflow-hidden bg-[#f0f5fa] flex items-center justify-center p-8" style="aspect-ratio: 1/1;">
                        <img src="https://cdn.shopify.com/s/files/1/0888/8297/0937/files/da75pmh_aura_neo_da_75pmh_gallery_images_01.png?v=1721414374" class="w-full h-full object-contain transition-transform duration-500 ease-out group-hover:scale-110" alt="Air Coolers" loading="lazy">
                    </div>
                    <div class="flex items-center justify-between py-4">
                        <h3 class="font-black text-[#0A0A0A] text-base uppercase tracking-widest group-hover:text-[#1A56DB] transition-colors" style="font-family: 'Plus Jakarta Sans', sans-serif;">Air Coolers</h3>
                        <span class="material-symbols-outlined text-[#0A0A0A] text-lg group-hover:text-[#1A56DB] group-hover:translate-x-1 transition-all">arrow_forward</span>
                    </div>
                </a>

                <!-- Air Purifiers -->
                <a href="/product-category/air-purifiers/" class="group block overflow-hidden bg-white" style="box-shadow: none;">
                    <div class="relative overflow-hidden bg-[#f0f5fa] flex items-center justify-center p-8" style="aspect-ratio: 1/1;">
                        <img src="https://cdn.shopify.com/s/files/1/0888/8297/0937/files/bs-ap490lan_bs-ap490lan-1.png?v=1721399063" class="w-full h-full object-contain transition-transform duration-500 ease-out group-hover:scale-110" alt="Air Purifiers" loading="lazy">
                    </div>
                    <div class="flex items-center justify-between py-4">
                        <h3 class="font-black text-[#0A0A0A] text-base uppercase tracking-widest group-hover:text-[#1A56DB] transition-colors" style="font-family: 'Plus Jakarta Sans', sans-serif;">Air Purifiers</h3>
                        <span class="material-symbols-outlined text-[#0A0A0A] text-lg group-hover:text-[#1A56DB] group-hover:translate-x-1 transition-all">arrow_forward</span>
                    </div>
                </a>

                <!-- Refrigeration -->
                <a href="/product-category/refrigeration/" class="group block overflow-hidden bg-white" style="box-shadow: none;">
                    <div class="relative overflow-hidden bg-[#f0f5fa] flex items-center justify-center p-8" style="aspect-ratio: 1/1;">
                        <img src="https://cdn.shopify.com/s/files/1/0888/8297/0937/files/SC375_74b1966b-be7e-4ce5-818c-672054881d44.png?v=1728630065" class="w-full h-full object-contain transition-transform duration-500 ease-out group-hover:scale-110" alt="Refrigeration" loading="lazy">
                    </div>
                    <div class="flex items-center justify-between py-4">
                        <h3 class="font-black text-[#0A0A0A] text-base uppercase tracking-widest group-hover:text-[#1A56DB] transition-colors" style="font-family: 'Plus Jakarta Sans', sans-serif;">Refrigeration</h3>
                        <span class="material-symbols-outlined text-[#0A0A0A] text-lg group-hover:text-[#1A56DB] group-hover:translate-x-1 transition-all">arrow_forward</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- VIDEO REELS: Get To Know Your AC -->
    <section class="w-full bg-[#0A0A0A] py-24 px-4 sm:px-8 lg:px-20">
        <div class="max-w-screen-xl mx-auto">
            <!-- Section Header -->
            <div class="flex flex-col gap-4 mb-12">
                <span class="inline-block bg-[#FBBF24] text-black font-black text-xs px-4 py-1.5 uppercase tracking-widest w-fit">Featured Videos</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Get To Know Your AC</h2>
            </div>

            <!-- Video Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                <!-- Reel 1: Energy Management -->
                <div class="flex flex-col group">
                    <p class="bg-[#FBBF24] text-black p-2 font-black text-xs sm:text-sm uppercase tracking-widest mb-3 truncate" style="font-family: 'Plus Jakarta Sans', sans-serif;">Energy Management</p>
                    <div class="relative w-full overflow-hidden bg-black cursor-pointer" style="aspect-ratio: 9/16;" onclick="toggleReelMute(this)">
                        <video class="w-full h-full object-cover" poster="https://cdn.shopify.com/s/files/1/0888/8297/0937/files/placeholder_350x.jpg?v=1722499477" autoplay muted loop playsinline>
                            <source src="//consumer.bluestarindia.com/cdn/shop/videos/c/vp/071486194f1245259cdcb66e85f2f787/071486194f1245259cdcb66e85f2f787.HD-1080p-7.2Mbps-45241661.mp4?v=0" type="video/mp4">
                        </video>
                        <div class="absolute bottom-3 right-3 w-8 h-8 sm:w-9 sm:h-9 bg-black/50 backdrop-blur-sm flex items-center justify-center text-white z-10">
                            <span class="material-symbols-outlined text-base sm:text-lg reel-mute-icon">volume_off</span>
                        </div>
                    </div>
                </div>

                <!-- Reel 2: AI Pro+ Technology -->
                <div class="flex flex-col group">
                    <p class="bg-[#FBBF24] text-black p-2 font-black text-xs sm:text-sm uppercase tracking-widest mb-3 truncate" style="font-family: 'Plus Jakarta Sans', sans-serif;">AI Pro+ Technology</p>
                    <div class="relative w-full overflow-hidden bg-black cursor-pointer" style="aspect-ratio: 9/16;" onclick="toggleReelMute(this)">
                        <video class="w-full h-full object-cover" poster="https://cdn.shopify.com/s/files/1/0888/8297/0937/files/placeholder_350x.jpg?v=1722499477" autoplay muted loop playsinline>
                            <source src="//consumer.bluestarindia.com/cdn/shop/videos/c/vp/37c96cfe281749d68c699e5b554d7936/37c96cfe281749d68c699e5b554d7936.HD-1080p-7.2Mbps-50813998.mp4?v=0" type="video/mp4">
                        </video>
                        <div class="absolute bottom-3 right-3 w-8 h-8 sm:w-9 sm:h-9 bg-black/50 backdrop-blur-sm flex items-center justify-center text-white z-10">
                            <span class="material-symbols-outlined text-base sm:text-lg reel-mute-icon">volume_off</span>
                        </div>
                    </div>
                </div>

                <!-- Reel 3: Anti-Corrosive Blue Fins -->
                <div class="flex flex-col group">
                    <p class="bg-[#FBBF24] text-black p-2 font-black text-xs sm:text-sm uppercase tracking-widest mb-3 truncate" style="font-family: 'Plus Jakarta Sans', sans-serif;">Anti-Corrosive Blue Fins</p>
                    <div class="relative w-full overflow-hidden bg-black cursor-pointer" style="aspect-ratio: 9/16;" onclick="toggleReelMute(this)">
                        <video class="w-full h-full object-cover" poster="https://cdn.shopify.com/s/files/1/0888/8297/0937/files/placeholder_350x.jpg?v=1722499477" autoplay muted loop playsinline>
                            <source src="//consumer.bluestarindia.com/cdn/shop/videos/c/vp/ee35daeac4424ec784c921c1e020869a/ee35daeac4424ec784c921c1e020869a.HD-1080p-7.2Mbps-50814114.mp4?v=0" type="video/mp4">
                        </video>
                        <div class="absolute bottom-3 right-3 w-8 h-8 sm:w-9 sm:h-9 bg-black/50 backdrop-blur-sm flex items-center justify-center text-white z-10">
                            <span class="material-symbols-outlined text-base sm:text-lg reel-mute-icon">volume_off</span>
                        </div>
                    </div>
                </div>

                <!-- Reel 4: Heavy Duty Outdoor Unit -->
                <div class="flex flex-col group">
                    <p class="bg-[#FBBF24] text-black p-2 font-black text-xs sm:text-sm uppercase tracking-widest mb-3 truncate" style="font-family: 'Plus Jakarta Sans', sans-serif;">Heavy Duty Outdoor Unit</p>
                    <div class="relative w-full overflow-hidden bg-black cursor-pointer" style="aspect-ratio: 9/16;" onclick="toggleReelMute(this)">
                        <video class="w-full h-full object-cover" poster="https://cdn.shopify.com/s/files/1/0888/8297/0937/files/placeholder_350x.jpg?v=1722499477" autoplay muted loop playsinline>
                            <source src="//consumer.bluestarindia.com/cdn/shop/videos/c/vp/2d7c04c7d92a4d8886ff7a01ab653344/2d7c04c7d92a4d8886ff7a01ab653344.HD-1080p-7.2Mbps-50814222.mp4?v=0" type="video/mp4">
                        </video>
                        <div class="absolute bottom-3 right-3 w-8 h-8 sm:w-9 sm:h-9 bg-black/50 backdrop-blur-sm flex items-center justify-center text-white z-10">
                            <span class="material-symbols-outlined text-base sm:text-lg reel-mute-icon">volume_off</span>
                        </div>
                    </div>
                </div>

                <!-- Reel 5: Defrost Clean Technology -->
                <div class="flex flex-col group">
                    <p class="bg-[#FBBF24] text-black p-2 font-black text-xs sm:text-sm uppercase tracking-widest mb-3 truncate" style="font-family: 'Plus Jakarta Sans', sans-serif;">Defrost Clean Tech</p>
                    <div class="relative w-full overflow-hidden bg-black cursor-pointer" style="aspect-ratio: 9/16;" onclick="toggleReelMute(this)">
                        <video class="w-full h-full object-cover" poster="https://cdn.shopify.com/s/files/1/0888/8297/0937/files/placeholder_350x.jpg?v=1722499477" autoplay muted loop playsinline>
                            <source src="//consumer.bluestarindia.com/cdn/shop/videos/c/vp/39b3f05e85e342e4881439fc980dbccd/39b3f05e85e342e4881439fc980dbccd.HD-1080p-7.2Mbps-50814229.mp4?v=0" type="video/mp4">
                        </video>
                        <div class="absolute bottom-3 right-3 w-8 h-8 sm:w-9 sm:h-9 bg-black/50 backdrop-blur-sm flex items-center justify-center text-white z-10">
                            <span class="material-symbols-outlined text-base sm:text-lg reel-mute-icon">volume_off</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEW IMAGE SLIDER SECTION -->
    <section class="border-t border-b border-black bg-slate-900">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <div class="relative w-full overflow-hidden image-slideshow-container group">
            <!-- Swiper -->
            <div class="swiper image-slideshow-swiper w-full">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide w-full flex items-center justify-center bg-black">
                        <a href="/product-category/room-air-conditioners/" class="block w-full h-full cursor-pointer">
                            <img src="//consumer.bluestarindia.com/cdn/shop/files/HD-Desktop_1800x473_08110126-182e-42ae-bd5d-6fc6c244d49b.jpg?v=1724913656&width=1800" class="w-full h-auto object-cover hover:opacity-95 transition-opacity" alt="Banner 1">
                        </a>
                    </div>
                    <!-- Slide 2 -->
                    <div class="swiper-slide w-full flex items-center justify-center bg-black">
                        <a href="/product-category/room-air-conditioners/" class="block w-full h-full cursor-pointer">
                            <img src="//consumer.bluestarindia.com/cdn/shop/files/SEE-Flagship-1_HP-1800x473_98e560b1-fcdb-4670-b165-82aff31ab730.jpg?v=1728886491&width=1800" class="w-full h-auto object-cover hover:opacity-95 transition-opacity" alt="Banner 2">
                        </a>
                    </div>
                    <!-- Slide 3 -->
                    <div class="swiper-slide w-full flex items-center justify-center bg-black">
                        <a href="/product-category/room-air-conditioners/" class="block w-full h-full cursor-pointer">
                            <img src="//consumer.bluestarindia.com/cdn/shop/files/Hot_Cold-Flagship-HP-1800x473_af74a4d9-32f8-4676-b40d-23e257bc8be0.jpg?v=1728886491&width=1800" class="w-full h-auto object-cover hover:opacity-95 transition-opacity" alt="Banner 3">
                        </a>
                    </div>
                    <!-- Slide 4 -->
                    <div class="swiper-slide w-full flex items-center justify-center bg-black">
                        <a href="/product-category/room-air-conditioners/" class="block w-full h-full cursor-pointer">
                            <img src="//consumer.bluestarindia.com/cdn/shop/files/Anti-Virus-Flagship-HP-1800x473_ee0460e1-7ce6-45e9-a529-fcb52cacc59e.jpg?v=1728886491&width=1800" class="w-full h-auto object-cover hover:opacity-95 transition-opacity" alt="Banner 4">
                        </a>
                    </div>
                </div>
                
                <!-- Navigation Arrows -->
                <div class="swiper-button-next !text-[#FBBF24] !right-6 after:!text-2xl drop-shadow-md hidden md:flex"></div>
                <div class="swiper-button-prev !text-[#FBBF24] !left-6 after:!text-2xl drop-shadow-md hidden md:flex"></div>
                
                <!-- Pagination -->
                <div class="swiper-pagination !bottom-6"></div>
            </div>

            <!-- Slideshow Controls -->
            <div class="absolute bottom-6 right-6 z-30">
                <button type="button" class="slideshow-control flex items-center justify-center w-12 h-12 rounded-none bg-[#FBBF24] text-black hover:bg-yellow-500 transition-colors duration-300 shadow-lg" id="slideshow-play-pause" is="control-button" aria-controls="Slider-template--23122564907321__slideshow_tAHgWW" aria-live="polite">
                    <span class="slideshow-control__pause">
                        <svg class="icon icon-pause w-5 h-5" viewBox="0 0 36 36" stroke="currentColor" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-width="6" d="M9 4V32"></path>
                            <path stroke-linecap="round" stroke-width="6" d="M27 4V32"></path>
                        </svg>
                        <span class="sr-only">Pause slideshow</span>
                    </span>
                    <span class="slideshow-control__play hidden">
                        <svg class="icon icon-play w-6 h-6 ml-1" viewBox="0 0 36 36" stroke="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M34 17.5006C34 18.3302 33.5707 19.0963 32.8683 19.5206L9.535 33.6629C9.164 33.8869 8.74867 34 8.33333 34C7.93667 34 7.54 33.8986 7.183 33.6936C6.45267 33.274 6 32.4915 6 31.6429V3.35817C6 2.50962 6.45267 1.72708 7.183 1.30752C7.91333 0.885606 8.814 0.899749 9.535 1.33816L32.8683 15.4805C33.5707 15.9048 34 16.6709 34 17.5006"></path>
                        </svg>
                        <span class="sr-only">Play slideshow</span>
                    </span>
                </button>
            </div>
            
        </div>
        </div>
    </section>

    <!-- B2C FEATURED PRODUCTS -->
    <section class="bg-slate-50 py-20 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-800 tracking-tight mb-2">Latest Products</h2>
                    <p class="text-slate-500 font-medium">Discover our newest consumer range.</p>
                </div>
                <a href="/consumer/" class="hidden md:inline-flex items-center gap-2 text-[#1A56DB] font-bold text-sm uppercase tracking-wider hover:text-slate-900 transition-colors">
                    View All Products
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                // Fetch only B2C products
                $consumer_args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 8,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'slug',
                            'terms'    => array('room-air-conditioners', 'air-coolers', 'air-purifiers', 'water-purifiers'),
                            'operator' => 'IN',
                        ),
                    ),
                );
                
                $consumer_query = new WP_Query($consumer_args);

                if ($consumer_query->have_posts()) :
                    while ($consumer_query->have_posts()) : $consumer_query->the_post();
                        global $product;
                        
                        $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
                        $image = $image_url ? $image_url[0] : wc_placeholder_img_src();
                        
                        $price_html = $product->get_price_html();
                        $title = get_the_title();
                        $link = get_the_permalink();
                        ?>
                        <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 overflow-hidden flex flex-col relative">
                            <!-- Image -->
                            <a href="<?php echo esc_url($link); ?>" class="relative block aspect-[4/3] bg-white overflow-hidden flex-shrink-0">
                                <img src="<?php echo esc_url($image); ?>" class="w-full h-full object-contain p-6 transition-transform duration-700 group-hover:scale-110" alt="<?php echo esc_attr($title); ?>">
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="absolute top-4 left-4 bg-[#1A56DB] text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full shadow-md z-10">Sale</span>
                                <?php endif; ?>
                                
                                <!-- Hover Actions -->
                                <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-500 flex justify-center bg-gradient-to-t from-white via-white/80 to-transparent z-10">
                                    <span class="bg-[#FBBF24] text-black text-xs font-black uppercase tracking-widest px-6 py-2.5 rounded-xl shadow-lg hover:bg-yellow-500 transition-colors">
                                        View Details
                                    </span>
                                </div>
                            </a>
                            
                            <!-- Content -->
                            <div class="p-6 flex flex-col flex-grow bg-white relative z-20 border-t border-slate-50">
                                <?php 
                                $cats = wc_get_product_category_list($product->get_id(), ', ', '', ''); 
                                if($cats) echo '<div class="text-[10px] uppercase font-bold tracking-widest text-slate-400 mb-2 truncate">'.strip_tags($cats).'</div>';
                                ?>
                                <a href="<?php echo esc_url($link); ?>">
                                    <h3 class="font-bold text-slate-800 text-sm mb-2 line-clamp-2 group-hover:text-[#1A56DB] transition-colors leading-relaxed">
                                        <?php echo esc_html($title); ?>
                                    </h3>
                                </a>
                                <div class="mt-auto pt-4 flex items-center justify-between">
                                    <span class="font-black text-slate-900 flex items-center text-lg">
                                        <?php echo $price_html; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                    ?>
                    <div class="col-span-full py-12 text-center text-slate-500">
                        <span class="material-symbols-outlined text-4xl mb-3 opacity-50">inventory_2</span>
                        <p>Products are currently being updated. Please check back later.</p>
                    </div>
                    <?php
                endif;
                ?>
            </div>
            
            <div class="mt-10 text-center md:hidden">
                <a href="/consumer/" class="inline-flex items-center justify-center gap-2 w-full bg-white border border-slate-200 text-slate-700 font-bold text-sm uppercase tracking-wider px-6 py-3 rounded-xl hover:bg-slate-50 active:scale-95 transition-all shadow-sm">
                    View All Products
                </a>
            </div>
        </div>
    </section>

</main>

<script>
// Global function for inline onclick handlers on the reels
function toggleReelMute(element) {
    const video = element.querySelector('video');
    const icon = element.querySelector('.reel-mute-icon');
    
    if (video) {
        video.muted = !video.muted;
        if (video.muted) {
            icon.textContent = 'volume_off';
            icon.parentElement.classList.remove('bg-[#FBBF24]', 'text-black');
            icon.parentElement.classList.add('bg-black/50', 'text-white');
        } else {
            icon.textContent = 'volume_up';
            icon.parentElement.classList.remove('bg-black/50', 'text-white');
            icon.parentElement.classList.add('bg-[#FBBF24]', 'text-black');
            
            // Auto-pause other videos to avoid cacophony
            document.querySelectorAll('#reel-track video').forEach(v => {
                if (v !== video && !v.muted) {
                    v.muted = true;
                    const vIcon = v.parentElement.querySelector('.reel-mute-icon');
                    if (vIcon) {
                        vIcon.textContent = 'volume_off';
                        vIcon.parentElement.classList.remove('bg-[#FBBF24]', 'text-black');
                        vIcon.parentElement.classList.add('bg-black/50', 'text-white');
                    }
                }
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Hero Video Controls
    const video = document.getElementById('hero-video');
    const playPauseBtn = document.getElementById('hero-play-pause-btn');
    const playIcon = document.getElementById('hero-play-icon');
    const muteBtn = document.getElementById('hero-mute-btn');
    const muteIcon = document.getElementById('hero-mute-icon');

    if (video && playPauseBtn && muteBtn) {
        playPauseBtn.addEventListener('click', function() {
            if (video.paused) {
                video.play();
                playIcon.textContent = 'pause';
            } else {
                video.pause();
                playIcon.textContent = 'play_arrow';
            }
        });

        muteBtn.addEventListener('click', function() {
            video.muted = !video.muted;
            if (video.muted) {
                muteIcon.textContent = 'volume_off';
            } else {
                muteIcon.textContent = 'volume_up';
            }
        });
    }

    // Image Slider Navigation - Swiper JS
    if (document.querySelector('.image-slideshow-swiper')) {
        const imageSwiper = new Swiper('.image-slideshow-swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        const playPauseBtn = document.getElementById('slideshow-play-pause');
        const playIcon = playPauseBtn.querySelector('.slideshow-control__play');
        const pauseIcon = playPauseBtn.querySelector('.slideshow-control__pause');

        // Initial state (autoplay is true, so show pause)
        playIcon.classList.add('hidden');
        pauseIcon.classList.remove('hidden');

        playPauseBtn.addEventListener('click', function() {
            if (imageSwiper.autoplay.running) {
                imageSwiper.autoplay.stop();
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
            } else {
                imageSwiper.autoplay.start();
                playIcon.classList.add('hidden');
                pauseIcon.classList.remove('hidden');
            }
        });
    }

});
</script>

<!-- Swiper JS & CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<?php get_footer(); ?>
