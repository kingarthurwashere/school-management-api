<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md">
            <form @submit.prevent="register" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h2 class="text-2xl font-bold mb-4 text-center">Register</h2>

                <!-- Name Input -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input v-model="name" type="text" id="name" name="name"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter your name" required />
                </div>

                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input v-model="email" type="email" id="email" name="email"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter your email" required />
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input v-model="password" type="password" id="password" name="password"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter your password" required />
                </div>

                <!-- Role Input (Dropdown) -->
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <select v-model="role" id="role" name="role"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        required>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-indigo active:bg-indigo-800">
                        Register
                    </button>
                    <router-link to="/login" class="text-indigo-500 hover:text-indigo-700">
                        Login
                    </router-link>
                </div>
            </form>

            <!-- Validation Error Message -->
            <div v-if="validationError" class="text-red-500 text-sm mb-4">{{ validationError }}</div>
        </div>
    </div>
</template>

<script>
import api from '@/axios';
import AuthService from '@/AuthService';

export default {
    data ()
    {
        return {
            name: '',
            email: '',
            password: '',
            role: 'student', // Set a default role if needed
            validationError: '',
        };
    },
    methods: {
        register ()
        {
            if ( this.name && this.email && this.password && this.role )
            {
                const payload = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    role: this.role,
                };

                api.post( '/api/register', payload )
                    .then( response =>
                    {
                        console.log( 'Registration successful:', response.data );

                        const accessToken = response.data.access_token;
                        AuthService.setBearerToken( accessToken );

                        // Redirect based on the user's role
                        const userRole = response.data.role;

                        if ( userRole )
                        {
                            console.log( 'Role successful:', userRole );

                            // Optionally, you can set validationError to a success message
                            this.validationError = 'Registration successful.';

                            // Redirect based on the user's role
                            if ( userRole === 'teacher' )
                            {
                                this.$router.push( { name: 'teacher-dashboard' } );
                            } else if ( userRole === 'student' )
                            {
                                this.$router.push( { name: 'student-dashboard' } );
                            } else if ( userRole === 'admin' )
                            {
                                this.$router.push( { name: 'admin-dashboard' } );
                            } else
                            {
                                // Handle other roles or redirect to a default page
                                this.$router.push( { name: 'default-dashboard' } );
                            }
                        } else
                        {
                            // Handle the case where the role is not present in the response
                            this.validationError = 'Role information not available.';
                        }
                    } )
                    .catch( error =>
                    {
                        console.error( 'Registration error:', error.response.data );
                        this.validationError = 'Registration failed';
                    } );
            } else
            {
                this.validationError = 'Name, email, password, and role are required';
            }
        },
    },
};
</script>

<style scoped>/* You can add custom styles specific to this component */</style>
