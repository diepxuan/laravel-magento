# Laravel Magento

Tích hợp Laravel với Magento API (OAuth 1.0).

## Mô tả ngắn gọn

Laravel Integration With Magento API (OAuth 1.0). Package cung cấp client để tương tác với Magento 2 REST API thông qua OAuth 1.0, với các builder và model cho từng resource.

## Chức năng chính

- Cung cấp client Magento với xác thực OAuth 1.0 (sử dụng Guzzle và OAuth subscriber).
- Các builder để truy vấn dữ liệu: Product, Category, Customer, Order, Store Websites, Store Views, Store Configs, Customer Group, Customer Address.
- Hỗ trợ Magento 2 API (version V1).
- Cung cấp các model tương ứng với resource của Magento.
- Xử lý exception riêng cho Magento.
- Migration để lưu trữ OAuth keys.
- Cấu hình linh hoạt qua file config và environment variables.

## Cài đặt / Sử dụng

```bash
composer require diepxuan/laravel-magento
```

Package tự động đăng ký ServiceProvider (tuy nhiên provider chưa có logic đăng ký).

Cấu hình environment variables trong `.env`:

```env
MAGENTO_BASE_URL=https://store.com
MAGENTO_CONSUMER_KEY=your_consumer_key
MAGENTO_CONSUMER_SECRET=your_consumer_secret
MAGENTO_ACCESS_TOKEN=your_access_token
MAGENTO_ACCESS_TOKEN_SECRET=your_access_token_secret
MAGENTO_BASE_PATH=rest
MAGENTO_STORE_CODE=all
MAGENTO_API_VERSION=V1
MAGENTO_DEBUG_ENABLED=true
```

Sử dụng qua Facade `Diepxuan\Magento\Magento` (cho các resource cơ bản) hoặc `Diepxuan\Magento\Magento2` (cho đầy đủ resource):

```php
use Diepxuan\Magento\Magento;
use Diepxuan\Magento\Magento2;

// Dùng Magento facade (static)
$products = Magento::products()->all();
$categories = Magento::categories()->all();

// Dùng Magento2 client (instance)
$magento = new Magento2();
$orders = $magento->orders()->all();
$customers = $magento->customers()->all();
```

Xem chi tiết trong từng builder.

## Cấu trúc thư mục

```
laravel-magento/
├── config/
│   └── config.php                 # Cấu hình package
├── database/
│   └── migrations/
│       └── 2024_05_06_131052_magento_oauth_keys.php
├── routes/
│   └── web.php                    # Route (hiện trống)
├── src/
│   ├── Builders/                  # Các builder cho từng resource
│   │   ├── Builder.php
│   │   ├── ProductBuilder.php
│   │   ├── CategoryBuilder.php
│   │   ├── CustomerBuilder.php
│   │   ├── OrderBuilder.php
│   │   ├── StoreWebsitesBuilder.php
│   │   ├── StoreViewsBuilder.php
│   │   ├── StoreConfigsBuilder.php
│   │   ├── CustomerGroupBuilder.php
│   │   └── CustomerAddressBuilder.php
│   ├── Models/                    # Các model mapping với Magento
│   │   ├── Model.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Customer.php
│   │   ├── Order.php
│   │   ├── StoreWebsites.php
│   │   ├── StoreViews.php
│   │   ├── StoreConfigs.php
│   │   ├── CustomerGroup.php
│   │   └── CustomerAddress.php
│   ├── Exceptions/                # Exception đặc thù
│   ├── Http/                      # Request client
│   ├── Query/                     # SearchCriteria, Grammar
│   ├── Utils/                     # Oauth1 helper
│   ├── Magento.php                # Facade chính (một số resource)
│   ├── Magento2.php               # Magento 2 client (đầy đủ)
│   └── Providers/
│       └── MagentoServiceProvider.php
├── .editorconfig
├── .gitignore
├── .php-cs-fixer.dist.php
├── LICENSE
├── README.md
└── composer.json
```

## Liên kết đến các package liên quan

- diepxuan/laravel-core
- guzzlehttp/guzzle
- guzzlehttp/oauth-subscriber

## Ghi chú

Package này giúp tích hợp dễ dàng với Magento API, phù hợp cho các dự án thương mại điện tử sử dụng Magento làm backend. Cần lưu ý rằng ServiceProvider chưa đăng ký các binding, cần tự đăng ký nếu muốn sử dụng dependency injection.