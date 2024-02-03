
export default {
    setBearerToken ( token )
    {
        localStorage.setItem( 'bearerToken', token );
    },

    getBearerToken ()
    {
        return localStorage.getItem( 'bearerToken' );
    },

    removeBearerToken ()
    {
        localStorage.removeItem( 'bearerToken' );
    },
};
