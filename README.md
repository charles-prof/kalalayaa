# Kalalayaa Schools & Fine Arts — WordPress Platform
### Crafted with Human Code Organization by CharNithi Software Crafts

> **"Lighting the Path"** — Built for Mrs. Dhipikca Rajasekaran and the teachers, children, and parents of Tiruchirappalli.

---

## 🏛️ Architecture Overview

This repository represents the production WordPress architecture for Kalalayaa Schools & Fine Arts. It adheres strictly to:
1. **WordPress Full Site Editing (FSE) Standards** (`theme.json` v3, HTML block templates, zero build-step block patterns)
2. **SMACSS (Scalable and Modular Architecture for CSS)**:
   - `Base`: Normalized element styling and typographic scale
   - `Layout`: Macro shells (`.l-container`, `.l-header`, `.l-footer`, `.l-grid-*`)
   - `Module`: Self-contained reusable UI components (`.m-campus-card`, `.m-matcher-card`, `.m-counselor-pill`)
   - `State`: Dynamic augmentations (`.is-active`, `.is-open`, `.is-routed`)
   - `Theme`: Branch-specific styling modifiers (`.theme-srirangam`, `.theme-etechno`, etc.)
3. **Multisite-Ready Context Abstraction**: Runs seamlessly as a single-site installation today with campus query routing (`/campuses/{id}/`), yet natively supports WordPress Multisite network activation tomorrow without code changes.
4. **Data Separation**: Custom Post Types and REST API routing reside in a dedicated companion plugin (`kalalayaa-admissions-engine`), ensuring zero student data is ever lost if themes are switched.

---

## 📂 Human-Readable Directory Structure

```
kalalayaa/
├── package.sh                          <-- Builds ready-to-install ZIP packages in dist/
├── dist/
│   ├── kalalayaa-theme.zip             <-- Installable WordPress Theme
│   └── kalalayaa-admissions-engine.zip <-- Installable WordPress Plugin
│
├── wp-content/
│   ├── themes/
│   │   └── kalalayaa/
│   │       ├── style.css               <-- Master theme stylesheet & SMACSS index
│   │       ├── theme.json              <-- Schema v3: Palette (#0E2E35, #E0281D, #27AF0A) & 8pt grid
│   │       ├── functions.php           <-- Enqueues, rewrites, block pattern categories
│   │       ├── inc/
│   │       │   ├── campus-registry.php <-- Declarative 6-campus definitions (SLA ₹8k expansion ready)
│   │       │   ├── class-campus-context.php <-- Single-site vs Multisite context bridge
│   │       │   └── template-tags.php   <-- Semantic helper functions
│   │       ├── templates/
│   │       │   ├── front-page.html     <-- Assembled FSE landing experience
│   │       │   ├── index.html          <-- Fallback archive template
│   │       │   ├── page.html           <-- Standard inner page template
│   │       │   └── 404.html            <-- Warm, reassuring 404 screen
│   │       ├── parts/
│   │       │   ├── header.html         <-- Header with campus switcher
│   │       │   ├── footer.html         <-- 4-column footer
│   │       │   └── campus-strip.html   <-- Fast campus filter navigation strip
│   │       ├── patterns/
│   │       │   ├── hero-matcher.php    <-- Hero with interactive 2-click campus matcher
│   │       │   ├── campuses-grid.php   <-- 6 campus cards with authentic photo headers
│   │       │   ├── founder-quote.php   <-- Mrs. Dhipikca's ethos & 3 pillars
│   │       │   ├── fine-arts-grid.php  <-- 9 disciplines with photo thumbnails
│   │       │   ├── moments-gallery.php <-- Real student life photographic documentation
│   │       │   └── admissions-form.php <-- Smart routing admissions desk & modal
│   │       └── assets/
│   │           ├── css/
│   │           │   ├── base/           <-- reset.css, typography.css, elements.css
│   │           │   ├── layout/         <-- containers.css, grid.css, header.css, footer.css
│   │           │   ├── modules/        <-- card, matcher, counselor, gallery, form, modal, toast
│   │           │   ├── state/          <-- is-active.css, is-open.css, is-routed.css
│   │           │   └── theme/          <-- campuses.css (branch color modifiers)
│   │           ├── js/                 <-- navigation.js, matcher.js, admissions.js
│   │           └── photos/             <-- 1920x750 authentic Kalalayaa campus photography
│   │
│   └── plugins/
│       └── kalalayaa-admissions-engine/
│           ├── kalalayaa-admissions.php <-- Plugin bootstrap & activation hooks
│           ├── inc/
│           │   ├── class-inquiry-cpt.php      <-- Post Type: kalalayaa_inquiry + custom columns
│           │   ├── class-rest-api.php         <-- POST /wp-json/kalalayaa/v1/inquire
│           │   └── class-counselor-mailer.php <-- Deterministic notification mailer
│           └── admin/
│               ├── class-admin-cockpit.php    <-- Staff Cockpit: KPIs, status toggle, CSV export
│               ├── cockpit.css
│               └── cockpit.js
```

---

## 🚀 Installation & Deployment

### Method 1: Drop into Existing WordPress
Copy `wp-content/themes/kalalayaa` to your WordPress `wp-content/themes/` and `wp-content/plugins/kalalayaa-admissions-engine` to `wp-content/plugins/`.

### Method 2: Upload via WordPress Admin
1. Run `./package.sh` in the terminal to generate the fresh zip packages.
2. In WordPress Admin (`/wp-admin/`):
   - Navigate to **Appearance → Themes → Add New → Upload Theme** and choose `dist/kalalayaa-theme.zip`.
   - Navigate to **Plugins → Add New → Upload Plugin** and choose `dist/kalalayaa-admissions-engine.zip`.
   - Activate both.
3. The **Admissions Cockpit** menu will immediately appear in the left sidebar.

---

## 🎨 Color Palette Reference (Derived from Official Logo)
* **Kalalayaa Deep Teal (`#0E2E35`)**: Primary Wordmark (WCAG AAA 10.8:1 contrast).
* **Torch Crimson (`#E0281D`)**: Fine Arts Emblem, Srirangam Accent.
* **Grove Green (`#27AF0A`)**: Tuition & CBSE STEM Emblem, E-Techno Accent.

---

## 📝 Future Branch Expansion SLA
Adding a 7th campus (e.g. Thillai Nagar or Thuvakudi) requires only appending a single declarative entry in `wp-content/themes/kalalayaa/inc/campus-registry.php`. No template restructuring or CSS hacking is needed, honoring CharNithi's **flat ₹8,000 per branch** expansion SLA.
