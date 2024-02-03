<template>
    <div class="container mx-auto mt-8">
        <Header @logout="logout" />

        <!-- Recent Classes -->
        <div class="w-full md:w-1/3 p-4 bg-gray-100 rounded-md mb-4 md:mb-0">
            <h2 class="text-2xl font-semibold mb-2">Recent Classes</h2>
            <ul>
                <li v-for="classItem in recentClasses" :key="classItem.id" class="mb-2">
                    {{ classItem.name }}
                </li>
            </ul>
        </div>

        <!-- Recent Students -->
        <div class="w-full md:w-1/3 p-4 bg-gray-100 rounded-md mb-4 md:mb-0">
            <h2 class="text-2xl font-semibold mb-2">Recent Students</h2>
            <ul>
                <li v-for="student in recentStudents" :key="student.id" class="mb-2">
                    {{ student.name }}
                </li>
            </ul>
        </div>

        <!-- Recent Teachers -->
        <div class="w-full md:w-1/3 p-4 bg-gray-100 rounded-md">
            <h2 class="text-2xl font-semibold mb-2">Recent Teachers</h2>
            <ul>
                <li v-for="teacher in recentTeachers" :key="teacher.id" class="mb-2">
                    {{ teacher.name }}
                </li>
            </ul>
        </div>

        <!-- Add Teacher Form -->
        <div v-if="viewMode === 'addTeacher'">
            <form @submit.prevent="addTeacher" class="mb-4">
                <!-- Your existing code for adding teachers -->
            </form>
        </div>

        <!-- Add Student Form -->
        <div v-if="viewMode === 'addStudent'">
            <form @submit.prevent="addStudent" class="mb-4">
                <!-- Your existing code for adding students -->
            </form>
        </div>

        <!-- Teacher and Student Lists -->
        <div v-else>
            <!-- Teacher List -->
            <ul>
                <li v-for="teacher in teachers" :key="teacher.id" class="mb-4">
                    <!-- Your existing code for displaying teacher details -->
                </li>
            </ul>

            <!-- Student List -->
            <ul>
                <li v-for="student in students" :key="student.id" class="mb-4">
                    <!-- Your existing code for displaying student details -->
                </li>
            </ul>
        </div>

        <!-- Toggle buttons to switch between add and view mode -->
        <div class="flex justify-between mt-4">
            <button @click="toggleViewMode('addTeacher')"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                Add Teacher
            </button>

            <button @click="toggleViewMode('addStudent')"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-green active:bg-green-800">
                Add Student
            </button>
        </div>

        <header />
    </div>
</template>

<script>
import api from "@/axios";
import Header from "@/components/Header.vue";

export default {
    components: {
        Header,
    },
    data ()
    {
        return {
            viewMode: "addTeacher",
            recentClasses: [],
            recentStudents: [],
            recentTeachers: [],
            teachers: [],
            students: [],
        };
    },
    mounted ()
    {
        this.fetchRecentClasses();
        this.fetchRecentStudents();
        this.fetchRecentTeachers();
        this.fetchTeachers();
        this.fetchStudents();
    },
    methods: {
        fetchRecentClasses ()
        {
            // Make a GET request to fetch recent classes from your API
            api.get( "/api/classrooms" )
                .then( ( response ) =>
                {
                    console.log( "Successful response for recent classes:", response );
                    this.recentClasses = response.data.classrooms;
                } )
                .catch( ( error ) =>
                {
                    console.error( "Error fetching recent classes:", error );
                } );
        },
        fetchRecentStudents ()
        {
            // Make a GET request to fetch recent students from your API
            api.get( "/api/students" )
                .then( ( response ) =>
                {
                    console.log( "Successful response for recent students:", response );
                    this.recentStudents = response.data.students;
                } )
                .catch( ( error ) =>
                {
                    console.error( "Error fetching recent students:", error );
                } );
        },
        fetchRecentTeachers ()
        {
            // Make a GET request to fetch recent teachers from your API
            api.get( "/api/teachers" )
                .then( ( response ) =>
                {
                    console.log( "Successful response for recent teachers:", response );
                    this.recentTeachers = response.data.teachers;
                } )
                .catch( ( error ) =>
                {
                    console.error( "Error fetching recent teachers:", error );
                } );
        },
        fetchTeachers ()
        {
            // Make a GET request to fetch all teachers from your API
            api.get( "/api/teachers" )
                .then( ( response ) =>
                {
                    console.log( "Successful response for all teachers:", response );
                    this.teachers = response.data.teachers;
                } )
                .catch( ( error ) =>
                {
                    console.error( "Error fetching all teachers:", error );
                } );
        },
        fetchStudents ()
        {
            // Make a GET request to fetch all students from your API
            api.get( "/api/students" )
                .then( ( response ) =>
                {
                    console.log( "Successful response for all students:", response );
                    this.students = response.data.students;
                } )
                .catch( ( error ) =>
                {
                    console.error( "Error fetching all students:", error );
                } );
        },
        // Your existing methods for adding teachers and students
        addTeacher ()
        {
            // Your existing code for adding teachers
        },
        addStudent ()
        {
            // Your existing code for adding students
        },
        toggleViewMode ( mode )
        {
            this.viewMode = mode;
        },
        logout ()
        {
            // Perform logout actions
            // Then redirect to the login page. Adjust the path accordingly.
            this.$router.push( { name: 'login' } );
        },
    },
};
</script>

<style scoped>/* You can add custom styles specific to this component */</style>
