# eBay Custom Icon Font

This directory contains the custom icon font for the eBay Connector package.

## Files

### Font Files
- `ebay-icons.eot` - Embedded OpenType font (for IE9+ compatibility)
- `ebay-icons.woff2` - Web Open Font Format 2.0 (modern browsers)
- `ebay-icons.woff` - Web Open Font Format (legacy browsers)
- `ebay-icons.ttf` - TrueType Font (fallback)
- `ebay-icons.svg` - SVG font (legacy browsers)

### CSS File
- `../css/app.css` - Font-face definition and icon class

## Usage

After publishing the assets with:
```bash
php artisan vendor:publish --tag=ebayconnector-assets
```

The icon font will be available at:
```
public/vendor/ebayconnector/fonts/ebay/
public/vendor/ebayconnector/css/app.css
```

## Icon Class

The `icon-ebay` class is used in the admin sidebar menu. It displays a black and white eBay logo.

```html
<i class="icon-ebay"></i>
```

## Customization

To create custom icon fonts:
1. Use IcoMoon or similar tool to generate font files
2. Replace the files in this directory
3. Update the unicode character in `app.css` if needed
4. Republish assets

## Integration

The icon is automatically used in the Bagisto admin sidebar through the menu configuration in `publishable/config/menu.php`:

```php
'icon' => 'icon-ebay',
```
