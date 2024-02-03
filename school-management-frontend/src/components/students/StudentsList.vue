<template>
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">Student List</h2>

        <!-- Student List -->
        <div>
            <ul>
                <li v-for="student in students" :key="student.id" class="mb-4">
                    <div class="flex justify-between items-center bg-gray-200 p-4 rounded">
                        <div>
                            <h3 class="text-lg font-semibold">{{ student.first_name }} {{ student.surname }}</h3>
                            <p>Student Number: {{ student.student_num }}</p>
                            <!-- ... (additional fields) ... -->
                        </div>
                        <div class="flex items-center space-x-2">
                            <router-link :to="{ name: 'student-details', params: { id: student.id } }"
                                class="text-indigo-500 hover:text-indigo-700">Details</router-link>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import api from '@/axios';

export default {
    data ()
    {
        return {
            students: [],
        };
    },
    mounted ()
    {
        // Fetch students from the API when the component is mounted
        this.fetchStudents();
    },
    methods: {
        fetchStudents ()
        {
            // Make a GET request to fetch students from your API
            api.get( '/api/students' )
                .then( response =>
                {
                    this.students = response.data;
                } )
                .catch( error =>
                {
                    console.error( 'Error fetching students:', error );
                } );
        },
    },
};
</script>

<style scoped>/* You can add custom styles specific to this component */</style>
