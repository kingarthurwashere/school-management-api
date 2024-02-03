<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <header class="bg-blue-500 p-4">
        <div class="container mx-auto flex items-center justify-between">
            <!-- Logo or Branding -->
            <div>
                <h1 class="text-white text-xl font-bold">School System</h1>
            </div>

            <!-- Navigation Links -->
            <nav class="flex space-x-4">
                <router-link to="/admin-dashboard" class="text-white hover:underline">Dashboard</router-link>
                <router-link to="/students" class="text-white hover:underline">Students</router-link>
                <router-link to="/teachers" class="text-white hover:underline">Teachers</router-link>
                <router-link to="/classes" class="text-white hover:underline">Classes</router-link>
            </nav>

            <!-- User Actions (e.g., Logout) -->
            <div>
                <button @click="logout" class="text-white hover:underline">Logout</button>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    methods: {
        logout ()
        {
            // Perform logout actions
            // Then redirect to the login page. Adjust the path accordingly.
            this.$router.push( { name: 'login' } );
        },
    },
};
</script>

<style scoped>
/* Add specific styles for the Header component */
/* You can customize the styles according to your design */
</style>
