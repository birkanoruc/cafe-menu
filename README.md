# Laravel API with Vue.js

Bu proje, Laravel ile REST API geliştirmeyi ve Vue.js kullanarak frontend'i oluşturmayı amaçlayan bir projedir. Ayrıca, MySQL veritabanı ve local filesystem kullanılarak veriler saklanmaktadır. Laravel içinde Vue.js ile entegre edilmiş ve API üzerinden veri alışverişi yapılmıştır. State yönetimi pinia ile gerçekleştirilmiştir. Laravel'in yerel özellikleri kullanılmaya çalışarak hazırlanılmıştır.

## Proje Kurulumu

### 1. Depoyu Klonlayın

Öncelikle, bu projeyi bilgisayarınıza klonlayın:

```bash
git clone https://github.com/birkanoruc/cafe-menu.git
cd cafe-menu
```

### 2. Gerekli Paketleri Yükleyin

Projede kullanılan PHP bağımlılıklarını yüklemek için Composer kullanın:

```bash
composer install
```

### 3. Ortam Değişkenlerini Yapılandırın

.env.example dosyasını .env olarak kopyalayın:

```bash
cp .env.example .env
```

Veritabanı ayarlarını .env dosyasında yapılandırın:

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proje_adi
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Uygulama Anahtarı Oluşturun

Laravel uygulama anahtarını oluşturun:

```bash
php artisan key:generate
```

### 5. Veritabanını Kurun ve Seeder’ları Çalıştırın

Veritabanını oluşturun ve seed işlemini yapın:

```bash
php artisan migrate --seed
```

### 6. Storage Link Oluşturun

Local filesystem için storage linki oluşturun:

```bash
php artisan storage:link
```

### 7. Vue.js Bağımlılıklarını Yükleyin

Vue.js bağımlılıklarını yüklemek için npm veya yarn kullanabilirsiniz:

```bash
npm install
```

### 8. Frontend Derleme

Frontend’i derlemek için aşağıdaki komutu kullanın:

```bash
npm run dev
```

### 9. Uygulamayı Çalıştırın

Laravel uygulamanızı başlatmak için aşağıdaki komutu kullanın:

```bash
php artisan serve
```

Uygulama, http://localhost:8000 adresinde çalışacaktır.
