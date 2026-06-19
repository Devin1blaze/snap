import re

with open('D:\\projects\\pro\\snpmarketing without divi\\wp-content\\themes\\snap-stitch-theme\\front-page.php', 'r', encoding='utf-8') as f:
    content = f.read()

start_idx = content.find('<!-- Section 2: Shop by Category (Dynamic) -->')

if start_idx != -1:
    head = content[:start_idx]
    tail = content[start_idx:]
    
    # Text colors
    tail = tail.replace('text-[#0A0A0A]', 'text-[#020617]')
    tail = tail.replace('text-[#1A56DB]', 'text-[#0369A1]')
    tail = tail.replace('text-[#FBBF24]', 'text-[#0369A1]')
    
    # Backgrounds
    tail = tail.replace('bg-[#1A56DB]', 'bg-[#0369A1]')
    tail = tail.replace('bg-[#0A0A0A]', 'bg-[#020617]')
    tail = tail.replace('bg-[#FBBF24]', 'bg-[#0369A1]')
    tail = tail.replace('bg-zinc-50', 'bg-[#F8FAFC]')
    
    # Borders
    tail = tail.replace('border-[#1A56DB]', 'border-[#0369A1]')
    tail = tail.replace('border-[#FBBF24]', 'border-[#0369A1]')
    
    # Text black to white in buttons/badges where we changed bg from gold to blue
    tail = tail.replace('bg-[#0369A1] text-black', 'bg-[#0369A1] text-white')
    tail = tail.replace('hover:text-black', 'hover:text-white')
    tail = tail.replace('hover:bg-[#FBBF24]', 'hover:bg-[#0284C7]')
    tail = tail.replace('hover:bg-yellow-500', 'hover:bg-[#0284C7]')
    tail = tail.replace('hover:bg-black', 'hover:bg-[#0F172A]')
    
    # Gradient overlays
    tail = tail.replace('from-[#0A0A0A]/80', 'from-[#020617]/80')
    tail = tail.replace('via-[#0A0A0A]/30', 'via-[#020617]/30')
    
    # Trust & Scale specific
    tail = tail.replace('bg-[#0369A1] py-24', 'bg-[#0F172A] py-24') # Was bg-[#1A56DB]
    
    # Shadows
    tail = tail.replace('shadow-[10px_10px_0px_rgba(251,191,36,0.3)]', 'shadow-[10px_10px_0px_rgba(3,105,161,0.3)]')
    
    with open('D:\\projects\\pro\\snpmarketing without divi\\wp-content\\themes\\snap-stitch-theme\\front-page.php', 'w', encoding='utf-8') as f:
        f.write(head + tail)
    print('Updated remaining sections.')
else:
    print('Could not find start index.')
