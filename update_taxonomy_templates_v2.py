import os
import re

files_patterns = [
    {
        'file': 'wp-content/themes/snap-stitch-theme/taxonomy-product_cat-entrance-solutions.php',
        'grid_start': r'<section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-1 content-start">',
        'grid_end': r'</section>',
        'pag_start': r'<!-- Pagination -->',
        'pag_end': r'</div>' # Need to be careful here
    },
    {
        'file': 'wp-content/themes/snap-stitch-theme/taxonomy-product_cat-hygiene-ppe.php',
        'grid_start': r'<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-0.5 bg-outline-variant/20">',
        'grid_end': r'</div>\s*<!-- Pagination -->',
        'pag_start': r'<!-- Pagination -->',
        'pag_end': r'</div>'
    },
    {
        'file': 'wp-content/themes/snap-stitch-theme/taxonomy-product_cat-vending-machines.php',
        'grid_start': r'<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">',
        'grid_end': r'</div>\s*<!-- Centered Large Button replacing pagination -->',
        'pag_start': r'<!-- Centered Large Button replacing pagination -->',
        'pag_end': r'</a>\s*</div>'
    }
]

PRODUCT_LOOP_TEMPLATE = """
<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); global $product; ?>
        <?php 
        $image_url = wp_get_attachment_image_url( $product->get_image_id(), 'large' ) ?: wc_placeholder_img_src();
        $title = $product->get_name();
        $sku = $product->get_sku() ?: 'N/A';
        $permalink = $product->get_permalink();
        $is_b2b = snap_stitch_is_b2b_product( $product->get_id() );
        ?>
        <article class="bg-white p-6 flex flex-col group relative cursor-pointer border border-gray-100 hover:shadow-xl transition-all" onclick="window.location.href='<?php echo esc_url($permalink); ?>'">
            <?php if ($product->is_featured()) : ?>
            <div class="absolute top-0 left-0 z-10 bg-[#FBBF24] text-[#0A0A0A] px-3 py-1 text-[10px] font-black uppercase tracking-tighter">FEATURED</div>
            <?php endif; ?>
            <div class="relative aspect-square mb-6 bg-surface-container-low overflow-hidden">
                <img alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 p-2" src="<?php echo esc_url($image_url); ?>"/>
                <div class="absolute bottom-0 left-0 bg-[#FBBF24] text-[#0A0A0A] px-2 py-1 text-[10px] font-black uppercase tracking-tighter">SKU: <?php echo esc_html($sku); ?></div>
            </div>
            <h3 class="text-[#0A0A0A] font-black uppercase tracking-tighter text-lg mb-4 leading-tight"><?php echo esc_html($title); ?></h3>
            
            <div class="mt-auto space-y-2">
                <?php if ($is_b2b) : ?>
                    <button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-widest text-xs hover:bg-[#0A0A0A] hover:text-[#FBBF24] transition-colors js-open-quote-modal">Get Best Price</button>
                    <button class="w-full border-2 border-[#1A56DB] text-[#1A56DB] py-3 font-black uppercase tracking-widest text-xs hover:bg-[#1A56DB] hover:text-white transition-colors js-open-quote-modal">Add to Quote Cart</button>
                <?php else : ?>
                    <div class="text-xl font-black mb-2 text-center"><?php echo $product->get_price_html(); ?></div>
                    <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="w-full bg-[#1A56DB] text-white py-3 font-black uppercase tracking-widest text-xs hover:bg-[#0A0A0A] hover:text-white transition-colors block text-center">Add to Cart</a>
                <?php endif; ?>
            </div>
        </article>
    <?php endwhile; ?>
<?php else : ?>
    <div class="p-8 col-span-full text-center">
        <h3 class="text-xl font-bold">No products found in this category.</h3>
    </div>
<?php endif; ?>
"""

PAGINATION_TEMPLATE = """
<!-- Pagination -->
<div class="mt-12 w-full flex justify-center custom-pagination">
    <style>
        .custom-pagination .woocommerce-pagination ul { display: flex; gap: 1rem; list-style: none; padding: 0; margin: 0; }
        .custom-pagination .woocommerce-pagination ul li { display: inline-block; }
        .custom-pagination .woocommerce-pagination ul li a, .custom-pagination .woocommerce-pagination ul li span.current { 
            display: flex; align-items: center; justify-content: center; width: 3rem; height: 3rem; font-weight: 900; 
            border: 2px solid #1A56DB; color: #1A56DB; transition: all 0.2s; 
        }
        .custom-pagination .woocommerce-pagination ul li span.current { background-color: #1A56DB; color: white; }
        .custom-pagination .woocommerce-pagination ul li a:hover { background-color: #1A56DB; color: white; }
    </style>
    <?php woocommerce_pagination(); ?>
</div>
"""

for item in files_patterns:
    filepath = item['file']
    if not os.path.exists(filepath):
        print("File not found: {}".format(filepath))
        continue
        
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    grid_match = re.search(item['grid_start'], content)
    if not grid_match:
        print("Grid start not found in {}".format(filepath))
        continue
        
    grid_start_idx = grid_match.end()
    
    grid_end_match = re.search(item['grid_end'], content[grid_start_idx:])
    if not grid_end_match:
        print("Grid end not found in {}".format(filepath))
        continue
        
    grid_end_idx = grid_start_idx + grid_end_match.start()
    
    new_content = content[:grid_start_idx] + "\n" + PRODUCT_LOOP_TEMPLATE + "\n" + content[grid_end_idx:]
    
    # Handle pagination
    pag_match = re.search(item['pag_start'], new_content)
    if pag_match:
        pag_end_match = re.search(item['pag_end'], new_content[pag_match.end():])
        if pag_end_match:
            # We want to replace from pag_match.start() to pag_match.end() + pag_end_match.end()
            # but we need to find the correct closing div. Let's just do a simple replacement for the comment down to the next </section> or </main>
            
            # actually let's just find the next </main> or </section> after pagination
            pag_end_tag = re.search(r'</(main|section)>', new_content[pag_match.end():])
            if pag_end_tag:
                # Find the div closing just before it
                div_close = list(re.finditer(r'</div>', new_content[pag_match.start():pag_match.end() + pag_end_tag.start()]))
                if div_close:
                    end_idx = pag_match.start() + div_close[-1].end()
                    new_content = new_content[:pag_match.start()] + PAGINATION_TEMPLATE + "\n" + new_content[end_idx:]
                
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(new_content)
        
    print("Updated {}".format(filepath))
