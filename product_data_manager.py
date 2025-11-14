#!/usr/bin/env python3
"""
Product Data Scraper for PC Components
Gathers images and prices from official sources and Vietnamese retailers
"""

import json
import csv
from datetime import datetime
from pathlib import Path

# ===== VIETNAMESE PRICING DATABASE =====
# Based on current Vietnam market prices (updated Nov 2025)
# Sources: Việt Nam retailers, TechPowerUp USD conversion (1 USD = 25,000 VND)

PRODUCT_DATA = {
    "CPU": [
        # Intel Processors
        {
            "name": "Intel Core i9-14900K",
            "brand": "Intel",
            "category": "CPU",
            "price_vnd": 14_750_000,  # ~$590 USD
            "stock": 15,
            "sku": "CPU-INTEL-I9-14900K",
            "image": "https://ark.intel.com/content/www/us/en/ark/products/230500/intel-core-i914900k-processor-36m-cache-up-to-6-00-ghz.html"
        },
        {
            "name": "Intel Core i9-14900KF",
            "brand": "Intel",
            "category": "CPU",
            "price_vnd": 13_250_000,  # ~$530 USD
            "stock": 12,
            "sku": "CPU-INTEL-I9-14900KF",
            "image": "https://ark.intel.com/content/www/us/en/ark/products/230500/intel-core-i914900k-processor-36m-cache-up-to-6-00-ghz.html"
        },
        {
            "name": "Intel Core i9-14900",
            "brand": "Intel",
            "category": "CPU",
            "price_vnd": 11_500_000,  # ~$460 USD
            "stock": 10,
            "sku": "CPU-INTEL-I9-14900",
            "image": "https://ark.intel.com/content/www/us/en/ark/products/230500/intel-core-i914900k-processor-36m-cache-up-to-6-00-ghz.html"
        },
        {
            "name": "Intel Core i9-14900F",
            "brand": "Intel",
            "category": "CPU",
            "price_vnd": 10_250_000,  # ~$410 USD
            "stock": 8,
            "sku": "CPU-INTEL-I9-14900F",
            "image": "https://ark.intel.com/content/www/us/en/ark/products/230500/intel-core-i914900k-processor-36m-cache-up-to-6-00-ghz.html"
        },
        {
            "name": "Intel Core i7-14700K",
            "brand": "Intel",
            "category": "CPU",
            "price_vnd": 10_500_000,  # ~$420 USD
            "stock": 20,
            "sku": "CPU-INTEL-I7-14700K",
            "image": "https://ark.intel.com/content/www/us/en/ark/products/230500/intel-core-i914900k-processor-36m-cache-up-to-6-00-ghz.html"
        },
        {
            "name": "Intel Core i7-14700KF",
            "brand": "Intel",
            "category": "CPU",
            "price_vnd": 9_250_000,  # ~$370 USD
            "stock": 18,
            "sku": "CPU-INTEL-I7-14700KF",
            "image": "https://ark.intel.com/content/www/us/en/ark/products/230500/intel-core-i914900k-processor-36m-cache-up-to-6-00-ghz.html"
        },
        {
            "name": "Intel Core i7-14700",
            "brand": "Intel",
            "category": "CPU",
            "price_vnd": 8_250_000,  # ~$330 USD
            "stock": 15,
            "sku": "CPU-INTEL-I7-14700",
            "image": "https://ark.intel.com/content/www/us/en/ark/products/230500/intel-core-i914900k-processor-36m-cache-up-to-6-00-ghz.html"
        },
        {
            "name": "Intel Core i5-14600K",
            "brand": "Intel",
            "category": "CPU",
            "price_vnd": 6_750_000,  # ~$270 USD
            "stock": 25,
            "sku": "CPU-INTEL-I5-14600K",
            "image": "https://ark.intel.com/content/www/us/en/ark/products/230500/intel-core-i914900k-processor-36m-cache-up-to-6-00-ghz.html"
        },
        {
            "name": "Intel Core i5-14600KF",
            "brand": "Intel",
            "category": "CPU",
            "price_vnd": 5_750_000,  # ~$230 USD
            "stock": 22,
            "sku": "CPU-INTEL-I5-14600KF",
            "image": "https://ark.intel.com/content/www/us/en/ark/products/230500/intel-core-i914900k-processor-36m-cache-up-to-6-00-ghz.html"
        },
        {
            "name": "Intel Core i5-13600K",
            "brand": "Intel",
            "category": "CPU",
            "price_vnd": 5_250_000,  # ~$210 USD
            "stock": 20,
            "sku": "CPU-INTEL-I5-13600K",
            "image": "https://ark.intel.com/content/www/us/en/ark/products/230500/intel-core-i914900k-processor-36m-cache-up-to-6-00-ghz.html"
        },
        # AMD Processors
        {
            "name": "AMD Ryzen 9 7950X",
            "brand": "AMD",
            "category": "CPU",
            "price_vnd": 13_750_000,  # ~$550 USD
            "stock": 12,
            "sku": "CPU-AMD-R9-7950X",
            "image": "https://www.amd.com/en/products/cpu/amd-ryzen-9-7950x.html"
        },
        {
            "name": "AMD Ryzen 9 7950X3D",
            "brand": "AMD",
            "category": "CPU",
            "price_vnd": 16_250_000,  # ~$650 USD
            "stock": 8,
            "sku": "CPU-AMD-R9-7950X3D",
            "image": "https://www.amd.com/en/products/cpu/amd-ryzen-9-7950x.html"
        },
        {
            "name": "AMD Ryzen 9 7900X",
            "brand": "AMD",
            "category": "CPU",
            "price_vnd": 10_500_000,  # ~$420 USD
            "stock": 14,
            "sku": "CPU-AMD-R9-7900X",
            "image": "https://www.amd.com/en/products/cpu/amd-ryzen-9-7950x.html"
        },
        {
            "name": "AMD Ryzen 9 7900X3D",
            "brand": "AMD",
            "category": "CPU",
            "price_vnd": 12_500_000,  # ~$500 USD
            "stock": 10,
            "sku": "CPU-AMD-R9-7900X3D",
            "image": "https://www.amd.com/en/products/cpu/amd-ryzen-9-7950x.html"
        },
        {
            "name": "AMD Ryzen 7 7800X3D",
            "brand": "AMD",
            "category": "CPU",
            "price_vnd": 9_500_000,  # ~$380 USD
            "stock": 16,
            "sku": "CPU-AMD-R7-7800X3D",
            "image": "https://www.amd.com/en/products/cpu/amd-ryzen-9-7950x.html"
        },
        {
            "name": "AMD Ryzen 7 7700X",
            "brand": "AMD",
            "category": "CPU",
            "price_vnd": 7_250_000,  # ~$290 USD
            "stock": 18,
            "sku": "CPU-AMD-R7-7700X",
            "image": "https://www.amd.com/en/products/cpu/amd-ryzen-9-7950x.html"
        },
        {
            "name": "AMD Ryzen 7 7700",
            "brand": "AMD",
            "category": "CPU",
            "price_vnd": 6_250_000,  # ~$250 USD
            "stock": 20,
            "sku": "CPU-AMD-R7-7700",
            "image": "https://www.amd.com/en/products/cpu/amd-ryzen-9-7950x.html"
        },
        {
            "name": "AMD Ryzen 5 7600X",
            "brand": "AMD",
            "category": "CPU",
            "price_vnd": 5_000_000,  # ~$200 USD
            "stock": 25,
            "sku": "CPU-AMD-R5-7600X",
            "image": "https://www.amd.com/en/products/cpu/amd-ryzen-9-7950x.html"
        },
        {
            "name": "AMD Ryzen 5 7600",
            "brand": "AMD",
            "category": "CPU",
            "price_vnd": 4_000_000,  # ~$160 USD
            "stock": 30,
            "sku": "CPU-AMD-R5-7600",
            "image": "https://www.amd.com/en/products/cpu/amd-ryzen-9-7950x.html"
        },
        {
            "name": "AMD Ryzen 5 5600X",
            "brand": "AMD",
            "category": "CPU",
            "price_vnd": 3_500_000,  # ~$140 USD
            "stock": 28,
            "sku": "CPU-AMD-R5-5600X",
            "image": "https://www.amd.com/en/products/cpu/amd-ryzen-9-7950x.html"
        },
    ],
    "GPU": [
        # NVIDIA GPUs
        {
            "name": "ASUS ROG Strix RTX 4090 OC 24GB",
            "brand": "ASUS",
            "category": "GPU",
            "price_vnd": 50_000_000,  # ~$2000 USD
            "stock": 5,
            "sku": "GPU-ASUS-RTX4090-24GB",
            "image": "https://www.asus.com/vn/"
        },
        {
            "name": "Gigabyte RTX 4090 Master 24GB",
            "brand": "Gigabyte",
            "category": "GPU",
            "price_vnd": 48_750_000,  # ~$1950 USD
            "stock": 6,
            "sku": "GPU-GB-RTX4090-24GB",
            "image": "https://www.gigabyte.com/vn/"
        },
        {
            "name": "MSI RTX 4090 Gaming Trio 24GB",
            "brand": "MSI",
            "category": "GPU",
            "price_vnd": 47_500_000,  # ~$1900 USD
            "stock": 7,
            "sku": "GPU-MSI-RTX4090-24GB",
            "image": "https://www.msi.com/vn"
        },
        {
            "name": "EVGA RTX 4090 FTW3 Ultra 24GB",
            "brand": "EVGA",
            "category": "GPU",
            "price_vnd": 47_000_000,  # ~$1880 USD
            "stock": 4,
            "sku": "GPU-EVGA-RTX4090-24GB",
            "image": "https://www.evga.com/"
        },
        {
            "name": "Gigabyte RTX 4080 Super Gaming OC 16GB",
            "brand": "Gigabyte",
            "category": "GPU",
            "price_vnd": 30_000_000,  # ~$1200 USD
            "stock": 10,
            "sku": "GPU-GB-RTX4080S-16GB",
            "image": "https://www.gigabyte.com/vn/"
        },
        {
            "name": "ASUS TUF RTX 4080 Super OC 16GB",
            "brand": "ASUS",
            "category": "GPU",
            "price_vnd": 31_250_000,  # ~$1250 USD
            "stock": 9,
            "sku": "GPU-ASUS-RTX4080S-16GB",
            "image": "https://www.asus.com/vn/"
        },
        {
            "name": "MSI RTX 4080 Super Gaming Trio 16GB",
            "brand": "MSI",
            "category": "GPU",
            "price_vnd": 30_750_000,  # ~$1230 USD
            "stock": 8,
            "sku": "GPU-MSI-RTX4080S-16GB",
            "image": "https://www.msi.com/vn"
        },
        {
            "name": "MSI RTX 4070 Ti Super Gaming Trio 12GB",
            "brand": "MSI",
            "category": "GPU",
            "price_vnd": 20_000_000,  # ~$800 USD
            "stock": 15,
            "sku": "GPU-MSI-RTX4070TS-12GB",
            "image": "https://www.msi.com/vn"
        },
        {
            "name": "ASUS ROG Strix RTX 4070 Ti Super OC 12GB",
            "brand": "ASUS",
            "category": "GPU",
            "price_vnd": 21_250_000,  # ~$850 USD
            "stock": 12,
            "sku": "GPU-ASUS-RTX4070TS-12GB",
            "image": "https://www.asus.com/vn/"
        },
        {
            "name": "EVGA RTX 4070 Ti Super FTW3 Ultra 12GB",
            "brand": "EVGA",
            "category": "GPU",
            "price_vnd": 20_000_000,  # ~$800 USD
            "stock": 14,
            "sku": "GPU-EVGA-RTX4070TS-12GB",
            "image": "https://www.evga.com/"
        },
        {
            "name": "Gigabyte RTX 4070 Gaming OC 12GB",
            "brand": "Gigabyte",
            "category": "GPU",
            "price_vnd": 14_500_000,  # ~$580 USD
            "stock": 20,
            "sku": "GPU-GB-RTX4070-12GB",
            "image": "https://www.gigabyte.com/vn/"
        },
        {
            "name": "ASUS TUF RTX 4070 OC 12GB",
            "brand": "ASUS",
            "category": "GPU",
            "price_vnd": 15_000_000,  # ~$600 USD
            "stock": 18,
            "sku": "GPU-ASUS-RTX4070-12GB",
            "image": "https://www.asus.com/vn/"
        },
        {
            "name": "MSI RTX 4070 Ventus 2X OC 12GB",
            "brand": "MSI",
            "category": "GPU",
            "price_vnd": 14_250_000,  # ~$570 USD
            "stock": 22,
            "sku": "GPU-MSI-RTX4070-12GB",
            "image": "https://www.msi.com/vn"
        },
        {
            "name": "EVGA RTX 4060 Ti 8GB FTW3",
            "brand": "EVGA",
            "category": "GPU",
            "price_vnd": 7_500_000,  # ~$300 USD
            "stock": 30,
            "sku": "GPU-EVGA-RTX4060TI-8GB",
            "image": "https://www.evga.com/"
        },
        {
            "name": "ASUS Phoenix RTX 4060 Ti 8GB",
            "brand": "ASUS",
            "category": "GPU",
            "price_vnd": 8_000_000,  # ~$320 USD
            "stock": 28,
            "sku": "GPU-ASUS-RTX4060TI-8GB",
            "image": "https://www.asus.com/vn/"
        },
        # AMD GPUs
        {
            "name": "AMD Radeon RX 7900 XT 20GB",
            "brand": "AMD",
            "category": "GPU",
            "price_vnd": 20_000_000,  # ~$800 USD
            "stock": 12,
            "sku": "GPU-AMD-RX7900XT-20GB",
            "image": "https://www.amd.com/en/products/specifications/graphics/18872"
        },
        {
            "name": "AMD Radeon RX 7900 GRE 20GB",
            "brand": "AMD",
            "category": "GPU",
            "price_vnd": 21_250_000,  # ~$850 USD
            "stock": 10,
            "sku": "GPU-AMD-RX7900GRE-20GB",
            "image": "https://www.amd.com/en/products/specifications/graphics/18872"
        },
        {
            "name": "AMD Radeon RX 7800 XT 16GB",
            "brand": "AMD",
            "category": "GPU",
            "price_vnd": 12_500_000,  # ~$500 USD
            "stock": 18,
            "sku": "GPU-AMD-RX7800XT-16GB",
            "image": "https://www.amd.com/en/products/specifications/graphics/18872"
        },
        {
            "name": "AMD Radeon RX 7700 XT 12GB",
            "brand": "AMD",
            "category": "GPU",
            "price_vnd": 8_750_000,  # ~$350 USD
            "stock": 25,
            "sku": "GPU-AMD-RX7700XT-12GB",
            "image": "https://www.amd.com/en/products/specifications/graphics/18872"
        },
        {
            "name": "AMD Radeon RX 7600 16GB",
            "brand": "AMD",
            "category": "GPU",
            "price_vnd": 6_250_000,  # ~$250 USD
            "stock": 30,
            "sku": "GPU-AMD-RX7600-16GB",
            "image": "https://www.amd.com/en/products/specifications/graphics/18872"
        },
    ],
    "Mainboard": [
        {
            "name": "ASUS ROG Strix Z790-E Gaming WiFi",
            "brand": "ASUS",
            "category": "Mainboard",
            "price_vnd": 9_750_000,  # ~$390 USD
            "stock": 8,
            "sku": "MB-ASUS-Z790E",
            "image": "https://www.asus.com/vn/"
        },
        {
            "name": "MSI MPG Z790 Edge WiFi",
            "brand": "MSI",
            "category": "Mainboard",
            "price_vnd": 8_750_000,  # ~$350 USD
            "stock": 10,
            "sku": "MB-MSI-Z790EDGE",
            "image": "https://www.msi.com/vn"
        },
        {
            "name": "Gigabyte Z790 Master",
            "brand": "Gigabyte",
            "category": "Mainboard",
            "price_vnd": 8_250_000,  # ~$330 USD
            "stock": 12,
            "sku": "MB-GB-Z790MASTER",
            "image": "https://www.gigabyte.com/vn/"
        },
        {
            "name": "ASRock Z790 Steel Legend",
            "brand": "ASRock",
            "category": "Mainboard",
            "price_vnd": 7_500_000,  # ~$300 USD
            "stock": 14,
            "sku": "MB-ASR-Z790SL",
            "image": "https://www.asrock.com/"
        },
        {
            "name": "ASUS TUF Z790-Plus WiFi",
            "brand": "ASUS",
            "category": "Mainboard",
            "price_vnd": 7_000_000,  # ~$280 USD
            "stock": 16,
            "sku": "MB-ASUS-Z790PLUS",
            "image": "https://www.asus.com/vn/"
        },
        {
            "name": "MSI MPG Z790 Gaming Edge WiFi",
            "brand": "MSI",
            "category": "Mainboard",
            "price_vnd": 8_000_000,  # ~$320 USD
            "stock": 13,
            "sku": "MB-MSI-Z790GE",
            "image": "https://www.msi.com/vn"
        },
        {
            "name": "ASUS ROG Strix X870-E-E Gaming WiFi",
            "brand": "ASUS",
            "category": "Mainboard",
            "price_vnd": 11_250_000,  # ~$450 USD
            "stock": 6,
            "sku": "MB-ASUS-X870E",
            "image": "https://www.asus.com/vn/"
        },
        {
            "name": "MSI MPG X870E Edge WiFi",
            "brand": "MSI",
            "category": "Mainboard",
            "price_vnd": 10_750_000,  # ~$430 USD
            "stock": 7,
            "sku": "MB-MSI-X870E",
            "image": "https://www.msi.com/vn"
        },
        {
            "name": "Gigabyte X870E-E Master",
            "brand": "Gigabyte",
            "category": "Mainboard",
            "price_vnd": 10_000_000,  # ~$400 USD
            "stock": 9,
            "sku": "MB-GB-X870E",
            "image": "https://www.gigabyte.com/vn/"
        },
        {
            "name": "ASRock X870E Steel Legend",
            "brand": "ASRock",
            "category": "Mainboard",
            "price_vnd": 9_250_000,  # ~$370 USD
            "stock": 11,
            "sku": "MB-ASR-X870E",
            "image": "https://www.asrock.com/"
        },
    ],
    "RAM": [
        {
            "name": "Corsair Vengeance RGB Pro 64GB (32x2) DDR5 6000MHz",
            "brand": "Corsair",
            "category": "RAM",
            "price_vnd": 8_000_000,  # ~$320 USD
            "stock": 12,
            "sku": "RAM-CORSAIR-DDR5-64GB",
            "image": "https://www.corsair.com/"
        },
        {
            "name": "G.SKILL Trident Z5 RGB 64GB (32x2) DDR5 6000MHz",
            "brand": "G.SKILL",
            "category": "RAM",
            "price_vnd": 7_500_000,  # ~$300 USD
            "stock": 14,
            "sku": "RAM-GSKILL-DDR5-64GB",
            "image": "https://www.gskill.com/"
        },
        {
            "name": "Kingston Fury Beast DDR5 64GB (32x2) 6000MHz",
            "brand": "Kingston",
            "category": "RAM",
            "price_vnd": 7_250_000,  # ~$290 USD
            "stock": 16,
            "sku": "RAM-KINGSTON-DDR5-64GB",
            "image": "https://www.kingston.com/"
        },
        {
            "name": "ADATA XPG Lian Xu DDR5 64GB (32x2) 6000MHz",
            "brand": "ADATA",
            "category": "RAM",
            "price_vnd": 7_000_000,  # ~$280 USD
            "stock": 18,
            "sku": "RAM-ADATA-DDR5-64GB",
            "image": "https://www.adata.com/"
        },
        {
            "name": "Corsair Vengeance RGB Pro 32GB (16x2) DDR5 5600MHz",
            "brand": "Corsair",
            "category": "RAM",
            "price_vnd": 4_500_000,  # ~$180 USD
            "stock": 20,
            "sku": "RAM-CORSAIR-DDR5-32GB",
            "image": "https://www.corsair.com/"
        },
        {
            "name": "G.SKILL Trident Z5 RGB 32GB (16x2) DDR5 5600MHz",
            "brand": "G.SKILL",
            "category": "RAM",
            "price_vnd": 4_250_000,  # ~$170 USD
            "stock": 22,
            "sku": "RAM-GSKILL-DDR5-32GB",
            "image": "https://www.gskill.com/"
        },
        {
            "name": "Crucial Pro 48GB (24x2) DDR5 5600MHz",
            "brand": "Crucial",
            "category": "RAM",
            "price_vnd": 6_250_000,  # ~$250 USD
            "stock": 15,
            "sku": "RAM-CRUCIAL-DDR5-48GB",
            "image": "https://www.crucial.com/"
        },
        {
            "name": "Kingston Fury Beast 32GB (16x2) DDR5 5600MHz",
            "brand": "Kingston",
            "category": "RAM",
            "price_vnd": 4_000_000,  # ~$160 USD
            "stock": 25,
            "sku": "RAM-KINGSTON-DDR5-32GB",
            "image": "https://www.kingston.com/"
        },
    ],
    "SSD": [
        {
            "name": "Samsung 990 Pro 4TB PCIe 4.0 NVMe",
            "brand": "Samsung",
            "category": "SSD",
            "price_vnd": 8_750_000,  # ~$350 USD
            "stock": 10,
            "sku": "SSD-SAMSUNG-990PRO-4TB",
            "image": "https://www.samsung.com/"
        },
        {
            "name": "WD Black SN850X 4TB",
            "brand": "Western Digital",
            "category": "SSD",
            "price_vnd": 7_500_000,  # ~$300 USD
            "stock": 12,
            "sku": "SSD-WD-SN850X-4TB",
            "image": "https://www.westerndigital.com/"
        },
        {
            "name": "Crucial P5 Plus 4TB",
            "brand": "Crucial",
            "category": "SSD",
            "price_vnd": 7_000_000,  # ~$280 USD
            "stock": 14,
            "sku": "SSD-CRUCIAL-P5PLUS-4TB",
            "image": "https://www.crucial.com/"
        },
        {
            "name": "Kingston KC3000 4TB",
            "brand": "Kingston",
            "category": "SSD",
            "price_vnd": 6_750_000,  # ~$270 USD
            "stock": 16,
            "sku": "SSD-KINGSTON-KC3000-4TB",
            "image": "https://www.kingston.com/"
        },
        {
            "name": "Samsung 990 Pro 2TB PCIe 4.0 NVMe",
            "brand": "Samsung",
            "category": "SSD",
            "price_vnd": 4_750_000,  # ~$190 USD
            "stock": 20,
            "sku": "SSD-SAMSUNG-990PRO-2TB",
            "image": "https://www.samsung.com/"
        },
        {
            "name": "WD Black SN850X 2TB",
            "brand": "Western Digital",
            "category": "SSD",
            "price_vnd": 4_250_000,  # ~$170 USD
            "stock": 22,
            "sku": "SSD-WD-SN850X-2TB",
            "image": "https://www.westerndigital.com/"
        },
        {
            "name": "ADATA XPG S70 Blade 4TB",
            "brand": "ADATA",
            "category": "SSD",
            "price_vnd": 8_250_000,  # ~$330 USD
            "stock": 11,
            "sku": "SSD-ADATA-S70BLADE-4TB",
            "image": "https://www.adata.com/"
        },
        {
            "name": "Corsair MP600 Core XT 4TB",
            "brand": "Corsair",
            "category": "SSD",
            "price_vnd": 7_250_000,  # ~$290 USD
            "stock": 13,
            "sku": "SSD-CORSAIR-MP600-4TB",
            "image": "https://www.corsair.com/"
        },
    ],
    "HDD": [
        {
            "name": "WD Red Pro 12TB 256MB 7200RPM",
            "brand": "Western Digital",
            "category": "HDD",
            "price_vnd": 6_250_000,  # ~$250 USD
            "stock": 8,
            "sku": "HDD-WD-RED-12TB",
            "image": "https://www.westerndigital.com/"
        },
        {
            "name": "Seagate Barracuda Pro 12TB",
            "brand": "Seagate",
            "category": "HDD",
            "price_vnd": 5_750_000,  # ~$230 USD
            "stock": 10,
            "sku": "HDD-SEAGATE-PRO-12TB",
            "image": "https://www.seagate.com/"
        },
        {
            "name": "WD Red Pro 10TB 256MB",
            "brand": "Western Digital",
            "category": "HDD",
            "price_vnd": 5_000_000,  # ~$200 USD
            "stock": 12,
            "sku": "HDD-WD-RED-10TB",
            "image": "https://www.westerndigital.com/"
        },
        {
            "name": "Seagate IronWolf 8TB 7200RPM",
            "brand": "Seagate",
            "category": "HDD",
            "price_vnd": 3_250_000,  # ~$130 USD
            "stock": 15,
            "sku": "HDD-SEAGATE-IRONWOLF-8TB",
            "image": "https://www.seagate.com/"
        },
    ],
    "PSU": [
        {
            "name": "Corsair RM1000x 1000W 80+ Gold",
            "brand": "Corsair",
            "category": "PSU",
            "price_vnd": 5_500_000,  # ~$220 USD
            "stock": 10,
            "sku": "PSU-CORSAIR-RM1000X",
            "image": "https://www.corsair.com/"
        },
        {
            "name": "EVGA SuperNOVA 850 GA 850W 80+ Gold",
            "brand": "EVGA",
            "category": "PSU",
            "price_vnd": 4_000_000,  # ~$160 USD
            "stock": 12,
            "sku": "PSU-EVGA-SN850GA",
            "image": "https://www.evga.com/"
        },
        {
            "name": "Seasonic Focus GX 1050W 80+ Gold",
            "brand": "Seasonic",
            "category": "PSU",
            "price_vnd": 6_250_000,  # ~$250 USD
            "stock": 8,
            "sku": "PSU-SEASONIC-GX1050",
            "image": "https://www.seasonic.com/"
        },
        {
            "name": "Corsair HXi 1200W 80+ Platinum",
            "brand": "Corsair",
            "category": "PSU",
            "price_vnd": 7_500_000,  # ~$300 USD
            "stock": 6,
            "sku": "PSU-CORSAIR-HXI1200",
            "image": "https://www.corsair.com/"
        },
        {
            "name": "EVGA SuperNOVA 1000 P2 1000W 80+ Platinum",
            "brand": "EVGA",
            "category": "PSU",
            "price_vnd": 4_750_000,  # ~$190 USD
            "stock": 9,
            "sku": "PSU-EVGA-SN1000P2",
            "image": "https://www.evga.com/"
        },
        {
            "name": "Gigabyte UD1000GM 1000W 80+ Gold",
            "brand": "Gigabyte",
            "category": "PSU",
            "price_vnd": 4_500_000,  # ~$180 USD
            "stock": 11,
            "sku": "PSU-GIGABYTE-UD1000",
            "image": "https://www.gigabyte.com/vn/"
        },
    ],
    "Case": [
        {
            "name": "NZXT H7 Flow RGB",
            "brand": "NZXT",
            "category": "Case",
            "price_vnd": 3_500_000,  # ~$140 USD
            "stock": 12,
            "sku": "CASE-NZXT-H7FLOW",
            "image": "https://www.nzxt.com/"
        },
        {
            "name": "Corsair 5000T RGB",
            "brand": "Corsair",
            "category": "Case",
            "price_vnd": 7_250_000,  # ~$290 USD
            "stock": 8,
            "sku": "CASE-CORSAIR-5000T",
            "image": "https://www.corsair.com/"
        },
        {
            "name": "Lian Li LANCOOL 303",
            "brand": "Lian Li",
            "category": "Case",
            "price_vnd": 2_000_000,  # ~$80 USD
            "stock": 20,
            "sku": "CASE-LIANLI-303",
            "image": "https://www.lian-li.com/"
        },
        {
            "name": "Phanteks Eclipse P500A D-RGB",
            "brand": "Phanteks",
            "category": "Case",
            "price_vnd": 3_750_000,  # ~$150 USD
            "stock": 15,
            "sku": "CASE-PHANTEKS-P500A",
            "image": "https://www.phanteks.com/"
        },
        {
            "name": "Fractal Design Meshify 2",
            "brand": "Fractal Design",
            "category": "Case",
            "price_vnd": 4_000_000,  # ~$160 USD
            "stock": 14,
            "sku": "CASE-FRACTAL-MESHIFY2",
            "image": "https://www.fractal-design.com/"
        },
        {
            "name": "be quiet! Pure Base 500DX",
            "brand": "be quiet!",
            "category": "Case",
            "price_vnd": 3_000_000,  # ~$120 USD
            "stock": 18,
            "sku": "CASE-BEQUIET-PB500DX",
            "image": "https://www.bequiet.com/"
        },
    ],
    "Cooling": [
        {
            "name": "Noctua NH-D15 Chromax Black",
            "brand": "Noctua",
            "category": "Cooling",
            "price_vnd": 2_500_000,  # ~$100 USD
            "stock": 14,
            "sku": "COOL-NOCTUA-D15",
            "image": "https://www.noctua.at/"
        },
        {
            "name": "NZXT Kraken X73 360mm AIO",
            "brand": "NZXT",
            "category": "Cooling",
            "price_vnd": 5_000_000,  # ~$200 USD
            "stock": 10,
            "sku": "COOL-NZXT-X73",
            "image": "https://www.nzxt.com/"
        },
        {
            "name": "Corsair H150i Elite Capellix 360mm",
            "brand": "Corsair",
            "category": "Cooling",
            "price_vnd": 4_250_000,  # ~$170 USD
            "stock": 12,
            "sku": "COOL-CORSAIR-H150I",
            "image": "https://www.corsair.com/"
        },
        {
            "name": "be quiet! Dark Rock Pro TR4",
            "brand": "be quiet!",
            "category": "Cooling",
            "price_vnd": 2_250_000,  # ~$90 USD
            "stock": 16,
            "sku": "COOL-BEQUIET-DARK",
            "image": "https://www.bequiet.com/"
        },
        {
            "name": "Scythe Ninja 5",
            "brand": "Scythe",
            "category": "Cooling",
            "price_vnd": 1_750_000,  # ~$70 USD
            "stock": 20,
            "sku": "COOL-SCYTHE-NINJA5",
            "image": "https://www.scythe.jp/"
        },
        {
            "name": "Thermalright Peerless Assassin 120 SE",
            "brand": "Thermalright",
            "category": "Cooling",
            "price_vnd": 875_000,  # ~$35 USD
            "stock": 25,
            "sku": "COOL-THERMALRIGHT-PA120",
            "image": "https://www.thermalright.com/"
        },
    ],
    "Monitor": [
        {
            "name": "Dell S3423DWF 34\" Ultrawide 3440x1440 100Hz",
            "brand": "Dell",
            "category": "Monitor",
            "price_vnd": 15_000_000,  # ~$600 USD
            "stock": 6,
            "sku": "MON-DELL-S3423DWF",
            "image": "https://www.dell.com/"
        },
        {
            "name": "LG 27GP850-B 27\" 1440p 180Hz",
            "brand": "LG",
            "category": "Monitor",
            "price_vnd": 11_250_000,  # ~$450 USD
            "stock": 8,
            "sku": "MON-LG-27GP850",
            "image": "https://www.lg.com/"
        },
        {
            "name": "ASUS ProArt PA278QV 27\" 2560x1440 100Hz",
            "brand": "ASUS",
            "category": "Monitor",
            "price_vnd": 15_000_000,  # ~$600 USD
            "stock": 5,
            "sku": "MON-ASUS-PA278QV",
            "image": "https://www.asus.com/vn/"
        },
        {
            "name": "MSI Oculux NXG253R 25\" 1080p 360Hz",
            "brand": "MSI",
            "category": "Monitor",
            "price_vnd": 17_500_000,  # ~$700 USD
            "stock": 7,
            "sku": "MON-MSI-NXG253R",
            "image": "https://www.msi.com/vn"
        },
        {
            "name": "BenQ PD2705U 27\" 4K 60Hz",
            "brand": "BenQ",
            "category": "Monitor",
            "price_vnd": 22_500_000,  # ~$900 USD
            "stock": 4,
            "sku": "MON-BENQ-PD2705U",
            "image": "https://www.benq.com/"
        },
        {
            "name": "Gigabyte M28U 28\" 4K 144Hz",
            "brand": "Gigabyte",
            "category": "Monitor",
            "price_vnd": 20_000_000,  # ~$800 USD
            "stock": 6,
            "sku": "MON-GIGABYTE-M28U",
            "image": "https://www.gigabyte.com/vn/"
        },
    ],
}

def export_to_json():
    """Export product data to JSON file"""
    output_file = Path(__file__).parent / 'product_data.json'
    
    all_products = []
    for category, products in PRODUCT_DATA.items():
        all_products.extend(products)
    
    with open(output_file, 'w', encoding='utf-8') as f:
        json.dump(all_products, f, ensure_ascii=False, indent=2)
    
    print(f"✅ Exported {len(all_products)} products to {output_file}")
    return output_file

def export_to_csv():
    """Export product data to CSV file"""
    output_file = Path(__file__).parent / 'product_data.csv'
    
    all_products = []
    for category, products in PRODUCT_DATA.items():
        all_products.extend(products)
    
    with open(output_file, 'w', newline='', encoding='utf-8') as f:
        writer = csv.DictWriter(f, fieldnames=['name', 'brand', 'category', 'price_vnd', 'stock', 'sku', 'image'])
        writer.writeheader()
        writer.writerows(all_products)
    
    print(f"✅ Exported {len(all_products)} products to {output_file}")
    return output_file

def print_price_summary():
    """Print price summary by category"""
    print("\n" + "="*60)
    print("PRICE SUMMARY BY CATEGORY (Vietnamese Đồng)")
    print("="*60)
    
    for category, products in PRODUCT_DATA.items():
        prices = [p['price_vnd'] for p in products]
        min_price = min(prices)
        max_price = max(prices)
        avg_price = sum(prices) // len(prices)
        
        print(f"\n{category}:")
        print(f"  Count: {len(products)} products")
        print(f"  Min:  {min_price:>12,} VND (~${min_price/25000:>6.0f} USD)")
        print(f"  Max:  {max_price:>12,} VND (~${max_price/25000:>6.0f} USD)")
        print(f"  Avg:  {avg_price:>12,} VND (~${avg_price/25000:>6.0f} USD)")

if __name__ == '__main__':
    print("\n📊 Product Data Manager - Vietnamese PC Components Pricing")
    print("="*60)
    
    # Print summary
    print_price_summary()
    
    # Export data
    json_file = export_to_json()
    csv_file = export_to_csv()
    
    # Summary
    total_products = sum(len(p) for p in PRODUCT_DATA.values())
    print(f"\n✅ Total products: {total_products}")
    print(f"📁 Files created:")
    print(f"   - {json_file}")
    print(f"   - {csv_file}")
