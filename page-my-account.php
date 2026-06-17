<?php
/**
 * Template Name: My Account
 */

get_header(); ?>

<!-- Page Hero -->
<section class="w-full bg-[#1A56DB] pt-[88px] py-24 md:py-32 px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-white text-5xl md:text-7xl font-black tracking-tighter leading-tight mb-6 max-w-4xl uppercase">
            My Account
        </h1>
        <p class="text-[#FBBF24] text-xl md:text-2xl font-bold max-w-2xl leading-relaxed">
            Manage your industrial B2C orders, technical specs, and profile.
        </p>
    </div>
</section>

<!-- Main Content -->
<main id="primary" class="site-main bg-zinc-50 py-16 px-8">
    <div class="max-w-7xl mx-auto">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
