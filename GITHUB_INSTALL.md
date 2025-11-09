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

### eBay Connector Menu Not Appearing

**This is the most common issue after installation.** If the "eBay Connector" menu doesn't appear in the Bagisto admin sidebar:

#### Step 1: Verify Service Provider Registration
```bash
php artisan package:discover
```

You **must** see `KevinBHarris\EbayConnector\Providers\EbayConnectorServiceProvider` in the output.

If not listed:
```bash
composer dump-autoload
php artisan package:discover
```

#### Step 2: Clear All Caches (CRITICAL)
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

**Important**: You must clear caches after installation for the menu to appear!

#### Step 3: Verify Published Configuration
```bash
# Check if config file exists
ls -la config/ebayconnector.php

# If not found, publish it
php artisan vendor:publish --tag=ebayconnector-config
```

#### Step 4: Check Laravel Logs
```bash
tail -100 storage/logs/laravel.log | grep "eBay Connector"
```

**Look for warnings like:**
- "eBay Connector: Unable to register menu items. Bagisto core binding not found."
- "eBay Connector: Unable to register ACL permissions. Bagisto core binding not found."

If you see these warnings:
- Ensure you're running this inside a **Bagisto installation**, not a standalone Laravel app
- Verify Bagisto is properly installed and functional
- Check that Bagisto's core service provider is loaded

#### Step 5: Verify Bagisto Core Binding
```bash
php artisan tinker
```
Then type:
```php
app()->bound('core')
```
Press Enter. This **must** return `true`. If it returns `false`, Bagisto is not properly installed.

To exit tinker, type `exit` and press Enter.

#### Step 6: Check Admin User ACL Permissions
1. Log in to Bagisto admin panel
2. Navigate to **Settings** → **Users** → **Roles**
3. Edit your admin role (e.g., "Administrator")
4. Look for "eBay Connector" in the permissions list
5. Ensure all eBay Connector permissions are checked
6. Click **Save**
7. Log out and log back in

#### Step 7: Verify Database Tables Created
```bash
php artisan migrate:status | grep ebay
```

You should see:
- `ebay_configurations`
- `ebay_product_mappings`
- `ebay_order_mappings`
- `ebay_sync_logs`

If missing, run:
```bash
php artisan migrate
```

#### Step 8: Hard Refresh and Browser Cache
- Clear your browser cache
- Hard refresh (Ctrl+F5 or Cmd+Shift+R)
- Try a different browser or incognito mode
- Log out and log back in to admin panel

#### Still Not Working?

**Complete Reset Procedure:**
```bash
# 1. Clear everything
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 2. Dump autoload
composer dump-autoload

# 3. Re-publish configs
php artisan vendor:publish --tag=ebayconnector-config --force
php artisan vendor:publish --tag=ebayconnector-views --force
php artisan vendor:publish --tag=ebayconnector-assets --force

# 4. Clear caches again
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 5. Restart queue workers if running
php artisan queue:restart
```

Then log out and log back in to the admin panel.

### Package Not Found

**Problem**: `composer require` can't find the package

**Solution**:
- Verify the package is in `packages/kevinbharris/ebayconnector`
- Check your `composer.json` has the correct repository path
- Make sure the path is relative to the composer.json location
- Run `composer update --no-scripts`

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
