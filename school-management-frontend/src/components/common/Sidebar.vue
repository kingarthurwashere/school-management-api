<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <aside class="bg-gray-800 text-white h-screen w-64 flex flex-col">
        <div class="flex items-center justify-center p-4">
            <!-- Your logo or branding goes here -->
            <span class="text-xl font-semibold">School</span>
        </div>

        <ul class="flex-1">
            <li v-for="link in navLinks" :key="link.name" class="p-4 cursor-pointer hover:bg-gray-700">
                <router-link :to="link.to" class="flex items-center">
                    <span class="mr-2">{{ link.icon }}</span>
                    <span>{{ link.name }}</span>
                </router-link>
            </li>
        </ul>
    </aside>
</template>

<script>
export default {
    data ()
    {
        return {
            navLinks: [
                { name: 'Home', to: '/', icon: '🏠' },
                { name: 'Students', to: '/students', icon: '👨‍🎓' },
                { name: 'Teachers', to: '/teachers', icon: '👩‍🏫' },
                { name: 'Classes', to: '/classes', icon: '🏫' },
                // Add more navigation links as needed
            ],
        };
    },
};
</script>

<style scoped>
/* Add specific styles for the SideNav component */
aside {
    min-width: 240px;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

ul {
    list-style: none;
}

li {
    transition: background-color 0.3s;
}</style>
