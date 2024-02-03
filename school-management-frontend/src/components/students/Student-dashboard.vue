<!-- eslint-disable vue/no-parsing-error -->
<template>
    <div class="container mx-auto mt-8">
         <!-- Logout Button -->
            <button @click="logout" class="absolute top-0 right-0 m-4 px-4 py-2 bg-red-500 text-white rounded">
                Logout
            </button>

        <h2 class="text-2xl font-bold mb-4">Student Details</h2>

        <!-- Add Student Form -->
        <form @submit.prevent="addStudent" class="mb-4">
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="firstName" class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                    <input v-model="newStudent.first_name" type="text" id="firstName" name="firstName"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter first name" required />
                </div>
                <div>
                    <label for="surname" class="block text-gray-700 text-sm font-bold mb-2">Surname</label>
                    <input v-model="newStudent.surname" type="text" id="surname" name="surname"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter surname" required />
                </div>
                <div>
                    <label for="studentNum" class="block text-gray-700 text-sm font-bold mb-2">Student Number</label>
                    <input v-model="newStudent.student_num" type="text" id="studentNum" name="studentNum"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter student number" required />
                </div>
                <!-- Additional Fields -->
                <div>
                    <label for="birthDate" class="block text-gray-700 text-sm font-bold mb-2">Birth Date</label>
                    <input v-model="newStudent.birth_date" type="date" id="birthDate" name="birthDate"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        required />
                </div>
                <div>
                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                    <input v-model="newStudent.address" type="text" id="address" name="address"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter address" />
                </div>
                <div>
                    <label for="parentPhoneNumber" class="block text-gray-700 text-sm font-bold mb-2">Parent Phone
                        Number</label>
                    <input v-model="newStudent.parent_phone_number" type="text" id="parentPhoneNumber"
                        name="parentPhoneNumber"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter parent's phone number" />
                </div>
                <div>
                    <label for="secondPhoneNumber" class="block text-gray-700 text-sm font-bold mb-2">Second Phone
                        Number</label>
                    <input v-model="newStudent.second_phone_number" type="text" id="secondPhoneNumber"
                        name="secondPhoneNumber"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter second phone number" />
                </div>
                <div>
                    <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                    <select v-model="newStudent.gender" id="gender" name="gender"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="classroomId" class="block text-gray-700 text-sm font-bold mb-2">Classroom ID</label>
                    <input v-model="newStudent.classroom_id" type="text" id="classroomId" name="classroomId"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter classroom ID" />
                </div>
                <div>
                    <label for="enrollmentDate" class="block text-gray-700 text-sm font-bold mb-2">Enrollment Date</label>
                    <input v-model="newStudent.enrollment_date" type="date" id="enrollmentDate" name="enrollmentDate"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        required />
                </div>
                <div>
                    <button type="submit"
                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-indigo active:bg-indigo-800">
                        Add Student
                    </button>
                </div>
            </div>
        </form>


        <!-- Student List -->
        <div>
            <ul>
                <li v-for="student in students" :key="student.id" class="mb-4">
                    <div class="flex justify-between items-center bg-gray-200 p-4 rounded">
                        <div>
                            <h3 class="text-lg font-semibold">{{ student.first_name }} {{ student.surname }}</h3>
                            <p>Student Number: {{ student.student_num }}</p>
                            <p>Birth Date: {{ student.birth_date }}</p>
                            <p>Address: {{ student.address }}</p>
                            <p>Parent Phone Number: {{ student.parent_phone_number }}</p>
                            <p>Second Phone Number: {{ student.second_phone_number }}</p>
                            <p>Gender: {{ student.gender }}</p>
                            <p>Classroom ID: {{ student.classroom_id }}</p>
                            <p>Enrollment Date: {{ student.enrollment_date }}</p>
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
            newStudent: {
                first_name: '',
                surname: '',
                student_num: '',
                birth_date: '1995-01-01',  // Sample birth date
                address: '123 Main St',   // Sample address
                parent_phone_number: '555-1234',// Sample parent phone number
                second_phone_number: '',
                gender: '',
                classroom_id: '',
                enrollment_date: '',
                
            },
            students: [],
        };
    },
    mounted ()
    {
        // Fetch students from the API when the component is mounted
        this.fetchStudents();
    },
    methods: {
        logout ()
        {
            // Perform logout actions, such as clearing authentication tokens, etc.
            // Then redirect to the login page. Adjust the path accordingly.
            this.$router.push( { name: 'login' } );
        },
        fetchStudents ()
        {
            // Make a GET request to fetch students from your API
            api.get( '/api/students' )
                .then( response =>
                {
                    console.log( 'Successful response:', response );
                    this.students = response.data.students;
                } )
                .catch( error =>
                {
                    console.error( 'Error fetching students:', error );
                } );
        },
        addStudent ()
        {
            // Make a POST request to add a new student
            api.post( '/api/students', this.newStudent )
                .then( () =>
                {
                    this.newStudent = {
                        first_name: '',
                        surname: '',
                        student_num: '',
                        birth_date: '',
                        address: '',
                        parent_phone_number: '',
                        second_phone_number: '',
                        gender: '',
                        classroom_id: '',
                        enrollment_date: '',
                        
                    }; // Clear the form
                    this.fetchStudents(); 
                } )
                .catch( error =>
                {
                    console.error( 'Error adding student:', error );
                } );
        },
        
    },
};
</script>

<style scoped>

</style>
