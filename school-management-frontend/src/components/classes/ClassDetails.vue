<template>
    <div class="container mx-auto mt-8">
        <Header @logout="logout" />
        <h2 class="text-2xl font-bold mb-4">Class Details</h2>

        <!-- Add Class Form -->
        <form @submit.prevent="addClass" class="mb-4">
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="className" class="block text-gray-700 text-sm font-bold mb-2">Class Name</label>
                    <input v-model="newClass.name" type="text" id="className" name="className"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter class name" required />
                </div>
                <div>
                    <label for="classCapacity" class="block text-gray-700 text-sm font-bold mb-2">Class Capacity</label>
                    <input v-model="newClass.capacity" type="number" id="classCapacity" name="classCapacity"
                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                        placeholder="Enter class capacity" required />
                </div>
                <div>
                    <button type="submit"
                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-indigo active:bg-indigo-800">
                        Add Class
                    </button>
                </div>
            </div>
        </form>

        <!-- Assign Students Form -->
        <form @submit.prevent="assignStudentsToClass" class="mb-4">
          <div class="grid grid-cols-3 gap-4">
            <div>
              <label for="students" class="block text-gray-700 text-sm font-bold mb-2">Select Students</label>
              <select v-model="studentsToAssign" id="students" name="students" multiple
                class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500">
                <!-- Populate the select options with students data -->
                <option v-for="student in allStudents" :key="student.id" :value="student.id">{{ student.name }}</option>
              </select>
            </div>
            <div>
              <button type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-green active:bg-green-800">
                Assign Students
              </button>
            </div>
          </div>
        </form>

        <!-- Assign Teachers Form -->
        <form @submit.prevent="assignTeachersToClass" class="mb-4">
          <div class="grid grid-cols-3 gap-4">
            <div>
              <label for="teachers" class="block text-gray-700 text-sm font-bold mb-2">Select Teachers</label>
              <select v-model="teachersToAssign" id="teachers" name="teachers" multiple
                class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500">
                <!-- Populate the select options with teachers data -->
                <option v-for="teacher in allTeachers" :key="teacher.id" :value="teacher.id">{{ teacher.name }}</option>
              </select>
            </div>
            <div>
              <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                Assign Teachers
              </button>
            </div>
          </div>
        </form>

        <!-- Class List -->
        <div>
            <ul>
                <li v-for="classItem in classes" :key="classItem.id" class="mb-4">
        <div class="flex justify-between items-center bg-gray-200 p-4 rounded">
            <div>
                <h3 class="text-lg font-semibold">{{ classItem.name }}</h3>
                <p>Capacity: {{ classItem.capacity }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <button @click="editClass(classItem)" class="text-indigo-500 hover:text-indigo-700">Edit</button>
                <button @click="deleteClass(classItem.id)" class="text-red-500 hover:text-red-700">Delete</button>
            </div>
        </div>
    </li>

            </ul>
        </div>

        <!-- Edit Class Modal -->
        <div v-if="showEditModal" class="fixed inset-0 z-50 overflow-auto bg-smokeflex">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Class</h3>
                                <div class="mt-2">
                                    <label for="editClassName" class="block text-gray-700 text-sm font-bold mb-2">Class
                                        Name</label>
                                    <input v-model="editClassData.name" type="text" id="editClassName" name="editClassName"
                                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                                        required />
                                </div>
                                <div class="mt-2">
                                    <label for="editClassCapacity" class="block text-gray-700 text-sm font-bold mb-2">Class
                                        Capacity</label>
                                    <input v-model="editClassData.capacity" type="number" id="editClassCapacity"
                                        name="editClassCapacity"
                                        class="w-full px-3 py-2 border rounded-md shadow appearance-none hover:border-gray-500 focus:outline-none focus:border-indigo-500"
                                        required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="updateClass" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-500 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button @click="closeEditModal" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
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
            newClass: {
                name: '',
                capacity: null,
            },
            classes: [],
            showEditModal: false,
            editClassData: {
                id: null,
                name: '',
                capacity: null,
            },
            // New data properties for assigning students and teachers
            studentsToAssign: [],
            teachersToAssign: [],
            allStudents: [],
            allTeachers: [],
            currentClassId: null, // Added variable to track the current class ID
        };
    },
    mounted ()
    {
        // Fetch classes from the API when the component is mounted
        this.fetchClasses();
        // Fetch all students and teachers for assigning
        this.fetchAllStudents();
        this.fetchAllTeachers();
    },
    methods: {
        fetchClasses ()
        {
            api.get( '/api/classrooms' )
                .then( response =>
                {
                    console.log( 'Successful response:', response );
                    this.classes = response.data.classrooms;
                } )
                .catch( error =>
                {
                    console.error( 'Error fetching classes:', error );
                } );
        },
        addClass ()
        {
            api.post( '/api/classrooms', this.newClass )
                .then( () =>
                {
                    this.newClass = { name: '', capacity: null };
                    this.fetchClasses();
                } )
                .catch( error =>
                {
                    console.error( 'Error adding class:', error );
                } );
        },
        updateClass ()
        {
            const { id, name, capacity } = this.editClassData;
            api.put( `/api/classrooms/${ id }`, { name, capacity } )
                .then( () =>
                {
                    this.showEditModal = false;
                    this.fetchClasses();
                } )
                .catch( error =>
                {
                    console.error( 'Error updating class:', error );
                } );
        },
        deleteClass ( classId )
        {
            console.log( 'Deleting class with ID:', classId );
            api.delete( `/api/classrooms/${ classId }` )
                .then( () =>
                {
                    console.log( 'Class deleted successfully:', classId );
                    this.fetchClasses();
                } )
                .catch( error =>
                {
                    console.error( 'Error deleting class:', error );

                    if ( error.response )
                    {
                        console.error( 'Response data:', error.response.data );
                    } else if ( error.request )
                    {
                        console.error( 'No response received. Request:', error.request );
                    } else
                    {
                        console.error( 'Error setting up the request. Message:', error.message );
                    }
                } );
        },
        fetchAllStudents ()
        {
            api.get( '/api/students' )
                .then( response =>
                {
                    this.allStudents = response.data.students;
                } )
                .catch( error =>
                {
                    console.error( 'Error fetching students:', error );
                } );
        },
        fetchAllTeachers ()
        {
            api.get( '/api/teachers' )
                .then( response =>
                {
                    this.allTeachers = response.data.teachers;
                } )
                .catch( error =>
                {
                    console.error( 'Error fetching teachers:', error );
                } );
        },
        assignStudentsToClass ()
        {
            api.post( `/api/classrooms/${ this.currentClassId }/assign-students`, { students: this.studentsToAssign } )
                .then( () =>
                {
                    this.studentsToAssign = [];
                    this.fetchClasses();
                } )
                .catch( error =>
                {
                    console.error( 'Error assigning students:', error );
                } );
        },
        assignTeachersToClass ()
        {
            api.post( `/api/classrooms/${ this.currentClassId }/assign-teachers`, { teachers: this.teachersToAssign } )
                .then( () =>
                {
                    this.teachersToAssign = [];
                    this.fetchClasses();
                } )
                .catch( error =>
                {
                    console.error( 'Error assigning teachers:', error );
                } );
        },
    },
};
</script>


<style scoped>
/* You can add custom styles specific to this component */
</style>
