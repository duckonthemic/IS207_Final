#!/usr/bin/env python3
"""
Download Official Product Images
=================================
Tải ảnh từ file official_product_images.json (URLs đã được xác nhận)

Usage:
    python download_official_images.py
"""

import json
import os
import sys
import time
from pathlib import Path

# Fix Windows console encoding
if sys.platform == 'win32':
    sys.stdout.reconfigure(encoding='utf-8')

try:
    import requests
    from PIL import Image
    from io import BytesIO
except ImportError:
    print("Missing dependencies. Install with:")
    print("pip install requests Pillow")
    exit(1)

# Configuration
SCRIPT_DIR = Path(__file__).parent
PROJECT_ROOT = SCRIPT_DIR.parent
IMAGE_JSON_PATH = SCRIPT_DIR / "official_product_images.json"
OUTPUT_DIR = PROJECT_ROOT / "public" / "images" / "products"

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
    "Accept": "image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8",
}


def download_image(url: str, save_path: Path) -> bool:
    """Download image from URL and save to path"""
    try:
        response = requests.get(url, headers=HEADERS, timeout=30, stream=True)
        response.raise_for_status()
        
        content = response.content
        
        # Validate and convert image
        img = Image.open(BytesIO(content))
        if img.mode in ('RGBA', 'P'):
            img = img.convert('RGB')
        
        # Resize if too large (max 1200px)
        max_size = 1200
        if img.width > max_size or img.height > max_size:
            img.thumbnail((max_size, max_size), Image.Resampling.LANCZOS)
        
        img.save(save_path, 'JPEG', quality=90)
        return True
    except Exception as e:
        print(f"    ❌ Error: {e}")
        return False


def main():
    print("=" * 60)
    print("📥 Download Official Product Images")
    print("=" * 60)
    
    # Load image URLs
    if not IMAGE_JSON_PATH.exists():
        print(f"❌ File not found: {IMAGE_JSON_PATH}")
        return 1
    
    with open(IMAGE_JSON_PATH, 'r', encoding='utf-8') as f:
        data = json.load(f)
    
    # Create output directory
    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)
    
    stats = {"total": 0, "success": 0, "failed": 0}
    
    # Process each category
    for category, products in data.items():
        print(f"\n📁 {category}")
        print("-" * 40)
        
        for product in products:
            product_id = product.get('id', '')
            name = product.get('name', '')
            images = product.get('images', [])
            
            print(f"\n  📦 {name}")
            
            # Create product folder
            product_folder = OUTPUT_DIR / product_id
            product_folder.mkdir(exist_ok=True)
            
            # Clear existing images
            for old_file in product_folder.glob('*.jpg'):
                old_file.unlink()
            
            # Download images
            for i, url in enumerate(images):
                stats["total"] += 1
                img_filename = f"{i+1}.jpg"
                img_path = product_folder / img_filename
                
                print(f"    ⬇️  Downloading {img_filename}...", end=" ")
                
                if download_image(url, img_path):
                    print("✅")
                    stats["success"] += 1
                else:
                    stats["failed"] += 1
                
                # Rate limiting
                time.sleep(0.5)
    
    # Print summary
    print("\n" + "=" * 60)
    print("📊 Summary")
    print("=" * 60)
    print(f"Total images: {stats['total']}")
    print(f"Downloaded: {stats['success']}")
    print(f"Failed: {stats['failed']}")
    print(f"\nImages saved to: {OUTPUT_DIR}")
    
    return 0


if __name__ == "__main__":
    exit(main())
