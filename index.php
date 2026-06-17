<?php
/**
 * The main template file
 */

get_header(); ?>

<main id="primary" class="site-main py-24 bg-zinc-50">
    <div class="container mx-auto px-8">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('mb-16'); ?>>
                    <header class="mb-8 border-l-8 border-[#FBBF24] pl-6">
                        <h1 class="text-[#0A0A0A] text-4xl font-black uppercase tracking-tight"><?php the_title(); ?></h1>
                    </header>
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;
        else :
            ?>
            <p class="text-center text-gray-500 italic py-20">No content found.</p>
            <?php
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
