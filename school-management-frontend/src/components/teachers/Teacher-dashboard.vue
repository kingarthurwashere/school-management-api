<template>
    <div class="container mx-auto mt-8">
        <Header @logout="logout" />
        <h2 class="text-2xl font-bold mb-4">Teacher Details</h2>

        <!-- Add Teacher Form -->
        <form v-if="viewMode === 'add'" @submit.prevent="addTeacher" class="mb-4">
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="teacherName" class="block text-gray-700 text-sm font-bold mb-2">Teacher Name</label>
                    <input v-model="newTeacher.name" type="text" id="teacherName" name="teacherName"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter teacher name" required />
                </div>
                <div>
                    <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Subject</label>
                    <input v-model="newTeacher.subject" type="text" id="subject" name="subject"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter subject" required />
                </div>
                <div>
                    <label for="teacherBirthDate" class="block text-gray-700 text-sm font-bold mb-2">Birth Date</label>
                    <input v-model="newTeacher.birth_date" type="date" id="teacherBirthDate" name="teacherBirthDate"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        required />
                </div>
                <div>
                    <label for="teacherEmail" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input v-model="newTeacher.email" type="email" id="teacherEmail" name="teacherEmail"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter teacher email" />
                </div>
                <div>
                    <label for="phoneNumber" class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                    <input v-model="newTeacher.phone_number" type="text" id="phoneNumber" name="phoneNumber"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter phone number" />
                </div>
                <div>
                    <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                    <select v-model="newTeacher.gender" id="gender" name="gender"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <!-- Toggle button to switch between add and view mode -->
                <button @click="toggleViewMode"
                    class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                    {{ viewMode === 'add' ? 'View All Teachers' : 'Add Teacher' }}
                </button>

                <!-- Display validation errors -->
                <div v-if="Object.keys(errors).length > 0" class="text-red-500 mt-2">
                    <ul>
                        <li v-if="errors.name">{{ errors.name }}</li>
                        <li v-if="errors.subject">{{ errors.subject }}</li>
                        <li v-if="errors.birth_date">{{ errors.birth_date }}</li>
                        <li v-if="errors.email">{{ errors.email }}</li>
                        <li v-if="errors.phone_number">{{ errors.phone_number }}</li>
                        <li v-if="errors.gender">{{ errors.gender }}</li>
                    </ul>
                </div>

                <div>
                    <button type="submit"
                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-indigo active:bg-indigo-800">
                        Add Teacher
                    </button>
                </div>
            </div>
        </form>

        <!-- Teacher List -->
        <div v-else>
            <ul>
                <li v-for="teacher in teachers" :key="teacher.id" class="mb-4">
                    <div class="flex justify-between items-center bg-gray-200 p-4 rounded">
                        <div>
                            <h3 class="text-lg font-semibold">{{ teacher.name }}</h3>
                            <p>Subject: {{ teacher.subject }}</p>
                            <p>Email: {{ teacher.email }}</p>
                            <p>Phone Number: {{ teacher.phone_number }}</p>
                            <p>Gender: {{ teacher.gender }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <router-link :to="{ name: 'teacher-details', params: { id: teacher.id } }"
                                class="text-indigo-500 hover:text-indigo-700">
                                Details
                            </router-link>
                            <button @click="deleteTeacher(teacher.id)"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-red active:bg-red-800">
                                Delete
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <header />
    </div>
</template>

<script>
import api from '@/axios';
import Header from '@/components/Header.vue';

export default {
    components: {
        Header,

    },
    data ()
    {
        return {
            viewMode: 'add',
            newTeacher: {
                name: '',
                subject: '',
                birth_date: '',
                email: '',
                phone_number: '',
                gender: '',
            },
            teachers: [],
            errors: {}, // Added to store validation errors
        };
    },
    mounted ()
    {
        // Fetch teachers from the API when the component is mounted
        this.fetchTeachers();
    },
    methods: {
        fetchTeachers ()
        {
            // Make a GET request to fetch teachers from your API
            api.get( '/api/teachers' )
                .then( response =>
                {
                    console.log( 'Successful response:', response );
                    this.teachers = response.data.teachers;
                } )
                .catch( error =>
                {
                    console.error( 'Error fetching teachers:', error );
                } );
        },
        addTeacher ()
        {
            // Clear previous errors
            this.errors = {};

            // Client-side validation
            const requiredFields = [ 'name', 'subject', 'birth_date', 'email', 'phone_number', 'gender' ];
            requiredFields.forEach( field =>
            {
                if ( !this.newTeacher[ field ] )
                {
                    this.errors[ field ] = `${ field.charAt( 0 ).toUpperCase() + field.slice( 1 ) } is required.`;
                }
            } );

            // Check if there are validation errors
            if ( Object.keys( this.errors ).length > 0 )
            {
                return;
            }

            // Make a POST request to add a new teacher
            api.post( '/api/teachers', this.newTeacher )
                .then( () =>
                {
                    this.newTeacher = {
                        name: '',
                        subject: '',
                        birth_date: '',
                        email: '',
                        phone_number: '',
                        gender: '',
                    }; // Clear the form
                    this.fetchTeachers(); // Refresh the teacher list
                } )
                .catch( error =>
                {
                    if ( error.response && error.response.status === 422 )
                    {
                        // Server-side validation errors
                        this.errors = error.response.data.errors;
                    } else
                    {
                        console.error( 'Error adding teacher:', error );
                    }
                } );
        },
        deleteTeacher ( teacherId )
        {
            const confirmed = window.confirm( 'Are you sure you want to delete this teacher?' );

            if ( !confirmed )
            {
                return;
            }

            // Make a DELETE request to remove the teacher
            api.delete( `/api/teachers/${ teacherId }` )
                .then( () =>
                {
                    this.fetchTeachers(); // Refresh the teacher list
                } )
                .catch( error =>
                {
                    console.error( 'Error deleting teacher:', error );
                } );
        },
        toggleViewMode ()
        {
            this.viewMode = this.viewMode === 'add' ? 'view' : 'add';
        },
    },
};
</script>


<style scoped>
/* You can add custom styles specific to this component */
</style>
