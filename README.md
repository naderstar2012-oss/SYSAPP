# نظام إدارة العقارات - Laravel

نظام شامل لإدارة العقارات تم تحويله من Node.js/React/tRPC إلى Laravel.

## الميزات

- ✅ إدارة المستخدمين والصلاحيات
- ✅ إدارة العقارات
- ✅ إدارة المستأجرين والعقود
- ✅ إدارة الفواتير والدفعات
- ✅ إدارة المصروفات والمشتريات
- ✅ إدارة الصيانة
- ✅ تقارير شاملة (PDF/Excel)
- ✅ سجل الإشعارات (Email/SMS)
- ✅ رفع الملفات إلى AWS S3
- ✅ واجهة مستخدم تفاعلية (Inertia.js + React)

## التقنيات المستخدمة

- **Backend:** Laravel 10.x
- **Frontend:** Inertia.js + React
- **Database:** MySQL/TiDB Cloud
- **Authentication:** Laravel Sanctum
- **File Storage:** AWS S3
- **Reports:** maatwebsite/excel, barryvdh/laravel-dompdf

## التثبيت

راجع ملف `CONVERSION_GUIDE.md` للحصول على تعليمات التثبيت والإعداد الكاملة.

## الاستخدام

### تشغيل المشروع

```bash
# تثبيت الاعتماديات
composer install
npm install

# توليد مفتاح التطبيق
php artisan key:generate

# تطبيق الـ Migrations
php artisan migrate
php artisan db:seed --class=AdminUserSeeder

# بناء الأصول
npm run dev  # للتطوير
npm run build  # للإنتاج

# تشغيل الخادم
php artisan serve
```

### المستخدم الافتراضي

- **Username:** admin
- **Password:** 123456
- **Email:** admin@example.com

## الترخيص

جميع الحقوق محفوظة © 2025
