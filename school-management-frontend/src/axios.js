import axios from 'axios';
import AuthService from '@/AuthService';

const getCookie = ( name ) =>
{
    const value = `; ${ document.cookie }`;
    const parts = value.split( `; ${ name }=` );
    return parts.length === 2 ? parts.pop().split( ';' ).shift() : null;
};

const api = axios.create( {
    baseURL: 'http://localhost:8000',
    headers: {
        'Content-Type': 'application/json',
    },
} );

api.interceptors.request.use( async ( config ) =>
{
    const tokenFromCookie = getCookie( 'token' );
    const tokenFromLocalStorage = AuthService.getBearerToken();

    const token = tokenFromLocalStorage || tokenFromCookie;

    if ( token )
    {
        config.headers.Authorization = `Bearer ${ token }`;
        console.log( 'Authorization header set with token:', token );
    }

    return config;
}, ( error ) =>
{
    // Handle request error (e.g., when no network connection)
    console.error( 'Request error:', error );
    return Promise.reject( error );
} );

export default api;
