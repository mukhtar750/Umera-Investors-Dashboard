# Uméra Investors Dashboard - Premium Design System

## 🎨 Color Palette

### Primary Colors
- **Deep Wine**: `#890706` - Primary brand color, used for CTAs and key elements
- **Dark Wine**: `#6d0505` / `#5d0505` - Gradient complement
- **Muted Gold**: `#B8976A` - Elegant accent color for highlights and premium touches
- **Gold Complement**: `#8d7555` - Darker gold for gradients

### Neutral Colors
- **White**: `#FFFFFF` - Primary background
- **Black**: `#000000` - Premium footer
- **Neutral 900**: `#171717` - Dark sections
- **Neutral 50-700**: Standard neutral scale

---

## 📐 Typography

### Font Families
1. **Cormorant Garamond** (Serif)
   - Usage: Headings, hero text, sophisticated titles
   - Weights: 300 (Light), 400 (Regular), 500, 600, 700
   - Character: Elegant, luxury, investment-grade

2. **Inter** (Sans-serif)
   - Usage: Body text, UI elements, descriptions
   - Weights: 300 (Light), 400 (Regular), 500 (Medium), 600 (Semi-bold), 700 (Bold)
   - Character: Modern, readable, professional

### Type Scale
- **Hero Headings**: `clamp(3rem, 8vw, 7rem)` - Cormorant Garamond 300
- **Section Headings**: `text-5xl` to `text-6xl` - Cormorant Garamond 300
- **Subsection Headings**: `text-3xl` to `text-4xl` - Cormorant Garamond 400
- **Body Large**: `text-xl` to `text-2xl` - Inter 300
- **Body Regular**: `text-base` to `text-lg` - Inter 300-400
- **Small Text**: `text-sm` - Inter 300

---

## 🎭 Design Principles

### 1. **Premium Minimalism**
- Generous white space (py-28 for sections)
- Clean layouts with clear hierarchy
- Subtle decorative elements, never overwhelming
- Focus on content, not decoration

### 2. **Sophisticated Interactions**
- Smooth transitions (300-500ms duration)
- Hover states that elevate without jarring
- Micro-animations for engagement
- Progressive disclosure

### 3. **Investment-Grade Trust**
- Security indicators throughout
- Professional imagery
- Consistent brand application
- Data transparency emphasis

### 4. **Responsive Elegance**
- Desktop-first approach
- Graceful degradation on mobile
- Maintained luxury feel across devices
- Touch-friendly interactions

---

## 🧩 Component Patterns

### Navigation
- **Desktop**: Sticky nav with blur backdrop on scroll
- **Logo**: 12x12px with gradient background + gold accent dot
- **CTA**: Minimal border button, transforms on scroll
- **Behavior**: Changes from transparent to white with shadow

### Buttons

#### Primary CTA
```tsx
className="bg-gradient-to-r from-[#890706] to-[#6d0505] text-white px-12 py-5 
           hover:shadow-2xl hover:shadow-[#890706]/50 transition-all duration-500"
```

#### Secondary CTA
```tsx
className="border border-white/30 text-white px-12 py-5 
           hover:border-[#B8976A] hover:bg-white/5 transition-all duration-300"
```

#### Icon Button
```tsx
className="flex items-center gap-3 group"
// Icon with group-hover:translate-x-2 transition
```

### Cards

#### Feature Card
- White background
- Border: `border-neutral-200`
- Hover: `hover:border-[#890706]/20 hover:shadow-2xl`
- Padding: `p-10`
- Icon container: 16x16 with transition to gradient background

#### Stat Card
- Centered content
- Large number: Cormorant Garamond, gradient text
- Label: Small, tracked, neutral
- Divider line with hover expansion

### Forms

#### Input Fields
```tsx
className="w-full px-5 py-4 bg-neutral-50 border border-neutral-300 
           focus:border-[#890706] focus:bg-white transition-all duration-300"
```

#### Labels
```tsx
className="block mb-2 text-neutral-700" 
style={{ fontWeight: 400 }}
```

### Decorative Elements

#### Gradient Lines
```tsx
<div className="w-24 h-px bg-gradient-to-r from-transparent via-[#890706] to-transparent" />
```

#### Background Overlays
```tsx
<div className="absolute inset-0 bg-gradient-to-br from-black/80 via-black/70 to-[#890706]/30" />
```

#### Decorative Squares
```tsx
<div className="absolute top-1/4 right-10 w-64 h-64 border border-[#B8976A]/20 rotate-45 opacity-30" />
```

---

## 📏 Spacing System

### Section Padding
- **Major sections**: `py-28`
- **Minor sections**: `py-20`
- **Compact sections**: `py-12`

### Container Widths
- **Standard**: `max-w-7xl mx-auto`
- **Narrow**: `max-w-6xl mx-auto`
- **Text**: `max-w-3xl mx-auto`

### Grid Gaps
- **Large**: `gap-16 lg:gap-20`
- **Standard**: `gap-8 lg:gap-12`
- **Compact**: `gap-4 lg:gap-6`

---

## 🎬 Animation Guidelines

### Transition Speeds
- **Fast**: `150ms` - Small UI elements
- **Standard**: `300ms` - Most interactions
- **Smooth**: `500ms` - Sophisticated effects
- **Slow**: `700ms` - Shimmer/slide effects

### Common Patterns
```tsx
// Hover translate
group-hover:translate-x-2 transition-transform duration-300

// Scale on hover
group-hover:scale-110 transition-transform duration-500

// Fade with slide up
opacity-0 group-hover:opacity-100 transition-opacity duration-500

// Background shimmer
transform -skew-x-12 -translate-x-full group-hover:translate-x-full 
transition-transform duration-700
```

---

## 🖼️ Image Treatment

### Hero Images
- Overlay: `bg-gradient-to-br from-black/80 via-black/70 to-[#890706]/30`
- Scale: `scale-105` for subtle zoom
- Additional radial gradient for depth

### Feature Images
- Aspect ratio: `aspect-[3/4]` or `aspect-[4/3]`
- Shadow: `shadow-2xl`
- Decorative frames with borders/colored blocks

### Background Images
- Always with overlay
- Blur backgrounds: `backdrop-blur-md` or `backdrop-blur-sm`

---

## 🔐 Security UI Patterns

### Trust Badges
- Shield icons with gradient backgrounds
- 256-bit encryption mentions
- SSL certificate indicators
- Audit trail references

### Access Control UI
- Lock icons for protected content
- Role-based access messaging
- "Verified investors only" labels
- Confidentiality assurances

---

## 📱 Responsive Breakpoints

### Tailwind Defaults
- **sm**: 640px
- **md**: 768px
- **lg**: 1024px
- **xl**: 1280px

### Common Patterns
```tsx
// Typography
text-3xl lg:text-5xl

// Grid
grid-cols-1 md:grid-cols-2 lg:grid-cols-3

// Spacing
px-6 lg:px-12

// Hide/Show
hidden lg:block
```

---

## 🎯 Call-to-Action Hierarchy

### Primary
- "Access Dashboard" / "Investor Login"
- Gradient background, white text
- Prominent placement, largest size

### Secondary
- "Request Access"
- Transparent with border
- Equal visual weight but less urgency

### Tertiary
- Text links with arrow
- Subtle hover states
- Supporting actions

---

## ✨ Luxury Details

### Micro-interactions
1. Navigation blur effect on scroll
2. Animated underlines on hover
3. Icon movements in button groups
4. Smooth color transitions
5. Subtle pulse on interactive elements

### Premium Touches
1. Dual typography (serif + sans)
2. Gold accent strategically placed
3. Generous negative space
4. High-quality imagery only
5. Consistent iconography (Lucide React)

### Professional Copy
- **Tone**: Confident, sophisticated, trustworthy
- **Voice**: Third person, professional
- **Language**: Investment terminology, no jargon
- **Labels**: "Verified", "Secure", "Exclusive", "Premium"

---

## 🚀 Implementation Notes

### Performance
- Images optimized and lazy-loaded
- Transitions use `transform` and `opacity` (GPU-accelerated)
- Minimal re-renders with proper React patterns

### Accessibility
- High contrast maintained
- Focus states visible
- Semantic HTML structure
- ARIA labels where needed

### Browser Support
- Modern browsers (Chrome, Firefox, Safari, Edge)
- CSS Grid and Flexbox
- Custom properties (CSS variables)
- Backdrop filters with fallbacks

---

## 📋 Component Checklist

### Landing Page
✅ Premium hero with gradient overlay  
✅ Sticky navigation with scroll behavior  
✅ Trust indicators section  
✅ Stats showcase  
✅ Feature grid (6 cards)  
✅ Timeline "How It Works"  
✅ Security split section  
✅ Premium footer  

### Sign In Page
✅ Split layout (form + visual)  
✅ Premium form styling  
✅ Password visibility toggle  
✅ Remember me checkbox  
✅ Error state handling  
✅ Loading states  
✅ Security badges  
✅ Responsive design  

---

## 🎨 Figma/Design Tool Integration

If recreating in Figma:
1. Import Cormorant Garamond and Inter fonts
2. Set up color variables for brand colors
3. Create component library for buttons, cards, inputs
4. Use Auto Layout for responsive behavior
5. Apply 8px grid system
6. Layer effects: Drop shadows at 0-20px, low opacity

---

*This is a premium, investment-grade design system. Every decision prioritizes trust, clarity, and sophistication.*
