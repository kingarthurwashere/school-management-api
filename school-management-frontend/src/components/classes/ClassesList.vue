<template>
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">Class List</h2>

        <!-- Add Class Form -->
        <form @submit.prevent="addClass" class="mb-4">
            <div class="flex items-center space-x-4">
                <label for="className" class="text-sm">Class Name:</label>
                <input v-model="newClassName" type="text" id="className" name="className" class="border p-2 rounded">
                <label for="capacity" class="text-sm">Capacity:</label>
                <input v-model.number="newClassCapacity" type="number" id="capacity" name="capacity"
                    class="border p-2 rounded">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add Class</button>
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
                            <router-link :to="{ name: 'class-details', params: { id: classItem.id } }"
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
            classes: [],
            newClassName: '',
            newClassCapacity: null,
            validationError: '',
        };
    },
    mounted ()
    {
        this.fetchClasses();
    },
    methods: {
        async fetchClasses ()
        {
            try
            {
                const response = await api.get( '/api/classrooms' );
                this.classes = response.data;
            } catch ( error )
            {
                console.error( 'Error fetching classes:', error );
            }
        },
        async addClass ()
        {
            try
            {
                if ( this.newClassName && this.newClassCapacity !== null )
                {
                    const newClass = {
                        name: this.newClassName,
                        capacity: this.newClassCapacity,
                    };

                    const response = await api.post( '/api/classrooms', newClass );

                    if ( response.status === 201 )
                    {
                        // Class created successfully
                        this.fetchClasses();
                        this.newClassName = '';
                        this.newClassCapacity = null;
                    } else
                    {
                        this.validationError = 'Failed to add class. Please try again.';
                    }
                } else
                {
                    this.validationError = 'Invalid input for adding a new class';
                }
            } catch ( error )
            {
                console.error( 'Error adding class:', error );
                this.validationError = 'An error occurred while adding the class.';
            }
        },
    },
};
</script>

<style scoped>/* You can add custom styles specific to this component */</style>
