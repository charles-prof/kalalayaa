// Kalalayaa Schools & Fine Arts — Unified Campus Application Engine
// CharNithi Software Crafts | Built with UX Laws & 8pt Grid System

import { CAMPUSES, FINE_ARTS_DISCIPLINES, MOMENTS_GALLERY, INITIAL_INQUIRIES, PARENT_TESTIMONIALS } from './data/campuses.js';

/* ═══════════════════════════════════════════════════════════
   APPLICATION STATE
   ═══════════════════════════════════════════════════════════ */
const STATE = {
  activeCampusId: 'all',
  inquiries: [],
  adminFilter: 'all',
};

/* ═══════════════════════════════════════════════════════════
   DATA PERSISTENCE (localStorage)
   ═══════════════════════════════════════════════════════════ */
function initData() {
  const stored = localStorage.getItem('kalalayaa_inquiries_v2');
  if (stored) {
    try { STATE.inquiries = JSON.parse(stored); }
    catch (e) { STATE.inquiries = [...INITIAL_INQUIRIES]; }
  } else {
    STATE.inquiries = [...INITIAL_INQUIRIES];
    saveInquiries();
  }
}

function saveInquiries() {
  localStorage.setItem('kalalayaa_inquiries_v2', JSON.stringify(STATE.inquiries));
}

/* ═══════════════════════════════════════════════════════════
   SVG ICON SYSTEM
   ═══════════════════════════════════════════════════════════ */
const ICONS = {
  check:    `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>`,
  phone:    `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>`,
  mapPin:   `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>`,
  arrow:    `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>`,
  wa:       `<svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>`,
  sparkles: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>`,
  box:      `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>`,
  music:    `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>`,
  palette:  `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>`,
  award:    `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>`,
  cpu:      `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/></svg>`,
  target:   `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>`,
  users:    `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>`,
  volume:   `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>`,
};

function icon(name) { return ICONS[name] || ICONS.sparkles; }

/* ═══════════════════════════════════════════════════════════
   CAMPUS STRIP RENDER
   Von Restorff: active chip visually stands apart from rest
   ═══════════════════════════════════════════════════════════ */
function renderCampusStrip() {
  const list = document.getElementById('campusStripList');
  if (!list) return;

  const allBtn = `
    <li role="presentation">
      <button
        class="strip-btn ${STATE.activeCampusId === 'all' ? 'active' : ''}"
        role="tab"
        aria-selected="${STATE.activeCampusId === 'all'}"
        onclick="window.selectCampus('all')"
      >
        ${icon('sparkles')} All 6 Campuses
      </button>
    </li>`;

  const campusBtns = CAMPUSES.map(c => `
    <li role="presentation">
      <button
        class="strip-btn ${STATE.activeCampusId === c.id ? 'active' : ''}"
        role="tab"
        aria-selected="${STATE.activeCampusId === c.id}"
        onclick="window.selectCampus('${c.id}')"
      >
        <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:${c.accentColor}; flex-shrink:0;" aria-hidden="true"></span>
        ${c.name.replace('Kalalayaa ', '')}
      </button>
    </li>`).join('');

  list.innerHTML = allBtn + campusBtns;
}

/* ═══════════════════════════════════════════════════════════
   CAMPUS SELECTOR DROPDOWN
   ═══════════════════════════════════════════════════════════ */
function renderCampusMenu() {
  const menu = document.getElementById('campusMenu');
  if (!menu) return;

  const allItem = `
    <div
      class="campus-selector__item ${STATE.activeCampusId === 'all' ? 'active' : ''}"
      role="option"
      aria-selected="${STATE.activeCampusId === 'all'}"
      onclick="window.selectCampus('all')"
    >
      <span class="campus-selector__dot" style="background:var(--k-teal-500);" aria-hidden="true"></span>
      <div>
        <div class="campus-selector__label">All Campuses (Trichy)</div>
        <div class="campus-selector__sub">Overview of all 6 branches</div>
      </div>
    </div>`;

  const items = CAMPUSES.map(c => `
    <div
      class="campus-selector__item ${STATE.activeCampusId === c.id ? 'active' : ''}"
      role="option"
      aria-selected="${STATE.activeCampusId === c.id}"
      onclick="window.selectCampus('${c.id}')"
    >
      <span class="campus-selector__dot" style="background:${c.accentColor};" aria-hidden="true"></span>
      <div>
        <div class="campus-selector__label">${c.name}</div>
        <div class="campus-selector__sub">${c.landmark}</div>
      </div>
    </div>`).join('');

  menu.innerHTML = allItem + items;
}

/* ═══════════════════════════════════════════════════════════
   CAMPUS CARDS GRID
   Miller's Law: 6 cards = within 7±2 capacity
   Law of Proximity: counselor details grouped in one block
   ═══════════════════════════════════════════════════════════ */
function renderCampusCards() {
  const grid = document.getElementById('campusesGrid');
  if (!grid) return;

  grid.innerHTML = CAMPUSES.map(c => `
    <article
      class="campus-card"
      role="listitem"
      aria-label="${c.name}"
    >
      <div class="campus-card__media">
        <img src="${c.image}" alt="${c.name} Campus Environment" loading="lazy">
        <span class="campus-card__media-badge">${c.badge}</span>
      </div>
      <div class="campus-card__accent-bar" style="background:${c.accentColor};" aria-hidden="true"></div>

      <header class="campus-card__header">
        <h3 class="campus-card__name">${c.name}</h3>
        <p class="campus-card__sub">${c.subtitle}</p>
      </header>

      <div class="campus-card__body">
        <p class="campus-card__desc">${c.description}</p>

        <ul class="campus-card__features" aria-label="Campus highlights">
          ${c.features.slice(0, 3).map(f => `
            <li>
              <span class="check-icon">${icon('check')}</span>
              <span>${f}</span>
            </li>`).join('')}
        </ul>

        <!-- Law of Proximity: all counselor contact info together -->
        <div class="counselor-pill" role="group" aria-label="Campus counselor contact">
          <div>
            <div class="counselor-pill__name">${c.counselor}</div>
            <div class="counselor-pill__role">${c.counselorTitle}</div>
          </div>
          <a
            href="tel:${c.phone}"
            style="color:${c.accentColor}; display:flex; align-items:center; gap:4px;"
            aria-label="Call ${c.counselor} at ${c.phone}"
            title="Call Counselor"
          >
            ${icon('phone')}
          </a>
        </div>
      </div>

      <footer class="campus-card__footer">
        <button
          class="btn btn-outline btn-sm"
          onclick="window.selectCampus('${c.id}')"
          aria-label="View full detail for ${c.name}"
        >
          Campus Detail ${icon('arrow')}
        </button>
        <button
          class="btn btn-sm"
          style="background:${c.accentColor}; color:white; border-color:${c.accentColor};"
          onclick="window.openAdmissions('${c.id}')"
          aria-label="Apply to ${c.name}"
        >
          Apply Here
        </button>
      </footer>
    </article>
  `).join('');
}

/* ═══════════════════════════════════════════════════════════
   CAMPUS MICRO-VIEW (expanded detail)
   Law of Common Region: bounded container = grouped info
   ═══════════════════════════════════════════════════════════ */
function renderMicroView(campusId) {
  const container = document.getElementById('microView');
  if (!container) return;

  if (campusId === 'all') {
    container.classList.remove('active');
    return;
  }

  const c = CAMPUSES.find(x => x.id === campusId);
  if (!c) return;

  container.innerHTML = `
    <div class="micro-view__banner">
      <img src="${c.image}" alt="${c.name} Campus">
      <div class="micro-view__banner-overlay">
        <div class="micro-view__banner-text">
          <span class="badge" style="background:white; color:var(--k-teal-900); margin-bottom:8px;">${c.badge}</span>
          <h2 style="font-size:clamp(var(--text-2xl), 4vw, var(--text-4xl)); color:white; margin-bottom:4px; font-family:var(--font-display);">${c.name}</h2>
          <p style="font-size:var(--text-base); color:rgba(255,255,255,0.9);">${c.subtitle}</p>
        </div>
      </div>
    </div>

    <div class="micro-view__header">
      <div>
        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:12px;">
          <span class="badge" style="background:${c.accentBg}; color:${c.accentColor}; border-color:${c.accentColor}30;">${c.badge}</span>
          <span class="badge badge-teal">Est. ${c.established}</span>
          <span class="badge badge-green">${c.studentRatio}</span>
        </div>
        <h2 style="font-size:var(--text-4xl); color:${c.accentColor}; margin-bottom:8px;">${c.name}</h2>
        <p style="font-size:var(--text-lg); color:var(--color-text-muted); max-width:580px; margin-bottom:10px;">${c.subtitle}</p>
        <div style="display:flex; align-items:center; gap:6px; font-size:var(--text-sm); color:var(--color-text-muted);">
          ${icon('mapPin')} <span>${c.address} · ${c.landmark}</span>
        </div>
      </div>
      <div style="display:flex; flex-direction:column; gap:10px; align-items:flex-end; flex-shrink:0;">
        <button class="btn btn-outline btn-sm" onclick="window.selectCampus('all')" aria-label="Back to all campuses">
          ← Back to All Campuses
        </button>
        <button
          class="btn btn-sm"
          style="background:${c.accentColor}; color:white; border-color:${c.accentColor};"
          onclick="window.openAdmissions('${c.id}')"
        >
          Apply to ${c.name.replace('Kalalayaa ', '')}
        </button>
      </div>
    </div>

    <div class="micro-view__grid">
      <div>
        <h3 style="font-size:var(--text-2xl); margin-bottom:var(--sp-3);">Curriculum & Programs</h3>
        ${c.programs.map(p => `
          <div class="program-item">
            <div class="program-item__top">
              <span class="program-item__name">${p.name}</span>
              <span class="program-item__age">${p.age}</span>
            </div>
            <p class="program-item__desc">${p.desc}</p>
          </div>`).join('')}

        <h3 style="font-size:var(--text-xl); margin-top:var(--sp-5); margin-bottom:var(--sp-2);">Campus Infrastructure & Care</h3>
        <ul class="campus-card__features" style="margin-bottom:0;" aria-label="Campus features">
          ${c.features.map(f => `
            <li style="font-size:var(--text-base); padding-block:6px;">
              <span class="check-icon" style="color:${c.accentColor};">${icon('check')}</span>
              <span>${f}</span>
            </li>`).join('')}
        </ul>
      </div>

      <div>
        <!-- Law of Proximity: all counselor contact info in one bounded block -->
        <div class="counselor-block">
          <h4 style="margin-bottom:var(--sp-2); font-size:var(--text-lg);">Dedicated Campus Counselor</h4>
          <div style="display:flex; align-items:center; gap:14px; margin-bottom:var(--sp-2);">
            <div style="
              width:52px; height:52px; border-radius:50%;
              background:${c.accentBg}; color:${c.accentColor};
              display:flex; align-items:center; justify-content:center;
              font-weight:800; font-size:var(--text-xl); font-family:var(--font-display);
              flex-shrink:0;
            " aria-hidden="true">
              ${c.counselor[4] || c.counselor[0]}
            </div>
            <div>
              <div class="counselor-block__name">${c.counselor}</div>
              <div class="counselor-block__role">${c.counselorTitle}</div>
            </div>
          </div>
          <p class="counselor-block__quote">
            "Whenever you have a question about admissions, transport, or your child's first day — I am personally here for you."
          </p>
          <div class="counselor-block__actions">
            <a href="tel:${c.phone}" class="btn btn-outline btn-sm" style="justify-content:flex-start;">
              ${icon('phone')} ${c.phone}
            </a>
            <a
              href="https://wa.me/${c.whatsapp}?text=Hello%20${encodeURIComponent(c.counselor)},%20I%20would%20like%20to%20enquire%20about%20admissions%20at%20${encodeURIComponent(c.name)}."
              target="_blank"
              rel="noopener noreferrer"
              class="btn btn-wa btn-sm"
              style="justify-content:flex-start;"
            >
              ${icon('wa')} WhatsApp Campus Desk
            </a>
          </div>
        </div>

        <!-- Quick facts -->
        <div class="quick-facts" role="list" aria-label="Campus statistics">
          <div class="quick-fact-row" role="listitem">
            <span class="quick-fact-row__label">Student Capacity</span>
            <span class="quick-fact-row__val">${c.capacity}</span>
          </div>
          <div class="quick-fact-row" role="listitem">
            <span class="quick-fact-row__label">Teaching Educators</span>
            <span class="quick-fact-row__val">${c.stats.teachers}</span>
          </div>
          <div class="quick-fact-row" role="listitem">
            <span class="quick-fact-row__label">Parent Rating</span>
            <span class="quick-fact-row__val" style="color:#D97706;">★ ${c.stats.parentRating}</span>
          </div>
          <div class="quick-fact-row" role="listitem">
            <span class="quick-fact-row__label">Students Enrolled</span>
            <span class="quick-fact-row__val" style="color:${c.accentColor};">${c.stats.students}</span>
          </div>
        </div>
      </div>
    </div>
  `;

  container.classList.add('active');
  requestAnimationFrame(() => {
    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
}

/* ═══════════════════════════════════════════════════════════
   FINE ARTS GRID
   ═══════════════════════════════════════════════════════════ */
function renderFineArts() {
  const grid = document.getElementById('artsGrid');
  if (!grid) return;

  const iconMap = {
    sparkles: 'sparkles', music: 'music', 'volume-2': 'volume',
    palette: 'palette', box: 'box', award: 'award',
    cpu: 'cpu', target: 'target', users: 'users',
  };

  grid.innerHTML = FINE_ARTS_DISCIPLINES.map(f => `
    <article class="arts-card" role="listitem" aria-label="${f.title}">
      ${f.image ? `
        <div class="arts-card__media">
          <img src="${f.image}" alt="${f.title}" loading="lazy">
        </div>
      ` : ''}
      <div class="arts-card__icon-wrap" aria-hidden="true">
        ${icon(iconMap[f.icon] || 'sparkles')}
      </div>
      <div class="arts-card__category">${f.category} · ${f.ageGroup}</div>
      <h3 class="arts-card__name">${f.title}</h3>
      <p class="arts-card__desc">${f.desc}</p>
      <div class="arts-card__campuses">
        Offered at: <strong>${f.campuses.join(', ')}</strong>
      </div>
    </article>
  `).join('');
}

/* ═══════════════════════════════════════════════════════════
   MOMENTS OF JOY GALLERY (Real Campus Life)
   ═══════════════════════════════════════════════════════════ */
function renderMomentsGallery() {
  const grid = document.getElementById('momentsGrid');
  if (!grid) return;

  grid.innerHTML = MOMENTS_GALLERY.map(m => `
    <article class="moment-card" role="listitem" aria-label="${m.title}">
      <div class="moment-card__image-wrap">
        <img src="${m.image}" alt="${m.title}" loading="lazy">
        <span class="moment-card__tag">${m.tag}</span>
      </div>
      <div class="moment-card__body">
        <div class="moment-card__category">${m.category}</div>
        <h3 class="moment-card__title">${m.title}</h3>
        <p class="moment-card__caption">${m.caption}</p>
      </div>
    </article>
  `).join('');
}

/* ═══════════════════════════════════════════════════════════
   TESTIMONIALS
   ═══════════════════════════════════════════════════════════ */
function renderTestimonials() {
  const grid = document.getElementById('testimonialsGrid');
  if (!grid) return;

  grid.innerHTML = PARENT_TESTIMONIALS.map(t => `
    <article class="testimonial-card" role="listitem" aria-label="Testimonial from ${t.parent}">
      <div class="testimonial-card__stars" aria-label="5 out of 5 stars">★★★★★</div>
      <p class="testimonial-card__text">"${t.text}"</p>
      <hr class="testimonial-card__divider">
      <div class="testimonial-card__name">${t.parent}</div>
      <div class="testimonial-card__child">${t.child}</div>
      <div class="testimonial-card__badge">✔ ${t.verified}</div>
    </article>
  `).join('');
}

/* ═══════════════════════════════════════════════════════════
   SMART CAMPUS MATCHER (Hero Tool)
   Hick's Law: 2 selects → instant, deterministic result
   ═══════════════════════════════════════════════════════════ */
function updateMatcher() {
  const age = document.getElementById('matcherAge')?.value;
  const loc = document.getElementById('matcherLocality')?.value;
  const result = document.getElementById('matcherResult');
  if (!result) return;

  let campusId = 'kk-nagar';
  let program = 'Foundations & Fine Arts Hub';

  if (age === 'cbse' || loc === 'etechno') {
    campusId = 'e-techno';
    program = 'CBSE Grades & Robotics STEM Lab';
  } else if (loc === 'srirangam') {
    campusId = 'srirangam';
    program = age === 'toddler' ? 'Toddler Gurukulam Nest' : 'Heritage Pre-KG & Fine Arts';
  } else if (loc === 'crawford') {
    campusId = 'crawford';
    program = 'Cozy Neighbourhood Playgroup';
  } else if (loc === 'cantonment') {
    campusId = 'cantonment';
    program = 'Pre-KG & Extended Corporate Daycare';
  } else if (loc === 'kailash') {
    campusId = 'kailash-nagar';
    program = 'Active Playgroup & Junior Archery';
  } else {
    campusId = 'kk-nagar';
    program = age === 'arts' ? 'Fine Arts Academy (Dance & Music)' : 'Foundations & Fine Arts Hub';
  }

  const c = CAMPUSES.find(x => x.id === campusId) || CAMPUSES[0];

  result.innerHTML = `
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
      <strong style="color:${c.accentColor}; font-size:var(--text-base);">Recommended: ${c.name}</strong>
      <span class="badge" style="background:${c.accentBg}; color:${c.accentColor}; border-color:${c.accentColor}30;">${c.badge.split(' ')[0]}</span>
    </div>
    <div style="font-size:var(--text-sm); color:var(--color-text-muted); margin-bottom:12px; line-height:1.5;">
      Best match: <strong>${program}</strong><br>
      Counselor: <strong>${c.counselor}</strong>
    </div>
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
      <button
        class="btn btn-sm"
        style="background:${c.accentColor}; color:white; border-color:${c.accentColor};"
        onclick="window.selectCampus('${c.id}')"
      >
        View Campus
      </button>
      <button
        class="btn btn-outline btn-sm"
        onclick="window.openAdmissions('${c.id}')"
      >
        Book Free Trial Class
      </button>
    </div>
  `;
}

/* ═══════════════════════════════════════════════════════════
   FORM: POPULATE CAMPUSES & ROUTING PREVIEW
   ═══════════════════════════════════════════════════════════ */
function populateFormCampuses() {
  const select = document.getElementById('formCampus');
  if (!select) return;
  select.innerHTML = CAMPUSES.map(c => `
    <option value="${c.id}">${c.name}</option>
  `).join('');
}

function updateFormRouting() {
  const campusId = document.getElementById('formCampus')?.value;
  const preview = document.getElementById('formRoutingPreview');
  if (!preview) return;

  const c = CAMPUSES.find(x => x.id === campusId) || CAMPUSES[0];
  preview.innerHTML = `
    ${icon('phone')}
    <div>
      <strong>Smart Routing Active:</strong>
      Your application will go directly to <strong>${c.counselor}</strong> at the
      <strong>${c.name}</strong> desk — no shared inbox, no delays.
    </div>
  `;
}

/* ═══════════════════════════════════════════════════════════
   FORM SUBMISSION
   Peak-End Rule: success modal is the emotional climax
   ═══════════════════════════════════════════════════════════ */
function handleFormSubmit(e) {
  e.preventDefault();

  const name    = document.getElementById('parentName')?.value.trim();
  const phone   = document.getElementById('parentPhone')?.value.trim();
  const child   = document.getElementById('childName')?.value.trim();
  const childAge = document.getElementById('childAge')?.value.trim();
  const email   = document.getElementById('parentEmail')?.value.trim();
  const campusId = document.getElementById('formCampus')?.value;
  const program = document.getElementById('formProgram')?.value;
  const notes   = document.getElementById('formNotes')?.value.trim();

  if (!name || !phone || !child || !childAge) {
    showToast('Please fill in all required fields.');
    return;
  }

  const c = CAMPUSES.find(x => x.id === campusId) || CAMPUSES[0];
  const refId = `KL-2026-${c.id.substring(0, 3).toUpperCase()}-${Math.floor(100 + Math.random() * 900)}`;

  const newInquiry = {
    id: refId,
    parentName: name,
    childName: child,
    childAge,
    phone,
    email: email || '—',
    campusId: c.id,
    campusName: c.name,
    program,
    status: 'New',
    date: new Date().toLocaleString('en-IN'),
    counselor: c.counselor,
    notes: notes || 'Direct portal submission.',
  };

  STATE.inquiries.unshift(newInquiry);
  saveInquiries();
  renderAdminTable();
  updateAdminStats();
  showSuccessModal(newInquiry, c);

  document.getElementById('admissionsForm')?.reset();
  updateFormRouting();
  showToast(`Inquiry ${refId} routed to ${c.counselor}`);
}

/* ═══════════════════════════════════════════════════════════
   SUCCESS MODAL
   Peak-End Rule: warmth + reference ID + direct WhatsApp
   ═══════════════════════════════════════════════════════════ */
function showSuccessModal(inq, campus) {
  const body = document.getElementById('successModalBody');
  const modal = document.getElementById('successModal');
  if (!body || !modal) return;

  body.innerHTML = `
    <div style="text-align:center; margin-bottom:var(--sp-4);">
      <div style="
        width:72px; height:72px; border-radius:50%;
        background:var(--k-green-50); color:var(--k-green-600);
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 16px; font-size:2rem;
      " aria-hidden="true">✓</div>
      <h2 style="font-size:var(--text-2xl); margin-bottom:8px;">Application Received with Warmth</h2>
      <p style="font-size:var(--text-sm); color:var(--color-text-muted);">Welcome to the Kalalayaa family. We are honoured to be part of your child's journey.</p>
    </div>

    <div style="
      background:var(--k-teal-25); border:1px solid var(--k-teal-100);
      border-radius:var(--radius-md); padding:var(--sp-3); margin-bottom:var(--sp-3);
    ">
      <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:var(--text-sm);">
        <span style="color:var(--color-text-muted);">Inquiry Reference</span>
        <strong class="ref-id">${inq.id}</strong>
      </div>
      <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:var(--text-sm);">
        <span style="color:var(--color-text-muted);">Child</span>
        <strong>${inq.childName} · ${inq.childAge}</strong>
      </div>
      <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:var(--text-sm);">
        <span style="color:var(--color-text-muted);">Target Campus</span>
        <strong>${campus.name}</strong>
      </div>
      <div style="display:flex; justify-content:space-between; font-size:var(--text-sm);">
        <span style="color:var(--color-text-muted);">Assigned Counselor</span>
        <strong style="color:var(--k-green-600);">${campus.counselor}</strong>
      </div>
    </div>

    <div style="
      background:var(--k-teal-50); border:1px solid var(--k-teal-100);
      border-radius:var(--radius-md); padding:var(--sp-2); margin-bottom:var(--sp-4);
      font-size:var(--text-sm); color:var(--k-teal-700); line-height:1.55;
    ">
      <strong>What happens next?</strong><br>
      ${campus.counselor} will reach out to you within 2 hours to arrange a warm, personal campus walkthrough at a time that suits your family.
    </div>

    <div style="display:flex; gap:var(--sp-1); flex-wrap:wrap;">
      <a
        href="https://wa.me/${campus.whatsapp}?text=Hello%20${encodeURIComponent(campus.counselor)},%20I%20just%20submitted%20an%20application%20for%20my%20child%20${encodeURIComponent(inq.childName)}%20(Ref:%20${inq.id}).%20Kindly%20confirm."
        target="_blank"
        rel="noopener noreferrer"
        class="btn btn-wa"
        style="flex:1;"
      >
        ${icon('wa')} Message ${campus.counselor.split(' ')[1]}
      </a>
      <button class="btn btn-outline" onclick="window.closeModal('successModal')">
        Close
      </button>
    </div>
  `;

  modal.classList.add('active');
}

/* ═══════════════════════════════════════════════════════════
   ADMIN COCKPIT
   ═══════════════════════════════════════════════════════════ */
function renderAdminTable() {
  const tbody = document.getElementById('adminTableBody');
  if (!tbody) return;

  let list = [...STATE.inquiries];
  if (STATE.adminFilter !== 'all') {
    list = list.filter(i =>
      i.status.toLowerCase() === STATE.adminFilter.toLowerCase()
    );
  }

  if (!list.length) {
    tbody.innerHTML = `
      <tr>
        <td colspan="7" style="text-align:center; padding:40px; color:rgba(255,255,255,0.3);">
          No inquiries found for this filter. When parents apply, they appear here — routed directly to the right counselor.
        </td>
      </tr>`;
    return;
  }

  tbody.innerHTML = list.map(item => `
    <tr>
      <td><span class="ref-id">${item.id}</span></td>
      <td>
        <strong style="color:white;">${item.parentName}</strong>
        <div style="font-size:var(--text-xs); color:rgba(255,255,255,0.4);">${item.phone}</div>
      </td>
      <td>
        <strong style="color:white;">${item.childName}</strong>
        <div style="font-size:var(--text-xs); color:rgba(255,255,255,0.4);">${item.childAge}</div>
      </td>
      <td>
        <div style="color:white;">${item.campusName.replace('Kalalayaa ', '')}</div>
        <div style="font-size:var(--text-xs); color:rgba(255,255,255,0.4);">${item.program}</div>
      </td>
      <td>
        <div style="font-size:var(--text-sm); color:rgba(255,255,255,0.7);">${item.counselor}</div>
        <div style="font-size:var(--text-xs); color:rgba(255,255,255,0.3);">${item.date}</div>
      </td>
      <td>
        <select
          class="admin-select"
          onchange="window.updateInquiryStatus('${item.id}', this.value)"
          aria-label="Update status for ${item.id}"
        >
          <option value="New"       ${item.status === 'New'       ? 'selected' : ''}>New Lead</option>
          <option value="Contacted" ${item.status === 'Contacted' ? 'selected' : ''}>Contacted</option>
          <option value="Enrolled"  ${item.status === 'Enrolled'  ? 'selected' : ''}>Enrolled</option>
        </select>
      </td>
      <td>
        <button
          class="btn btn-ghost btn-sm"
          style="color:rgba(255,255,255,0.6); border:1px solid rgba(255,255,255,0.1);"
          onclick="window.viewInquiry('${item.id}')"
          aria-label="View full detail for ${item.id}"
        >
          View
        </button>
      </td>
    </tr>`).join('');
}

function updateAdminStats() {
  const total     = STATE.inquiries.length;
  const newCount  = STATE.inquiries.filter(i => i.status === 'New').length;
  const enrolled  = STATE.inquiries.filter(i => i.status === 'Enrolled').length;
  const rate      = total > 0 ? Math.round((enrolled / total) * 100) : 0;

  const el = id => document.getElementById(id);
  if (el('statTotal'))  el('statTotal').textContent  = total;
  if (el('statNew'))    el('statNew').textContent    = newCount;
  if (el('statRate'))   el('statRate').textContent   = `${rate}%`;
}

/* ═══════════════════════════════════════════════════════════
   GLOBAL EVENT HANDLERS (window scope for inline HTML)
   ═══════════════════════════════════════════════════════════ */
window.selectCampus = function(id) {
  STATE.activeCampusId = id;
  renderCampusStrip();
  renderCampusMenu();
  renderMicroView(id);

  const label = document.getElementById('campusTriggerLabel');
  if (label) {
    if (id === 'all') {
      label.textContent = 'All Campuses';
    } else {
      const c = CAMPUSES.find(x => x.id === id);
      label.textContent = c ? c.name.replace('Kalalayaa ', '') : 'Select Campus';
    }
  }

  // Close dropdown
  document.getElementById('campusSelector')?.classList.remove('open');
  const btn = document.getElementById('campusTriggerBtn');
  if (btn) btn.setAttribute('aria-expanded', 'false');
};

window.toggleCampusMenu = function(e) {
  e.stopPropagation();
  const selector = document.getElementById('campusSelector');
  const btn = document.getElementById('campusTriggerBtn');
  const isOpen = selector?.classList.toggle('open');
  if (btn) btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
};

window.openAdmissions = function(campusId) {
  const select = document.getElementById('formCampus');
  if (select) {
    select.value = campusId;
    updateFormRouting();
  }
  document.getElementById('admissions')?.scrollIntoView({ behavior: 'smooth' });
};

window.toggleAdmin = function() {
  const section = document.getElementById('adminCockpit');
  if (!section) return;
  const hidden = section.style.display === 'none';
  section.style.display = hidden ? 'block' : 'none';
  if (hidden) {
    section.scrollIntoView({ behavior: 'smooth' });
    showToast('Entered Unified Staff Admin Cockpit');
  }
};

window.filterAdmin = function(filter) {
  STATE.adminFilter = filter;
  document.querySelectorAll('.admin-tab').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.filter === filter);
  });
  renderAdminTable();
};

window.updateInquiryStatus = function(id, status) {
  const item = STATE.inquiries.find(i => i.id === id);
  if (item) {
    item.status = status;
    saveInquiries();
    renderAdminTable();
    updateAdminStats();
    showToast(`Inquiry ${id} → "${status}"`);
  }
};

window.viewInquiry = function(id) {
  const item = STATE.inquiries.find(i => i.id === id);
  if (!item) return;
  alert(
    `Inquiry: ${item.id}\n` +
    `Parent: ${item.parentName} · ${item.phone}\n` +
    `Child: ${item.childName} (${item.childAge})\n` +
    `Campus: ${item.campusName}\n` +
    `Program: ${item.program}\n` +
    `Counselor: ${item.counselor}\n` +
    `Status: ${item.status}\n` +
    `Notes: ${item.notes}`
  );
};

window.closeModal = function(id) {
  document.getElementById(id)?.classList.remove('active');
};

window.updateMatcher = updateMatcher;
window.updateFormRouting = updateFormRouting;

/* ═══════════════════════════════════════════════════════════
   TOAST SYSTEM
   ═══════════════════════════════════════════════════════════ */
function showToast(msg) {
  const stack = document.getElementById('toastStack');
  if (!stack) return;
  const t = document.createElement('div');
  t.className = 'toast';
  t.innerHTML = `${icon('check')} <span>${msg}</span>`;
  stack.appendChild(t);
  setTimeout(() => {
    t.style.opacity = '0';
    t.style.transform = 'translateX(-16px)';
    t.style.transition = 'all 0.25s ease';
    setTimeout(() => t.remove(), 300);
  }, 4000);
}

/* ═══════════════════════════════════════════════════════════
   GLOBAL CLICK HANDLER: close dropdowns on outside click
   ═══════════════════════════════════════════════════════════ */
document.addEventListener('click', () => {
  const selector = document.getElementById('campusSelector');
  if (selector?.classList.contains('open')) {
    selector.classList.remove('open');
    document.getElementById('campusTriggerBtn')?.setAttribute('aria-expanded', 'false');
  }
});

/* ═══════════════════════════════════════════════════════════
   BOOT
   ═══════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  initData();
  renderCampusStrip();
  renderCampusMenu();
  renderCampusCards();
  renderFineArts();
  renderMomentsGallery();
  renderTestimonials();
  updateMatcher();
  populateFormCampuses();
  updateFormRouting();
  renderAdminTable();
  updateAdminStats();

  document.getElementById('admissionsForm')?.addEventListener('submit', handleFormSubmit);
});
