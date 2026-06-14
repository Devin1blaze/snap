import sys

filepath = 'wp-content/themes/snap-stitch-theme/woocommerce/single-product.php'
with open(filepath, 'r') as f:
    content = f.read()

old_str = """                            </a>
                        </div>
                    <?php else : ?>"""

new_str = """                            </a>
                            
                            <?php 
                                $brochure_url = get_post_meta( $product_id, '_brochure_url', true );
                                if ( ! empty( $brochure_url ) ) :
                            ?>
                            <a href="<?php echo esc_url( $brochure_url ); ?>" target="_blank" class="flex items-center justify-center gap-2 w-full border-2 border-zinc-200 text-black font-bold py-3 mt-4 rounded-full uppercase tracking-widest hover:border-black hover:bg-black hover:text-white transition-all text-xs">
                                <span class="material-symbols-outlined text-base">download</span>
                                Download Brochure
                            </a>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>"""

if old_str in content:
    with open(filepath, 'w') as f:
        f.write(content.replace(old_str, new_str))
    print("Successfully replaced.")
else:
    print("Could not find the old string.")
