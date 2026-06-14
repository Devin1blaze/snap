import re

filepath = 'wp-content/themes/snap-stitch-theme/woocommerce/single-product.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

old_block = r'''                        <div class="pt-2 space-y-4">
                            <a href="https://wa.me/919876543210" target="_blank" class="group flex items-center justify-between w-full bg-[#0A0A0A] text-white pl-6 pr-2 h-\[64px\] hover:bg-[#1A56DB] transition-colors duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 bg-\[\#25D366\] animate-pulse"></div>
                                    <span class="text-\[11px\] font-black uppercase tracking-\[0\.15em\] text-white/80 group-hover:text-secondary transition-colors">Have Questions\? Chat With An Expert</span>
                                </div>
                                <div class="bg-\[\#25D366\] text-white px-6 h-\[48px\] flex items-center gap-2 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                    <span class="text-sm font-black uppercase tracking-widest">Chat Now</span>
                                </div>
                            </a>

                            <\?php
                                \$brochure_url = get_post_meta\( \$product_id, '_brochure_url', true \);
                                if \( ! empty\( \$brochure_url \) \) :
                            \?>
                            <a href="<\?php echo esc_url\( \$brochure_url \); \?>" target="_blank" class="flex items-center justify-center gap-3 w-full border-2 border-secondary text-secondary font-black h-\[64px\] uppercase tracking-tighter text-lg hover:bg-secondary hover:text-black transition-all">
                                <span class="material-symbols-outlined text-xl">download</span>
                                DOWNLOAD BROCHURE
                            </a>
                            <\?php endif; \?>
                        </div>'''

new_block = '''                        <div class="pt-4 flex flex-col sm:flex-row gap-4">
                            <a href="https://wa.me/919876543210" target="_blank" class="flex-1 flex items-center justify-center gap-2 border-2 border-zinc-200 text-black font-bold h-[48px] uppercase tracking-widest hover:border-black hover:bg-black hover:text-white transition-all text-[11px]">
                                <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                CHAT ON WHATSAPP
                            </a>

                            <?php
                                $brochure_url = get_post_meta( $product_id, '_brochure_url', true );
                                if ( ! empty( $brochure_url ) ) :
                            ?>
                            <a href="<?php echo esc_url( $brochure_url ); ?>" target="_blank" class="flex-1 flex items-center justify-center gap-2 border-2 border-zinc-200 text-black font-bold h-[48px] uppercase tracking-widest hover:border-black hover:bg-black hover:text-white transition-all text-[11px]">
                                <span class="material-symbols-outlined text-sm">download</span>
                                DOWNLOAD BROCHURE
                            </a>
                            <?php endif; ?>
                        </div>'''

if re.search(old_block, content):
    content = re.sub(old_block, new_block, content)
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print("Success")
else:
    print("Failed to match")
