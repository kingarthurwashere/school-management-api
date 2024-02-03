import Home from './views/Home.vue';
import Studentdashboard from './components/students/Student-dashboard.vue';
import StudentDetails from './components/students/StudentDetails.vue';
import Teacherdashboard from './components/teachers/Teacher-dashboard.vue';
import TeacherDetails from './components/teachers/TeacherDetails.vue';
import ClassDetails from './components/classes/ClassDetails.vue';
import Register from './components/auth/Register.vue';
import Login from './components/auth/Login.vue';
import AdminDashboardVue from './views/Admin-dashboard.vue';

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/admin-dashboard', name: 'admin-dashboard', component: AdminDashboardVue },
    { path: '/student-dashboard', name: 'student-dashboard', component: Studentdashboard },
    { path: '/students', name: 'student-details', component: StudentDetails },
    { path: '/teacher-dashboard', name: 'teacher-dashboard', component: Teacherdashboard },
    { path: '/teachers', name: 'teacher-details', component: TeacherDetails },
    { path: '/classes', name: 'class-details', component: ClassDetails },
    { path: '/register', name: 'register', component: Register },
    { path: '/login', name: 'login', component: Login },

];

export default routes;
