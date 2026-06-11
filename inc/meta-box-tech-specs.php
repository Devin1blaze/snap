<?php
/**
 * Add a custom Meta Box for Technical Specifications
 */

add_action( 'add_meta_boxes', 'snap_stitch_add_tech_specs_meta_box' );
function snap_stitch_add_tech_specs_meta_box() {
    add_meta_box(
        'snap_tech_specs',
        __( 'Technical Specifications', 'snap-stitch-theme' ),
        'snap_stitch_tech_specs_html',
        'product',
        'normal',
        'high'
    );
}

function snap_stitch_tech_specs_html( $post ) {
    wp_nonce_field( 'snap_save_tech_specs', 'snap_tech_specs_nonce' );
    
    // Retrieve existing specs
    $specs = get_post_meta( $post->ID, '_technical_specs', true );
    if ( ! is_array( $specs ) ) {
        $specs = [];
    }
    
    // Inline CSS for the admin table
    ?>
    <style>
        #snap_tech_specs_table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        #snap_tech_specs_table th { text-align: left; padding: 8px; background: #f9f9f9; border: 1px solid #ddd; }
        #snap_tech_specs_table td { padding: 8px; border: 1px solid #ddd; }
        .remove-spec { color: #d63638; cursor: pointer; background: none; border: none; font-weight: bold; }
        .remove-spec:hover { color: #a00; }
    </style>

    <div id="snap_tech_specs_wrapper">
        <p>Add technical specifications that will be displayed in the data table on the product page.</p>
        <table id="snap_tech_specs_table">
            <thead>
                <tr>
                    <th>Specification Name (e.g., Material)</th>
                    <th>Specification Value (e.g., Stainless Steel 304)</th>
                    <th style="width: 60px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ( empty( $specs ) ) : ?>
                    <tr>
                        <td><input type="text" name="snap_tech_spec_name[]" class="widefat" placeholder="e.g. Voltage" /></td>
                        <td><input type="text" name="snap_tech_spec_value[]" class="widefat" placeholder="e.g. 220V AC" /></td>
                        <td><button type="button" class="remove-spec button">X</button></td>
                    </tr>
                <?php else : ?>
                    <?php foreach ( $specs as $spec ) : ?>
                        <tr>
                            <td><input type="text" name="snap_tech_spec_name[]" class="widefat" value="<?php echo esc_attr( $spec['name'] ); ?>" /></td>
                            <td><input type="text" name="snap_tech_spec_value[]" class="widefat" value="<?php echo esc_attr( $spec['value'] ); ?>" /></td>
                            <td><button type="button" class="remove-spec button">X</button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <button type="button" class="button button-primary" id="snap_add_spec_row">Add Specification</button>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#snap_add_spec_row').on('click', function(e) {
            e.preventDefault();
            var row = '<tr>' +
                '<td><input type="text" name="snap_tech_spec_name[]" class="widefat" placeholder="e.g. Size" /></td>' +
                '<td><input type="text" name="snap_tech_spec_value[]" class="widefat" placeholder="e.g. 10x10" /></td>' +
                '<td><button type="button" class="remove-spec button">X</button></td>' +
            '</tr>';
            $('#snap_tech_specs_table tbody').append(row);
        });
        
        $(document).on('click', '.remove-spec', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });
    });
    </script>
    <?php
}

add_action( 'save_post_product', 'snap_stitch_save_tech_specs' );
function snap_stitch_save_tech_specs( $post_id ) {
    if ( ! isset( $_POST['snap_tech_specs_nonce'] ) || ! wp_verify_nonce( $_POST['snap_tech_specs_nonce'], 'snap_save_tech_specs' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $specs = [];
    if ( isset( $_POST['snap_tech_spec_name'] ) && isset( $_POST['snap_tech_spec_value'] ) ) {
        $names = wp_unslash( $_POST['snap_tech_spec_name'] );
        $values = wp_unslash( $_POST['snap_tech_spec_value'] );
        
        for ( $i = 0; $i < count( $names ); $i++ ) {
            $name = sanitize_text_field( $names[$i] );
            $value = sanitize_text_field( $values[$i] );
            
            // Only save if both are provided
            if ( ! empty( $name ) && ! empty( $value ) ) {
                $specs[] = [
                    'name'  => $name,
                    'value' => $value,
                ];
            }
        }
    }
    
    update_post_meta( $post_id, '_technical_specs', $specs );
}
