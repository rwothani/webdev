<?php require_once 'header.php'; ?>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8 text-center">About Palace Restaurant</h1>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-12">
            <div>
                <img src="restaurant.jpeg" alt="Palace Restaurant Interior" class="w-full h-96 object-cover rounded-md">
            </div>
            <div class="flex items-center">
                <div>
                    <h2 class="text-2xl font-semibold mb-4">Our Story</h2>
                    <p class="text-lg mb-4">
                        Founded in 2015, Palace Restaurant was born from a passion for bringing people together through food. 
                        We blend the rich flavors of local cuisine with the vibrant tastes of international dishes, 
                        creating a dining experience that celebrates diversity and tradition.
                    </p>
                    <p class="text-lg mb-4">
                        Our mission is simple: to craft memorable meals using the freshest ingredients and heartfelt service. 
                        Whether you’re savoring our signature Jollof Rice or exploring our global sushi platter, 
                        every dish tells a story of quality and care.
                    </p>
                    <a href="menu.php" class="bg-yellow-400 text-black px-6 py-3 rounded-md hover:bg-yellow-500">Explore Our Menu</a>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 py-12 text-center rounded-md">
            <h2 class="text-2xl font-semibold mb-4">Our Values</h2>
            <p class="text-lg mb-6 max-w-3xl mx-auto">
                At Palace Restaurant, we believe in sustainability, community, and excellence. 
                We source ingredients locally whenever possible, support our neighborhood, 
                and strive to exceed your expectations with every visit.
            </p>
            <a href="order.php#booking" class="bg-yellow-400 text-black px-6 py-3 rounded-md hover:bg-yellow-500">Book a Table</a>
        </div>
    </div>
</section>

<?php require_once 'footer.php'; ?>