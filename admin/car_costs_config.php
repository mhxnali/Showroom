<?php
// Car Costs Configuration File
// This file defines the actual cost prices and commission rates for each car in your database
// The key is the car ID from your database, and the value is an array with cost_price and commission_rate

$carCostsConfig = [
    // Toyota Prius (Selling Price: 7,500,000)
    1 => ['cost_price' => 6800000, 'commission_rate' => 5.0],
    
    // Honda Civic (Selling Price: 8,500,000)
    2 => ['cost_price' => 7700000, 'commission_rate' => 5.0],
    
    // Toyota Supra (Selling Price: 5,500,000)
    3 => ['cost_price' => 5000000, 'commission_rate' => 7.0],
    
    // Toyota Land Cruiser (LC-200) (Selling Price: 50,000,000)
    6 => ['cost_price' => 45000000, 'commission_rate' => 8.0],
    
    // Honda Civic (Rebirth) (Selling Price: 3,600,000)
    7 => ['cost_price' => 3200000, 'commission_rate' => 5.0],
    
    // Toyota Crown Rs-Advance (Selling Price: 20,000,000)
    8 => ['cost_price' => 18000000, 'commission_rate' => 6.0],
    
    // BMW-i7 (Selling Price: 100,000,000)
    9 => ['cost_price' => 95000000, 'commission_rate' => 10.0],
    
    // Haval-H6 (Selling Price: 12,000,000)
    10 => ['cost_price' => 11000000, 'commission_rate' => 7.0],
    
    // Range Rover (Selling Price: 140,000,000)
    11 => ['cost_price' => 130000000, 'commission_rate' => 12.0],
    
    // Hyundai Sonata N-line (Selling Price: 17,000,000)
    12 => ['cost_price' => 15000000, 'commission_rate' => 7.0],
    
    // Mercedes E-Class E400 (Selling Price: 50,000,000)
    13 => ['cost_price' => 45000000, 'commission_rate' => 9.0],
    
    // Mercedes S-Class s680 Maybach (Selling Price: 150,000,000)
    14 => ['cost_price' => 135000000, 'commission_rate' => 12.0],
    
    // BMW-M4 Competition (Selling Price: 60,000,000)
    15 => ['cost_price' => 55000000, 'commission_rate' => 10.0],
    
    // Toyota Camry (Selling Price: 20,000,000)
    17 => ['cost_price' => 18000000, 'commission_rate' => 6.0],
    
    // Honda Accord Turbo Sport (Selling Price: 2,300,000)
    18 => ['cost_price' => 2000000, 'commission_rate' => 5.0],
    
    // Rolls-Royce Phantom (Selling Price: 220,000,000)
    19 => ['cost_price' => 200000000, 'commission_rate' => 15.0],
    
    // Honda City (Selling Price: 4,300,000)
    21 => ['cost_price' => 3800000, 'commission_rate' => 5.0],
    
    // Suzuki Swift (Selling Price: 4,200,000)
    22 => ['cost_price' => 3700000, 'commission_rate' => 5.0],
    
    // Suzuki Alto (Selling Price: 2,600,000)
    23 => ['cost_price' => 2300000, 'commission_rate' => 5.0],
    
    // Toyota Corolla Cross Hybrid 1.8 X (Selling Price: 9,800,000)
    24 => ['cost_price' => 8800000, 'commission_rate' => 6.0],
    
    // Toyota Yaris (Hatchback) (Selling Price: 4,500,000)
    26 => ['cost_price' => 4000000, 'commission_rate' => 5.0],
    
    // Tesla Model-S (Selling Price: 22,000,000)
    27 => ['cost_price' => 20000000, 'commission_rate' => 8.0],
    
    // Hyundai Elantra Hybrid (Selling Price: 9,800,000)
    32 => ['cost_price' => 8500000, 'commission_rate' => 7.0],
    
    // Lexus LX600 (Selling Price: 90,000,000)
    33 => ['cost_price' => 85000000, 'commission_rate' => 10.0],
    
    // Land Cruiser LC300 (Selling Price: 70,000,000)
    34 => ['cost_price' => 65000000, 'commission_rate' => 9.0]
];

// Default values for any car not in the configuration
$defaultCarCost = [
    'cost_price' => 0,      // Will be calculated as 70% of selling price if not set
    'commission_rate' => 5.0 // Default commission rate of 5%
];
?>