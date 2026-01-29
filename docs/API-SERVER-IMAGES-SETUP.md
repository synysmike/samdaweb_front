# API Server: Serving Product Images

The app loads product images from the **API** at `API_BASE_URL` (set in `.env`).  
Image URLs are built as: **`{API_BASE_URL}/storage/products/...`**

On the **API server** (where the API runs), do the following so those URLs work.

---

## 1. Where images are stored

The API stores product images under a directory like:

- `storage/app/public/products/` (Laravel-style), or
- Another path your API uses (e.g. `uploads/products/`).

Use that path in the steps below.

---

## 2. Expose storage via `/storage`

You must serve those files over HTTP at **`/storage/...`** (e.g.  
`https://your-api-host/storage/products/xyz.jpg`).

### Option A: Laravel API

1. Create the symlink:

    ```bash
    cd /path/to/api
    php artisan storage:link
    ```

    This creates `public/storage` → `storage/app/public`.

2. Ensure the app is served with **document root = `public`** (nginx/apache point to `public/`).

3. Ensure `storage/app/public/products` exists and is writable:

    ```bash
    mkdir -p storage/app/public/products
    chown -R www-data:www-data storage/app/public
    chmod -R 775 storage/app/public
    ```

4. Then `{your-api-base-url}/storage/products/filename.jpg` will serve the file.

### Option B: Nginx in front of the API

If nginx proxies the API and you serve static files yourself, add a `location` for `/storage`:

```nginx
server {
    listen 80;   # or 443 for HTTPS
    server_name your-api-host;

    # API (proxy to app)
    location / {
        proxy_pass http://127.0.0.1:8080;  # or your API upstream
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        # ...
    }

    # Serve product images from disk
    location /storage/ {
        alias /path/to/api/storage/app/public/;
        # Or, if you use another directory:
        # alias /path/to/api/uploads/;
        add_header Cache-Control "public, max-age=86400";
    }
}
```

Adjust `alias` to the **directory that contains** `products/` (so `.../products/xyz.jpg` matches  
`/storage/products/xyz.jpg`).

Reload nginx:

```bash
nginx -t && systemctl reload nginx
```

### Option C: API framework serves files

Alternatively, add a route (e.g. `GET /storage/products/:filename`) that:

1. Reads the file from `storage/app/public/products/` (or your uploads path).
2. Returns it with the correct `Content-Type` (e.g. `image/jpeg`).
3. Uses safe path handling (no directory traversal).

---

## 3. Permissions

- Storage directory (and `products/`) must be **readable** by the user running the web server / API.
- Same user must be able to **write** when the API stores new images.

Example (Linux, web user `www-data`):

```bash
chown -R www-data:www-data /path/to/api/storage/app/public
chmod -R 755 /path/to/api/storage/app/public
chmod -R 775 /path/to/api/storage/app/public/products
```

---

## 4. CORS (if frontend is on another domain)

If the Laravel app (or frontend) runs on a different origin than the API, allow cross-origin requests for image URLs.

- **Nginx**: add `Access-Control-Allow-Origin` for `/storage/` (or your image path).
- **Laravel**: use CORS middleware for the routes that serve images, or configure your CORS package to allow the frontend origin.

---

## 5. `file_path` in API responses

The API should return `file_path` in responses (e.g. product-image get) in one of these forms:

- `products/filename.jpg`
- `app/public/products/filename.jpg`
- `storage/app/public/products/filename.jpg`

The Laravel app normalizes these and builds:

`{API_BASE_URL}/storage/products/filename.jpg`

So the API must serve files at **`/storage/products/...`** as above.

---

## 6. Quick check

1. Upload a product image via the API (or place a test file in `storage/app/public/products/`).
2. Open `{API_BASE_URL}/storage/products/your-test-file.jpg` in a browser.

    You should see the image. If you get 404, check path, alias, and symlink.

---

## 7. HTTPS (recommended for production)

Use HTTPS in production. Set `API_BASE_URL` in `.env` to `https://...` so image URLs use `https` and match your API domain.
