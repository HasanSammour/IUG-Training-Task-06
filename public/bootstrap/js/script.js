// Category Color Function
function getCategoryClass(categoryName) {
    const categories = {
        'Electronics': 'category-electronics',
        'Fashion': 'category-fashion',
        'Home & Garden': 'category-home',
        'Books': 'category-books',
        'Sports': 'category-sports',
        'Health & Beauty': 'category-health',
        'Toys': 'category-toys',
        'Automotive': 'category-automotive'
    };
    return categories[categoryName] || 'category-other';
}
