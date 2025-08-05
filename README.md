<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<h1 align="center">real-estate-company-management</h1>

<p align="center">
  لوحة تحكم بسيطة لإدارة العقارات وعمليات الحجز، تؤمن واجهة منظمة وسهلة الاستخدام للزبائن لتصفح العقارات، حجز المواعيد، والتواصل مع فريق الشركة.
</p>

---

## 🏠 وصف النظام

نظام متكامل لإدارة شركة عقارية، مبني باستخدام Laravel 12. يتيح للمدير والموظف إدارة العقارات والحجوزات من خلال لوحة تحكم Blade، بينما يستطيع الزبائن استخدام واجهة API لتصفح العقارات وطلب الزيارات وتقييم الخدمات.

---

## 🚀 المميزات الرئيسية

- مصادقة JWT للزبائن
- Laravel UI للمصادقة التقليدية للإدارة
- أدوار وصلاحيات باستخدام Spatie
- واجهة Blade للمدير والموظف
- واجهة API للزبون والزائر
- إدارة العقارات بأنواعها (شقة، فيلا، أرض، محل)
- خدمات إضافية اختيارية للعقارات
- حجز الزيارات، التقييمات، سجل الحجز

---

## 👥 أنواع المستخدمين

| الدور | المميزات |
|------|-----------|
| 👑 Admin | إدارة العقارات، أنواع العقارات، المستخدمين، الصلاحيات، التقارير |
| 👨‍💼 Employee | إدارة الحجوزات، تأكيد المواعيد، متابعة الملاحظات |
| 🧑‍💻 Customer | تسجيل الحساب، تصفح العقارات، طلب حجز، تقييم العقارات |
| 🌐 Guest | تصفح العقارات فقط بدون تسجيل |

---

## ⚙️ التثبيت والتشغيل

```bash
git clone https://github.com/your-username/real-estate-company-management.git
cd real-estate-company-management
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
