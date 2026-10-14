<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="theme-color" content="#4b1520" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-title" content="طلبات الدير" />
    <title>طلبات دير الأنبا بيشوي</title>
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}" />
    <link rel="apple-touch-icon" href="{{ asset('assets/icon-192.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
</head>

<body>
    <div class="app-shell">
        <header class="topbar">
            <button class="icon-btn" id="backBtn" aria-label="رجوع" hidden>
                <span aria-hidden="true">←</span>
            </button>
            <div class="brand-mini">
                <span class="brand-mark" aria-hidden="true">✠</span>
                <div>
                    <strong>دير الأنبا بيشوي</strong>
                    <small>خدمة الطلبات والمخزن</small>
                </div>
            </div>
            <button class="icon-btn" id="profileBtn" aria-label="الحساب" hidden>
                <span aria-hidden="true">☰</span>
            </button>
        </header>

        <main>
            <!-- Login -->
            <section class="screen is-active" id="loginScreen" data-screen="login">
                <div class="login-wrap">
                    <div class="hero-card login-hero">
                        <div class="hero-glow"></div>
                        <div class="cross-seal" aria-hidden="true">✠</div>
                        <p class="eyebrow">مجمع رهبان دير الأنبا بيشوي العامر</p>
                        <h1>طلبات الدير</h1>
                        <p>واجهة بسيطة وسريعة للوجبات والمخزن، مصممة للاستخدام اليومي على الموبايل.</p>
                    </div>

                    <form class="panel login-panel" id="loginForm">
                        <div class="section-heading compact">
                            <div>
                                <span class="kicker">تسجيل الدخول</span>
                                <h2>أهلًا وسهلًا</h2>
                            </div>
                        </div>

                        <label class="field">
                            <span>اسم المستخدم</span>
                            <input id="username" name="username" autocomplete="username" placeholder="مثال: abouna.bishoy" required />
                        </label>

                        <label class="field">
                            <span>كلمة المرور</span>
                            <input id="password" name="password" type="password" autocomplete="current-password" placeholder="••••••••" required />
                        </label>

                        <button class="btn btn-primary btn-wide" type="submit">دخول</button>

                        <div class="demo-actions">
                            <button class="btn btn-ghost" type="button" data-demo-login="monk">دخول تجريبي كراهب</button>
                            <button class="btn btn-ghost" type="button" data-demo-login="admin">دخول تجريبي كمسؤول</button>
                        </div>
                        <p class="helper-text">في النسخة النهائية سيكون التحقق من الحسابات عن طريق PHP وMySQL، وليس من المتصفح.</p>
                    </form>
                </div>
            </section>

            <!-- Home -->
            <section class="screen" id="homeScreen" data-screen="home">
                <div class="page-pad">
                    <div class="welcome-card">
                        <div>
                            <span class="kicker">مساء الخير</span>
                            <h1 id="welcomeName">أبونا بيشوي</h1>
                            <p id="todayLabel"></p>
                        </div>
                        <div class="avatar" aria-hidden="true">✠</div>
                    </div>

                    <div class="section-heading">
                        <div>
                            <span class="kicker">اختيار الخدمة</span>
                            <h2>ماذا تريد اليوم؟</h2>
                        </div>
                    </div>

                    <div class="service-grid">
                        <button class="service-card food-service" id="openFoodBtn">
                            <span class="service-icon">🍽️</span>
                            <span class="service-copy">
                                <strong>وجبات اليوم</strong>
                                <small>فطار · غداء · عشاء</small>
                            </span>
                            <span class="service-arrow">←</span>
                        </button>

                        <button class="service-card store-service is-disabled" id="openStoreBtn" aria-disabled="true">
                            <span class="service-icon">📦</span>
                            <span class="service-copy">
                                <strong>المخزن</strong>
                                <small>سيتم تنفيذه في المرحلة التالية</small>
                            </span>
                            <span class="tag">قريبًا</span>
                        </button>
                    </div>

                    <div class="notice-card" id="adminShortcut" hidden>
                        <div>
                            <span class="kicker">لوحة المسؤول</span>
                            <h3>تجهيز قائمة اليوم والتقارير</h3>
                            <p>اختر الأصناف المتاحة اليوم أو اطبع تقرير الطلبات.</p>
                        </div>
                        <button class="btn btn-secondary" id="openAdminBtn">فتح اللوحة</button>
                    </div>
                </div>
            </section>

            <!-- Food ordering -->
            <section class="screen" id="foodScreen" data-screen="food">
                <div class="food-banner page-pad">
                    <div>
                        <span class="kicker">قائمة اليوم</span>
                        <h1>اختار وجباتك</h1>
                        <p>حدد الصنف والكمية ثم راجع الطلب قبل الإرسال.</p>
                    </div>
                    <div class="mini-seal">✠</div>
                </div>

                <div class="meal-tabs page-pad" id="mealTabs" role="tablist" aria-label="الوجبات">
                    <button class="meal-tab is-active" data-meal="breakfast" role="tab">
                        <span>🌤️</span><strong>فطار</strong><small>الصباح</small>
                    </button>
                    <button class="meal-tab" data-meal="lunch" role="tab">
                        <span>☀️</span><strong>غداء</strong><small>الظهر</small>
                    </button>
                    <button class="meal-tab" data-meal="dinner" role="tab">
                        <span>🌙</span><strong>عشاء</strong><small>المساء</small>
                    </button>
                </div>

                <div class="category-tabs page-pad" id="categoryTabs" role="tablist" aria-label="أقسام الوجبة">
                    <button class="category-tab is-active" data-category="food">🍲 أكل</button>
                    <button class="category-tab" data-category="drinks">☕ مشروبات</button>
                    <button class="category-tab" data-category="dessert">🍮 حلو</button>
                </div>

                <div class="page-pad menu-area">
                    <div class="section-heading compact">
                        <div>
                            <span class="kicker" id="currentCategoryLabel">أكل</span>
                            <h2 id="currentMealLabel">فطار اليوم</h2>
                        </div>
                        <span class="availability-dot"><i></i> متاح الآن</span>
                    </div>

                    <div class="food-grid" id="foodGrid"></div>
                    <div class="empty-state" id="foodEmpty" hidden>
                        <div>🍽️</div>
                        <h3>لا توجد أصناف متاحة هنا</h3>
                        <p>المسؤول لم يحدد أصناف هذا القسم حتى الآن.</p>
                    </div>
                </div>

                <div class="sticky-order-bar" id="stickyOrderBar">
                    <div>
                        <small>طلبك الحالي</small>
                        <strong><span id="orderCount">0</span> صنف</strong>
                    </div>
                    <button class="btn btn-primary" id="reviewOrderBtn" disabled>مراجعة الطلب</button>
                </div>
            </section>

            <!-- Admin -->
            <section class="screen" id="adminScreen" data-screen="admin">
                <div class="page-pad">
                    <div class="admin-hero">
                        <div>
                            <span class="kicker">لوحة المسؤول</span>
                            <h1>إدارة وجبات اليوم</h1>
                            <p>اختيار المتاح، إضافة أصناف جديدة، ثم متابعة الطلبات وتجهيز التقرير.</p>
                        </div>
                        <span class="admin-badge">مسؤول</span>
                    </div>

                    <div class="segmented" id="adminSections">
                        <button class="is-active" data-admin-section="menu">قائمة اليوم</button>
                        <button data-admin-section="report">التقرير</button>
                    </div>

                    <div id="adminMenuSection">
                        <div class="admin-toolbar">
                            <label class="field slim">
                                <span>الوجبة</span>
                                <select id="adminMealSelect">
                                    <option value="breakfast">فطار</option>
                                    <option value="lunch">غداء</option>
                                    <option value="dinner">عشاء</option>
                                </select>
                            </label>
                            <label class="field slim">
                                <span>القسم</span>
                                <select id="adminCategorySelect">
                                    <option value="food">أكل</option>
                                    <option value="drinks">مشروبات</option>
                                    <option value="dessert">حلو</option>
                                </select>
                            </label>
                        </div>

                        <div class="panel admin-panel">
                            <div class="section-heading compact">
                                <div>
                                    <span class="kicker">الأصناف الحالية</span>
                                    <h2>حدد المتاح اليوم</h2>
                                </div>
                                <span class="count-pill" id="availableCount">0 متاح</span>
                            </div>
                            <div id="adminCatalog" class="catalog-list"></div>
                        </div>

                        <div class="panel admin-panel add-item-panel">
                            <div class="section-heading compact">
                                <div>
                                    <span class="kicker">صنف غير موجود؟</span>
                                    <h2>إضافة صنف جديد</h2>
                                </div>
                            </div>
                            <form id="addItemForm" class="add-item-form">
                                <label class="field grow">
                                    <span>اسم الصنف</span>
                                    <input id="newItemName" placeholder="مثال: عدس" required />
                                </label>
                                <label class="field icon-field">
                                    <span>أيقونة</span>
                                    <input id="newItemIcon" value="🍲" maxlength="4" />
                                </label>
                                <button class="btn btn-secondary" type="submit">إضافة</button>
                            </form>
                        </div>

                        <button class="btn btn-primary btn-wide save-menu-btn" id="saveMenuBtn">حفظ قائمة اليوم</button>
                    </div>

                    <div id="adminReportSection" hidden>
                        <div class="report-actions no-print">
                            <button class="btn btn-secondary" id="refreshReportBtn">تحديث التقرير</button>
                            <button class="btn btn-primary" id="printReportBtn">🖨️ طباعة / حفظ PDF</button>
                        </div>

                        <article class="report-sheet" id="reportSheet">
                            <div class="report-header">
                                <div class="report-cross">✠</div>
                                <div>
                                    <h2>دير الأنبا بيشوي العامر</h2>
                                    <h1>تقرير طلبات الوجبات اليومية</h1>
                                    <p id="reportDate"></p>
                                </div>
                                <div class="report-seal">طلبات الدير</div>
                            </div>

                            <div class="report-summary" id="reportSummary"></div>

                            <section class="report-totals-block">
                                <div class="report-subheading">
                                    <h3>إجمالي الأصناف المطلوبة</h3>
                                    <small>ملخص سريع للمطبخ</small>
                                </div>
                                <div class="report-table-wrap">
                                    <table class="totals-table">
                                        <thead>
                                            <tr>
                                                <th>الوجبة</th>
                                                <th>القسم</th>
                                                <th>الصنف</th>
                                                <th>الإجمالي</th>
                                            </tr>
                                        </thead>
                                        <tbody id="reportTotalsBody"></tbody>
                                    </table>
                                </div>
                            </section>

                            <div class="report-subheading detailed-heading">
                                <h3>تفاصيل طلبات الرهبان</h3>
                                <small>للمراجعة والمتابعة</small>
                            </div>
                            <div class="report-table-wrap">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم الراهب</th>
                                            <th>الوجبة</th>
                                            <th>القسم</th>
                                            <th>الصنف</th>
                                            <th>الكمية</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reportTableBody"></tbody>
                                </table>
                            </div>
                            <div class="report-empty" id="reportEmpty" hidden>لا توجد طلبات مسجلة بعد.</div>
                        </article>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Order review modal -->
    <div class="modal" id="orderModal" aria-hidden="true">
        <div class="modal-backdrop" data-close-modal></div>
        <section class="modal-card" role="dialog" aria-modal="true" aria-labelledby="orderModalTitle">
            <div class="modal-handle"></div>
            <header class="modal-header">
                <div>
                    <span class="kicker">الخطوة الأخيرة</span>
                    <h2 id="orderModalTitle">راجع طلبك</h2>
                </div>
                <button class="icon-btn dark" data-close-modal aria-label="إغلاق">×</button>
            </header>
            <div class="order-review" id="orderReview"></div>
            <div class="modal-actions">
                <button class="btn btn-ghost" data-close-modal>تعديل الطلب</button>
                <button class="btn btn-primary" id="submitOrderBtn">إرسال الطلب</button>
            </div>
        </section>
    </div>

    <!-- Profile drawer -->
    <div class="drawer" id="profileDrawer" aria-hidden="true">
        <div class="drawer-backdrop" data-close-drawer></div>
        <aside class="drawer-card">
            <div class="profile-head">
                <div class="avatar large">✠</div>
                <div>
                    <strong id="profileName">أبونا بيشوي</strong>
                    <small id="profileRole">راهب</small>
                </div>
            </div>
            <button class="drawer-link" id="drawerHomeBtn">⌂ الرئيسية</button>
            <button class="drawer-link" id="drawerFoodBtn">🍽️ وجبات اليوم</button>
            <button class="drawer-link" id="drawerAdminBtn" hidden>⚙️ لوحة المسؤول</button>
            <button class="drawer-link danger" id="logoutBtn">تسجيل الخروج</button>
        </aside>
    </div>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
