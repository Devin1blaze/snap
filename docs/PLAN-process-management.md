# Process Management Section Implementation Plan

## Context
- **User Request**: Implement a "Process Management" (How It Works) section using the provided HTML layout from `bhaktienterprises.co.in`, but adapted to Snap Marketing's branding. **Must include the special scroll-triggered line and card pop-in animation.**
- **Mode**: PLANNING ONLY
- **Goal**: Seamlessly integrate the winding timeline layout into `front-page.php` while strictly enforcing the industrial design system (sharp edges, specific color palette, flat heavy shadows) and smoothly recreating the React-based scroll animation using vanilla JavaScript.

## 🌟 The "Special Animation" Strategy
The reference site uses a dynamic scroll animation (likely built with Framer Motion or GSAP in Next.js). Since we are in a lightweight WordPress environment, we will recreate it natively for maximum performance:

1. **The Winding Line**: The SVG paths have a `stroke-dasharray` equal to their length. We will use a vanilla JS scroll listener to calculate the section's scroll percentage and dynamically animate the `stroke-dashoffset` from `100%` to `0`, making the line "draw" itself as the user scrolls down.
2. **The Card Pop-ins**: The cards initially have `opacity-0 translate-y-6 scale-95 blur-sm`. We will use an `IntersectionObserver` in JavaScript so that as each card enters the viewport (or as the drawn line reaches it), those classes are replaced with `opacity-100 translate-y-0 scale-100 blur-0`, triggering the buttery 700ms cubic-bezier transition.

## Design System Adaptations (The "Snap Marketing" Way)

The provided HTML uses soft greens, rounded corners, and gentle drop shadows. We must apply our anti-patterns from `frontend-design` to industrialize it:

1. **Colors**:
   - Backgrounds/Accents: `bg-[#a8e063]` / `yellowgreen-100` ➡️ `#FBBF24` (Industrial Gold)
   - Text/Lines: `text-deepskyblue` / `stroke="#019FDF"` ➡️ `text-primary` / `#1A56DB` (Brand Blue)
   - Section Background: `bg-whitesmoke` ➡️ `bg-zinc-50` or `bg-white`
2. **Typography & Shapes**:
   - `rounded-2xl`, `rounded-3xl`, `rounded-full` ➡️ `rounded-none` (Sharp, rigid edges).
   - Soft Shadows `shadow-[0px_20px_25px...]` ➡️ Solid, offset industrial shadows e.g., `shadow-[8px_8px_0px_#1A56DB]`.
3. **Assets**:
   - The original uses Next.js Image components for PNGs (`1.png` - `6.png`). We will replace these with high-contrast, scalable **Material Symbols** matching the steps (e.g., `shopping_cart`, `assignment`, `precision_manufacturing`, `inventory_2`, `local_shipping`, `task_alt`) to maintain consistency with the rest of `front-page.php`.

## Proposed Changes

### `front-page.php`
- **Location**: Insert the new section just before the "Industries We Serve" block.
- **Content Updates**:
  - Update the heading from "We are a patient experience team..." to an appropriate B2B copy such as "Industrial-Scale Order Fulfillment".
  - Map the 6 timeline steps to the SVG coordinates exactly as provided, preserving the responsive absolute positioning (`top-[9%] left-[12%]`, etc.).
  - Embed the Vanilla JS animation script directly inside the section (or via `functions.php`) to handle the line drawing and Intersection Observers.

## Open Questions

> [!WARNING]
> **To proceed with implementation, I need your input on the following:**
> 1. **Icons vs Images**: Should I use Material Icons for the 6 steps (recommended for consistency), or do you have custom images you'd like to use?
> 2. **SVG Line Color**: Do you want the winding timeline SVG line to be Primary Blue (`#1A56DB`) or Industrial Gold (`#FBBF24`)?
> 3. **Copywriting**: Does the text "Process Management" and the 6 step descriptions need to be updated with new copy, or should I keep the text exactly as provided in the HTML snippet?

## Verification Plan
- [ ] Insert adapted HTML block into `front-page.php`.
- [ ] Apply Tailwind utilities to remove rounded corners and apply brand colors.
- [ ] Implement vanilla JS script for scroll line drawing and card reveal.
- [ ] Ensure mobile, tablet, and desktop SVGs scale correctly without breaking the absolute positioned cards.
