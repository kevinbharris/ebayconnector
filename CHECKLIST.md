# Installation Verification Checklist

Use this checklist to verify that the eBay Connector package has been installed correctly.

---

## Pre-Installation Checklist

- [ ] Bagisto 2.3.8 (or compatible version) is installed and working
- [ ] PHP 8.1 or higher is installed
- [ ] Composer is installed and working
- [ ] Database is configured and accessible
- [ ] You have admin access to Bagisto admin panel
- [ ] You have eBay Developer account credentials

---

## Installation Verification

### 1. Package Files

- [ ] Package directory exists at `packages/kevinbharris/ebayconnector` (for GitHub install) OR
- [ ] Package is listed in `vendor/kevinbharris/ebayconnector` (for Composer install)

### 2. Composer Configuration

Run: `composer show kevinbharris/ebayconnector`

- [ ] Package is listed with correct version
- [ ] Package description is shown
- [ ] License shows as "MIT"

### 3. Service Provider

Run: `php artisan package:discover`

- [ ] `KevinBHarris\EbayConnector\Providers\EbayConnectorServiceProvider` appears in the list

### 4. Configuration File

- [ ] File exists: `config/ebayconnector.php`
- [ ] Configuration can be loaded: `php artisan config:cache` (no errors)

### 5. Database Tables

Run: `php artisan migrate:status`

Check that these migrations are completed:
- [ ] `create_ebay_configurations_table`
- [ ] `create_ebay_product_mappings_table`
- [ ] `create_ebay_order_mappings_table`
- [ ] `create_ebay_sync_logs_table`

Verify tables exist in your database:
- [ ] `ebay_configurations`
- [ ] `ebay_product_mappings`
- [ ] `ebay_order_mappings`
- [ ] `ebay_sync_logs`

### 6. Routes

Run: `php artisan route:list | grep ebayconnector`

Check that these routes are registered:
- [ ] `ebayconnector.admin.configuration.index`
- [ ] `ebayconnector.admin.configuration.store`
- [ ] `ebayconnector.admin.configuration.test`
- [ ] `ebayconnector.admin.products.index`
- [ ] `ebayconnector.admin.products.sync`
- [ ] `ebayconnector.admin.products.sync-all`
- [ ] `ebayconnector.admin.orders.index`
- [ ] `ebayconnector.admin.orders.sync`
- [ ] `ebayconnector.admin.orders.sync-new`
- [ ] `ebayconnector.admin.logs.index`
- [ ] `ebayconnector.admin.logs.clear`

### 7. Artisan Commands

Run: `php artisan list | grep ebay`

Check that these commands are available:
- [ ] `ebay:sync-products`
- [ ] `ebay:sync-orders`

### 8. Views

Run: `php artisan view:clear`

- [ ] Command completes without errors
- [ ] Views are accessible

### 9. Admin Panel

Log in to Bagisto admin panel:

- [ ] "eBay Connector" menu appears in the sidebar
- [ ] Menu has submenu items:
  - [ ] Configuration
  - [ ] Product Sync
  - [ ] Order Sync
  - [ ] Sync Logs

### 10. Configuration Page

Navigate to: eBay Connector → Configuration

- [ ] Page loads without errors
- [ ] Form fields are visible:
  - [ ] Enable eBay Connector checkbox
  - [ ] Environment dropdown
  - [ ] API Key field
  - [ ] API Secret field
  - [ ] Developer ID field
  - [ ] Certificate ID field
  - [ ] Auto Sync Products checkbox
  - [ ] Auto Sync Orders checkbox
  - [ ] Sync Interval field
- [ ] "Save Configuration" button works
- [ ] "Test Connection" button is present

### 11. Product Sync Page

Navigate to: eBay Connector → Product Sync

- [ ] Page loads without errors
- [ ] Product table displays
- [ ] "Sync All Products" button is present
- [ ] "Sync Selected" button is present
- [ ] Table headers are visible
- [ ] Pagination works (if applicable)

### 12. Order Sync Page

Navigate to: eBay Connector → Order Sync

- [ ] Page loads without errors
- [ ] Order mapping table displays
- [ ] "Sync New Orders" button is present
- [ ] Table shows eBay Order ID column
- [ ] Table shows Bagisto Order ID column
- [ ] Pagination works (if applicable)

### 13. Sync Logs Page

Navigate to: eBay Connector → Sync Logs

- [ ] Page loads without errors
- [ ] Log table displays
- [ ] Filter dropdowns work (Type, Status)
- [ ] "Clear Old Logs" button is present
- [ ] Logs can be filtered
- [ ] Pagination works (if applicable)

---

## Functional Testing

### Test eBay API Connection

1. Navigate to Configuration page
2. Enter your eBay API credentials:
   - API Key (Client ID)
   - API Secret (Client Secret)
   - Select Sandbox environment
3. Click "Test Connection"

- [ ] Connection test runs
- [ ] Success message appears (if credentials are correct)
- [ ] OR error message explains the issue (if credentials are wrong)

### Test Configuration Save

1. Fill in all required fields
2. Check "Enable eBay Connector"
3. Click "Save Configuration"

- [ ] Success message appears
- [ ] Configuration is saved
- [ ] Reload page shows saved values

### Test Product Sync

1. Navigate to Product Sync page
2. Select a product (or multiple products)
3. Click "Sync Selected"

- [ ] Sync process starts
- [ ] Result message appears
- [ ] Check Sync Logs for entries

OR if no products exist:
- [ ] Appropriate message is shown

### Test CLI Commands

Run: `php artisan ebay:sync-products --help`
- [ ] Command help is displayed
- [ ] Options are shown

Run: `php artisan ebay:sync-orders --help`
- [ ] Command help is displayed
- [ ] Options are shown

---

## Troubleshooting Checklist

If something isn't working:

### Clear All Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

- [ ] All cache clear commands run successfully

### Rebuild Autoloader

```bash
composer dump-autoload
```

- [ ] Autoloader rebuilds successfully

### Re-publish Assets

```bash
php artisan vendor:publish --tag=ebayconnector-config --force
php artisan vendor:publish --tag=ebayconnector-assets --force
```

- [ ] Assets publish successfully

### Check Permissions

For GitHub installation:
```bash
cd packages/kevinbharris/ebayconnector
ls -la
```

- [ ] All files are readable
- [ ] Directory has correct permissions

### Check Logs

```bash
tail -f storage/logs/laravel.log
```

- [ ] No errors related to ebayconnector
- [ ] If errors exist, they provide useful debugging info

---

## Performance Checks

### Memory Usage

- [ ] Package loads without excessive memory usage
- [ ] No memory errors in logs

### Database Performance

Run a simple query test:
```sql
SELECT COUNT(*) FROM ebay_configurations;
```

- [ ] Query executes successfully
- [ ] Tables are accessible

### Page Load Time

- [ ] Configuration page loads in < 3 seconds
- [ ] Product Sync page loads in < 5 seconds
- [ ] No timeout errors

---

## Security Checks

### Environment Variables

- [ ] `.env` file contains eBay credentials (if using env vars)
- [ ] `.env` is in `.gitignore` (never commit credentials)
- [ ] Credentials are not hardcoded in any files

### Access Control

- [ ] Only admin users can access eBay Connector pages
- [ ] ACL permissions are working
- [ ] Non-admin users cannot access connector routes

### CSRF Protection

- [ ] All forms have CSRF tokens
- [ ] CSRF validation is working
- [ ] No CSRF errors in console

---

## Final Verification

After completing all checks:

- [ ] All admin pages are accessible
- [ ] All features work as expected
- [ ] No errors in Laravel logs
- [ ] No JavaScript console errors
- [ ] Documentation is accessible and helpful

---

## Post-Installation Tasks

Once installation is verified:

1. [ ] Configure eBay API credentials in production
2. [ ] Test product sync with a test product
3. [ ] Test order import with a test order
4. [ ] Set up automatic sync schedule (optional)
5. [ ] Configure log retention settings
6. [ ] Train team on using the connector
7. [ ] Bookmark documentation for reference

---

## Getting Help

If any checklist item fails:

1. **Check Documentation**:
   - `README.md` - Feature overview
   - `INSTALLATION.md` - Installation guide
   - `GITHUB_INSTALL.md` - GitHub installation guide
   - `SUMMARY.md` - Implementation details

2. **Check Logs**:
   - `storage/logs/laravel.log` - Application logs
   - Database `ebay_sync_logs` table - Sync activity logs

3. **Clear Caches**: Run all cache clear commands

4. **Check Requirements**: Verify PHP version, Laravel version, Bagisto version

5. **Contact Support**:
   - GitHub Issues: https://github.com/kevinbharris/ebayconnector/issues
   - Email: kevin.b.harris.2015@gmail.com

---

## Success Criteria

Installation is successful when:

✅ All checklist items are completed  
✅ Admin menu appears correctly  
✅ All pages load without errors  
✅ Configuration can be saved  
✅ Test connection works (with valid credentials)  
✅ No errors in logs  

**Congratulations! Your eBay Connector is ready to use!** 🎉
