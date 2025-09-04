# Test Sinovlarini O'tkazish Tizimi - Loyiha Tavsifi

## 📋 Umumiy Ma'lumot

Men sizga Laravel + Bootstrap asosida **Test Sinovlarini O'tkazish Tizimi**ni ishlab chiqib berdim. Bu tizim admin panel va foydalanuvchi interfeysi bilan to'liq kompleks echimdir.

## 🎯 Bajarilgan Vazifalar

### ✅ Admin Panel Imkoniyatlari:

1. **Savol kategoriyalari (CRUD)**:
   - Kategoriya qo'shish, o'zgartirish, o'chirish
   - Har bir kategoriya faol/nofaol holatini boshqarish

2. **Savollar (CRUD)**:
   - Kategoriya bo'yicha savollar yaratish
   - Har bir savol uchun 4 ta variant (a, b, c, d)
   - To'g'ri javobni belgilash imkoniyati
   - Savollarni tahrirlash va o'chirish

3. **Test yaratish**:
   - Qaysi kategoriyadan nechta savol olinishini aniqlash
   - Test davomiyligini belgilash (daqiqalarda)
   - Test boshlanish va tugash vaqtini o'rnatish
   - Maksimal urinishlar sonini belgilash

4. **Foydalanuvchilar boshqaruvi (CRUD)**:
   - Ism, familiya, email, parol kiritish
   - Foydalanuvchini faol/nofaol qilish
   - Admin va oddiy foydalanuvchi huquqlarini boshqarish

### ✅ Foydalanuvchi Interfeysi:

1. **Autentifikatsiya**:
   - Login-parol orqali kirish tizimi
   - Admin va foydalanuvchi huquqlari bo'yicha ajratish

2. **Test olish**:
   - Savollar **random tartibda** chiqadi
   - Har bir savol variantlari ham **random** tartibda ko'rsatiladi
   - Real-time **timer** (vaqt hisoblash)
   - AJAX orqali javoblarni avtomatik saqlash

3. **Test tugashi**:
   - Foydalanuvchi o'zi testni yakunlashi mumkin
   - Vaqt tugaganda **avtomatik yakunlanadi**
   - Test tugagandan so'ng batafsil hisobot

4. **Natijalar ko'rish**:
   - Nechta to'g'ri javob
   - Nechta noto'g'ri javob  
   - Nechta belgilangan savol
   - Nechta belgilanmagan savol
   - Har bir savolga qaysi javob berilgani batafsil ko'rsatiladi

5. **Logout tugmasi**: Tizimdan chiqish imkoniyati

### ✅ Qo'shimcha Shartlar:

- **Urinishlar soni**: Admin tomonidan har bir test uchun foydalanuvchi necha marta urinish qilishi mumkinligi belgilanadi
- **Vaqt nazorati**: Timer orqali vaqt tugaganda avtomatik yakunlanish
- **Random savollar**: Har safar turli tartibda savollar chiqishi

## 🛠 Texnik Xususiyatlar

### Backend:
- **Laravel 11** - PHP framework
- **SQLite** database (MySQL ham qo'llab-quvvatlanadi)
- **Eloquent ORM** - ma'lumotlar bazasi bilan ishlash
- **Custom Middleware** - admin va foydalanuvchi huquqlarini nazorat qilish
- **AJAX API** - real-time javoblarni saqlash

### Frontend:
- **Bootstrap 5.1.3** - responsive dizayn
- **jQuery** - JavaScript interaktivligi  
- **Font Awesome 6** - ikonkalar
- **Real-time Timer** - JavaScript timer
- **CSRF Protection** - xavfsizlik

### Database Strukturasi:
- **Categories** - test kategoriyalari
- **Questions** - savollar va variantlar
- **Tests** - test konfiguratsiyalari
- **Users** - foydalanuvchilar
- **Test_Results** - test natijalari
- **User_Test_Attempts** - foydalanuvchi urinishlarini nazorat qilish

## 🔧 O'rnatish va Ishga Tushirish

```bash
# 1. Dependencies o'rnatish
composer install

# 2. Environment sozlash  
php artisan key:generate

# 3. Database yaratish va ma'lumotlarni to'ldirish
php artisan migrate --seed

# 4. Server ishga tushirish
php artisan serve
```

## 👥 Test Ma'lumotlari

Tizim avtomatik ravishda quyidagi test hisoblarini yaratadi:

**Admin:**
- Email: admin@test.uz
- Parol: 12345678

**Foydalanuvchi:**
- Email: user@test.uz
- Parol: 12345678

## 🎨 Interfeys

### Admin Panel:
- Professional sidebar navigation
- Statistika dashboard
- CRUD operatsiyalar uchun to'liq interface
- Responsive dizayn

### Foydalanuvchi:  
- Zamonaviy card-based dizayn
- Intuitiv test olish interfeysi
- Real-time timer va progress
- Batafsil natijalar sahifasi

## 📊 Asosiy Funksiyalar

### Test Tizimi:
1. **Random Questions**: Har safar boshqa tartibda savollar
2. **Random Options**: Variantlar ham aralashtirilib chiqadi
3. **Timer**: Vaqt tugaganda avtomatik tugatish
4. **Auto-save**: Javoblar real-time saqlanadi
5. **Attempts Control**: Urinishlar sonini nazorat qilish
6. **Detailed Results**: Har bir javob uchun batafsil natija

### Admin Funksiyalar:
1. **Complete CRUD**: Barcha ma'lumotlarni boshqarish
2. **Statistics**: Dashboard orqali statistikalar
3. **User Management**: Foydalanuvchilarni boshqarish
4. **Test Configuration**: Murakkab test sozlamalari

## 🔒 Xavfsizlik

- **Role-based Access Control**: Admin va User huquqlari
- **CSRF Protection**: Laravel himoyasi
- **Input Validation**: Barcha ma'lumotlar tekshiriladi
- **Secure Authentication**: Bcrypt password hashing
- **Route Protection**: Middleware himoyasi

## ✨ Natija

Tizim to'liq **profesional darajada** ishlab chiqilgan bo'lib, sizning barcha talablaringizni qondiradi:

- ✅ Admin va foydalanuvchi interfeyslari
- ✅ CRUD operatsiyalar
- ✅ Random savollar va variantlar  
- ✅ Timer va avtomatik tugatish
- ✅ Batafsil natijalar
- ✅ Urinishlar nazorati
- ✅ Responsive dizayn
- ✅ Xavfsizlik choralari
- ✅ Professional kod sifati

Tizim Laravel va Bootstrap texnologiyalari yordamida zamonaviy standartlar asosida yaratilgan va ishlatishga tayyor!
