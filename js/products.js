// js/products.js

// MASTER PRODUCT LIST
const products = [
  { id: 1, name: "Paracetamol 650mg", price: 45, category: "Tablets", description: "Pain relief & fever reducer", image: "images/med1.jpg" },
  { id: 2, name: "Azithromycin 500mg", price: 120, category: "Tablets", description: "Antibiotic for infections", image: "images/med2.jpg" },
  { id: 3, name: "Cough Syrup 100ml", price: 90, category: "Syrups", description: "Cough & cold relief", image: "images/med3.jpg" },
  { id: 4, name: "Vitamin C 500mg", price: 140, category: "Vitamins", description: "Immunity booster", image: "images/med4.jpg" },
  { id: 5, name: "Elastic Bandage", price: 60, category: "First Aid", description: "Support bandage", image: "images/med5.jpg" },

  { id: 6, name: "Ibuprofen 400mg", price: 85, category: "Tablets", description: "Pain reliever & anti-inflammatory", image: "images/ibuprofen.jpg" },
  { id: 7, name: "Dolo 650", price: 35, category: "Tablets", description: "Fever and body pain relief", image: "images/dolo650.jpg" },
  { id: 8, name: "ORS Packet", price: 20, category: "First Aid", description: "Hydration salt solution", image: "images/ors.jpg" },
  { id: 9, name: "Calcium Tablets", price: 160, category: "Vitamins", description: "Bone health supplement", image: "images/calcium.jpg" },
  { id: 10, name: "Baby Cough Syrup", price: 110, category: "Syrups", description: "Safe cough relief for children", image: "images/babycough.jpg" },

  { id: 11, name: "Dettol Antiseptic", price: 95, category: "First Aid", description: "Disinfectant liquid", image: "images/dettol.jpg" },
  { id: 12, name: "Savlon Spray", price: 120, category: "First Aid", description: "Instant germ protection", image: "images/savlon.jpg" },
  { id: 13, name: "Multivitamin Capsules", price: 180, category: "Vitamins", description: "Daily energy boost", image: "images/multivitamin.jpg" },
  { id: 14, name: "Cetirizine 10mg", price: 25, category: "Tablets", description: "Anti-allergic tablet", image: "images/cetirizine.jpg" },
  { id: 15, name: "Cough Drops (Pack of 10)", price: 15, category: "Syrups", description: "Sore throat relief drops", image: "images/coughdrops.jpg" },

  { id: 16, name: "Hand Sanitizer 100ml", price: 45, category: "Personal Care", description: "Instant germ protection", image: "images/sanitizer.jpg" },
  { id: 17, name: "Body Lotion 200ml", price: 130, category: "Personal Care", description: "Moisturizing body lotion", image: "images/bodylotion.jpg" },
  { id: 18, name: "Sunscreen SPF 30", price: 180, category: "Personal Care", description: "UV protection sunscreen", image: "images/sunscreen.jpg" },
  { id: 19, name: "Burnol Cream", price: 35, category: "First Aid", description: "Burn relief cream", image: "images/burnol.jpg" },
  { id: 20, name: "ORS Orange Flavour", price: 25, category: "First Aid", description: "Electrolyte replacement", image: "images/orsorange.jpg" },
    /*{(1)
    id: 21,
    name: "Digital Thermometer",
    price: 120,
    category: "First Aid",
    description: "Accurate digital thermometer for body temperature measurement",
    image: "images/thermometer.jpg"
  }*/


];


  // ⭐ Add your new medicines here (just copy & paste a block)
  /*
  {
    id: 6,
    name: "New Medicine Name",
    price: 199,
    category: "Tablets",
    description: "Short description",
    image: "images/newmed.jpg"
  }
  */



// ⭐ Helper: Search products
function searchProducts(query) {
  if (!query) return products.slice();

  query = query.toLowerCase();

  return products.filter(p =>
    p.name.toLowerCase().includes(query) ||
    p.description.toLowerCase().includes(query) ||
    p.category.toLowerCase().includes(query)
  );
}


// ⭐ Helper: Filter by category
function filterByCategory(category) {
  return products.filter(p => p.category === category);
}


// ⭐ Export for global access
window.allProducts = products;
window.searchProducts = searchProducts;
window.filterByCategory = filterByCategory;


