#!/usr/bin/env python3
"""
Script to download product images and organize them by category
"""

import os
import requests
import json
from urllib.parse import quote
from pathlib import Path

# Base directory for images
BASE_IMAGE_DIR = r'C:\Users\hoang\Downloads\pc-parts-e-store-boilerplate\public\images\products'

# Product mapping with categories
PRODUCTS = {
    'CPU': [
        'Intel Core i9-14900K',
        'Intel Core i9-14900KF',
        'Intel Core i9-14900',
        'Intel Core i9-14900F',
        'Intel Core i7-14700K',
        'Intel Core i7-14700KF',
        'Intel Core i7-14700',
        'Intel Core i5-14600K',
        'Intel Core i5-14600KF',
        'Intel Core i5-13600K',
        'AMD Ryzen 9 7950X',
        'AMD Ryzen 9 7950X3D',
        'AMD Ryzen 9 7900X',
        'AMD Ryzen 9 7900X3D',
        'AMD Ryzen 7 7800X3D',
        'AMD Ryzen 7 7700X',
        'AMD Ryzen 7 7700',
        'AMD Ryzen 5 7600X',
        'AMD Ryzen 5 7600',
        'AMD Ryzen 5 5600X',
    ],
    'GPU': [
        'ASUS ROG Strix RTX 4090 OC 24GB',
        'Gigabyte RTX 4090 Master 24GB',
        'MSI RTX 4090 Gaming Trio 24GB',
        'EVGA RTX 4090 FTW3 Ultra 24GB',
        'Gigabyte RTX 4080 Super Gaming OC 16GB',
        'ASUS TUF RTX 4080 Super OC 16GB',
        'MSI RTX 4080 Super Gaming Trio 16GB',
        'MSI RTX 4070 Ti Super Gaming Trio 12GB',
        'ASUS ROG Strix RTX 4070 Ti Super OC 12GB',
        'EVGA RTX 4070 Ti Super FTW3 Ultra 12GB',
        'Gigabyte RTX 4070 Gaming OC 12GB',
        'ASUS TUF RTX 4070 OC 12GB',
        'MSI RTX 4070 Ventus 2X OC 12GB',
        'EVGA RTX 4060 Ti 8GB FTW3',
        'ASUS Phoenix RTX 4060 Ti 8GB',
        'AMD Radeon RX 7900 XT 20GB',
        'AMD Radeon RX 7900 GRE 20GB',
        'AMD Radeon RX 7800 XT 16GB',
        'AMD Radeon RX 7700 XT 12GB',
        'AMD Radeon RX 7600 16GB',
    ],
    'Mainboard': [
        'ASUS ROG Strix Z790-E Gaming WiFi',
        'MSI MPG Z790 Edge WiFi',
        'Gigabyte Z790 Master',
        'ASRock Z790 Steel Legend',
        'ASUS TUF Z790-Plus WiFi',
        'MSI MPG Z790 Gaming Edge WiFi',
        'ASUS ROG Strix X870-E-E Gaming WiFi',
        'MSI MPG X870E Edge WiFi',
        'Gigabyte X870E-E Master',
        'ASRock X870E Steel Legend',
    ],
    'RAM': [
        'Corsair Vengeance RGB Pro 64GB (32x2) DDR5 6000MHz',
        'G.SKILL Trident Z5 RGB 64GB (32x2) DDR5 6000MHz',
        'Kingston Fury Beast DDR5 64GB (32x2) 6000MHz',
        'ADATA XPG Lian Xu DDR5 64GB (32x2) 6000MHz',
        'Corsair Vengeance RGB Pro 32GB (16x2) DDR5 5600MHz',
        'G.SKILL Trident Z5 RGB 32GB (16x2) DDR5 5600MHz',
        'Crucial Pro 48GB (24x2) DDR5 5600MHz',
        'Kingston Fury Beast 32GB (16x2) DDR5 5600MHz',
    ],
    'SSD': [
        'Samsung 990 Pro 4TB PCIe 4.0 NVMe',
        'WD Black SN850X 4TB',
        'Crucial P5 Plus 4TB',
        'Kingston KC3000 4TB',
        'Samsung 990 Pro 2TB PCIe 4.0 NVMe',
        'WD Black SN850X 2TB',
        'ADATA XPG S70 Blade 4TB',
        'Corsair MP600 Core XT 4TB',
    ],
    'HDD': [
        'WD Red Pro 12TB 256MB 7200RPM',
        'Seagate Barracuda Pro 12TB',
        'WD Red Pro 10TB 256MB',
        'Seagate IronWolf 8TB 7200RPM',
    ],
    'PSU': [
        'Corsair RM1000x 1000W 80+ Gold',
        'EVGA SuperNOVA 850 GA 850W 80+ Gold',
        'Seasonic Focus GX 1050W 80+ Gold',
        'Corsair HXi 1200W 80+ Platinum',
        'EVGA SuperNOVA 1000 P2 1000W 80+ Platinum',
        'Gigabyte UD1000GM 1000W 80+ Gold',
    ],
    'Case': [
        'NZXT H7 Flow RGB',
        'Corsair 5000T RGB',
        'Lian Li LANCOOL 303',
        'Phanteks Eclipse P500A D-RGB',
        'Fractal Design Meshify 2',
        'be quiet! Pure Base 500DX',
    ],
    'Cooling': [
        'Noctua NH-D15 Chromax Black',
        'NZXT Kraken X73 360mm AIO',
        'Corsair H150i Elite Capellix 360mm',
        'be quiet! Dark Rock Pro TR4',
        'Scythe Ninja 5',
        'Thermalright Peerless Assassin 120 SE',
    ],
    'Monitor': [
        'Dell S3423DWF 34" Ultrawide 3440x1440 100Hz',
        'LG 27GP850-B 27" 1440p 180Hz',
        'ASUS ProArt PA278QV 27" 2560x1440 100Hz',
        'MSI Oculux NXG253R 25" 1080p 360Hz',
        'BenQ PD2705U 27" 4K 60Hz',
        'Gigabyte M28U 28" 4K 144Hz',
    ],
}

# Color mapping by category and brand
COLORS = {
    'CPU': {'Intel': 'FF6B6B', 'AMD': 'FF6B6B'},
    'GPU': {'ASUS': 'FF6B6B', 'Gigabyte': 'FF6B6B', 'MSI': 'FF6B6B', 'EVGA': 'FF6B6B', 'AMD': 'FF6B6B'},
    'Mainboard': {'ASUS': 'FF6B6B', 'MSI': 'FF6B6B', 'Gigabyte': 'FF6B6B', 'ASRock': 'FF6B6B'},
    'RAM': {'Corsair': 'FF6B6B', 'G.SKILL': 'FF6B6B', 'Kingston': 'FF6B6B', 'ADATA': 'FF6B6B', 'Crucial': 'FF6B6B'},
    'SSD': {'Samsung': 'FF6B6B', 'WD': 'FF6B6B', 'Crucial': 'FF6B6B', 'Kingston': 'FF6B6B', 'ADATA': 'FF6B6B', 'Corsair': 'FF6B6B'},
    'HDD': {'WD': 'FF6B6B', 'Seagate': 'FF6B6B'},
    'PSU': {'Corsair': 'FF6B6B', 'EVGA': 'FF6B6B', 'Seasonic': 'FF6B6B', 'Gigabyte': 'FF6B6B'},
    'Case': {'NZXT': 'FF6B6B', 'Corsair': 'FF6B6B', 'Lian Li': 'FF6B6B', 'Phanteks': 'FF6B6B', 'Fractal Design': 'FF6B6B', 'be quiet!': 'FF6B6B'},
    'Cooling': {'Noctua': 'FF6B6B', 'NZXT': 'FF6B6B', 'Corsair': 'FF6B6B', 'be quiet!': 'FF6B6B', 'Scythe': 'FF6B6B', 'Thermalright': 'FF6B6B'},
    'Monitor': {'Dell': 'FF6B6B', 'LG': 'FF6B6B', 'ASUS': 'FF6B6B', 'MSI': 'FF6B6B', 'BenQ': 'FF6B6B', 'Gigabyte': 'FF6B6B'},
}

def get_placeholder_url(product_name, category):
    """Generate placeholder image URL"""
    # Use a simple placeholder service
    return f"https://via.placeholder.com/500x500/FF6B6B/FFFFFF?text={quote(product_name)}"

def sanitize_filename(filename):
    """Sanitize filename for file system"""
    invalid_chars = '<>:"|?*'
    for char in invalid_chars:
        filename = filename.replace(char, '_')
    return filename

def download_images():
    """Download all product images"""
    # Create base directory
    Path(BASE_IMAGE_DIR).mkdir(parents=True, exist_ok=True)
    
    # Create product list JSON
    product_list = []
    
    for category, products in PRODUCTS.items():
        # Create category subdirectory
        category_dir = os.path.join(BASE_IMAGE_DIR, category.lower())
        Path(category_dir).mkdir(parents=True, exist_ok=True)
        
        print(f"\n📁 Processing {category}...")
        
        for idx, product_name in enumerate(products, 1):
            # Generate filename
            filename = f"{sanitize_filename(product_name)}.jpg"
            filepath = os.path.join(category_dir, filename)
            
            # Generate image URL
            image_url = get_placeholder_url(product_name, category)
            
            try:
                # Download image
                print(f"  [{idx}/{len(products)}] Downloading: {product_name}")
                response = requests.get(image_url, timeout=10)
                
                if response.status_code == 200:
                    # Save image
                    with open(filepath, 'wb') as f:
                        f.write(response.content)
                    
                    # Add to product list
                    product_list.append({
                        'name': product_name,
                        'category': category,
                        'image': f'images/products/{category.lower()}/{filename}'
                    })
                    
                    print(f"  ✅ Saved: {filepath}")
                else:
                    print(f"  ❌ Failed to download (Status: {response.status_code})")
                    
            except Exception as e:
                print(f"  ❌ Error: {str(e)}")
    
    # Save product list JSON
    json_path = os.path.join(BASE_IMAGE_DIR, 'products.json')
    with open(json_path, 'w', encoding='utf-8') as f:
        json.dump(product_list, f, indent=2, ensure_ascii=False)
    
    print(f"\n✅ Downloaded {len(product_list)} product images")
    print(f"📄 Saved product list to: {json_path}")

if __name__ == '__main__':
    download_images()
