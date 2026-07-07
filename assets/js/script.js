// ============ Shared: Mobile menu ============
const menuBtn = document.getElementById('menuBtn');
const mobileMenu = document.getElementById('mobileMenu');
const iconOpen = document.getElementById('menuIconOpen');
const iconClose = document.getElementById('menuIconClose');

function openMenu(){ mobileMenu.classList.remove('hidden'); iconOpen.classList.add('hidden'); iconClose.classList.remove('hidden'); menuBtn.setAttribute('aria-expanded','true'); }
function closeMenu(){ mobileMenu.classList.add('hidden'); iconOpen.classList.remove('hidden'); iconClose.classList.add('hidden'); menuBtn.setAttribute('aria-expanded','false'); }

menuBtn.addEventListener('click', (e) => { e.stopPropagation(); mobileMenu.classList.contains('hidden') ? openMenu() : closeMenu(); });
document.querySelectorAll('#mobileMenu a:not(#mobileServicesBtn)').forEach(link => link.addEventListener('click', closeMenu));
document.addEventListener('click', (e) => { if (!mobileMenu.classList.contains('hidden') && !mobileMenu.contains(e.target) && e.target !== menuBtn) closeMenu(); });
window.addEventListener('resize', () => { if (window.innerWidth >= 1024) closeMenu(); });

// ============ Shared: Mobile services dropdown ============
const mobileServicesBtn = document.getElementById('mobileServicesBtn');
if (mobileServicesBtn) {
  mobileServicesBtn.addEventListener('click', function(e) {
    e.preventDefault();
    const menu = document.getElementById('mobileServicesMenu');
    const icon = document.getElementById('mobileServicesIcon');
    menu.classList.toggle('hidden');
    icon.classList.toggle('bx-chevron-down');
    icon.classList.toggle('bx-chevron-up');
  });
}

// ============ Page-specific: Blog category filter ============
const categoryBtns = document.querySelectorAll('.category-btn');
if (categoryBtns.length) {
  const blogCards = document.querySelectorAll('.blog-card');
  categoryBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      categoryBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      const filter = this.dataset.filter;
      blogCards.forEach(card => {
        const categories = card.dataset.category.split(' ');
        card.style.display = (filter === 'all' || categories.includes(filter)) ? 'block' : 'none';
      });
    });
  });
}

// ============ Page-specific: Case study filter ============
const filterBtns = document.querySelectorAll('.filter-btn');
if (filterBtns.length) {
  const caseCards = document.querySelectorAll('.case-card');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      const filter = this.dataset.filter;
      caseCards.forEach(card => {
        const category = card.dataset.category;
        card.style.display = (filter === 'all' || category.includes(filter)) ? 'block' : 'none';
      });
    });
  });
}

// ============ Page-specific: FAQ category filter ============
const faqCategoryBtns = document.querySelectorAll('.faq-category');
if (faqCategoryBtns.length) {
  const faqItems = document.querySelectorAll('.faq-item');
  faqCategoryBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      faqCategoryBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      const category = this.dataset.category;
      faqItems.forEach(item => {
        item.style.display = (category === 'all' || item.dataset.category === category) ? 'block' : 'none';
      });
    });
  });
}

// ============ Page-specific: Service detail loader ============
const services = {
  'ui-ux': {
    title: 'UI/UX Design', tag: '01', icon: 'bx-pen',
    description: 'User-centered designs that combine aesthetics with functionality. We create intuitive interfaces that delight users and drive engagement.',
    image: 'https://picsum.photos/seed/uiux-design/1200/500',
    projects: '150+', satisfaction: '98%', team: '12', delivery: '2.5x',
    offers: ['User research and persona development','Wireframing and interactive prototyping','Visual design and design systems','Usability testing and iteration'],
    process: 'We follow a user-centered design process: Discover → Define → Design → Test → Deliver. Each phase involves close collaboration with you to ensure the final product exceeds expectations.',
    tools: ['Figma','Sketch','Adobe XD','InVision','Zeplin','Miro'],
    timeline: '4-8 weeks', price: '$2,500'
  },
  'web-dev': {
    title: 'Web Development', tag: '02', icon: 'bx-code-alt',
    description: 'Custom web solutions built with modern technologies. From landing pages to complex web applications, we deliver scalable and performant websites.',
    image: 'https://picsum.photos/seed/web-dev/1200/500',
    projects: '120+', satisfaction: '97%', team: '10', delivery: '2x',
    offers: ['Custom website development','E-commerce solutions','CMS integration (WordPress, Webflow)','Performance optimization'],
    process: 'Our development process follows Agile methodology: Plan → Design → Develop → Test → Deploy → Maintain. We ensure continuous communication and iterative improvements.',
    tools: ['React','Next.js','Node.js','Tailwind CSS','MongoDB','AWS'],
    timeline: '6-12 weeks', price: '$4,000'
  },
  'app-design': {
    title: 'App Design', tag: '07', icon: 'bx-mobile-alt',
    description: 'Mobile-first app designs that provide seamless user experiences across iOS and Android platforms with intuitive navigation and stunning visuals.',
    image: 'https://picsum.photos/seed/app-design/1200/500',
    projects: '80+', satisfaction: '96%', team: '8', delivery: '2x',
    offers: ['iOS and Android app design','Responsive mobile interfaces','App prototyping and testing','Design system creation'],
    process: 'We start with user research, create wireframes, develop high-fidelity prototypes, conduct usability testing, and deliver pixel-perfect designs ready for development.',
    tools: ['Figma','Sketch','Adobe XD','Principle','ProtoPie'],
    timeline: '4-10 weeks', price: '$3,500'
  },
  branding: {
    title: 'Branding', tag: '05', icon: 'bx-brush',
    description: 'Complete brand identity solutions including logo design, visual identity, typography, and brand guidelines that make your brand memorable.',
    image: 'https://picsum.photos/seed/branding/1200/500',
    projects: '90+', satisfaction: '99%', team: '7', delivery: '1.5x',
    offers: ['Logo and visual identity design','Brand strategy and positioning','Typography and color systems','Brand guidelines documentation'],
    process: 'We follow a strategic branding process: Research → Strategy → Design → Refine → Deliver. We ensure your brand stands out and resonates with your audience.',
    tools: ['Adobe Illustrator','Photoshop','InDesign','Figma','Miro'],
    timeline: '3-6 weeks', price: '$3,000'
  },
  motion: {
    title: 'Motion Graphics', tag: '04', icon: 'bx-movie',
    description: 'Dynamic motion graphics that captivate audiences. From explainer videos to animated logos, we create visual stories that engage and inspire.',
    image: 'https://picsum.photos/seed/motion-graphics/1200/500',
    projects: '70+', satisfaction: '97%', team: '6', delivery: '2x',
    offers: ['2D and 3D animation','Explainer videos','Animated logos and graphics','Visual effects and compositing'],
    process: 'Our motion design process: Concept → Storyboard → Animation → Review → Final Deliverable. We create compelling visual stories that capture attention.',
    tools: ['After Effects','Premiere Pro','Blender','Cinema 4D'],
    timeline: '4-10 weeks', price: '$3,500'
  }
};

function loadServiceData() {
  const titleEl = document.getElementById('serviceTitle');
  if (!titleEl) return;

  const urlParams = new URLSearchParams(window.location.search);
  const serviceId = urlParams.get('id');
  const defaultId = 'ui-ux';
  const id = serviceId && services[serviceId] ? serviceId : defaultId;
  const service = services[id];

  titleEl.textContent = service.title;
  document.getElementById('serviceTag').textContent = service.tag;
  document.getElementById('serviceIcon').innerHTML = `<i class='bx ${service.icon}'></i>`;
  document.getElementById('serviceDescription').textContent = service.description;
  document.getElementById('serviceImage').src = service.image;
  document.getElementById('statProjects').textContent = service.projects;
  document.getElementById('statClients').textContent = service.satisfaction;
  document.getElementById('statTeam').textContent = service.team;
  document.getElementById('statTime').textContent = service.delivery;
  document.getElementById('processText').textContent = service.process;
  document.getElementById('timelineText').textContent = service.timeline;
  document.getElementById('priceText').textContent = service.price;

  document.getElementById('offerList').innerHTML = service.offers.map(offer =>
    `<li class="flex items-start gap-2"><i class='bx bx-check-circle text-lime mt-0.5'></i> ${offer}</li>`
  ).join('');

  document.getElementById('toolsList').innerHTML = service.tools.map(tool =>
    `<span class="tag">${tool}</span>`
  ).join('');
}

window.addEventListener('DOMContentLoaded', loadServiceData);