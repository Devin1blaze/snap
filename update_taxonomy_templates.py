import os
import re

files = [
    'wp-content/themes/snap-stitch-theme/taxonomy-product_cat-entrance-solutions.php',
    'wp-content/themes/snap-stitch-theme/taxonomy-product_cat-hygiene-ppe.php',
    'wp-content/themes/snap-stitch-theme/taxonomy-product_cat-vending-machines.php',
    'wp-content/themes/snap-stitch-theme/taxonomy-product_cat-washroom-automations.php',
    'wp-content/themes/snap-stitch-theme/taxonomy-product_cat-water-purifiers.php'
]

PRODUCT_LOOP_TEMPLATE = """
<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); global $product; ?>
        <?php 
        $image_url = wp_get_attachment_image_url( $product->get_image_id(), 'large' ) ?: wc_placeholder_img_src();
        $title = $product->get_name();
        $sku = $product->get_sku() ?: 'N/A';
        $permalink = $product->get_permalink();
        
        $specs = get_post_meta( $product->get_id(), '_technical_specs', true );
        $spec1_name = 'Capacity'; $spec1_value = 'Standard';
        $spec2_name = 'Rating'; $spec2_value = 'Industrial';
        
        if ( is_array($specs) && count($specs) > 0 ) {
            $spec1_name = $specs[0]['name'];
            $spec1_value = $specs[0]['value'];
            if ( count($specs) > 1 ) {
                $spec2_name = $specs[1]['name'];
                $spec2_value = $specs[1]['value'];
            }
        }
        $is_b2b = snap_stitch_is_b2b_product( $product->get_id() );
        ?>
        <article class="bg-white p-6 flex flex-col group relative cursor-pointer" onclick="window.location.href='<?php echo esc_url($permalink); ?>'">
            <?php if ($product->is_featured()) : ?>
            <div class="absolute top-0 left-0 z-10 bg-[#FBBF24] text-[#0A0A0A] px-3 py-1 text-[10px] font-black uppercase tracking-tighter">TOP SELLER</div>
            <?php endif; ?>
            <div class="relative aspect-square mb-6 bg-surface-container-low overflow-hidden">
                <img alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 p-2" src="<?php echo esc_url($image_url); ?>"/>
                <div class="absolute bottom-0 left-0 bg-[#FBBF24] text-[#0A0A0A] px-2 py-1 text-[10px] font-black uppercase tracking-tighter">MODEL: <?php echo esc_html($sku); ?></div>
            </div>
            <h3 class="text-[#0A0A0A] font-black uppercase tracking-tighter text-xl mb-4 leading-tight"><?php echo esc_html($title); ?></h3>
            <div class="space-y-1 mb-8">
                <div class="flex justify-between text-[10px] font-bold uppercase text-[#1A56DB]">
                    <span><?php echo esc_html($spec1_name); ?></span>
                    <span><?php echo esc_html($spec1_value); ?></span>
                </div>
                <div class="flex justify-between text-[10px] font-bold uppercase text-[#1A56DB]">
                    <span><?php echo esc_html($spec2_name); ?></span>
                    <span><?php echo esc_html($spec2_value); ?></span>
                </div>
            </div>
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

for filepath in files:
    if not os.path.exists(filepath):
        print(f"File not found: {filepath}")
        continue
        
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Find the grid opening: <div or <section with class="grid grid-cols-X... gap-X..."
    # Note: in water purifiers it's <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    # in entrance solutions it's <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-1 content-start">
    grid_match = re.search(r'<(div|section) class="grid[^>]*gap[^>]*>', content)
    if not grid_match:
        print(f"Grid opening not found in {filepath}")
        continue
        
    grid_tag = grid_match.group(1) # 'div' or 'section'
    
    # However, there might be multiple grids (e.g. page layout grid vs product grid).
    # In entrance solutions, L13 is a page layout grid: <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-12">
    # We want the product grid. Let's find the grid that contains an <article> shortly after.
    
    all_grids = list(re.finditer(r'<(div|section) class="grid[^>]*gap[^>]*>', content))
    product_grid_match = None
    for g in all_grids:
        # Check if the next non-whitespace thing is a comment or article
        sub_content = content[g.end():g.end()+200]
        if '<article' in sub_content or '<!-- Product Card' in sub_content or '<!-- Featured Product' in sub_content:
            product_grid_match = g
            break
            
    if not product_grid_match:
        print(f"Product Grid opening not found in {filepath}")
        continue
        
    grid_start_idx = product_grid_match.end()
    grid_tag = product_grid_match.group(1)
    
    # Find the end of the grid. Usually before pagination or a banner
    grid_end_match = re.search(r'</' + grid_tag + r'>\s*<!-- (?:Custom Quote Banner|Banner|Centered Large Button|Pagination|Pagination Bar) -->', content[grid_start_idx:])
    if not grid_end_match:
        # fallback: find pagination
        pag_match = re.search(r'<!-- Pagination.*?-->', content[grid_start_idx:])
        if pag_match:
            # Assume grid ends right before pagination starts, minus closing div/section
            grid_end_idx = grid_start_idx + pag_match.start()
            # Need to backtrack to the closing tag of the grid
            closing_tag_match = list(re.finditer(r'</' + grid_tag + r'>', content[grid_start_idx:grid_end_idx]))
            if closing_tag_match:
                grid_end_idx = grid_start_idx + closing_tag_match[-1].start()
            else:
                grid_end_idx = grid_start_idx + pag_match.start()
        else:
            print(f"Grid end not found in {filepath}")
            continue
    else:
        grid_end_idx = grid_start_idx + grid_end_match.start()
        
    # Replace content between grid_start and grid_end
    new_content = content[:grid_start_idx] + "\n" + PRODUCT_LOOP_TEMPLATE + "\n" + content[grid_end_idx:]
    
    # Replace pagination
    pag_start = re.search(r'<!-- (Pagination|Pagination Bar).*?-->\s*<div[^>]*>', new_content)
    if pag_start:
        # Find closing of pagination
        pag_end = re.search(r'</(?:main|section)>', new_content[pag_start.end():])
        if pag_end:
            actual_pag_start = pag_start.start()
            # We backtrack one </div> before </main> or </section>
            closing_divs = list(re.finditer(r'</div>', new_content[pag_start.start():pag_start.start() + pag_end.start()]))
            if closing_divs:
                actual_pag_end = pag_start.start() + closing_divs[-1].end()
                new_content = new_content[:actual_pag_start] + PAGINATION_TEMPLATE + "\n" + new_content[actual_pag_end:]
    
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(new_content)
        
    print(f"Updated {filepath}")
