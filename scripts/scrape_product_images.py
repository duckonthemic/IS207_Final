#!/usr/bin/env python3
"""
Product Image Scraper Tool
===========================
Standalone tool để tải hình ảnh sản phẩm từ website nhà sản xuất.
KHÔNG phải là một phần của web app, chỉ là công cụ hỗ trợ.

Usage:
    python scrape_product_images.py

Requirements:
    pip install requests beautifulsoup4 Pillow
"""

import json
import os
import re
import sys
import time
import hashlib
import urllib.parse
from pathlib import Path
from typing import List, Dict, Optional

# Fix Windows console encoding
if sys.platform == 'win32':
    sys.stdout.reconfigure(encoding='utf-8')

try:
    import requests
    from bs4 import BeautifulSoup
    from PIL import Image
    from io import BytesIO
except ImportError:
    print("Missing dependencies. Install with:")
    print("pip install requests beautifulsoup4 Pillow")
    exit(1)

# Configuration
SCRIPT_DIR = Path(__file__).parent
PROJECT_ROOT = SCRIPT_DIR.parent
PRODUCT_JSON_PATH = PROJECT_ROOT / "product.json"
OUTPUT_DIR = PROJECT_ROOT / "public" / "images" / "products"
OUTPUT_JSON_PATH = SCRIPT_DIR / "product_images.json"

MIN_IMAGES = 2
MAX_IMAGES = 6
MIN_IMAGE_SIZE = (200, 200)  # Minimum width, height

# User agent to avoid blocking
HEADERS = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    "Accept-Language": "en-US,en;q=0.5",
}

# Manufacturer search URL patterns
MANUFACTURER_SEARCH = {
    "Intel": "https://ark.intel.com/content/www/us/en/ark/search.html?_charset_=UTF-8&q={query}",
    "AMD": "https://www.amd.com/en/search.html#q={query}",
    "NVIDIA": "https://www.nvidia.com/en-us/search/?page=1&q={query}",
    "ASUS": "https://www.asus.com/us/searchresult?searchType=products&searchKey={query}",
    "MSI": "https://www.msi.com/search/{query}",
    "Gigabyte": "https://www.gigabyte.com/Search?kw={query}",
    "Corsair": "https://www.corsair.com/us/en/s/{query}",
    "G.Skill": "https://www.gskill.com/search?keyword={query}",
    "Kingston": "https://www.kingston.com/unitedstates/us/search?q={query}",
    "Samsung": "https://www.samsung.com/us/search/searchMain?listType=g&searchTerm={query}",
    "Western Digital": "https://www.westerndigital.com/search?q={query}",
    "Crucial": "https://www.crucial.com/search?q={query}",
    "NZXT": "https://nzxt.com/search?q={query}",
    "Lian Li": "https://lian-li.com/?s={query}",
    "Cooler Master": "https://www.coolermaster.com/catalog/?q={query}",
    "Seasonic": "https://seasonic.com/?s={query}",
    "Noctua": "https://noctua.at/en/search/result?q={query}",
    "LG": "https://www.lg.com/us/search/search.lg?search={query}",
    "Dell": "https://www.dell.com/en-us/search/{query}",
}


def load_products() -> Dict:
    """Load products from product.json"""
    with open(PRODUCT_JSON_PATH, 'r', encoding='utf-8') as f:
        return json.load(f)


def sanitize_filename(name: str) -> str:
    """Create safe filename from product name"""
    name = re.sub(r'[^\w\s-]', '', name.lower())
    name = re.sub(r'[-\s]+', '-', name).strip('-')
    return name[:50]


def get_image_hash(url: str) -> str:
    """Generate hash for image URL to avoid duplicates"""
    return hashlib.md5(url.encode()).hexdigest()[:8]


def is_valid_image(content: bytes, min_size: tuple = MIN_IMAGE_SIZE) -> bool:
    """Check if image content is valid and meets size requirements"""
    try:
        img = Image.open(BytesIO(content))
        width, height = img.size
        return width >= min_size[0] and height >= min_size[1]
    except Exception:
        return False


def download_image(url: str, save_path: Path) -> bool:
    """Download image from URL and save to path"""
    try:
        response = requests.get(url, headers=HEADERS, timeout=15, stream=True)
        response.raise_for_status()
        
        content = response.content
        if not is_valid_image(content):
            return False
        
        # Convert to JPG for consistency
        img = Image.open(BytesIO(content))
        if img.mode in ('RGBA', 'P'):
            img = img.convert('RGB')
        
        img.save(save_path, 'JPEG', quality=90)
        return True
    except Exception as e:
        print(f"  Error downloading {url}: {e}")
        return False


def search_google_images(query: str, num_images: int = MAX_IMAGES) -> List[str]:
    """
    Search for product images using DuckDuckGo (free, no API key needed)
    Returns list of image URLs
    """
    urls = []
    try:
        # Use DuckDuckGo image search
        search_url = f"https://duckduckgo.com/?q={urllib.parse.quote(query + ' product')}&iax=images&ia=images"
        
        response = requests.get(search_url, headers=HEADERS, timeout=10)
        
        # DuckDuckGo returns a token we need to use for the actual image search
        vqd_match = re.search(r'vqd=([^&]+)', response.text)
        if not vqd_match:
            return urls
        
        vqd = vqd_match.group(1)
        
        # Get images from DuckDuckGo image API
        image_api_url = f"https://duckduckgo.com/i.js?l=us-en&o=json&q={urllib.parse.quote(query)}&vqd={vqd}&f=,,,,,&p=1"
        
        img_response = requests.get(image_api_url, headers=HEADERS, timeout=10)
        if img_response.status_code == 200:
            data = img_response.json()
            results = data.get('results', [])
            
            for result in results[:num_images * 2]:  # Get more than needed for filtering
                img_url = result.get('image')
                if img_url and not any(x in img_url.lower() for x in ['placeholder', 'icon', 'logo', 'avatar']):
                    urls.append(img_url)
                    if len(urls) >= num_images:
                        break
    except Exception as e:
        print(f"  DuckDuckGo search failed: {e}")
    
    return urls


def search_bing_images(query: str, num_images: int = MAX_IMAGES) -> List[str]:
    """
    Fallback: Search Bing images (no API key needed for basic scraping)
    """
    urls = []
    try:
        search_url = f"https://www.bing.com/images/search?q={urllib.parse.quote(query + ' official')}&first=1"
        
        response = requests.get(search_url, headers=HEADERS, timeout=10)
        soup = BeautifulSoup(response.text, 'html.parser')
        
        # Find image elements
        for img in soup.find_all('a', class_='iusc'):
            try:
                m = re.search(r'"murl":"([^"]+)"', str(img))
                if m:
                    img_url = m.group(1)
                    if not any(x in img_url.lower() for x in ['placeholder', 'icon', 'logo']):
                        urls.append(img_url)
                        if len(urls) >= num_images:
                            break
            except:
                continue
    except Exception as e:
        print(f"  Bing search failed: {e}")
    
    return urls


def scrape_manufacturer_page(brand: str, model: str) -> List[str]:
    """
    Try to scrape images from manufacturer website
    """
    urls = []
    
    if brand not in MANUFACTURER_SEARCH:
        return urls
    
    try:
        search_url = MANUFACTURER_SEARCH[brand].format(query=urllib.parse.quote(model))
        response = requests.get(search_url, headers=HEADERS, timeout=10)
        soup = BeautifulSoup(response.text, 'html.parser')
        
        # Find product images (common patterns)
        for img in soup.find_all('img'):
            src = img.get('src') or img.get('data-src') or img.get('data-lazy-src')
            if src:
                # Filter out small icons, logos, etc.
                if any(x in src.lower() for x in ['product', 'gallery', 'main', 'hero']):
                    if src.startswith('//'):
                        src = 'https:' + src
                    elif src.startswith('/'):
                        # Get base URL
                        parsed = urllib.parse.urlparse(search_url)
                        src = f"{parsed.scheme}://{parsed.netloc}{src}"
                    
                    if src not in urls:
                        urls.append(src)
                        if len(urls) >= MAX_IMAGES:
                            break
    except Exception as e:
        print(f"  Manufacturer scrape failed for {brand}: {e}")
    
    return urls


def get_product_images(product: Dict) -> List[str]:
    """
    Get images for a product using multiple methods
    """
    brand = product.get('brand', '')
    model = product.get('model', '')
    name = product.get('name', '')
    
    print(f"\n📦 Processing: {name}")
    
    all_urls = []
    
    # Method 1: Try manufacturer website first
    print(f"  🔍 Searching {brand} website...")
    manufacturer_urls = scrape_manufacturer_page(brand, model)
    all_urls.extend(manufacturer_urls)
    
    # Method 2: DuckDuckGo image search
    if len(all_urls) < MIN_IMAGES:
        print(f"  🔍 Searching DuckDuckGo...")
        search_query = f"{brand} {model} official product image"
        ddg_urls = search_google_images(search_query, MAX_IMAGES - len(all_urls))
        all_urls.extend([u for u in ddg_urls if u not in all_urls])
    
    # Method 3: Bing image search as fallback
    if len(all_urls) < MIN_IMAGES:
        print(f"  🔍 Searching Bing...")
        bing_urls = search_bing_images(f"{brand} {model}", MAX_IMAGES - len(all_urls))
        all_urls.extend([u for u in bing_urls if u not in all_urls])
    
    # Limit to MAX_IMAGES
    return all_urls[:MAX_IMAGES]


def main():
    """Main function to scrape all product images"""
    print("=" * 60)
    print("🖼️  Product Image Scraper")
    print("=" * 60)
    
    # Create output directory
    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)
    
    # Load products
    products = load_products()
    
    # Results
    results = {}
    stats = {"total": 0, "success": 0, "failed": 0}
    
    # Process each category
    for category, items in products.items():
        print(f"\n{'='*40}")
        print(f"📁 Category: {category}")
        print(f"{'='*40}")
        
        results[category] = []
        
        for product in items:
            stats["total"] += 1
            product_id = product.get('id', '')
            name = product.get('name', '')
            
            # Get image URLs
            image_urls = get_product_images(product)
            
            if len(image_urls) < MIN_IMAGES:
                print(f"  ⚠️  Only found {len(image_urls)} images (min: {MIN_IMAGES})")
                stats["failed"] += 1
            else:
                stats["success"] += 1
            
            # Download images
            downloaded = []
            product_folder = OUTPUT_DIR / sanitize_filename(product_id)
            product_folder.mkdir(exist_ok=True)
            
            for i, url in enumerate(image_urls):
                img_filename = f"{i+1}.jpg"
                img_path = product_folder / img_filename
                
                if download_image(url, img_path):
                    relative_path = f"images/products/{sanitize_filename(product_id)}/{img_filename}"
                    downloaded.append(relative_path)
                    print(f"  ✅ Downloaded: {img_filename}")
                else:
                    print(f"  ❌ Failed: {url[:50]}...")
            
            # Store result
            results[category].append({
                "id": product_id,
                "name": name,
                "source_urls": image_urls,
                "downloaded": downloaded
            })
            
            # Rate limiting
            time.sleep(1)
    
    # Save results
    with open(OUTPUT_JSON_PATH, 'w', encoding='utf-8') as f:
        json.dump(results, f, indent=2, ensure_ascii=False)
    
    # Print summary
    print("\n" + "=" * 60)
    print("📊 Summary")
    print("=" * 60)
    print(f"Total products: {stats['total']}")
    print(f"Successful (>= {MIN_IMAGES} images): {stats['success']}")
    print(f"Need attention: {stats['failed']}")
    print(f"\nResults saved to: {OUTPUT_JSON_PATH}")
    print(f"Images saved to: {OUTPUT_DIR}")


if __name__ == "__main__":
    main()
