import re

filepath = 'wp-content/themes/snap-stitch-theme/woocommerce/single-product.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

old_block = r'''                <?php endif; ?>

                <!-- Actions -->'''

new_block = r'''                <?php endif; ?>

                <!-- Enterprise Specs Info -->
                <?php 
                    $enterprise_info = get_post_meta( $product_id, '_enterprise_specs_info', true );
                    if ( ! empty( $enterprise_info ) && $is_b2b ) :
                ?>
                <details class="mb-10 group bg-surface-container-low/50" open="">
                    <summary class="list-none cursor-pointer p-4 bg-white border border-zinc-100 flex justify-between items-center text-secondary font-black text-xs uppercase tracking-widest">
                        WHY THESE SPECS MATTER FOR ENTERPRISE
                        <span class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                    </summary>
                    <div class="p-4 text-xs text-zinc-600 leading-relaxed border-x border-b border-zinc-100 bg-white prose prose-sm prose-zinc max-w-none prose-p:mb-2 prose-p:last:mb-0 prose-strong:text-black">
                        <?php echo wp_kses_post( wpautop( $enterprise_info ) ); ?>
                    </div>
                </details>
                <?php endif; ?>

                <!-- Actions -->'''

if re.search(old_block, content):
    content = re.sub(old_block, new_block, content)
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print("Success replacing single-product.php")
else:
    print("Failed to match old_block")
