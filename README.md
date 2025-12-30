# MyPage Landing Platform

MyPage Landing Platform is a lightweight WordPress plugin that allows you to create and serve fully custom HTML landing pages directly from WordPress, with support for both URL-based access and custom domains.

The plugin is designed for developers and marketing teams who need full control over markup, scripts, and page rendering — without using themes, page builders, or multisite setups.

---

## Features

- Custom **Landing Page** post type
- Full control over HTML and JavaScript output
- Separate editable sections for:
  - HTML `<head>`
  - HTML `<body>`
  - JavaScript in `<head>`
  - JavaScript before closing `</body>`
- Built-in WordPress code editor with syntax highlighting
- URL slug–based landing page previews
- Custom domain → landing page mapping
- Theme-independent rendering (standalone HTML output)
- Minimal overhead and fast page load

---

## How It Works

1. A custom post type (`landing_page`) is registered in WordPress.
2. Each landing page stores raw HTML and JavaScript in custom meta fields.
3. On frontend requests, the plugin:
   - Checks if the request domain matches a configured custom domain, or
   - Matches the request URL slug to a landing page
4. When a match is found:
   - WordPress themes are bypassed
   - A minimal HTML template is rendered
   - User-provided HTML and scripts are injected directly

---

## Installation

1. Download or clone this repository.
2. Upload the plugin folder to:
   ```
   /wp-content/plugins/mypage-landing-platform
   ```
3. Activate the plugin in **WordPress Admin → Plugins**.
4. A new **Landing Pages** menu will appear in the admin panel.

---

## Creating a Landing Page

1. Go to **Landing Pages → Add New**.
2. Enter a title (used internally).
3. Fill in the following fields:
   - **Head HTML** – meta tags, styles, external scripts
   - **Body HTML** – main page markup
   - **Head JS** – JavaScript loaded inside `<head>`
   - **Footer JS** – JavaScript loaded before `</body>`
4. Publish the landing page.

---

## Accessing Landing Pages

### Slug-Based URL

Each landing page is accessible by its slug:

```
https://example.com/your-landing-slug
```

### Custom Domain

You can assign a custom domain to a landing page:

1. Point the domain’s DNS to your WordPress server.
2. Enter the domain name in the landing page settings.
3. Requests to that domain will automatically render the assigned landing page.

> Only one landing page can be mapped to a domain at a time.

---

## Use Cases

- Marketing and advertising landing pages
- Client-specific microsites
- A/B testing static HTML pages
- Hosting externally designed HTML pages in WordPress
- Domain-based landing pages without WordPress multisite

---

## Technical Details

- Written using standard WordPress APIs
- No dependency on block editor or REST API
- Uses WordPress `wp-code-editor` for code editing
- Frontend rendering bypasses active theme
- No frontend assets are loaded unless explicitly added in page content

---

## Limitations

- No visual page builder (HTML-only by design)
- No built-in analytics or tracking
- Custom domain support depends on correct DNS configuration
- Not optimized for multi-author editorial workflows

---

## Development Status

⚠️ **Early-stage / Internal-use friendly**

This plugin is stable for controlled environments but may evolve.  
Backward compatibility is not guaranteed between early versions.

---

## Roadmap

- Export / import landing pages
- Versioning and revisions
- Domain conflict detection
- Optional access protection (password / IP)
- Performance & caching improvements

---

## Contributing

Contributions are welcome.

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Open a pull request with a clear description

---

## Author

Developed by **Vasyl**
