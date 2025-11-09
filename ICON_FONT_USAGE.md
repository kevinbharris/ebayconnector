# eBay Icon Font - Usage Guide

## Overview
This package includes a custom icon font featuring a black and white eBay logo that appears in the Bagisto admin sidebar. The font is automatically configured through the menu system.

## Publishing Assets

After installing the package, publish the assets:

```bash
php artisan vendor:publish --tag=ebayconnector-assets
```

This will copy the following files to your public directory:

```
public/vendor/ebayconnector/
├── css/
│   └── app.css
└── fonts/ebay/
    ├── ebay-icons.eot
    ├── ebay-icons.woff2
    ├── ebay-icons.woff
    ├── ebay-icons.ttf
    └── ebay-icons.svg
```

## Automatic Integration

The icon is automatically integrated into the Bagisto admin sidebar through the menu configuration. No additional setup is required.

The menu configuration in `publishable/config/menu.php` uses:

```php
[
    'key'        => 'ebayconnector',
    'name'       => 'eBay Connector',
    'route'      => 'admin.configuration.index',
    'sort'       => 7,
    'icon'       => 'icon-ebay',  // Custom eBay icon
],
```

## Manual Usage

If you need to use the icon elsewhere in your views, you can include it manually:

### 1. Include the CSS

In your Blade template, add the stylesheet:

```blade
<link rel="stylesheet" href="{{ asset('vendor/ebayconnector/css/app.css') }}">
```

### 2. Use the Icon

Add the icon using the CSS class:

```html
<i class="icon-ebay"></i>
```

Or next to text:

```html
<span>
    <i class="icon-ebay"></i>
    eBay Connector
</span>
```

## Icon Customization

The icon can be customized using CSS. The default styling is:

```css
.icon-ebay:before {
    font-family: "ebay-icons";
    content: "\e017";
    font-size: 22px;
    vertical-align: middle;
    display: inline-block;
    color: #000; /* Black */
}
```

### Example Customizations

Change the color:
```css
.icon-ebay.custom-color:before {
    color: #0064d2; /* eBay blue */
}
```

Change the size:
```css
.icon-ebay.large:before {
    font-size: 32px;
}
```

Add spacing:
```css
.icon-ebay.spaced:before {
    margin-right: 8px;
}
```

## Browser Support

The icon font supports all modern browsers through multiple font formats:
- **WOFF2** - Modern browsers (Chrome, Firefox, Edge, Safari)
- **WOFF** - Legacy browsers
- **TTF** - Fallback for older browsers
- **EOT** - Internet Explorer 9+
- **SVG** - Very old browsers (Safari 5.1, iOS 4.3)

## Creating Custom Icons

If you need to create or update the icon font:

1. Visit [IcoMoon App](https://icomoon.io/app/)
2. Import your SVG icon or select from icon sets
3. Generate the font with the name "ebay-icons"
4. Download the font package
5. Replace the files in `publishable/assets/fonts/ebay/`
6. Update the unicode character in `app.css` if needed
7. Republish assets: `php artisan vendor:publish --tag=ebayconnector-assets --force`

## Troubleshooting

### Icon not showing

1. **Check assets are published:**
   ```bash
   php artisan vendor:publish --tag=ebayconnector-assets
   ```

2. **Clear cache:**
   ```bash
   php artisan cache:clear
   php artisan view:clear
   ```

3. **Verify files exist:**
   Check that files exist in `public/vendor/ebayconnector/`

4. **Check browser console:**
   Look for 404 errors or font loading issues

### Icon appears as square or question mark

This usually means the font file isn't loading. Check:
- File paths in CSS are correct
- Font files are accessible (check file permissions)
- No CORS issues (if serving from CDN)

### Icon color not working

Make sure you're applying the color to the pseudo-element:
```css
.icon-ebay:before {
    color: red; /* This works */
}

.icon-ebay {
    color: red; /* This doesn't work */
}
```

## Technical Details

- **Font Family:** ebay-icons
- **Unicode Character:** \e017
- **Default Size:** 22px
- **Default Color:** #000 (black)
- **Glyph Name:** ebay

## Integration with Bagisto

The icon font is designed to work seamlessly with Bagisto v2.3.8:
- Follows Bagisto icon conventions
- Uses standard CSS class naming (icon-*)
- Compatible with Bagisto's admin theme
- Responsive and accessible
- No JavaScript required

## License

The icon font is part of the eBay Connector package and is licensed under the MIT License.
