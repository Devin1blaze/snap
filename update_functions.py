import re

filepath = 'wp-content/themes/snap-stitch-theme/functions.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

old_block = r'''    <label>
        <input type="radio" name="snap_product_design_type" value="b2c" <?php checked( $value, 'b2c' ); ?> />
        B2C Design (Retail, Add to Cart)
    </label>
    <?php
}

add_action( 'save_post_product', 'snap_stitch_save_product_design_meta_box' );'''

new_block = r'''    <label>
        <input type="radio" name="snap_product_design_type" value="b2c" <?php checked( $value, 'b2c' ); ?> />
        B2C Design (Retail, Add to Cart)
    </label>

    <hr style="margin: 15px 0;" />
    
    <p><strong>Brochure PDF URL (B2B):</strong></p>
    <?php $brochure = get_post_meta( $post->ID, '_brochure_url', true ); ?>
    <input type="url" name="snap_brochure_url" value="<?php echo esc_attr( $brochure ); ?>" class="widefat" placeholder="https://..." />
    <p class="description">Adds a "Download Brochure" button if filled.</p>

    <hr style="margin: 15px 0;" />
    
    <p><strong>Why These Specs Matter (Enterprise Context):</strong></p>
    <?php 
    $enterprise_info = get_post_meta( $post->ID, '_enterprise_specs_info', true ); 
    wp_editor( $enterprise_info, 'snap_enterprise_specs_info', array(
        'textarea_name' => 'snap_enterprise_specs_info',
        'media_buttons' => false,
        'textarea_rows' => 5,
        'teeny'         => true,
    ) );
    ?>
    <p class="description">This content will be displayed in an expandable accordion under the specs table for B2B products.</p>
    <?php
}

add_action( 'save_post_product', 'snap_stitch_save_product_design_meta_box' );'''

if re.search(old_block, content):
    content = re.sub(old_block, new_block, content)
else:
    print("Failed to match old_block 1")

old_block_save = r'''        // Add to correct category and remove from opposite
        wp_set_object_terms( $post_id, $term_slug, 'product_cat', true );
        wp_remove_object_terms( $post_id, $opposite_slug, 'product_cat' );
    }
}'''

new_block_save = r'''        // Add to correct category and remove from opposite
        wp_set_object_terms( $post_id, $term_slug, 'product_cat', true );
        wp_remove_object_terms( $post_id, $opposite_slug, 'product_cat' );
    }

    if ( isset( $_POST['snap_brochure_url'] ) ) {
        update_post_meta( $post_id, '_brochure_url', sanitize_url( $_POST['snap_brochure_url'] ) );
    }
    
    if ( isset( $_POST['snap_enterprise_specs_info'] ) ) {
        update_post_meta( $post_id, '_enterprise_specs_info', wp_kses_post( wp_unslash( $_POST['snap_enterprise_specs_info'] ) ) );
    }
}'''

if re.search(old_block_save, content):
    content = re.sub(old_block_save, new_block_save, content)
else:
    print("Failed to match old_block 2")

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated functions.php")
