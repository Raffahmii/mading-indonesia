# MADING INDONESIA — Struktur Folder Laravel

Stack: Laravel 11/12 · Blade · Tailwind CSS · Alpine.js · MySQL · Lucide Icons
Satu aplikasi, satu database, tiga area: **Public**, **Super Admin**, **Admin Universitas**.

Penanda `[P01]`–`[P12]` = modul prompt coding yang membuat file tersebut.

```text
mading-indonesia/
│
├── app/
│   ├── Enums/                                  [P02]
│   │   ├── UserRole.php                        # super_admin | university_admin | member
│   │   ├── UserStatus.php                      # active | suspended
│   │   ├── UniversityStatus.php                # active | inactive
│   │   ├── PostStatus.php                      # draft | pending | approved | rejected | published | archived
│   │   └── ReviewAction.php                    # submitted | approved | rejected | published | archived
│   │
│   ├── Models/                                 [P02]
│   │   ├── User.php
│   │   ├── University.php
│   │   ├── Category.php
│   │   ├── Post.php
│   │   ├── PostReview.php
│   │   ├── Bookmark.php
│   │   ├── ActivityLog.php
│   │   └── Scopes/
│   │       └── UniversityScope.php             # [P03] global scope: filter university_id admin
│   │
│   ├── Models/Concerns/
│   │   ├── BelongsToUniversity.php             # [P03] trait: pasang UniversityScope + auto-fill university_id
│   │   └── HasSlug.php                         # [P04] generate slug unik
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   │
│   │   │   ├── Auth/                           [P01]
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── RegisteredUserController.php    # register hanya untuk member
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   ├── NewPasswordController.php
│   │   │   │   └── ConfirmablePasswordController.php
│   │   │   │
│   │   │   ├── Public/                         [P08, P09]
│   │   │   │   ├── HomeController.php          # landing page
│   │   │   │   ├── UniversityController.php    # explorer + profil universitas
│   │   │   │   ├── PostController.php          # detail konten
│   │   │   │   ├── SearchController.php        # global search
│   │   │   │   ├── CategoryController.php
│   │   │   │   └── BookmarkController.php      # opsional
│   │   │   │
│   │   │   ├── Member/                         [P01]
│   │   │   │   └── ProfileController.php
│   │   │   │
│   │   │   ├── SuperAdmin/                     [P04, P07, P10]
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UniversityController.php    # CRUD universitas + buat admin
│   │   │   │   ├── UniversityAdminController.php
│   │   │   │   ├── MemberController.php
│   │   │   │   ├── PostController.php
│   │   │   │   ├── ApprovalController.php      # approve / reject / publish / archive
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── ActivityLogController.php
│   │   │   │   └── SettingController.php
│   │   │   │
│   │   │   └── UniversityAdmin/                [P06, P07, P11]
│   │   │       ├── DashboardController.php
│   │   │       ├── PostController.php          # CRUD + submit for approval
│   │   │       ├── UniversityProfileController.php
│   │   │       └── AccountController.php
│   │   │
│   │   ├── Middleware/                         [P03, P05]
│   │   │   ├── EnsureUserRole.php              # alias: role:super_admin
│   │   │   ├── EnsureUserIsActive.php          # tolak akun suspended
│   │   │   ├── EnsureUniversityIsActive.php    # tolak admin dari universitas inactive
│   │   │   └── ShareUniversityTheme.php        # inject warna universitas ke view
│   │   │
│   │   └── Requests/                           [P04, P06, P07]
│   │       ├── Auth/
│   │       │   ├── LoginRequest.php
│   │       │   └── RegisterRequest.php
│   │       ├── SuperAdmin/
│   │       │   ├── StoreUniversityRequest.php
│   │       │   ├── UpdateUniversityRequest.php
│   │       │   ├── StoreUniversityAdminRequest.php
│   │       │   ├── UpdateUniversityAdminRequest.php
│   │       │   ├── StoreCategoryRequest.php
│   │       │   ├── UpdateCategoryRequest.php
│   │       │   └── ReviewPostRequest.php       # note wajib saat reject
│   │       ├── UniversityAdmin/
│   │       │   ├── StorePostRequest.php
│   │       │   ├── UpdatePostRequest.php
│   │       │   └── UpdateUniversityProfileRequest.php
│   │       └── Member/
│   │           └── UpdateProfileRequest.php
│   │
│   ├── Policies/                               [P03]
│   │   ├── UniversityPolicy.php
│   │   ├── PostPolicy.php                      # admin hanya post universitasnya & status boleh diedit
│   │   ├── CategoryPolicy.php
│   │   └── UserPolicy.php
│   │
│   ├── Services/                               [P04, P07]
│   │   ├── UniversityService.php               # buat universitas + admin dalam satu transaksi
│   │   ├── PostWorkflowService.php             # state machine: submit/approve/reject/publish/archive
│   │   ├── ActivityLogger.php
│   │   ├── FileUploadService.php               # logo & cover image
│   │   └── ThemeService.php                    # validasi & turunkan shade warna universitas
│   │
│   ├── View/
│   │   └── Components/                         [P05, P08]
│   │       ├── Layouts/
│   │       │   ├── PublicLayout.php
│   │       │   ├── SuperAdminLayout.php
│   │       │   └── UniversityAdminLayout.php
│   │       └── StatusBadge.php
│   │
│   ├── Rules/
│   │   └── HexColor.php                        # [P04] validasi #RRGGBB
│   │
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── AuthServiceProvider.php             # [P03] register policies & gates
│
├── bootstrap/
│   └── app.php                                 # [P03] alias middleware, load route files
│
├── config/
│   └── mading.php                              # [P01] pagination, upload limit, warna default platform
│
├── database/
│   ├── migrations/                             [P02]
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_10_05_000010_create_universities_table.php
│   │   ├── 2026_10_05_000020_add_university_id_and_role_to_users_table.php
│   │   ├── 2026_10_05_000030_create_categories_table.php
│   │   ├── 2026_10_05_000040_create_posts_table.php
│   │   ├── 2026_10_05_000050_create_post_reviews_table.php
│   │   ├── 2026_10_05_000060_create_bookmarks_table.php
│   │   └── 2026_10_05_000070_create_activity_logs_table.php
│   │
│   ├── factories/                              [P02]
│   │   ├── UserFactory.php
│   │   ├── UniversityFactory.php
│   │   ├── CategoryFactory.php
│   │   └── PostFactory.php
│   │
│   └── seeders/                                [P02]
│       ├── DatabaseSeeder.php
│       ├── SuperAdminSeeder.php
│       ├── UniversitySeeder.php                # ITB, UI, UGM, ITS, IPB + admin masing-masing
│       ├── CategorySeeder.php                  # Pengumuman, Event, Lomba, Seminar, Beasiswa, dst.
│       └── PostSeeder.php                      # dummy konten berbagai status
│
├── public/
│   ├── index.php
│   └── images/
│       ├── brand/                              # logo Mading Indonesia
│       └── placeholders/                       # cover & logo default
│
├── resources/
│   ├── css/
│   │   ├── app.css                             # [P05] @tailwind + import
│   │   ├── theme.css                           # [P05] CSS variables platform & universitas
│   │   └── components.css                      # [P05] kelas komponen reusable
│   │
│   ├── js/
│   │   ├── app.js                              # init Alpine + Lucide
│   │   ├── bootstrap.js
│   │   └── components/
│   │       ├── sidebar.js                      # drawer mobile
│   │       ├── modal.js
│   │       ├── toast.js
│   │       ├── color-picker.js                 # preview warna di form universitas
│   │       └── image-preview.js
│   │
│   └── views/
│       │
│       ├── layouts/                            [P05]
│       │   ├── public.blade.php                # tema pink-purple platform
│       │   ├── guest.blade.php                 # login/register
│       │   ├── super-admin.blade.php           # tema platform, sidebar admin
│       │   └── university-admin.blade.php      # tema dinamis: style="--university-primary: ..."
│       │
│       ├── components/                         [P05]
│       │   ├── ui/
│       │   │   ├── button.blade.php
│       │   │   ├── input.blade.php
│       │   │   ├── textarea.blade.php
│       │   │   ├── select.blade.php
│       │   │   ├── search.blade.php
│       │   │   ├── badge.blade.php
│       │   │   ├── status-badge.blade.php      # draft/pending/approved/rejected/published/archived
│       │   │   ├── alert.blade.php
│       │   │   ├── toast.blade.php
│       │   │   ├── modal.blade.php
│       │   │   ├── confirm-dialog.blade.php
│       │   │   ├── dropdown.blade.php
│       │   │   ├── tabs.blade.php
│       │   │   ├── avatar.blade.php
│       │   │   ├── breadcrumb.blade.php
│       │   │   ├── pagination.blade.php
│       │   │   ├── table.blade.php
│       │   │   ├── empty-state.blade.php
│       │   │   ├── loading.blade.php
│       │   │   ├── file-upload.blade.php
│       │   │   └── icon.blade.php              # wrapper Lucide
│       │   │
│       │   ├── cards/
│       │   │   ├── university-card.blade.php
│       │   │   ├── post-card.blade.php
│       │   │   └── stat-card.blade.php
│       │   │
│       │   ├── nav/
│       │   │   ├── public-navbar.blade.php
│       │   │   ├── footer.blade.php
│       │   │   ├── admin-sidebar.blade.php
│       │   │   ├── admin-topbar.blade.php
│       │   │   └── mobile-menu.blade.php
│       │   │
│       │   └── decor/
│       │       └── blobs.blade.php             # organic shape untuk hero
│       │
│       ├── auth/                               [P01]
│       │   ├── login.blade.php
│       │   ├── register.blade.php              # hanya member
│       │   ├── forgot-password.blade.php
│       │   └── reset-password.blade.php
│       │
│       ├── public/                             [P08, P09]
│       │   ├── home.blade.php                  # hero, search, featured, latest, event, how it works, CTA
│       │   ├── search.blade.php
│       │   ├── universities/
│       │   │   ├── index.blade.php             # explorer + filter kota
│       │   │   └── show.blade.php              # profil universitas (aksen warna univ)
│       │   ├── posts/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php              # detail konten
│       │   ├── categories/
│       │   │   └── show.blade.php
│       │   └── partials/
│       │       ├── hero.blade.php
│       │       ├── featured-universities.blade.php
│       │       ├── latest-posts.blade.php
│       │       ├── events.blade.php
│       │       ├── how-it-works.blade.php
│       │       └── cta.blade.php
│       │
│       ├── member/                             [P01]
│       │   ├── profile.blade.php
│       │   └── bookmarks.blade.php             # opsional
│       │
│       ├── super-admin/                        [P10]
│       │   ├── dashboard.blade.php
│       │   ├── universities/
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php            # termasuk form akun admin awal
│       │   │   ├── edit.blade.php
│       │   │   └── show.blade.php
│       │   ├── admins/
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   └── edit.blade.php
│       │   ├── members/
│       │   │   └── index.blade.php
│       │   ├── posts/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── approvals/
│       │   │   ├── index.blade.php             # antrean pending
│       │   │   └── review.blade.php            # approve / reject + catatan
│       │   ├── categories/
│       │   │   └── index.blade.php
│       │   ├── activity-logs/
│       │   │   └── index.blade.php
│       │   └── settings/
│       │       └── index.blade.php
│       │
│       ├── university-admin/                   [P11]
│       │   ├── dashboard.blade.php
│       │   ├── posts/
│       │   │   ├── index.blade.php             # filter: semua/draft/pending/published/rejected
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   ├── show.blade.php              # termasuk riwayat review & alasan penolakan
│       │   │   └── _form.blade.php
│       │   ├── profile/
│       │   │   └── edit.blade.php              # profil universitas (tanpa ubah slug/status)
│       │   └── account/
│       │       └── edit.blade.php
│       │
│       └── errors/
│           ├── 403.blade.php
│           ├── 404.blade.php
│           └── 500.blade.php
│
├── routes/                                     [P01, P03]
│   ├── web.php                                 # include file di bawah
│   ├── auth.php
│   ├── public.php                              # guest & member
│   ├── super-admin.php                         # prefix /super-admin, middleware role:super_admin
│   ├── university-admin.php                    # prefix /admin, middleware role:university_admin
│   └── console.php
│
├── storage/
│   └── app/
│       └── public/
│           ├── universities/logos/
│           └── posts/covers/
│
├── tests/                                      [P12]
│   ├── Feature/
│   │   ├── Auth/
│   │   │   ├── RegistrationTest.php            # register selalu jadi member
│   │   │   └── LoginRedirectTest.php           # redirect per role
│   │   ├── Authorization/
│   │   │   ├── RoleAccessTest.php              # member tidak bisa buka dashboard admin, dst.
│   │   │   └── UniversityScopeTest.php         # admin ITB tidak bisa akses post UI via ID/URL
│   │   ├── Workflow/
│   │   │   └── PostApprovalTest.php            # draft → pending → published / rejected
│   │   ├── Public/
│   │   │   └── PublicVisibilityTest.php        # hanya published yang tampil
│   │   └── SuperAdmin/
│   │       └── UniversityManagementTest.php
│   └── Unit/
│       ├── PostWorkflowServiceTest.php
│       └── HexColorRuleTest.php
│
├── .env
├── .env.example
├── composer.json
├── package.json
├── tailwind.config.js                          # [P05] font Plus Jakarta Sans, warna platform, radius
├── postcss.config.js
├── vite.config.js
└── README.md
```

## Pemetaan Modul Prompt

| Prompt | Modul                              | Folder / file utama                                              |
|--------|------------------------------------|------------------------------------------------------------------|
| P01    | Laravel install + Authentication   | `Auth/`, `routes/auth.php`, `views/auth/`, `config/mading.php`   |
| P02    | Database + Models                  | `migrations/`, `Models/`, `Enums/`, `seeders/`, `factories/`     |
| P03    | Role authorization + scope         | `Middleware/`, `Policies/`, `Scopes/`, `bootstrap/app.php`       |
| P04    | University management              | `SuperAdmin/UniversityController`, `UniversityService`           |
| P05    | Dynamic theme + design system      | `theme.css`, `layouts/`, `components/`, `ShareUniversityTheme`   |
| P06    | Content CRUD                       | `UniversityAdmin/PostController`, `Requests/UniversityAdmin/`    |
| P07    | Approval workflow                  | `PostWorkflowService`, `ApprovalController`, `post_reviews`      |
| P08    | Public landing page                | `Public/HomeController`, `views/public/home` + `partials/`       |
| P09    | University public page             | `Public/UniversityController`, `views/public/universities/`      |
| P10    | Super Admin dashboard              | `views/super-admin/`, `SuperAdmin/*`                             |
| P11    | University Admin dashboard         | `views/university-admin/`, `UniversityAdmin/*`                   |
| P12    | Testing + security                 | `tests/`                                                         |

## Konvensi Penting

- **Route:** `/` publik · `/universitas/{slug}` · `/universitas/{slug}/{post}` · `/super-admin/*` · `/admin/*`
- **Scope:** model `Post` memakai trait `BelongsToUniversity` + `UniversityScope`. Scope hanya aktif untuk `university_admin`, dan `university_id` selalu diisi dari `auth()->user()`, tidak pernah dari request.
- **Tema dinamis:** `ShareUniversityTheme` membagikan `$theme` ke layout, lalu layout menulis `style="--university-primary: {{ $theme->primary }}; --university-secondary: {{ $theme->secondary }}"`. Tailwind memakai `bg-[var(--university-primary)]`, tidak ada warna universitas yang di-hardcode.
- **Workflow:** semua perubahan status lewat `PostWorkflowService`, tidak ada controller yang mengubah kolom `status` secara langsung. Setiap transisi menulis ke `post_reviews` dan `activity_logs`.
- **Controller tipis:** validasi di `Requests/`, otorisasi di `Policies/`, logika bisnis di `Services/`.
