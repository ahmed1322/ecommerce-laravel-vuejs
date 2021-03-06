import Api from "../api";

export default form => {
    return Api().post("/login", form);
};
