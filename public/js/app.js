//
const STORAGE = {
    session: 'monastery_demo_session',
    catalog: 'monastery_demo_catalog',
    available: 'monastery_demo_available',
    orders: 'monastery_demo_orders'
};

const LABELS = {
    meals: { breakfast: 'فطار', lunch: 'غداء', dinner: 'عشاء' },
    categories: { food: 'أكل', drinks: 'مشروبات', dessert: 'حلو' }
};

const defaultCatalog = {
    food: [
        { id: 'foul', name: 'فول', icon: '🫘' },
        { id: 'eggs', name: 'بيض', icon: '🍳' },
        { id: 'cheese', name: 'جبنة', icon: '🧀' },
        { id: 'bread', name: 'خبز', icon: '🥖' },
        { id: 'rice', name: 'أرز', icon: '🍚' },
        { id: 'fish', name: 'سمك', icon: '🐟' },
        { id: 'pasta', name: 'مكرونة', icon: '🍝' },
        { id: 'mahshi', name: 'محشي', icon: '🍃' },
        { id: 'vegetables', name: 'خضار', icon: '🥘' },
        { id: 'salad', name: 'سلطة', icon: '🥗' },
        { id: 'lentils', name: 'عدس', icon: '🥣' }
    ],
    drinks: [
        { id: 'tea', name: 'شاي', icon: '🫖' },
        { id: 'coffee', name: 'قهوة', icon: '☕' },
        { id: 'anise', name: 'يانسون', icon: '🍵' },
        { id: 'juice', name: 'عصير', icon: '🧃' }
    ],
    dessert: [
        { id: 'fruit', name: 'فاكهة', icon: '🍎' },
        { id: 'basbousa', name: 'بسبوسة', icon: '🍰' },
        { id: 'ricepudding', name: 'رز بلبن', icon: '🍮' },
        { id: 'biscuits', name: 'بسكويت', icon: '🍪' }
    ]
};

const defaultAvailable = {
    breakfast: {
        food: ['foul', 'eggs', 'cheese', 'bread'],
        drinks: ['tea', 'coffee', 'anise'],
        dessert: ['biscuits', 'ricepudding']
    },
    lunch: {
        food: ['rice', 'fish', 'pasta', 'mahshi', 'vegetables', 'salad'],
        drinks: ['tea', 'juice'],
        dessert: ['fruit', 'basbousa']
    },
    dinner: {
        food: ['foul', 'cheese', 'bread', 'salad'],
        drinks: ['tea', 'anise'],
        dessert: ['fruit', 'ricepudding']
    }
};

const state = {
    currentScreen: 'login',
    meal: 'breakfast',
    category: 'food',
    order: {},
    session: null,
    catalog: load(STORAGE.catalog, structuredClone(defaultCatalog)),
    available: load(STORAGE.available, structuredClone(defaultAvailable)),
    orders: load(STORAGE.orders, [])
};

function load(key, fallback) {
    try {
        const raw = localStorage.getItem(key);
        return raw ? JSON.parse(raw) : fallback;
    } catch {
        return fallback;
    }
}
function save(key, value) { localStorage.setItem(key, JSON.stringify(value)); }
function qs(s, root = document) { return root.querySelector(s); }
function qsa(s, root = document) { return [...root.querySelectorAll(s)]; }

function formatDate(date = new Date()) {
    return new Intl.DateTimeFormat('ar-EG', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }).format(date);
}

function localDateKey(date = new Date()) {
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, '0');
    const d = String(date.getDate()).padStart(2, '0');
    return `${y}-${m}-${d}`;
}

function setScreen(name, push = true) {
    state.currentScreen = name;
    qsa('.screen').forEach(s => s.classList.toggle('is-active', s.dataset.screen === name));
    const needsNav = name !== 'login';
    qs('#backBtn').hidden = !needsNav || name === 'home';
    qs('#profileBtn').hidden = !needsNav;
    if (name === 'food') renderFoodGrid();
    if (name === 'admin') renderAdminCatalog();
    window.scrollTo({ top: 0, behavior: 'auto' });
    if (push) history.replaceState({ screen: name }, '', `#${name}`);
}

function applySession(session) {
    state.session = session;
    save(STORAGE.session, session);
    qs('#welcomeName').textContent = session.name;
    qs('#profileName').textContent = session.name;
    qs('#profileRole').textContent = session.role === 'admin' ? 'راهب مسؤول' : 'راهب';
    qs('#adminShortcut').hidden = session.role !== 'admin';
    qs('#drawerAdminBtn').hidden = session.role !== 'admin';
    qs('#todayLabel').textContent = `اليوم ${formatDate()}`;
}

function demoLogin(role) {
    const session = role === 'admin'
        ? { name: 'أبونا بيشوي - مسؤول الخدمة', username: 'admin', role: 'admin' }
        : { name: 'أبونا مرقس', username: 'monk', role: 'monk' };
    applySession(session);
    setScreen('home');
    toast('تم تسجيل الدخول بنجاح');
}

qs('#loginForm').addEventListener('submit', e => {
    e.preventDefault();
    const username = qs('#username').value.trim();
    if (!username) return;
    applySession({ name: username, username, role: 'monk' });
    setScreen('home');
    toast('أهلًا بك');
});
qsa('[data-demo-login]').forEach(btn => btn.addEventListener('click', () => demoLogin(btn.dataset.demoLogin)));

qs('#openFoodBtn').addEventListener('click', () => setScreen('food'));
qs('#openAdminBtn').addEventListener('click', () => setScreen('admin'));
qs('#backBtn').addEventListener('click', () => {
    if (state.currentScreen === 'food' || state.currentScreen === 'admin') setScreen('home');
    else setScreen('home');
});

qsa('.meal-tab').forEach(btn => btn.addEventListener('click', () => {
    state.meal = btn.dataset.meal;
    qsa('.meal-tab').forEach(b => b.classList.toggle('is-active', b === btn));
    renderFoodGrid();
}));
qsa('.category-tab').forEach(btn => btn.addEventListener('click', () => {
    state.category = btn.dataset.category;
    qsa('.category-tab').forEach(b => b.classList.toggle('is-active', b === btn));
    renderFoodGrid();
}));

function itemKey(meal, category, id) { return `${meal}|${category}|${id}`; }
function getCatalogItem(category, id) { return state.catalog[category]?.find(i => i.id === id); }

function renderFoodGrid() {
    const ids = state.available[state.meal]?.[state.category] || [];
    const items = ids.map(id => getCatalogItem(state.category, id)).filter(Boolean);
    qs('#currentMealLabel').textContent = `${LABELS.meals[state.meal]} اليوم`;
    qs('#currentCategoryLabel').textContent = LABELS.categories[state.category];
    const grid = qs('#foodGrid');
    grid.innerHTML = '';
    qs('#foodEmpty').hidden = items.length > 0;
    grid.hidden = items.length === 0;

    items.forEach(item => {
        const key = itemKey(state.meal, state.category, item.id);
        const qty = state.order[key]?.qty || 0;
        const card = document.createElement('article');
        card.className = `food-card${qty ? ' is-selected' : ''}`;
        card.innerHTML = `
      <div class="food-emoji" aria-hidden="true">${item.icon}</div>
      <div>
        <h3>${escapeHtml(item.name)}</h3>
        <p>${LABELS.meals[state.meal]} · ${LABELS.categories[state.category]}</p>
      </div>
      <div class="qty-control">
        <button class="qty-btn" data-action="minus" aria-label="تقليل ${escapeHtml(item.name)}">−</button>
        <span class="qty-value">${qty}</span>
        <button class="qty-btn" data-action="plus" aria-label="زيادة ${escapeHtml(item.name)}">+</button>
      </div>`;
        card.querySelector('[data-action="plus"]').addEventListener('click', () => changeQty(item, 1));
        card.querySelector('[data-action="minus"]').addEventListener('click', () => changeQty(item, -1));
        grid.appendChild(card);
    });
    updateOrderBar();
}

function changeQty(item, delta) {
    const key = itemKey(state.meal, state.category, item.id);
    const current = state.order[key]?.qty || 0;
    const next = Math.max(0, Math.min(9, current + delta));
    if (next === 0) delete state.order[key];
    else state.order[key] = { meal: state.meal, category: state.category, id: item.id, name: item.name, icon: item.icon, qty: next };
    renderFoodGrid();
}

function updateOrderBar() {
    const count = Object.values(state.order).reduce((sum, x) => sum + x.qty, 0);
    qs('#orderCount').textContent = count;
    qs('#reviewOrderBtn').disabled = count === 0;
}

qs('#reviewOrderBtn').addEventListener('click', openOrderModal);
function openOrderModal() {
    renderOrderReview();
    const modal = qs('#orderModal');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
}
function closeOrderModal() {
    const modal = qs('#orderModal');
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
}
qsa('[data-close-modal]').forEach(el => el.addEventListener('click', closeOrderModal));

function renderOrderReview() {
    const rows = Object.values(state.order);
    const groupMap = {};
    rows.forEach(row => {
        const key = row.meal;
        (groupMap[key] ||= []).push(row);
    });
    qs('#orderReview').innerHTML = Object.entries(groupMap).map(([meal, items]) => `
    <section class="review-group">
      <h3>${LABELS.meals[meal]}</h3>
      ${items.map(item => `<div class="review-row"><span>${item.icon} ${escapeHtml(item.name)} <small>(${LABELS.categories[item.category]})</small></span><strong>× ${item.qty}</strong></div>`).join('')}
    </section>
  `).join('');
}

qs('#submitOrderBtn').addEventListener('click', () => {
    if (!state.session || Object.keys(state.order).length === 0) return;
    const now = new Date();
    const record = {
        id: `o_${Date.now()}`,
        user: state.session.name,
        username: state.session.username,
        dateKey: localDateKey(now),
        createdAt: now.toISOString(),
        items: Object.values(state.order)
    };
    state.orders.push(record);
    save(STORAGE.orders, state.orders);
    state.order = {};
    closeOrderModal();
    renderFoodGrid();
    toast('تم إرسال الطلب للمسؤول');
    setTimeout(() => setScreen('home'), 650);
});

/* Admin */
qs('#adminMealSelect').addEventListener('change', renderAdminCatalog);
qs('#adminCategorySelect').addEventListener('change', renderAdminCatalog);

function renderAdminCatalog() {
    const meal = qs('#adminMealSelect').value;
    const category = qs('#adminCategorySelect').value;
    const availableIds = new Set(state.available[meal]?.[category] || []);
    const list = qs('#adminCatalog');
    list.innerHTML = '';
    (state.catalog[category] || []).forEach(item => {
        const row = document.createElement('label');
        row.className = 'catalog-item';
        row.innerHTML = `
      <span class="catalog-item-main">
        <span class="catalog-item-icon">${item.icon}</span>
        <strong>${escapeHtml(item.name)}</strong>
      </span>
      <span class="switch">
        <input type="checkbox" data-item-id="${item.id}" ${availableIds.has(item.id) ? 'checked' : ''}>
        <span></span>
      </span>`;
        row.querySelector('input').addEventListener('change', updateAvailableCount);
        list.appendChild(row);
    });
    updateAvailableCount();
}
function updateAvailableCount() {
    const checked = qsa('#adminCatalog input:checked').length;
    qs('#availableCount').textContent = `${checked} متاح`;
}

qs('#saveMenuBtn').addEventListener('click', () => {
    const meal = qs('#adminMealSelect').value;
    const category = qs('#adminCategorySelect').value;
    state.available[meal] ||= {};
    state.available[meal][category] = qsa('#adminCatalog input:checked').map(input => input.dataset.itemId);
    save(STORAGE.available, state.available);
    toast('تم حفظ قائمة اليوم');
});

qs('#addItemForm').addEventListener('submit', e => {
    e.preventDefault();
    const category = qs('#adminCategorySelect').value;
    const name = qs('#newItemName').value.trim();
    const icon = qs('#newItemIcon').value.trim() || '🍲';
    if (!name) return;
    const id = `custom_${Date.now()}`;
    state.catalog[category].push({ id, name, icon });
    save(STORAGE.catalog, state.catalog);
    qs('#newItemName').value = '';
    renderAdminCatalog();
    toast('تمت إضافة الصنف للقائمة');
});

qsa('[data-admin-section]').forEach(btn => btn.addEventListener('click', () => {
    qsa('[data-admin-section]').forEach(b => b.classList.toggle('is-active', b === btn));
    const report = btn.dataset.adminSection === 'report';
    qs('#adminMenuSection').hidden = report;
    qs('#adminReportSection').hidden = !report;
    if (report) renderReport();
}));

qs('#refreshReportBtn').addEventListener('click', renderReport);
qs('#printReportBtn').addEventListener('click', () => window.print());

function renderReport() {
    state.orders = load(STORAGE.orders, []);
    qs('#reportDate').textContent = formatDate();
    const today = localDateKey();
    const orders = state.orders.filter(o => o.dateKey === today);
    const tbody = qs('#reportTableBody');
    tbody.innerHTML = '';
    let rowNo = 1;
    let totalQty = 0;
    const byMeal = { breakfast: 0, lunch: 0, dinner: 0 };
    const totals = {};
    orders.forEach(order => {
        order.items.forEach(item => {
            totalQty += item.qty;
            byMeal[item.meal] += item.qty;
            const totalKey = `${item.meal}|${item.category}|${item.id}`;
            if (!totals[totalKey]) totals[totalKey] = { ...item, qty: 0 };
            totals[totalKey].qty += item.qty;
            const tr = document.createElement('tr');
            tr.innerHTML = `
        <td>${rowNo++}</td>
        <td>${escapeHtml(order.user)}</td>
        <td>${LABELS.meals[item.meal]}</td>
        <td>${LABELS.categories[item.category]}</td>
        <td>${item.icon} ${escapeHtml(item.name)}</td>
        <td>${item.qty}</td>`;
            tbody.appendChild(tr);
        });
    });
    qs('#reportEmpty').hidden = rowNo > 1;
    qs('#reportTotalsBody').innerHTML = Object.values(totals)
        .sort((a, b) => `${a.meal}${a.category}${a.name}`.localeCompare(`${b.meal}${b.category}${b.name}`, 'ar'))
        .map(item => `<tr><td>${LABELS.meals[item.meal]}</td><td>${LABELS.categories[item.category]}</td><td>${item.icon} ${escapeHtml(item.name)}</td><td>${item.qty}</td></tr>`)
        .join('') || '<tr><td colspan="4" style="text-align:center;color:#8a767a">لا توجد أصناف بعد</td></tr>';
    qs('#reportSummary').innerHTML = [
        ['إجمالي الطلبات', orders.length],
        ['فطار', byMeal.breakfast],
        ['غداء', byMeal.lunch],
        ['عشاء', byMeal.dinner]
    ].map(([label, value]) => `<div class="summary-card"><small>${label}</small><strong>${value}</strong></div>`).join('');
}

/* Drawer */
qs('#profileBtn').addEventListener('click', () => toggleDrawer(true));
qsa('[data-close-drawer]').forEach(el => el.addEventListener('click', () => toggleDrawer(false)));
function toggleDrawer(open) {
    const drawer = qs('#profileDrawer');
    drawer.classList.toggle('is-open', open);
    drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
}
qs('#drawerHomeBtn').addEventListener('click', () => { toggleDrawer(false); setScreen('home'); });
qs('#drawerFoodBtn').addEventListener('click', () => { toggleDrawer(false); setScreen('food'); });
qs('#drawerAdminBtn').addEventListener('click', () => { toggleDrawer(false); setScreen('admin'); });
qs('#logoutBtn').addEventListener('click', () => {
    localStorage.removeItem(STORAGE.session);
    state.session = null;
    state.order = {};
    toggleDrawer(false);
    setScreen('login');
    toast('تم تسجيل الخروج');
});

function toast(message) {
    const el = qs('#toast');
    el.textContent = message;
    el.classList.add('is-showing');
    clearTimeout(toast._timer);
    toast._timer = setTimeout(() => el.classList.remove('is-showing'), 2200);
}

function escapeHtml(value = '') {
    return String(value).replace(/[&<>'"]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[c]));
}

/* PWA */
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => navigator.serviceWorker.register('sw.js').catch(() => { }));
}

/* Boot */
(() => {
    const session = load(STORAGE.session, null);
    if (session) {
        applySession(session);
        setScreen('home', false);
    } else {
        setScreen('login', false);
    }
})();
