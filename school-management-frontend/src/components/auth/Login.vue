<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md">
            <form @submit.prevent="login" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>

                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input v-model="email" type="email" id="email" name="email"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter your email" required />
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input v-model="password" type="password" id="password" name="password"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter your password" required />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-indigo active:bg-indigo-800">
                        Login
                    </button>
                    <router-link to="/register" class="text-indigo-500 hover:text-indigo-700">
                        Register
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
            email: '',
            password: '',
            validationError: '',
        };
    },
    methods: {
        async login ()
        {
            try
            {
                if ( this.email && this.password )
                {
                    const payload = {
                        email: this.email,
                        password: this.password,
                    };

                    const response = await api.post( '/api/login', payload );

                    // Handle successful login
                    console.log( 'Login successful:', response.data );

                    // Check if the login response has a success status
                    if ( response.status === 200 )
                    {
                        // Store the bearer token in local storage
                        AuthService.setBearerToken( response.data.access_token );

                        // Log a message when the access token is stored
                        console.log( 'Access token stored:', response.data.access_token );

                        // Check if the role is available in the response
                        const role = response.data.role;

                        if ( role )
                        {
                            console.log( 'Role successful:', role );

                            // Redirect based on the user's role
                            if ( role === 'teacher' )
                            {
                                this.$router.push( { name: 'teacher-dashboard' } );
                            } else if ( role === 'student' )
                            {
                                this.$router.push( { name: 'student-dashboard' } );
                            } else if ( role === 'admin' )
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
                    } else
                    {
                        // Handle other scenarios where the login might be considered unsuccessful
                        this.validationError = 'Login failed. Please check your credentials.';
                    }
                } else
                {
                    this.validationError = 'Email and password are required';
                }
            } catch ( error )
            {
                console.error( 'Login error:', error.response.data );
                this.validationError = 'Incorrect email or password';
            }
        },
    }

}
</script>

<style scoped>
/* You can add custom styles specific to this component */
</style>
