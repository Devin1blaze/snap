import re
import os

files_to_update = ['page-login.php', 'page-register.php']

for file in files_to_update:
    if not os.path.exists(file):
        continue
    
    with open(file, 'r') as f:
        content = f.read()

    # Background
    content = content.replace('bg-primary py-24', 'bg-zinc-50 py-24')
    
    # Remove decorative elements
    content = re.sub(r'<!-- Decorative background elements matching the homepage -->\s*<div class="absolute inset-0 z-0 opacity-10 diagonal-band bg-black scale-150 -rotate-12 translate-x-1/4"></div>\s*<div class="absolute w-\[80%\] h-\[80%\] bg-black rounded-full blur-\[120px\] opacity-20 -bottom-1/4 -left-1/4"></div>', '', content)
    
    # Form Container
    content = content.replace('bg-zinc-900 border-b-4 border-secondary p-10 shadow-2xl', 'bg-white border border-zinc-200 p-10 shadow-xl')
    
    # Text colors
    content = content.replace('text-white text-4xl', 'text-zinc-900 text-4xl')
    content = content.replace('text-gray-400 font-bold', 'text-zinc-600 font-bold')
    
    # Inputs
    content = content.replace('bg-zinc-800 border-none text-white', 'bg-zinc-50 border border-zinc-200 text-zinc-900')
    content = content.replace('bg-zinc-800 border-none', 'bg-zinc-50 border border-zinc-200')
    
    # Links & Subtext
    content = content.replace('text-gray-400 text-xs font-bold uppercase tracking-tight group-hover:text-white', 'text-zinc-600 text-xs font-bold uppercase tracking-tight group-hover:text-zinc-900')
    content = content.replace('hover:text-white transition-colors', 'hover:text-zinc-900 transition-colors')
    content = content.replace('text-gray-500 text-xs', 'text-zinc-500 text-xs')
    content = content.replace('text-gray-500 text-[10px]', 'text-zinc-500 text-[10px]')
    content = content.replace('text-gray-300', 'text-zinc-600')
    
    # Borders
    content = content.replace('border-zinc-800', 'border-zinc-200')
    
    # Outlined Buttons
    content = content.replace('text-white border-2 border-white hover:bg-white hover:text-black', 'text-zinc-900 border-2 border-zinc-900 hover:bg-zinc-900 hover:text-white')
    
    with open(file, 'w') as f:
        f.write(content)
        
print("Auth pages updated to light mode.")
