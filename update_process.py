import re

with open('D:\\projects\\pro\\snpmarketing without divi\\wp-content\\themes\\snap-stitch-theme\\front-page.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Define the start and end of the Process Management section to be safe
start_idx = content.find('<!-- Section: Process Management -->')
end_idx = content.find('<!-- SVG & Reveal Animation Logic -->', start_idx)

if start_idx != -1 and end_idx != -1:
    section = content[start_idx:end_idx]
    
    # 1. Header
    section = section.replace('bg-[#FFFFFF]', 'bg-[#F8FAFC]')
    section = section.replace('border-2 border-[#1A56DB] bg-[#1A56DB]/10 text-[#1A56DB] mb-4', 'border-2 border-[#0369A1] bg-[#0369A1]/10 text-[#0369A1] mb-4 rounded')
    section = section.replace('text-black\">Industrial-Scale Order Fulfillment', 'text-[#020617]\">Industrial-Scale Order Fulfillment')
    
    # 2. SVGs
    section = section.replace('stroke=\"#1A56DB\"', 'stroke=\"#0369A1\"')
    
    # 3. Cards Base Styles
    section = section.replace('shadow-[8px_8px_0px_#1A56DB]', 'shadow-[8px_8px_0px_#0369A1] rounded')
    section = section.replace('border-[#1A56DB]', 'border-[#0369A1]')
    
    # Icons background
    section = section.replace('shrink-0 bg-[#1A56DB]', 'shrink-0 bg-[#0369A1]')
    section = section.replace('shrink-0 bg-[#FBBF24]', 'shrink-0 bg-[#0369A1]')
    
    # Number bubble background
    section = section.replace('bg-[#FBBF24] text-black font-black flex items-center justify-center', 'bg-[#0F172A] text-white font-black flex items-center justify-center rounded')
    
    # Text colors
    section = section.replace('text-black uppercase leading-tight', 'text-[#020617] uppercase leading-tight')
    
    # Step 6 specific
    section = section.replace('bg-[#0A0A0A]', 'bg-[#020617]')
    
    # Replace in content
    content = content[:start_idx] + section + content[end_idx:]
    
    with open('D:\\projects\\pro\\snpmarketing without divi\\wp-content\\themes\\snap-stitch-theme\\front-page.php', 'w', encoding='utf-8') as f:
        f.write(content)
    print('Updated Process Management section.')
else:
    print('Could not find Process Management section.')
