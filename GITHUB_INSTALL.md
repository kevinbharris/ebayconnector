# Quick Start Guide - GitHub Installation

This guide is for users who have downloaded the eBay Connector package directly from GitHub.

## Prerequisites

- Bagisto 2.3.8 installed and running
- PHP 8.1 or higher
- Composer installed
- Terminal/command line access

---

## Quick Installation Steps

### 1. Prepare Package Directory

Create the packages directory structure in your Bagisto installation:

```bash
# Navigate to your Bagisto root directory
cd /path/to/your/bagisto

# Create packages directory structure
mkdir -p packages/kevinbharris
```

### 2. Download or Clone the Package

**Option A: Clone via Git**
```bash
cd packages/kevinbharris
git clone https://github.com/kevinbharris/ebayconnector.git
```

**Option B: Download ZIP**
1. Download the ZIP from [GitHub](https://github.com/kevinbharris/ebayconnector)
2. Extract to `packages/kevinbharris/ebayconnector`

### 3. Configure Composer

Edit your project's main `composer.json` (in Bagisto root):

Add this to the `"repositories"` section (create it if it doesn't exist):

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "packages/kevinbharris/ebayconnector",
            "options": {
                "symlink": true
            }
        }
    ]
}
```

If you already have a repositories section, just add the new repository object to the array.

### 4. Install the Package

Run Composer to install the package from local path:

```bash
composer require kevinbharris/ebayconnector:@dev
```

You should see output indicating the package is being installed from the local path.

### 5. Publish Package Files

Publish configuration:
```bash
php artisan vendor:publish --tag=ebayconnector-config
```

Publish assets (optional):
```bash
php artisan vendor:publish --tag=ebayconnector-assets
```

Publish views (optional, only if customizing):
```bash
php artisan vendor:publish --tag=ebayconnector-views
```

### 6. Run Migrations

Create the required database tables:

```bash
php artisan migrate
```

This creates:
- `ebay_configurations`
- `ebay_product_mappings`
- `ebay_order_mappings`
- `ebay_sync_logs`

### 7. Clear Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 8. Verify Installation

Check the package is registered:

```bash
php artisan package:discover
```

Look for: `KevinBHarris\EbayConnector\Providers\EbayConnectorServiceProvider`

Check routes are loaded:

```bash
php artisan route:list | grep ebayconnector
```

You should see routes like:
- `ebayconnector.admin.configuration.index`
- `ebayconnector.admin.products.index`
- `ebayconnector.admin.orders.index`
- `ebayconnector.admin.logs.index`

---

## Post-Installation

### 1. Log in to Admin Panel

Navigate to your Bagisto admin panel (typically `http://yourdomain.com/admin`)

### 2. Locate eBay Connector Menu

You should see "eBay Connector" in the admin sidebar with submenu items:
- Configuration
- Product Sync
- Order Sync
- Sync Logs

### 3. Configure eBay API

1. Click **eBay Connector** → **Configuration**
2. Enter your eBay API credentials (get them from [eBay Developer Portal](https://developer.ebay.com/))
3. Select environment (Sandbox for testing, Production for live)
4. Click **Test Connection** to verify
5. Enable auto-sync options if desired
6. Click **Save Configuration**

---

## Troubleshooting GitHub Installation

### Package Not Found

**Problem**: `composer require` can't find the package

**Solution**:
- Verify the package is in `packages/kevinbharris/ebayconnector`
- Check your `composer.json` has the correct repository path
- Make sure the path is relative to the composer.json location
- Run `composer update --no-scripts`

### Service Provider Not Loaded

**Problem**: Menu doesn't appear in admin panel

**Solution**:
```bash
composer dump-autoload
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
```

### Symlink Issues (Windows)

**Problem**: Symlink creation fails on Windows

**Solution**:
Change the repository configuration in `composer.json`:
```json
{
    "type": "path",
    "url": "packages/kevinbharris/ebayconnector",
    "options": {
        "symlink": false
    }
}
```

Then run:
```bash
composer update kevinbharris/ebayconnector
```

### Routes Not Working

**Problem**: 404 errors when accessing eBay Connector pages

**Solution**:
```bash
php artisan route:clear
php artisan route:cache
php artisan config:clear
```

### Migrations Already Exist

**Problem**: Migration error saying tables already exist

**Solution**:
If you're reinstalling, either:
- Drop the tables first, or
- Skip migrations if data should be preserved

### Views Not Found

**Problem**: Blade view errors

**Solution**:
```bash
php artisan vendor:publish --tag=ebayconnector-views --force
php artisan view:clear
```

---

## Directory Structure After Installation

Your Bagisto installation should look like this:

```
your-bagisto-project/
├── app/
├── config/
│   └── ebayconnector.php          # Published config
├── packages/
│   └── kevinbharris/
│       └── ebayconnector/          # Package source
│           ├── src/
│           ├── resources/
│           ├── publishable/
│           └── composer.json
├── public/
│   └── vendor/
│       └── ebayconnector/          # Published assets
├── resources/
│   └── views/
│       └── vendor/
│           └── ebayconnector/      # Published views (if published)
├── vendor/
│   └── kevinbharris/
│       └── ebayconnector -> ../../packages/kevinbharris/ebayconnector  # Symlink
└── composer.json                   # Modified with repository
```

---

## Updating the Package

When you pull updates from GitHub:

### 1. Pull Latest Changes

```bash
cd packages/kevinbharris/ebayconnector
git pull origin main
```

### 2. Update Dependencies

```bash
cd ../../../  # Back to Bagisto root
composer update kevinbharris/ebayconnector
```

### 3. Re-publish if Needed

```bash
php artisan vendor:publish --tag=ebayconnector-config --force
php artisan vendor:publish --tag=ebayconnector-assets --force
```

### 4. Run New Migrations

```bash
php artisan migrate
```

### 5. Clear Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## Development Mode

If you're developing or modifying the package:

### 1. Use Symlink

Make sure your composer.json has `"symlink": true` so changes are immediately reflected.

### 2. Autoload Changes

After modifying classes:
```bash
composer dump-autoload
```

### 3. Clear Caches

After any changes:
```bash
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

### 4. Route Changes

After modifying routes:
```bash
php artisan route:clear
```

---

## Need Help?

- **Documentation**: See [INSTALLATION.md](INSTALLATION.md) for detailed instructions
- **README**: See [README.md](README.md) for feature documentation
- **GitHub Issues**: https://github.com/kevinbharris/ebayconnector/issues
- **Email**: kevin.b.harris.2015@gmail.com

---

## Next Steps

After successful installation:

1. ✅ Configure eBay API credentials
2. ✅ Test connection to eBay
3. ✅ Set up automatic sync options
4. ✅ Sync your first product
5. ✅ Import your first order
6. ✅ Review sync logs

See the main [README.md](README.md) for detailed usage instructions.
