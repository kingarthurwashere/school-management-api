<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="bg-blue-100 h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-4xl font-bold mb-6">School Management System</h1>

            <div class="flex justify-between">
                <router-link to="/login" class="w-1/2">
                    <button class="w-full py-3 bg-blue-500 text-white font-semibold rounded">
                        Log In
                    </button>
                </router-link>

                <router-link to="/register" class="w-1/2 ml-4">
                    <button class="w-full py-3 bg-green-500 text-white font-semibold rounded">
                        Sign Up
                    </button>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    // Add any logic you need for the Home page
};
</script>

<style scoped>
/* Add specific styles for the Home component */
/* You can customize the styles according to your design */
</style>
