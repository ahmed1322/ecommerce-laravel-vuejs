import Api from "./Api";

export default {
    logout() {
        return Api().post("/logout").then( res => {
            localStorage.removeItem('access_token');
        } );
    }
};
