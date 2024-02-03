<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="bg-gray-800 p-4">
        <router-link to="/" class="text-white hover:text-gray-300 px-2 py-1">Home</router-link>
        <router-link v-if="loggedIn" to="/students" class="text-white hover:text-gray-300 px-2 py-1">Students</router-link>
        <router-link v-if="loggedIn" to="/teachers" class="text-white hover:text-gray-300 px-2 py-1">Teachers</router-link>
        <router-link v-if="loggedIn" to="/classes" class="text-white hover:text-gray-300 px-2 py-1">Classes</router-link>
        <router-link v-if="loggedIn" @click="logout" to="/login"
            class="text-white hover:text-gray-300 px-2 py-1">Logout</router-link>
        <router-link v-if="!loggedIn" to="/register" class="text-white hover:text-gray-300 px-2 py-1">Register</router-link>
        <router-link v-if="!loggedIn" to="/login" class="text-white hover:text-gray-300 px-2 py-1">Login</router-link>

        <!-- Additional links or content for logged-in users -->
        <router-link v-if="loggedIn" to="/dashboard"
            class="text-white hover:text-gray-300 px-2 py-1">Dashboard</router-link>
        <router-link v-if="loggedIn" to="/profile" class="text-white hover:text-gray-300 px-2 py-1">Profile</router-link>
    </div>
</template>

<script>
export default {
    // Navbar logic, check if the user is logged in
    data ()
    {
        return {
            loggedIn: false,
        };
    },
    methods: {
        logout ()
        {
            // Logout logic
            this.loggedIn = false; // Update the loggedIn state after logging out
        },
    },
};
</script>
